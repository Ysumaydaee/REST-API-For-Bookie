<?php
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

$data = json_decode(file_get_contents("php://input"), true);
if(!$data || !isset($data['cat_id']) || !isset($data['link']) || !isset($data['mark'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter cat_id, link, or mark in the JSON body.')
    );
    return;
}

$todo->setCatId($data['cat_id']);
$todo->setMarkTitle($data['mark']);
$todo->setMarkLink($data['link']);

if ($todo->createBookMark()) {
    echo json_encode(
        array('message' => 'A '.$data['mark'].' bookmark was created successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark item was not created')
    );
}