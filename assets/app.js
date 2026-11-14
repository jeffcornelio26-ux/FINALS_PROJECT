/* Integrative Programming Final Project: front-end logic (vanilla ES6+) */
const $  = (s, r = document) => r.querySelector(s);
const $$ = (s, r = document) => [...r.querySelectorAll(s)];
const esc = s => String(s ?? '').replace(/[&<>"']/g, c => ({'&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#39;'}[c]));
const pretty = d => typeof d === 'string' ? d : JSON.stringify(d, null, 2);
const formData = f => Object.fromEntries(new FormData(f));

/** Show text in an .out box; kind = 'ok' | 'err' */
function say(el, text, kind = '') { el.className = 'out ' + kind; el.textContent = typeof text === 'string' ? text : pretty(text); }

/** fetch wrapper: GET by default, JSON POST when body given. Throws with server message. */
async function api(url, body) {
  const opts = body === undefined ? {} : { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(body) };
  const res = await fetch(url, opts);
  const data = await res.json().catch(() => ({}));
  if (!res.ok) throw new Error(data.error || data.message || `HTTP ${res.status}`);
  return data;
}

/* ---------- Tabs (main, midterm and finals sub-tabs share one handler) ---------- */
function activate(group, target) {
  $$(`.panel[data-group="${group}"]`).forEach(p => p.classList.toggle('hidden', p.id !== target));
  $$(`button[data-group="${group}"].tab, button[data-group="${group}"].sub`).forEach(b => b.classList.toggle('active', b.dataset.target === target));
}
$$('button[data-group][data-target]').forEach(b => b.addEventListener('click', () => activate(b.dataset.group, b.dataset.target)));

/* ---------- Student table renderer (used by Midterm 2, 3, 4) ---------- */
function studentTable(list, actions = false) {
  if (!list.length) return '<p class="text-sm text-zinc-500">No students found. Add one with the form.</p>';
  return `<table><thead><tr><th>ID</th><th>Name</th><th>Course</th><th>Year</th><th>Email</th>${actions ? '<th></th>' : ''}</tr></thead><tbody>` +
    list.map(s => `<tr><td>${s.id}</td><td>${esc(s.name)}</td><td>${esc(s.course)}</td><td>${s.year}</td><td>${esc(s.email)}</td>` +
      (actions ? `<td class="whitespace-nowrap"><button class="btn ghost" data-edit="${s.id}">Edit</button> <button class="btn danger" data-del="${s.id}">Delete</button></td>` : '') + '</tr>').join('') +
    '</tbody></table>';
}

/* ---------- Midterm Exercises 1 and 2: self-contained pages shown in a frame, plus their source ---------- */
function fitFrame(f) {
  try {
    f.style.height = '200px';   // shrink first so scrollHeight reflects the content
    f.style.height = f.contentDocument.documentElement.scrollHeight + 'px';
  } catch (e) { f.style.height = '1000px'; }   // e.g. opened via file://
}
['ex1', 'ex2'].forEach(id => {
  const frame = $('#' + id + 'Frame'), code = $('#' + id + 'Code');
  let pending = false;
  const refit = () => { if (pending) return; pending = true; requestAnimationFrame(() => { pending = false; fitFrame(frame); }); };
  frame.addEventListener('load', () => {
    fitFrame(frame);
    try { new ResizeObserver(refit).observe(frame.contentDocument.body); } catch (e) {}   // follows table growth in Exercise 2
  });
  window.addEventListener('resize', refit);
  $$(`[data-target="${id}"],[data-target="midterm"]`).forEach(b => b.addEventListener('click', () => setTimeout(refit, 50)));

  fetch('api/source.php?file=' + id)   // raw source (a plain fetch of a .php file would return its output)
    .then(r => { if (!r.ok) throw new Error('HTTP ' + r.status); return r.text(); })
    .then(t => { code.textContent = t.replace(/\r\n/g, '\n'); })
    .catch(() => { code.textContent = 'Could not load the source. Open the portal through http://localhost/ (Apache), not as a file.'; });
});
$$('[data-copy]').forEach(btn => btn.addEventListener('click', async () => {
  try { await navigator.clipboard.writeText($('#' + btn.dataset.copy + 'Code').textContent); btn.textContent = 'Copied'; }
  catch { btn.textContent = 'Select the code and press Ctrl+C'; }
  setTimeout(() => { btn.textContent = 'Copy code'; }, 1800);
}));

/* ---------- Midterm Exercise 3: GET (query string) and POST (body) ---------- */
$('#getForm').addEventListener('submit', async e => {
  e.preventDefault();
  const qs = new URLSearchParams({ action: 'list', ...formData(e.target) }).toString();
  const url = 'api/students.php?' + qs;
  say($('#getUrl'), url);
  try { $('#getTable').innerHTML = studentTable(await api(url)); }
  catch (err) { $('#getTable').innerHTML = `<p class="text-red-400 text-sm">${esc(err.message)}</p>`; }
});
$('#postForm').addEventListener('submit', async e => {
  e.preventDefault();
  try { say($('#postOut'), await api('api/students.php', { ...formData(e.target), action: 'create' }), 'ok'); e.target.reset(); }
  catch (err) { say($('#postOut'), err.message, 'err'); }
});

/* ---------- Midterm Exercise 4: GET one, POST update/delete ---------- */
const edit = $('#editForm'), ex4Out = $('#ex4Out');
const loadEx4 = async () => { $('#ex4Table').innerHTML = studentTable(await api('api/students.php?action=list')); };
$('#loadForm').addEventListener('submit', async e => {
  e.preventDefault();
  try {
    const s = await api('api/students.php?action=get&id=' + e.target.id.value);
    Object.entries(s).forEach(([k, v]) => { if (edit[k]) edit[k].value = v; });
    say(ex4Out, `Loaded student #${s.id}.`, 'ok');
  } catch (err) { say(ex4Out, err.message, 'err'); }
});
edit.addEventListener('submit', async e => {
  e.preventDefault();
  if (!edit.id.value) return say(ex4Out, 'Load a student by ID first.', 'err');
  try { say(ex4Out, await api('api/students.php', { ...formData(edit), action: 'update' }), 'ok'); loadEx4(); }
  catch (err) { say(ex4Out, err.message, 'err'); }
});
$('#delBtn').addEventListener('click', async () => {
  if (!edit.id.value) return say(ex4Out, 'Load a student by ID first.', 'err');
  if (!confirm('Delete student #' + edit.id.value + '?')) return;
  try { say(ex4Out, await api('api/students.php', { action: 'delete', id: edit.id.value }), 'ok'); edit.reset(); loadEx4(); }
  catch (err) { say(ex4Out, err.message, 'err'); }
});
$$('[data-target="ex4"]').forEach(b => b.addEventListener('click', () => loadEx4().catch(() => {})));

/* ---------- Finals Lab 1: JSON in PHP ---------- */
const runs = {
  enc: () => api('api/lab1_encode.php'),
  dec: () => api('api/lab2_decode.php'),
  api: async () => { const r = await fetch('api/lab3_api.php'); return `Content-Type: ${r.headers.get('Content-Type')}\n\n${pretty(await r.json())}`; },
  inp: () => api('api/lab4_input.php', JSON.parse($('#rawJson').value))
};
$$('[data-run]').forEach(b => b.addEventListener('click', async () => {
  const out = $('#' + b.dataset.run + 'Out');
  try { say(out, await runs[b.dataset.run](), 'ok'); } catch (err) { say(out, err.message, 'err'); }
}));
$('#welcomeForm').addEventListener('submit', async e => {
  e.preventDefault();
  try { say($('#welcomeOut'), await api('api/lab5_welcome.php', formData(e.target)), 'ok'); }
  catch (err) { say($('#welcomeOut'), err.message, 'err'); }
});

/* ---------- Finals Lab 2: XMLHttpRequest ---------- */
function xhrGet(url) {
  const out = $('#xhrOut'), log = $('#xhrLog');
  log.textContent = ''; say(out, 'Loading...');
  const xhr = new XMLHttpRequest();
  xhr.onreadystatechange = () => {
    log.textContent += `readyState ${xhr.readyState}${xhr.readyState === 4 ? ' (DONE), status ' + xhr.status : ''}\n`;
    if (xhr.readyState !== 4) return;
    if (xhr.status === 200) {
      const d = JSON.parse(xhr.responseText);
      out.className = 'out ok';
      out.innerHTML = `<strong>Post Title:</strong> ${esc(d.title)}<br><br><strong>Content:</strong> ${esc(d.body)}`;
    } else {
      out.className = 'out err'; out.textContent = `Error: ${xhr.status} - ${xhr.statusText || 'Request failed'}`;
    }
  };
  xhr.onerror = () => say(out, 'Error: network problem. Check your internet connection.', 'err');
  xhr.open('GET', url, true);   // true = asynchronous
  xhr.send();
}
$('#xhrBtn').addEventListener('click', () => xhrGet('https://jsonplaceholder.typicode.com/posts/1'));
$('#xhrBad').addEventListener('click', () => xhrGet('https://jsonplaceholder.typicode.com/posts/99999'));

/* ---------- Finals Lab 3: Fetch API ---------- */
$('#fetchGet').addEventListener('click', () => {
  const out = $('#fetchGetOut'); say(out, 'Loading...');
  fetch('https://jsonplaceholder.typicode.com/posts/1')
    .then(r => { if (!r.ok) throw new Error(`HTTP error! Status: ${r.status}`); return r.json(); })
    .then(d => { out.className = 'out ok'; out.innerHTML = `<strong>Post Title:</strong> ${esc(d.title)}<br><br><strong>Content:</strong> ${esc(d.body)}`; })
    .catch(err => say(out, 'Error: ' + err.message, 'err'));
});
$('#fetchPostForm').addEventListener('submit', e => {
  e.preventDefault();
  const out = $('#fetchPostOut'), d = formData(e.target); d.userId = Number(d.userId);
  say(out, 'Sending...');
  fetch('https://jsonplaceholder.typicode.com/posts', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify(d) })
    .then(r => { if (!r.ok) throw new Error(`HTTP error! Status: ${r.status}`); return r.json(); })
    .then(r => say(out, `New Post Created!\nPost ID: ${r.id}\n\n${pretty(r)}`, 'ok'))
    .catch(err => say(out, 'Error: ' + err.message, 'err'));
});

/* ---------- Finals Lab 4: XML ---------- */
const xmlSrc = $('#xmlSrc'), xmlMsg = $('#xmlMsg');
function parseXml(text) {
  const doc = new DOMParser().parseFromString(text, 'application/xml');
  const err = doc.querySelector('parsererror');
  if (err) throw new Error(err.textContent.trim().split('\n')[0]);
  return doc;
}
function renderXml() {
  try {
    const doc = parseXml(xmlSrc.value);
    const rows = [...doc.querySelectorAll('student')].map(s => `<tr>${['id','name','course','year'].map(t => `<td>${esc(s.querySelector(t)?.textContent)}</td>`).join('')}</tr>`);
    $('#xmlTable').innerHTML = `<table><thead><tr><th>id</th><th>name</th><th>course</th><th>year</th></tr></thead><tbody>${rows.join('')}</tbody></table>`;
    return doc;
  } catch (err) { $('#xmlTable').innerHTML = '<p class="text-sm text-red-400">Fix the XML to see the table.</p>'; throw err; }
}
async function loadXml() {
  try { xmlSrc.value = await (await fetch('api/xml.php')).text(); renderXml(); say(xmlMsg, 'Loaded student_data.xml from the server.', 'ok'); }
  catch (err) { say(xmlMsg, err.message, 'err'); }
}
$('#xmlLoad').addEventListener('click', loadXml);
$('#xmlValidate').addEventListener('click', () => {
  try { const n = renderXml().querySelectorAll('student').length; say(xmlMsg, `Well-formed XML. ${n} student node(s) found.`, 'ok'); }
  catch (err) { say(xmlMsg, 'Not well-formed: ' + err.message, 'err'); }
});
$('#xmlSave').addEventListener('click', async () => {
  try { renderXml(); say(xmlMsg, await api('api/xml.php', { xml: xmlSrc.value }), 'ok'); }
  catch (err) { say(xmlMsg, err.message, 'err'); }
});
$('#xmlAdd').addEventListener('submit', e => {
  e.preventDefault();
  try {
    const doc = parseXml(xmlSrc.value), d = formData(e.target), node = doc.createElement('student');
    ['id','name','course','year'].forEach(k => { const c = doc.createElement(k); c.textContent = d[k]; node.append('\n    ', c); });
    node.append('\n  ');
    doc.documentElement.append('  ', node, '\n');
    xmlSrc.value = '<?xml version="1.0" encoding="UTF-8"?>\n' + new XMLSerializer().serializeToString(doc.documentElement);
    renderXml(); e.target.reset(); say(xmlMsg, 'Student node added. Use "Validate & save" to write it to the server.', 'ok');
  } catch (err) { say(xmlMsg, err.message, 'err'); }
});
$$('[data-target="lab4"]').forEach(b => b.addEventListener('click', () => { if (!xmlSrc.value) loadXml(); }));
