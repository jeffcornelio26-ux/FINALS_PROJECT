<?php /* Integrative Programming Final Project: single-page portal. Run via XAMPP: http://localhost/integrative_final/ */ ?>
<!DOCTYPE html>
<html lang="en" class="dark">
<head>
<meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Integrative Programming | Final Project</title>
<script src="https://cdn.tailwindcss.com"></script>
<link href="https://fonts.googleapis.com/css2?family=IBM+Plex+Mono:wght@400;500&family=IBM+Plex+Sans:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="assets/style.css">
</head>
<body class="text-zinc-200 min-h-screen">
<div class="flex flex-col md:flex-row min-h-screen">

<!-- ===== SIDEBAR ===== -->
<aside class="md:w-60 md:fixed md:inset-y-0 border-b md:border-b-0 md:border-r border-zinc-800 bg-zinc-950/80 p-4">
  <div class="mb-4"><div class="text-white font-semibold">Integrative Programming</div><div class="text-xs text-zinc-500 mono">final project portal</div></div>
  <nav class="flex md:flex-col gap-1" aria-label="Main">
    <button class="tab active" data-group="main" data-target="home">Home / Profile</button>
    <button class="tab" data-group="main" data-target="midterm">Midterms Lab Exercises</button>
    <button class="tab" data-group="main" data-target="finals">Finals Lab Exercises</button>
  </nav>
  <div class="hidden md:block absolute bottom-4 left-4 text-xs text-zinc-600 mono">PHP <?= PHP_VERSION ?></div>
</aside>

<main class="flex-1 md:ml-60 p-5 md:p-8 max-w-6xl">

<!-- ===== HOME ===== -->
<section class="panel" data-group="main" id="home">
  <div class="card flex flex-col sm:flex-row gap-6 items-start">
    <div class="w-24 h-24 rounded-full bg-gradient-to-br from-cyan-300 to-violet-400 grid place-items-center text-3xl font-semibold text-zinc-900" aria-hidden="true">SC</div>
    <div class="flex-1">
      <h1 class="text-2xl font-semibold text-white">SeptaCode</h1>
      <p class="text-zinc-400 text-sm mt-1">BSIT-3K &middot; Marikina City, Philippines</p>
      <p class="mt-3 text-sm text-zinc-300 max-w-prose">Third-year IT students building web apps that talk to servers. This portal bundles our Midterms Lab Exercises and Finals Lab Exercises on PHP, JSON, AJAX and XML.</p>
      <div class="flex flex-wrap gap-2 mt-4">
        <?php foreach (['PHP','JavaScript','MySQL','XML','AJAX','JSON','Fetch API','Tailwind CSS'] as $s): ?>
          <span class="badge"><?= $s ?></span>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
  <div class="grid sm:grid-cols-2 gap-4 mt-4">
    <button class="card text-left hover:border-cyan-300/50" data-group="main" data-target="midterm"><div class="text-white font-medium">Midterms Lab Exercises</div><div class="text-sm text-zinc-400 mt-1">Forms, CRUD, and GET/POST handling in PHP.</div></button>
    <button class="card text-left hover:border-violet-400/50" data-group="main" data-target="finals"><div class="text-white font-medium">Finals Lab Exercises</div><div class="text-sm text-zinc-400 mt-1">JSON in PHP, XMLHttpRequest, Fetch API, XML.</div></button>
  </div>
  <p class="text-xs text-zinc-500 mt-4">Edit the name, section and bio in <code>index.php</code> (Home section).</p>
</section>

