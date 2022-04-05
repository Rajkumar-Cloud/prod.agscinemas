<?php 
    
    include "config.php";
    $email = $_POST['email'];
    $password = $_POST['password'];
    if($email != '') {	
    $checkotp = $link->query("SELECT * FROM users WHERE email='$email'");
        $verified = $checkotp->fetch();
        if($verified) {
            $result2 = $link->query("SELECT * FROM users WHERE email='$email'");
            $resultrow1 = $result2->fetch();
            $userid1 = $resultrow1['id'];
            $newpassword1 = hash('sha512', $password . $userid1);
            $stmt1 = $link->query("SELECT * FROM `users` WHERE email='$email' AND password='$newpassword1'");
            $res1 = $stmt1->fetch();
            if($res1) {        
                if($verified['status'] == '1' && ($verified['otp'] != '' || $verified['otp'] != null)){
                    $stmt = $link->query("SELECT COUNT(*) FROM users WHERE email='$email' AND status = '1'");
                    $result = $stmt->fetch();
                    if($result[0] != 0) {
                        $result1 = $link->query("SELECT * FROM users WHERE email='$email' AND status = '1'");
                        $resultrow = $result1->fetch();
                        $userid = $resultrow['id'];
                        $newpassword = hash('sha512', $password . $userid);

                        $stmt1=$link->query("SELECT * FROM `users` WHERE email='$email' AND password='$newpassword' AND status = '1'");
                        $res = $stmt1->fetch();
                        if($res) {                        
                            $name = $res['name'];
                            $userid = $res['id'];
                            $profilepic = $res['profilepic'];
                            $mobile = $res['mobile'];

                            setcookie("username", $name, time() + (86400 * 30), "/");
                            setcookie("userid", $userid, time() + (86400 * 30), "/");
                            setcookie("mobile", $mobile, time() + (86400 * 30), "/");
                            setcookie("email", $email, time() + (86400 * 30), "/");
                            if($profilepic) {
                                setcookie("profilepic", $profilepic, time() + (86400 * 30), "/");
                            } else {
                                setcookie("profilepic", " ", time() + (86400 * 30), "/");
                            }                        
                            $json_array = ['type'=>'Success', 'alert'=>'login', 'message'=>"Login successfully!", 'code'=>'201'];
                        } else {
                            $json_array = ['type'=>'Success', 'alert'=>'passwrong', 'message'=>"Your Password is Wrong!", 'code'=>'201'];
                        }
                    } else {
                        $json_array = ['type'=>'Success', 'alert'=>'emailwrong', 'message'=>"The given details are incorrect", 'code'=>'201'];
                    }
                } else {
                    $json_array = ['type'=>'Failed', 'alert'=>'otpverify', 'message'=>"Please verify the OTP!", 'mobile'=>$verified['mobile'], 'code'=>'201'];
                }
            } else {
                $json_array = ['type'=>'Success', 'alert'=>'passwrong', 'message'=>"The given details are incorrect", 'code'=>'201'];
            }
        } else {
            $json_array = ['type'=>'Success', 'alert'=>'emailwrong', 'message'=>"Your email address is not exist", 'code'=>'201'];
        }
    } else {
        $json_array = ['type'=>'Success', 'alert'=>'error', 'message'=>"Email or password was empty!", 'code'=>'401'];
    }
    echo json_encode($json_array);

?>