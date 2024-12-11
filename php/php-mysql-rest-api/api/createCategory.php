<?php
//headers for all methods OPTIONS and POST
header('Access-Control-Allow-Methods: POST, OPTIONS'); 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Origin');

// Check Request Method
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
 http_response_code(211);
 echo json_encode('preflight handeled, awaiting post request...');
 return;
}

else if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Allow: POST');
    http_response_code(405);
    echo json_encode('Method Not Allowed');
    return;
}


include_once '../db/Database.php';
include_once '../models/Todo.php';

// Instantiate a Database object & connect
$database = new Database();
$dbConnection = $database->connect();

// Instantiate Todo object
$todo = new Todo($dbConnection);

// Get the HTTP POST request JSON body
$data = json_decode(file_get_contents("php://input"), true);
if(!$data || !isset($data['cat_title'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter cat_title in the JSON body.')
    );
    return;
}

$todo->set_Cat_title($data['cat_title']);

// Create ToDo
if ($todo->createCategory()) {
    echo json_encode(
        array('message' => 'A '.$data['cat_title'].' category was created successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a todo item was not created')
    );
}
