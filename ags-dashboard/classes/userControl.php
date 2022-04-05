<?php
    session_start();
    include("config.php");   
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;
    require_once '../../classes/php/vendor/autoload.php';

    if(isset($_POST['userLogin'])) {
        $userEmail = $_POST['userEmail'];
        $password = md5($_POST['userPassword']);
        // $user_sql = "SELECT `name`, `email`, `password`, `user_role`, `mobile`, `profile_path` FROM `ags_admin` WHERE `email`=:email AND `password`=:password";
	$user_sql = "SELECT a.id, a.name, a.email, a.password, a.user_role, r.role, a.mobile, a.profile_path, a.status, a.locationId FROM ags_admin AS a INNER JOIN roles AS r ON r.role_code = a.user_role WHERE a.email=:email AND a.password=:password";
        $query = $link->prepare($user_sql);
        $query->bindParam(':email', $userEmail, PDO::PARAM_STR);
        $query->bindParam(':password', $password, PDO::PARAM_STR);
        // $query->bindParam(':status', $userStatus, PDO::PARAM_INT);
        $query->execute();
        $results = $query->fetch(PDO::FETCH_OBJ);
        if($query->rowCount() > 0) {             
             if($results->status == 1) {
                $_SESSION['username'] = $results->name;            
                $_SESSION['userData'] = $results;
                if($results->user_role == 1 || $results->user_role == 7) 
                    header("Location:../index.php");
                else
                    header("Location:../dashboard.php");
            } else {
                $_SESSION["error"] = 'Your login access currently inactive. please contact to Admin';            
                header("Location:../login.php"); 
            }
        } else {
            $_SESSION["error"] = 'The username and password you entered is incorrect. please try again.';            
            header("Location:../login.php");            
        }
    }

    if(isset($_REQUEST['userRegister'])) {        
        $user_Data = [
            'name' => $_POST['userName'],
            'email' => $_POST['userEmail'],
            'password' => md5($_POST['userPassword']),
            'mobile' => $_POST['userMobileno'],
            'user_role' => $_POST['roleAssign'],
            'locationId' => $_POST['user_location'],
            'status' => $_POST['access_status']
        ];        
        $exist_qry = $link->prepare("SELECT email, mobile FROM `ags_admin` WHERE email=:email");
        $exist_qry->bindParam(':email', $_POST['userEmail'], PDO::PARAM_STR);
        $exist_qry->execute();
        if($exist_qry->rowCount() > 0) {
            $user_arr = ['type'=>'response', 'status'=> 'exist', 'message'=>'email_exist', 'code'=>'201'];        
        } else {
            $userRegsql = "INSERT INTO `ags_admin` (name, email, password, mobile, user_role, locationId, status) VALUES (:name, :email, :password, :mobile, :user_role, :locationId, :status)";
            $reg_stmt= $link->prepare($userRegsql);
            $reg_stmt->execute($user_Data);
            $lastInsertId = $link->lastInsertId();                
            if($lastInsertId > 0) {
                $user_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'inserted', 'code'=>'201'];        
            } else {
                $user_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'insert-error', 'code'=>'401'];            
            }  
        }             
        echo json_encode($user_arr); 
    }

    if(isset($_REQUEST['userAdmin_deletion'])) {
        $del_id = $_REQUEST['rowId'];
        $del_sql = 'DELETE FROM `ags_admin` WHERE id = :id';
        $user_st = $link->prepare($del_sql);
        $user_st->bindParam(':id', $del_id, PDO::PARAM_INT);
        $user_st->execute();
        $del_count = $user_st->rowCount();
        if($del_count > 0) {
            $del_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'deleted', 'code'=>'201'];        
        } else {
            $del_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'delete-error', 'code'=>'401'];            
        }       
        echo json_encode($del_arr);
    }

    if(isset($_REQUEST['userAdmin_statusUpdation'])) {
        $status_sql = "UPDATE `ags_admin` SET `status` = :status WHERE `id` = :id";
        $stsUpdate_st = $link->prepare($status_sql);
        $stsUpdate_st->bindParam(':id', $_REQUEST['rowId'], PDO::PARAM_INT);
        $stsUpdate_st->bindParam(':status', $_REQUEST['status'], PDO::PARAM_INT);
        $stsUpdate_st->execute();
        $up_count = $stsUpdate_st->rowCount();
        if($up_count > 0) {
            $up_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'updated', 'code'=>'201'];        
        } else {
            $up_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'update-error', 'code'=>'401'];            
        }       
        echo json_encode($up_arr);
    }

    if(isset($_REQUEST['userProfile_update'])) {
        $update_data = [
            'id' => $_REQUEST['user_profile_id'],
            'email' => $_REQUEST['user_profile_email'],
            'mobile' => $_REQUEST['user_profile_mobile']
        ];
        $profile_sql = "UPDATE `ags_admin` SET `email` = :email, `mobile` = :mobile WHERE `id` = :id";
        $update_st = $link->prepare($profile_sql);
        $update_st->execute($update_data);
        $pr_count = $update_st->rowCount();            
        if($pr_count > 0) {
            $profile_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'updated'];        
        } else {
            $profile_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'update-error'];            
        }       
        echo json_encode($profile_arr);
    }
	
    if(isset($_REQUEST['mailTriger'])) {        
        $userId = $_POST['userId']; 
        $user_name = $_POST['username'];                
        $user_mail = $_POST['email'];
        $mail_status = 1;
        $status_sql = $link->prepare("UPDATE `users` SET mail_status = :mail_status WHERE id = :id");
        $status_sql->bindParam(':mail_status', $mail_status, PDO::PARAM_INT);
        $status_sql->bindValue(':id', $userId);        
        $status_sql->execute();
        $service_type = "Single_mail";                       
        $template_body = "<div style='padding:8px'>
                    <img style='width: 82px;display:block;' title='AGS Cinemas' src='https://www.agscinemas.com/assets/images/logos/ags-logo.jpg' alt='logo' />
                    <div style='font-family:trebuchet ms,sans-serif;margin:12px auto;padding:15px;border:1px solid #ddd;background-color:#fff;'>
                        <h5 style='font-weight:600;margin-top:0;margin-bottom:18px;font-size:15px;color:#343434;'>Dear customer,</h5>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>We are delighted to inform you that AGS Cinemas is making live its own website so you can now book your tickets with us at the ease of your own home. The website has been designed in line with the <b>#AGS Cinemas</b> experience.</p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>As we enjoy your continued patronage we decided to make it easier for you. In our effort to make your movie-going experience a memorable one we have added the AGS Cinemas website so you can now book your tickets on the go and enjoy the latest movies at your favourite multiplex! </p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'> We welcome you to re-register with us on the below link
                        <a href='https://www.agscinemas.com/' target='_self' style='font-family:trebuchet ms,sans-serif;background-color:#ffe599;padding:2px;font-size:12px;'>Click here to login your account</a></p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>Hoping to serve you very soon and ever grateful for your patronage. </p>                        
                        <p style='font-weight:400;margin: 2rem 0px 1px auto;font-size: 14px;'>Warm regards, <br>Teams AGS Cinemas.</p>
                    </div>
                </div>";
        $sendMail = recover_send_mail($user_mail, $template_body, $service_type);        
        echo json_encode($sendMail);
    }   

    if(isset($_REQUEST['bulkTrigring'])) {
        $bulk_arr = $_POST['bulkSend_arr'];              
        $id_arr = array();    
        $name_arr = array();            
        $email_arr = array();            
        foreach($bulk_arr as $key => $val) {
            $id_arr[$key] = $val['id'];
            $name_arr[$key] = $val['name'];
            $email_arr[$key] = $val['email'];            
        }
        $ids = implode(',', $id_arr);
        $bulk_sql = "UPDATE `users` SET `mail_status` = '1' WHERE id IN ($ids)";
        $bulk_stmt = $link->query($bulk_sql);        
        $service_type = "Bulk_mail";
        $template_body = "<div style='padding:8px'>
                    <img style='width: 82px;display:block;' title='AGS Cinemas' src='https://www.agscinemas.com/assets/images/logos/ags-logo.jpg' alt='logo' />
                    <div style='font-family:trebuchet ms,sans-serif;margin:12px auto;padding:15px;border:1px solid #ddd;background-color:#fff;'>
                        <h5 style='font-weight:600;margin-top:0;margin-bottom:18px;font-size:15px;color:#343434;'>Dear customer,</h5>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>We are delighted to inform you that AGS Cinemas is making live its own website so you can now book your tickets with us at the ease of your own home. The website has been designed in line with the <b>#AGS Cinemas</b> experience.</p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>As we enjoy your continued patronage we decided to make it easier for you. In our effort to make your movie-going experience a memorable one we have added the AGS Cinemas website so you can now book your tickets on the go and enjoy the latest movies at your favourite multiplex! </p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'> We welcome you to re-register with us on the below link
                        <a href='https://www.agscinemas.com/' target='_self' style='font-family:trebuchet ms,sans-serif;background-color:#ffe599;padding:2px;font-size:12px;'>Click here to login your account</a></p>
                        <p style='font-weight:300;font-size:13px;color:#343434;'>Hoping to serve you very soon and ever grateful for your patronage. </p>                        
                        <p style='font-weight:400;margin: 2rem 0px 1px auto;font-size: 14px;'>Warm regards, <br>Teams AGS Cinemas.</p>
                    </div>
                </div>";
        $bulk_mail_response = recover_send_mail($email_arr, $template_body, $service_type);
        echo json_encode($bulk_mail_response);
    }

    if(isset($_REQUEST['userAdmin_pwdreset'])) {        
        $userId = $_REQUEST['rowId'];
        $user_sql = $link->prepare("SELECT id, name, email, password, user_role, mobile, profile_path, status, locationId FROM ags_admin WHERE id=:id");        
        $user_sql->bindValue(':id', $userId);
        $user_sql->execute();
        if( $user_sql->rowCount() > 0 ) {
                $user_results = $user_sql->fetch(PDO::FETCH_ASSOC);
            if($user_results['status'] == 1) {
                $resend_email = $user_results['email'];
                $resend_id = $user_results['id'];
                $oauth_token = openssl_random_pseudo_bytes(16);
                $user_token = bin2hex($oauth_token);
                $update_oauth = $link->prepare("UPDATE `ags_admin` SET oauth_uid = :oauth_uid WHERE id = :id");
                $update_oauth->bindParam(':oauth_uid', $user_token);
                $update_oauth->bindValue(':id', $resend_id);
                $username = $user_results['name'];
                if ($update_oauth->execute()) {               
                    $service_type = "Reset your password";                       
                    $template_body = "<div style='padding:8px'>
                        <img style='width: 82px;display:block;' title='AGS Cinemas' src='https://www.agscinemas.com/assets/images/logos/ags-logo.jpg' alt='logo' />
                        <div style='margin:12px auto;padding:15px;border:1px solid #ddd;background-color:#fff;'>
                            <h5 style='font-weight:200;margin-top:0;margin-bottom:18px;font-size:17px;color:#343434;'>Hello $username, </h5>
                            <p style='font-weight:bold;font-size:15px;color:#343434;'>A request has been received to change the password for your AGS Cinema account.</p>
                            <a href='https://www.agscinemas.com/ags-dashboard/reset-password.php?auth=$user_token&email=$resend_email' target='_self' style='padding:10px 12px;background-color:#1a73e8;color:#fff;font-size:12px;'>Click to reset your password</a>                    
                            <p style='font-weight:300;margin:2rem 0px 0px auto;font-size: 15px;color:#343434;'>If you did not initiate this request, please contact us immediately at</p>
                            <a href='mailto:wecare@agscinemas.com' target='_self' style='font-weight:300;font-size:14px;text-decoration:underline;'>wecare@agscinemas.com</a><br />
                            <p style='font-weight:400;margin: 3rem 0px 1px auto;font-size: 15px;'>Thank you <br>The AGS Cinemas Team.</p>
                        </div>
                    </div>";
                    $sendMail = reset_send_mail($resend_email, $template_body, $service_type);
                    $json_array = ['status'=>'success', 'message'=>"reset link send successfully!", 'code'=>'201'];
                }
            } else {
                $json_array = ['status'=>'failed', 'message'=>"This user is in-active please active and reset password", 'code'=>'401'];
            }
        } else {
            $json_array = ['status'=>'failed', 'message'=>"This user not found", 'code'=>'401'];
        }   
        echo json_encode($json_array);
    }

    if(isset($_REQUEST['userAdmin_updatePassword'])) {
        $auth_id = $_REQUEST['auth_id'];
        $reset_email = $_REQUEST['email'];
        $get_sql = $link->prepare('SELECT id FROM `ags_admin` WHERE oauth_uid =:oauth_uid AND email =:email');
        $get_sql->execute(['oauth_uid' => $auth_id, 'email' => $reset_email]);    
        $user_getData = $get_sql->fetch();    
        if(empty($user_getData)) {
            $json_array = ['status'=>'failed', 'message'=>"password update failed!", 'code'=>'401'];
        } else {
            $haspwd = md5($_REQUEST['password']);        
            $password_data = ['password' => $haspwd, 'status'=> '1', 'oauth_uid' => '0', 'id' => $user_getData['id'] ];
            $p_sql = $link->prepare('UPDATE `ags_admin` SET password=:password, status=:status, oauth_uid=:oauth_uid WHERE id=:id');
            $p_sql->execute($password_data);   
            $json_array = ['status'=>'success', 'message'=>"password reset successfully!", 'code'=>'201'];
        } 
        echo json_encode($json_array);
    }   

    function recover_send_mail($mailId, $body, $service_type) {            
        $mail_body = $body;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = false;
        $mail->isSMTP();     
        $mail->SMTPAuth = true;                          
        $mail->Username = 'AKIASED4WTLLWZ62DNFP';
        $mail->Password = 'BAQSEdMODYC1J75hmGGXrlHvsh6IozG13fyUt+cKUdIw';
        $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->setFrom('webticketing@agscinemas.com', 'AGS cinemas');        
        $mail->isHTML(true);        
        if($service_type == "Single_mail") {     
            $mail->addAddress($mailId, 'AGS Cinemas');       
            $mail->addBCC('rajkumar.v@verandalearning.com');
            $mail->addBCC('thandthandauthabani.c@agscinemas.com');
        } else {
            foreach ($mailId as $key => $value) {
                $mail->addAddress('thandthandauthabani.c@agscinemas.com');
                $mail->addBCC(trim($value)); 
                $mail->addBCC('rajkumar.v@verandalearning.com');                               
            }
        }        
	$mail->Subject = "Existing Customer Re-registration";
        $mail->Body = $mail_body; 
        if($mail->send()) {       
            $json_array = ['type'=>'email', 'status'=>"success",'message'=>"Mail send successfully",'code'=>'201'];
        } else {
            $json_array = ['type'=>'email', 'status'=>"fail",'message'=>"Mailer Error: ' . $mail->ErrorInfo",'code'=>'201'];            
        }
        return $json_array;
    }

    function reset_send_mail($mailId, $body, $service_type) {            
        $mail_body = $body;
        $mail = new PHPMailer(true);
        $mail->SMTPDebug = false;
        $mail->isSMTP();     
        $mail->SMTPAuth = true;                          
        $mail->Username = 'AKIASED4WTLLWZ62DNFP';
        $mail->Password = 'BAQSEdMODYC1J75hmGGXrlHvsh6IozG13fyUt+cKUdIw';
        $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
        $mail->SMTPSecure = "tls";
        $mail->Port = 587;
        $mail->setFrom('webticketing@agscinemas.com', 'AGS cinemas');        
        $mail->isHTML(true);        
        if($service_type == "Reset your password") {     
            $mail->addAddress($mailId, 'AGS Cinemas');
            $mail->addBCC('rajkumar.v@verandalearning.com');
        }      
    $mail->Subject = "AGS - Reset Password";
        $mail->Body = $mail_body; 
        if($mail->send()) {       
            $json_array = ['type'=>'email', 'status'=>"success",'message'=>"Mail send successfully",'code'=>'201'];
        } else {
            $json_array = ['type'=>'email', 'status'=>"fail",'message'=>"Mailer Error: ' . $mail->ErrorInfo",'code'=>'201'];            
        }
        return $json_array;
    }

?>