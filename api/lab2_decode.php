<?php
// Lab 1, Exercise 2: JSON string -> PHP object AND associative array
header('Content-Type: application/json');
$json = '{"name":"Venice Canlas","age":21,"email":"venice@example.com"}';
$obj  = json_decode($json);         // stdClass object
$arr  = json_decode($json, true);   // associative array
echo json_encode([
    'source_json'  => $json,
    'object_name'  => $obj->name,        // object syntax: ->
    'object_email' => $obj->email,
    'array_name'   => $arr['name'],      // array syntax: ['key']
    'array_email'  => $arr['email'],
]);
