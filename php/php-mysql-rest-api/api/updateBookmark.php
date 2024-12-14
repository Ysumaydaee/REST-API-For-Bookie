<?php
header('Access-Control-Allow-Methods: PUT, OPTIONS'); 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Origin');

// Check Request Method
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
 http_response_code(211);
 echo json_encode('preflight handeled, awaiting PUT request...');
 return;
}

// Check Request Method
if ($_SERVER['REQUEST_METHOD'] != 'PUT') {
    header('Allow: PUT');
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

// Get the HTTP PUT request JSON body
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['mark_id']) || !isset($data['url']) || !isset($data['title'])) {
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameters mark_id, title, or url in the JSON body.')
    );
    return;
}

$todo->setBookmarkId($data['mark_id']);
$todo->setMarkLink($data['url']);
$todo->setMarkTitle($data['title']);


// Update the ToDo item
if ($todo->updateBookmark()) {
    echo json_encode(
        array('message' => 'A bookmark was updated.')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark was not updated.')
    );
}
