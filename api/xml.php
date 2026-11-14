<?php
/**
 * Lab 4: XML on the server.
 *  GET             -> raw student_data.xml
 *  POST {xml:".."} -> checks the XML is well-formed, then saves it
 */
$file = __DIR__ . '/../data/student_data.xml';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $in = json_decode(file_get_contents('php://input'), true);
    libxml_use_internal_errors(true);
    $doc = simplexml_load_string($in['xml'] ?? '');
    if ($doc === false) {
        $errs = array_map(fn($e) => 'Line ' . $e->line . ': ' . trim($e->message), libxml_get_errors());
        http_response_code(422);
        echo json_encode(['valid' => false, 'errors' => $errs]);
        exit;
    }
    file_put_contents($file, $in['xml']);
    echo json_encode(['valid' => true, 'saved' => true, 'students' => count($doc->student)]);
    exit;
}
header('Content-Type: application/xml; charset=utf-8');
readfile($file);
