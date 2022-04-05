<?php 

    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("config.php");

    date_default_timezone_set('Asia/Kolkata');
    $today =date('Y-m-d H:i:s');
    $expiry_time =date('Y-m-d H:i:s',strtotime('+1 hour'));

    $mobile = $_POST['mobile'];

    if($mobile != ''){
        $randomnums = rand(1000, 9999);

        // $msg = "Dear AGS Customer, your OTP for Completion of Account Registration is $randomnums This will expire in 30 Minutes.";
        $appendString = "Dear Customer, Your OTP is $randomnums Use this Passcode to complete your transaction. Thank you by Veranda.";
        $appendString1 = urlencode($appendString) ;
        $msg = str_replace("+","%20",$appendString1);
        $urls = "http://smscampaigns.msgbell.com/API/sms.php?username=VERANDA&password=Veranda@123&from=VRANDA&to=".$mobile."&msg=".$msg."&type=1&dnd_check=0&template_id=1707161526941623022";    
        // $urls = "https://control.msg91.com/api/sendhttp.php?authkey=161404AqQqRTYF594ce5e6&mobiles=".$mobile."&message=".$msg."&sender=AGSPWD&route=4&country=91";
        $handle = curl_init($urls);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($handle);
        curl_close($handle);
        error_log($urls,3,"otp_error_log.txt");
        if($contents) {

            $userDetails = $link->query("SELECT * FROM users WHERE mobile ='$mobile' ");
            $res = $userDetails->fetch();

            if($res){
                $otpCount = $res['otp_count'] + 1;
                $link->query("UPDATE users SET otp = '$randomnums' , otp_count = '$otpCount', expiry_time = '$expiry_time' WHERE mobile ='$mobile'");
                $json_array = ['type'=>'Success', 'alert'=>'Sendotp', 'message'=>"Successfully sent otp!", 'code'=>'201'];
            }

        }else{
            $json_array = ['type'=>'Failed', 'alert'=>'Sendotp', 'message'=>"send otp Failed!", 'code'=>'401'];   
        }
    }else{
        $json_array = ['type'=>'Failed', 'alert'=>'empty', 'message'=>"Empty data", 'code'=>'401'];
    }
    echo json_encode($json_array);


?>