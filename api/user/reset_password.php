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
$user->auth_token = isset($_POST['auth_token']) ? $_POST['auth_token'] : die();
$user->password = isset($_POST['password']) ? $_POST['password'] : die();

// forgot password
$stmt = $user->reset_password();
// make it json format
echo(json_encode($stmt));
?>