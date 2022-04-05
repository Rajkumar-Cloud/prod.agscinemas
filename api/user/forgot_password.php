<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
 

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);

// set ID property of user to be edited
$user->email = isset($_POST['email']) ? $_POST['email'] : die(); 

// forgot password
$stmt = $user->forgot_password();
// make it json format
echo(json_encode($stmt));
?>