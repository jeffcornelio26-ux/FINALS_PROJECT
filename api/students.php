<?php
/**
 * One endpoint, used by Midterm Exercises 2, 3 and 4.
 *  GET  ?action=list[&q=..&course=..]   Read (search/filter)
 *  GET  ?action=get&id=N                Read one
 *  POST {action:create|update|delete,...}
 */
require __DIR__ . '/../includes/db.php';
$pdo = db();
$method = $_SERVER['REQUEST_METHOD'];

try {
    if ($method === 'GET') {
        $action = $_GET['action'] ?? 'list';
        if ($action === 'get') {
            $st = $pdo->prepare('SELECT * FROM students WHERE id = ?');
            $st->execute([(int)($_GET['id'] ?? 0)]);
            $row = $st->fetch();
            $row ? json_out($row) : json_out(['error' => 'Student not found.'], 404);
        }
        $q = '%' . trim($_GET['q'] ?? '') . '%';
        $course = trim($_GET['course'] ?? '');
        $sql = 'SELECT * FROM students WHERE (name LIKE ? OR email LIKE ?)';
        $args = [$q, $q];
        if ($course !== '') { $sql .= ' AND course = ?'; $args[] = $course; }
        $st = $pdo->prepare($sql . ' ORDER BY id');
        $st->execute($args);
        json_out($st->fetchAll());
    }

    if ($method === 'POST') {
        $in = body();
        $action = $in['action'] ?? '';
        $id = (int)($in['id'] ?? 0);

        if ($action === 'delete') {
            $st = $pdo->prepare('DELETE FROM students WHERE id = ?');
            $st->execute([$id]);
            json_out(['status' => $st->rowCount() ? 'deleted' : 'not found', 'id' => $id]);
        }
        if ($action === 'create' || $action === 'update') {
            $name = trim($in['name'] ?? ''); $course = trim($in['course'] ?? '');
            $year = (int)($in['year'] ?? 0); $email = trim($in['email'] ?? '');
            if ($name === '' || $course === '' || $year < 1 || $year > 6)
                json_out(['error' => 'Name, course and a year from 1 to 6 are required.'], 400);
            if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL))
                json_out(['error' => 'That email address is not valid.'], 400);

            if ($action === 'create') {
                $pdo->prepare('INSERT INTO students (name,course,year,email) VALUES (?,?,?,?)')
                    ->execute([$name, $course, $year, $email]);
                json_out(['status' => 'created', 'id' => (int)$pdo->lastInsertId()], 201);
            }
            $st = $pdo->prepare('UPDATE students SET name=?, course=?, year=?, email=? WHERE id=?');
            $st->execute([$name, $course, $year, $email, $id]);
            json_out(['status' => $st->rowCount() ? 'updated' : 'no changes', 'id' => $id]);
        }
        json_out(['error' => 'Unknown action.'], 400);
    }
    json_out(['error' => 'Method not allowed.'], 405);
} catch (Throwable $e) {
    json_out(['error' => 'Server error: ' . $e->getMessage()], 500);
}
