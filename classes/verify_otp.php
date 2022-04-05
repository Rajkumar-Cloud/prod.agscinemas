<?php

use function PHPSTORM_META\type;

include("config.php");
include("ags_mail.php");
date_default_timezone_set('Asia/Kolkata');
$today = date('Y-m-d H:i:s');


$mobile = $_POST['mobile'];
$otp = $_POST['otp'];


if($mobile !='' && $otp !=''){

    $checkotp=$link->query("SELECT * FROM users WHERE mobile ='$mobile' AND otp ='$otp'");
    $verified = $checkotp->fetch();
    
    if($verified){
    
        $link->query("UPDATE users SET status = '1' WHERE mobile ='$mobile' AND otp ='$otp'");
            
        $userDetails = $link->query("SELECT * FROM users WHERE mobile ='$mobile' AND status = '1' ");
        $res = $userDetails->fetch();

        if($res){
            
            $name = $res['name'];
            $userid = $res['id'];
            $profilepic = $res['profilepic'];
            $mobile = $res['mobile'];
            $email = $res['email'];

            setcookie("username", $name, time() + (86400 * 30), "/");
            setcookie("userid", $userid, time() + (86400 * 30), "/");
            setcookie("mobile", $mobile, time() + (86400 * 30), "/");
            setcookie("email", $email, time() + (86400 * 30), "/");

            if($profilepic)
                setcookie("profilepic", $profilepic, time() + (86400 * 30), "/");
            else
                setcookie("profilepic", " ", time() + (86400 * 30), "/");

            // $appendString ="Dear $name, Thanks for registering with AGS cinemas. Your account is successfully activated now, you can start your ticket booking for your favourite movie to enjoy the remarkable movie experience. thanks for choosing AGS cinemas. ";
            $appendString = "Dear Customer, Your OTP is Use this Passcode to complete your transaction. Thank you by AGS Cinemas.";
            $appendString1 = urlencode($appendString) ;
            $msg = str_replace("+","%20",$appendString1);
            $urls = "http://smscampaigns.msgbell.com/API/sms.php?username=VERANDA&password=Veranda@123&from=VRANDA&to=".$mobile."&msg=".$msg."&type=1&dnd_check=0&template_id=1707161526941623022";

            $handle = curl_init($urls);
            curl_setopt($handle, CURLOPT_POST, true);
            // curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            $contents = curl_exec($handle);
            curl_close($handle);

            error_log($urls,3,"register_error_log.txt");

            // Register Candidate Mail Trigger
            $service_type = "New User Registration";                       
            $template_body ="Dear $name, Thanks for registering with AGS cinemas. Your account is successfully activated now, you can start your ticket booking for your favourite movie to enjoy the remarkable movie experience. thanks for choosing AGS cinemas.";
            $sendMail = send_mail($email, $template_body, $service_type);   
            /*$sendMailRes = json_decode($sendMail);
            if($sendMailRes->type == 'Mail_success') {
                $json_array = ['type'=>'Success', 'alert'=>'registered', 'message'=>"Registration Successful!", 'code'=>'201'];
            } else {
                $json_array = ['type'=>'Success', 'alert'=>'registered', 'message'=>"Registration Successful mail not send!", 'code'=>'201'];
            }*/
            
            if($sendMail == "success") {
                $json_array = ['type'=>'Success', 'alert'=>'registered', 'message'=>"Registration Successful!", 'code'=>'201'];
            } else {
                $json_array = ['type'=>'Success', 'alert'=>'registered', 'message'=>"Registration Successful mail not send!", 'code'=>'201'];
            }
        }
    }else{
        $json_array = ['type'=>'Failed', 'alert'=>'wrong', 'message'=>"Wrong OTP.", 'code'=>'400'];
    }
        
}else{
    $json_array = ['type'=>'error', 'alert'=>'empty', 'message'=>'Empty data','code'=>401];
}



echo json_encode($json_array);




?>