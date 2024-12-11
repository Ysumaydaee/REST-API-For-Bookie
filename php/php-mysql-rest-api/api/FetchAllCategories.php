<?php
// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header('Allow: GET');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}

header('Access-Control-Allow-Methods: GET');
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');

include_once '../db/Database.php';
include_once '../models/Todo.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Todo object
$todo = new Todo($dbConnection);


// Read all ToDo items
$result = $todo->fetchAllCategories();
if (!empty($result)) {
    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'No categories exist',
        'categories' => $result
    ]);
}
