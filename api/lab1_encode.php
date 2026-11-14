<?php
// Lab 1, Exercise 1: PHP array -> JSON string
header('Content-Type: application/json');
$student = ['name' => 'Venice Canlas', 'age' => 21, 'course' => 'IT'];
echo json_encode($student);   // {"name":"Venice Canlas","age":21,"course":"IT"}
