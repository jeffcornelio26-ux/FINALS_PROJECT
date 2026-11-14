<?php
/**
 * Returns the raw source of a midterm exercise so the portal can display it
 * next to the rendered output. A whitelist stops anyone reading other files.
 * (Needed because fetching a .php file normally returns its OUTPUT, not its code.)
 */
$files = [
    'ex1' => __DIR__ . '/../midterm/ex1/index.html',
    'ex2' => __DIR__ . '/../midterm/ex2/index.php',
];
$key = $_GET['file'] ?? '';
if (!isset($files[$key])) { http_response_code(404); exit('Unknown file.'); }
header('Content-Type: text/plain; charset=utf-8');
readfile($files[$key]);
