<?php
/**
 * Shared helpers. Uses SQLite (built into XAMPP, zero setup).
 * To use MySQL instead, replace the PDO line with:
 *   new PDO('mysql:host=localhost;dbname=integrative;charset=utf8mb4', 'root', '');
 * and change AUTOINCREMENT to AUTO_INCREMENT in the CREATE TABLE below.
 */
function db(): PDO {
    static $pdo = null;
    if ($pdo) return $pdo;
    $pdo = new PDO('sqlite:' . __DIR__ . '/../data/app.sqlite');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
    $pdo->exec("CREATE TABLE IF NOT EXISTS students (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL, course TEXT NOT NULL,
        year INTEGER NOT NULL, email TEXT DEFAULT '')");
    if (!$pdo->query("SELECT COUNT(*) FROM students")->fetchColumn()) {
        $pdo->exec("INSERT INTO students (name,course,year,email) VALUES
            ('Venice Canlas','BSIT',3,'venice@example.com'),
            ('Jerwin Esparza','BSCS',2,'jerwin@example.com')");
    }
    return $pdo;
}

/** Send a JSON response and stop. */
function json_out($data, int $code = 200): void {
    http_response_code($code);
    header('Content-Type: application/json; charset=utf-8');
    echo json_encode($data, JSON_UNESCAPED_UNICODE);
    exit;
}

/** Read the request body as JSON (falls back to form-encoded $_POST). */
function body(): array {
    $j = json_decode(file_get_contents('php://input'), true);
    return is_array($j) ? $j : $_POST;
}
