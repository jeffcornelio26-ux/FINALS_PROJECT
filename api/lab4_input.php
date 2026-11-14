<?php
// Lab 1, Exercise 4: read raw JSON sent in the request body
header('Content-Type: application/json');
$raw  = file_get_contents('php://input');
$data = json_decode($raw);
if ($data === null) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid or empty JSON: ' . json_last_error_msg()]);
    exit;
}
echo json_encode([
    'Username' => $data->username ?? null,
    'Password' => $data->password ?? null,
]);
