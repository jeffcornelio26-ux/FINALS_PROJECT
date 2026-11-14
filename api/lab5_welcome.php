<?php
// Lab 1, Exercise 5: form -> AJAX -> PHP -> JSON -> page (no reload)
header('Content-Type: application/json');
$in   = json_decode(file_get_contents('php://input'), true) ?: [];
$name = trim($in['name'] ?? '');
if ($name === '') {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Please enter your name.']);
    exit;
}
echo json_encode(['status' => 'success', 'message' => 'Welcome, ' . htmlspecialchars($name) . '!']);