<!-- ===== MIDTERM ===== -->
<section class="panel hidden" data-group="main" id="midterm">
  <h2 class="text-xl font-semibold text-white mb-3">Midterms Lab Exercises</h2>
  <div class="flex overflow-x-auto border-b border-zinc-800 mb-5" role="tablist">
    <button class="sub active" data-group="mid" data-target="ex1">Exercise 1: Team page</button>
    <button class="sub" data-group="mid" data-target="ex2">Exercise 2: CRUD</button>
    <button class="sub" data-group="mid" data-target="ex3">Exercise 3: GET &amp; POST</button>
    <button class="sub" data-group="mid" data-target="ex4">Exercise 4: GET &amp; POST</button>
  </div>

  <!-- Ex 1: SeptaCode team landing page (static HTML, shown in its own frame so its styles stay untouched) -->
  <div class="panel" data-group="mid" id="ex1">
    <div class="flex items-center justify-between mb-3">
      <p class="text-sm text-zinc-400">Basic HTML and CSS: the SeptaCode team landing page.</p>
      <a class="btn ghost" href="midterm/ex1/index.html" target="_blank" rel="noopener">Open full page</a>
    </div>
    <iframe id="ex1Frame" src="midterm/ex1/index.html" title="Midterm Exercise 1: SeptaCode team page"
      class="w-full rounded-xl border border-zinc-800 bg-white" style="height:900px"></iframe>
    <div class="card mt-4">
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-white font-medium">Source code <span class="mono text-xs text-zinc-500">midterm/ex1/index.html</span></h3>
        <button class="btn ghost" data-copy="ex1">Copy code</button>
      </div>
      <pre class="out mono" id="ex1Code" style="max-height:32rem;overflow:auto;white-space:pre" tabindex="0">Loading source...</pre>
    </div>
  </div>

  <!-- Ex 2: SeptaCode user management CRUD (index2.php), shown in its own frame -->
  <div class="panel hidden" data-group="mid" id="ex2">
    <div class="flex items-center justify-between mb-3">
      <p class="text-sm text-zinc-400">PHP CRUD: add, edit, delete and search users. Data is kept in the PHP session, so it resets when the session ends.</p>
      <a class="btn ghost" href="midterm/ex2/index.php" target="_blank" rel="noopener">Open full page</a>
    </div>
    <iframe id="ex2Frame" src="midterm/ex2/index.php" title="Midterm Exercise 2: User Management CRUD"
      class="w-full rounded-xl border border-zinc-800 bg-white" style="height:900px"></iframe>
    <div class="card mt-4">
      <div class="flex items-center justify-between mb-2">
        <h3 class="text-white font-medium">Source code <span class="mono text-xs text-zinc-500">midterm/ex2/index.php</span></h3>
        <button class="btn ghost" data-copy="ex2">Copy code</button>
      </div>
      <pre class="out mono" id="ex2Code" style="max-height:32rem;overflow:auto;white-space:pre" tabindex="0">Loading source...</pre>
    </div>
  </div>

  <!-- Ex 3 -->
  <div class="panel hidden" data-group="mid" id="ex3">
    <div class="grid lg:grid-cols-2 gap-4">
      <div class="card space-y-3">
        <h3 class="text-white font-medium">GET: search by query string</h3>
        <form id="getForm" class="grid grid-cols-2 gap-3">
          <div><label class="lbl">Search name or email</label><input class="inp" name="q"></div>
          <div><label class="lbl">Course filter</label><input class="inp" name="course" placeholder="BSIT"></div>
          <button class="btn col-span-2">Send GET request</button>
        </form>
        <label class="lbl">Request URL</label><div class="out mono" id="getUrl">-</div>
        <div class="overflow-x-auto" id="getTable"></div>
      </div>
      <div class="card space-y-3">
        <h3 class="text-white font-medium">POST: add a record in the request body</h3>
        <form id="postForm" class="grid grid-cols-2 gap-3">
          <div class="col-span-2"><label class="lbl">Name</label><input class="inp" name="name" required></div>
          <div><label class="lbl">Course</label><input class="inp" name="course" required></div>
          <div><label class="lbl">Year</label><input class="inp" name="year" type="number" min="1" max="6" required></div>
          <div class="col-span-2"><label class="lbl">Email (optional)</label><input class="inp" name="email" type="email"></div>
          <button class="btn col-span-2">Send POST request</button>
        </form>
        <label class="lbl">Server response</label><div class="out" id="postOut"></div>
      </div>
    </div>
  </div>

  <!-- Ex 4 -->
  <div class="panel hidden" data-group="mid" id="ex4">
    <div class="grid lg:grid-cols-2 gap-4">
      <div class="card space-y-3">
        <h3 class="text-white font-medium">GET one record, then POST an update</h3>
        <form id="loadForm" class="flex gap-2 items-end">
          <div class="flex-1"><label class="lbl">Student ID</label><input class="inp" name="id" type="number" min="1" required></div>
          <button class="btn">Load (GET)</button>
        </form>
        <form id="editForm" class="grid grid-cols-2 gap-3">
          <input type="hidden" name="id">
          <div class="col-span-2"><label class="lbl">Name</label><input class="inp" name="name" required></div>
          <div><label class="lbl">Course</label><input class="inp" name="course" required></div>
          <div><label class="lbl">Year</label><input class="inp" name="year" type="number" min="1" max="6" required></div>
          <div class="col-span-2"><label class="lbl">Email</label><input class="inp" name="email" type="email"></div>
          <button class="btn">Update (POST)</button>
          <button type="button" class="btn danger" id="delBtn">Delete (POST)</button>
        </form>
        <div class="out" id="ex4Out"></div>
      </div>
      <div class="card overflow-x-auto"><h3 class="text-white font-medium mb-2">Current records</h3><div id="ex4Table"></div></div>
    </div>
    <p class="text-xs text-zinc-500 mt-3">Exercise 3 and 4 share one GitHub repo, so Exercise 3 covers searching and adding and Exercise 4 covers loading, updating and deleting.</p>
  </div>
