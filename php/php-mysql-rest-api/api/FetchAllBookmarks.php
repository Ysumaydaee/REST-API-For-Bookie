<?php
// Check Request Method
header('Access-Control-Allow-Methods: GET, OPTIONS'); 
header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
header('Access-Control-Allow-Headers: Content-Type, Origin');

// Check Request Method
if($_SERVER['REQUEST_METHOD'] == 'OPTIONS'){
 http_response_code(211);
 echo json_encode('preflight handeled, awaiting GET request...');
 return;
}

else if ($_SERVER['REQUEST_METHOD'] != 'GET') {
    header('Allow: GET');
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

$result = $todo->FetchAllBookmarks();

if (!empty($result)) {
    echo json_encode($result);
} else {
    echo json_encode([
        'message' => 'No Bookmarks exist',
        'bookmarks' => $result
    ]);
}