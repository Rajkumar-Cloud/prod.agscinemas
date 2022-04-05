<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("config.php");
    include("ags_mail.php");
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
    $expiry_time = date('Y-m-d H:i:s',strtotime('+1 hour'));
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $mobile = $_POST['mobileno'];
    $balance='0';

    if($email != '' && $password !='' && $name !=''){
        $result = $link->query("SELECT COUNT(*) FROM users WHERE email='$email' AND status = '1'");
        $check_email = $result->fetch();

        $result3 = $link->query("SELECT COUNT(*) FROM users WHERE mobile='$mobile' AND status = '1'");
        $check_mobile = $result3->fetch();

        if($check_email[0] > 0 && $check_mobile[0] > 0){
            $json_array = ['type'=>'error', 'alert'=>'email_mobile', 'message'=>'Email and Mobile Number Already Registered!','code'=>401];
        }
        else if($check_email[0] > 0){
            $json_array = ['type'=>'error', 'alert'=>'email', 'message'=>'Email Already Registered!','code'=>401];
        }
        else if($check_mobile[0] > 0){
            $json_array = ['type'=>'error', 'alert'=>'mobile', 'message'=>'Mobile Number Already Registered!','code'=>401];
        }
        else if($check_email[0] == 0 && $check_mobile[0] == 0) {
            $result1 = $link->query("INSERT INTO `users`(`name`, `email`, `password`, `mobile`, `balance`,`device`,`signuptime`) VALUES ('$name','$email','$password','$mobile','$balance','web','$today')");                
            $pwdquery = $link->query("SELECT * FROM users WHERE email='$email' AND password ='$password'");
            $pwdrow = $pwdquery->fetch();

            $userid = $pwdrow['id'];
            $haspwd = hash('sha512', $password . $userid);
            
            $updatequery = $link->query("UPDATE users SET password = '$haspwd' WHERE id ='$userid'");    

            $sentOTP = otp_send($mobile, $userid, $link, $expiry_time, $email);    
            
            $sentData = json_decode($sentOTP);

            if($sentData->type == 'Success') {
                $json_array = ['type'=>$sentData->type, 'alert'=>$sentData->alert, 'mobile'=>$sentData->mobile, 'message'=>$sentData->message, 'code'=>'201'];
            } else {
                $json_array = ['type'=>$sentData->type, 'alert'=>$sentData->alert, 'mobile'=>$sentData->mobile, 'message'=>$sentData->message, 'code'=>'401'];
            }
        }        
    } else {
        $json_array = ['type'=>'error', 'alert'=>'empty', 'message'=>'Empty data','code'=>401];
    }

    function otp_send($mobile, $userid, $link, $expiry_time, $email) {
        $randomnums = rand(1000, 9999);
        $appendString = "Dear AGS Customer, your OTP for Completion of Account Registration is $randomnums This will expire in 30 Minutes.";
        // $appendString = "Dear Customer, Your OTP is $randomnums Use this Passcode to complete your transaction. Thank you by Veranda.";        
        $appendString1 = urlencode($appendString) ;
        $msg = str_replace("+","%20",$appendString1);        
        // $urls = "http://smscampaigns.msgbell.com/API/sms.php?username=VERANDA&password=Veranda@123&from=VRANDA&to=".$mobile."&msg=".$msg."&type=1&dnd_check=0&template_id=1707161526941623022";                     
        $urls = "https://control.msg91.com/api/sendhttp.php?authkey=161404AqQqRTYF594ce5e6&mobiles=".$mobile."&message=".$msg."&sender=AGSROT&route=4&country=91";
        $handle = curl_init($urls);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($handle);
        curl_close($handle);
        error_log($urls,3,"otp_error_log.txt");
	// OTP send confirmation throught Given Email          
        $message = "Dear Customer, Your OTP is <b>$randomnums</b> Use this Passcode to complete your transaction. Thank you by AGS Cinemas.";        
        $service_type = "New Registration - OTP Verification";                       
        $template_body = "
        <div style='width:100%;background-color:transparent;display:block;text-align:left;'>
            <img src='https://pbs.twimg.com/profile_images/935001716285612032/fhRidd97_400x400.jpg' style='width: 10%; margin-left:12px;' alt='AGS Logo' />            
            <p style='margin:1rem auto;color:#000;'>".$message."</p>            
            <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Warm Regards by<br/>AGS Team </p>
        </div>";
        send_mail($email, $template_body, $service_type); 
	
        if($contents) {
            $link->query("UPDATE users SET otp = '$randomnums' , otp_count = '1', expiry_time = '$expiry_time' WHERE id ='$userid'");
            $json_array = ['type'=>'Success', 'alert'=>'Sendotp', 'mobile'=>$mobile, 'message'=>"Successfully sent otp!", 'code'=>'201'];
        } else {
            $json_array = ['type'=>'Failed', 'alert'=>'Sendotp', 'mobile'=>$mobile, 'message'=>"send otp Failed!", 'code'=>'401'];   
        }
        return json_encode($json_array);
    }
    echo json_encode($json_array);
?>