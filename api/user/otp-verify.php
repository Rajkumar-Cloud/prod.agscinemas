<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare user object
$user = new User($db);

// set ID property of user to be edited
$user->mobile = isset($_POST['mobile']) ? $_POST['mobile'] : die();
$user->otp = isset($_POST['otp']) ? $_POST['otp'] : die();

// read the details of user to be edited
if(!empty($user->mobile) && !empty($user->otp)) {
    $stmt = $user->otpVerify(); 
} else {
    $stmt = ['status'=>'error', 'message'=>"the mobile no and otp should not be blank", 'code'=>401];
}
// make it json format
echo(json_encode($stmt));
?>