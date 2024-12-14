<?php
// Check Request Method
header('Access-Control-Allow-Methods: DELETE, OPTIONS'); 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Origin');

// Check Request Method
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
 http_response_code(211);
 echo json_encode('preflight handeled, awaiting DELETE request...');
 return;
}

else if ($_SERVER['REQUEST_METHOD'] != 'DELETE') {
    header('Allow: DELETE');
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

if(!$data || !isset($data['mark_id'])){
    http_response_code(422);
    echo json_encode(
        array('message' => 'Error: Missing required parameter mark_id in the JSON body.')
    );
    return;
}

$todo->setBookmarkId($data['mark_id']);

if ($todo->deleteMark()) {
    echo json_encode(
        array('message' => 'A '.$data['mark_id'].' bookmark was deleted successfully')
    );
} else {
    echo json_encode(
        array('message' => 'Error: a bookmark item was not deleted')
    );
}