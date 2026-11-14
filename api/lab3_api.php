<?php
// Lab 1, Exercise 3: behaves like a tiny REST API
header('Content-Type: application/json');
$profile = ['id' => 1, 'name' => 'Venice Canlas', 'email' => 'venice@example.com', 'status' => 'active'];
echo json_encode($profile);
