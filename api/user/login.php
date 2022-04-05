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
$user->password = isset($_POST['password']) ? $_POST['password'] : die();  

// read the details of user to be edited
$stmt = $user->login();
// make it json format
echo(json_encode($stmt));
?>