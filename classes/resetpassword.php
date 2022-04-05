<?php 
    include("config.php");
    include("ags_mail.php");
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
    if(isset($_REQUEST['resetpassword'])) { 
        $resend_email = $_REQUEST['resend_email'];
        $user_sql = $link->prepare("SELECT id, name, email FROM `users` WHERE email= :email");        
        $user_sql->bindValue(':email', $resend_email);
        $user_sql->execute();
        if( $user_sql->rowCount() > 0 ) {
            $user_results = $user_sql->fetch(PDO::FETCH_ASSOC);
            $oauth_token = openssl_random_pseudo_bytes(16);
            $user_token = bin2hex($oauth_token);
            $update_oauth = $link->prepare("UPDATE `users` SET oauth_uid = :oauth_uid WHERE id = :id");
            $update_oauth->bindParam(':oauth_uid', $user_token);
            $update_oauth->bindValue(':id', $user_results['id']);
            $username = $user_results['name'];
            if ($update_oauth->execute()) {               
                $service_type = "Reset your password";                       
                $template_body = "<div style='padding:8px'>
                    <img src='https://www.agscinemas.com/assets/images/logos/ags-logo.jpg' style='width: 82px;display:block;' title='AGS Cinemas' alt='logo' />
                    <div style='margin:12px auto;padding:15px;border:1px solid #ddd;background-color:#fff;'>
                        <h5 style='font-weight:200;margin-top:0;margin-bottom:18px;font-size:17px;color:#343434;'>Hello $username, </h5>
                        <p style='font-weight:bold;font-size:15px;color:#343434;'>A request has been received to change the password for your AGS Cinema account.</p>
                        <a href='https://www.agscinemas.com/reset-password.php?auth=$user_token&email=$resend_email' target='_self' style='padding:10px 12px;background-color:#1a73e8;color:#fff;font-size:12px;'>Click to reset your password</a>                    
                        <p style='font-weight:300;margin:2rem 0px 0px auto;font-size: 15px;color:#343434;'>If you did not initiate this request, please contact us immediately at</p>
                        <a href='mailto:wecare@agscinemas.com' target='_self' style='font-weight:300;font-size:14px;text-decoration:underline;'>wecare@agscinemas.com</a><br />
                        <p style='font-weight:400;margin: 3rem 0px 1px auto;font-size: 15px;'>Thank you <br>The AGS Cinemas Team.</p>
                    </div>
                </div>";
                $sendMail = send_mail($resend_email, $template_body, $service_type);
                $json_array = ['type'=>'success', 'message'=>"reset link send successfully!", 'code'=>'201'];
            }
        } else {
            $json_array = ['type'=>'failed', 'message'=>"email address not found", 'code'=>'401'];
        }       
    }

    if(isset($_REQUEST['updatePassword'])) {
        $auth_id = $_REQUEST['auth_id'];
        $reset_email = $_REQUEST['email'];
        $get_sql = $link->prepare('SELECT id FROM `users` WHERE oauth_uid =:oauth_uid AND email =:email ');
        $get_sql->execute(['oauth_uid' => $auth_id, 'email' => $reset_email]);    
        $user_getData = $get_sql->fetch();        
        if(empty($user_getData)) {
            $json_array = ['type'=>'failed', 'message'=>"password update failed", 'code'=>'401'];
        } else {
            $haspwd = hash('sha512', $_REQUEST['password'] . $user_getData['id']);        
            $password_data = ['password' => $haspwd, 'status'=> '1', 'oauth_uid' => $auth_id, 'id' => $user_getData['id'] ];
            $p_sql = $link->prepare('UPDATE `users` SET password=:password, status=:status WHERE oauth_uid=:oauth_uid AND id=:id');
            $p_sql->execute($password_data);
            $json_array = ['type'=>'success', 'message'=>"password reset successfully", 'code'=>'201'];
            // $row_affected = $p_sql->rowCount();
            // if ($row_affected != 0) {
            //     $json_array = ['type'=>'success', 'message'=>"password reset successfully", 'code'=>'201'];
            // }
        }      
    }

    echo json_encode($json_array);

?>