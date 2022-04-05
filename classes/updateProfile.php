<?php 
    include("config.php");
    include("../classes/ags_mail.php");

    if(isset($_REQUEST['profileUpdate'])) { 
        $userId = $_COOKIE['userid'];
        $email = $_POST['email'];
        $mobile = $_POST['mobileno'];
        $profile = $_FILES['profilepic'];
        $imageUpload = '';
        $profilepic = '';
        if ($profile['size'] != 0 && $profile['error'] == 0) 
            $imageUpload = imageUpload($userId,$profile);
        $ImageData = json_decode($imageUpload);

        if($ImageData->uploadOk == 1) {
            $profilepic = $ImageData->profilepic;
        }

        $sqlUpdate = $link->prepare("UPDATE `users` set email=:email, mobile=:mobile, profilepic=:profilepic where id=:id");
        $sqlUpdate->bindParam(':email',$email,PDO::PARAM_STR, 50);
        $sqlUpdate->bindParam(':mobile',$mobile,PDO::PARAM_STR, 20);
        $sqlUpdate->bindParam(':profilepic',$profilepic,PDO::PARAM_STR, 50);
        $sqlUpdate->bindParam(':id',$_COOKIE['userid'],PDO::PARAM_INT, 5);
        if($sqlUpdate->execute()) {
            setcookie("mobile", $mobile, time() + (86400 * 30), "/");
            setcookie("email", $email, time() + (86400 * 30), "/");
            setcookie("profilepic", $profilepic, time() + (86400 * 30), "/");
            $json_array = ['type'=>'success', 'alert'=>'success', 'message'=>"profile details updated successfully!", 'code'=>'201'];
        } else {
            $json_array = ['type'=>'fail', 'alert'=>'error', 'message'=>"failed to update your profile", 'code'=>'401'];
        }
    }



    function imageUpload($userid,$profilepic) {

        $target_dir = "../assets/Profile/";
        $target_file = $target_dir . $userid."_".basename($profilepic["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));


        if(isset($profilepic)) {
          $check = getimagesize($profilepic["tmp_name"]);
          if($check !== false) {
            $message = "File is an image - " . $check["mime"] . ".";
            $uploadOk = 1; 
          } else {
            $message = "File is not an image.";
            $uploadOk = 0;
          }
        }

        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" ) {
          $message = "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
          $uploadOk = 0;
        }

        if ($uploadOk == 0) {
          $response = ['message' => $message, 'uploadOk' => $uploadOk];
        } else {
          if (move_uploaded_file($profilepic["tmp_name"], $target_file)) {
            $profilepic = htmlspecialchars( $userid."_".basename( $profilepic["name"]));
            $message = "The file ". $profilepic. " has been uploaded.";
            $response = ['message' => $message, 'uploadOk' => $uploadOk, 'profilepic' => $profilepic];
          } else {
            $message = "Sorry, there was an error uploading your file.";
            $response = ['message' => $message, 'uploadOk' => $uploadOk];
          }
        }

        return json_encode($response);

    }

    echo json_encode($json_array);

?>