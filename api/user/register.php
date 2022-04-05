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
$user->name = isset($_POST['name']) ? $_POST['name'] : die();
$user->email = isset($_POST['email']) ? $_POST['email'] : die();
$user->password = isset($_POST['password']) ? $_POST['password'] : die();  
$user->mobile = isset($_POST['mobile']) ? $_POST['mobile'] : die();  

// read the details of user to be edited
if(!empty($user->email)) {
    if(filter_var($user->email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $user->signup();
        if($stmt == false) {
	    $stmt = ['status'=>'exist', 'message'=>"the given email or mobile no already exists", 'code'=>201];
        } else {
            $stmt = ['status'=>'success', 'message'=>"you are register successfully", 'code'=>200];
        }
    } else {
        $stmt = ['status'=>'error', 'message'=>"not valid email", 'code'=>201];
    }
} else {
    $stmt = ['status'=>'error', 'message'=>"the fields should not be blank", 'code'=>401];
}
// make it json format
echo(json_encode($stmt));
?>