</section>

<!-- ===== FINALS ===== -->
<section class="panel hidden" data-group="main" id="finals">
  <h2 class="text-xl font-semibold text-white mb-3">Finals Lab Exercises</h2>
  <div class="flex overflow-x-auto border-b border-zinc-800 mb-5" role="tablist">
    <button class="sub active" data-group="fin" data-target="lab1">Lab 1: JSON in PHP</button>
    <button class="sub" data-group="fin" data-target="lab2">Lab 2: XMLHttpRequest</button>
    <button class="sub" data-group="fin" data-target="lab3">Lab 3: Fetch API</button>
    <button class="sub" data-group="fin" data-target="lab4">Lab 4: XML</button>
  </div>

  <!-- Lab 1 -->
  <div class="panel" data-group="fin" id="lab1">
    <div class="grid md:grid-cols-2 gap-4">
      <div class="card space-y-2"><h3 class="text-white font-medium">1. json_encode()</h3><p class="text-sm text-zinc-400">PHP array with name, age, course becomes a JSON string.</p>
        <button class="btn" data-run="enc">Run lab1_encode.php</button><div class="out mono" id="encOut"></div></div>
      <div class="card space-y-2"><h3 class="text-white font-medium">2. json_decode()</h3><p class="text-sm text-zinc-400">The same JSON read as an object and as an associative array.</p>
        <button class="btn" data-run="dec">Run lab2_decode.php</button><div class="out mono" id="decOut"></div></div>
      <div class="card space-y-2"><h3 class="text-white font-medium">3. JSON API simulation</h3><p class="text-sm text-zinc-400">Sends <code>Content-Type: application/json</code> with a user profile.</p>
        <button class="btn" data-run="api">Call lab3_api.php</button><div class="out mono" id="apiOut"></div></div>
      <div class="card space-y-2"><h3 class="text-white font-medium">4. Handling JSON input</h3><p class="text-sm text-zinc-400">PHP reads the raw body with <code>php://input</code>.</p>
        <textarea class="inp mono" rows="3" id="rawJson">{"username":"admin","password":"1234"}</textarea>
        <button class="btn" data-run="inp">POST to lab4_input.php</button><div class="out mono" id="inpOut"></div></div>
      <form class="card space-y-2 md:col-span-2" id="welcomeForm"><h3 class="text-white font-medium">5. PHP + JSON + AJAX</h3><p class="text-sm text-zinc-400">The page updates without reloading.</p>
        <div class="flex gap-2"><input class="inp" name="name" placeholder="Your name" aria-label="Your name"><button class="btn">Send</button></div>
        <div class="out mono" id="welcomeOut"></div></form>
    </div>
  </div>

  <!-- Lab 2 -->
  <div class="panel hidden" data-group="fin" id="lab2">
    <div class="card space-y-3">
      <h3 class="text-white font-medium">XMLHttpRequest GET</h3>
      <p class="text-sm text-zinc-400">Requests <code>jsonplaceholder.typicode.com/posts/1</code> and checks <code>readyState === 4</code> and <code>status === 200</code>.</p>
      <div class="flex gap-2"><button class="btn" id="xhrBtn">Load Post Data</button><button class="btn ghost" id="xhrBad">Trigger an error (bad URL)</button></div>
      <div class="out" id="xhrOut" style="background:#0c0c0f"></div>
      <label class="lbl">readyState log</label><div class="out mono" id="xhrLog"></div>
    </div>
  </div>

  <!-- Lab 3 -->
  <div class="panel hidden" data-group="fin" id="lab3">
    <div class="grid md:grid-cols-2 gap-4">
      <div class="card space-y-3"><h3 class="text-white font-medium">Fetch GET</h3>
        <button class="btn" id="fetchGet">Load Post Data</button><div class="out" id="fetchGetOut"></div></div>
      <form class="card space-y-3" id="fetchPostForm"><h3 class="text-white font-medium">Fetch POST</h3>
        <div><label class="lbl">Title</label><input class="inp" name="title" value="My New Post"></div>
        <div><label class="lbl">Body</label><input class="inp" name="body" value="Learning Fetch API is fun!"></div>
        <div><label class="lbl">User ID</label><input class="inp" name="userId" type="number" value="1"></div>
        <button class="btn">Create post</button><div class="out" id="fetchPostOut"></div></form>
    </div>
  </div>

  <!-- Lab 4 -->
  <div class="panel hidden" data-group="fin" id="lab4">
    <div class="grid lg:grid-cols-2 gap-4">
      <div class="card space-y-3"><h3 class="text-white font-medium">student_data.xml (raw)</h3>
        <textarea class="inp mono" rows="16" id="xmlSrc" spellcheck="false" aria-label="XML source"></textarea>
        <div class="flex flex-wrap gap-2">
          <button class="btn" id="xmlLoad">Load from server</button>
          <button class="btn ghost" id="xmlValidate">Validate</button>
          <button class="btn ghost" id="xmlSave">Validate &amp; save to server</button>
        </div>
        <div class="out" id="xmlMsg"></div></div>
      <div class="space-y-4">
        <div class="card overflow-x-auto"><h3 class="text-white font-medium mb-2">Parsed viewer</h3><div id="xmlTable"></div></div>
        <form class="card grid grid-cols-2 gap-3" id="xmlAdd"><h3 class="text-white font-medium col-span-2">Add a &lt;student&gt; node</h3>
          <div><label class="lbl">ID</label><input class="inp" name="id" placeholder="003" required></div>
          <div><label class="lbl">Name</label><input class="inp" name="name" required></div>
          <div><label class="lbl">Course</label><input class="inp" name="course" required></div>
          <div><label class="lbl">Year</label><input class="inp" name="year" type="number" required></div>
          <button class="btn col-span-2">Insert into XML</button></form>
      </div>
    </div>
  </div>
</section>

</main></div>
<script src="assets/app.js"></script>
</body></html>
