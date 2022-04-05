<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
/*
    Author:- AGS Cinemas
    Date:- 08-12-2021
    Purpose:- User Class to manage actions: Login and SignUp with user details.
*/

class User{
 
    // database connection and table name
    private $conn;
    private $table_name = "users";
 
    // object properties
    public $id;
    public $name;
    public $email;
    public $password; 
    public $mobile;
    public $otp;    
    public $created_at;	
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

        //user signup method
    function signup(){
    
        if($this->isAlreadyExist()){
            return false;
        }
        
        // query to insert record of new user signup
        $device_register = "app";
        $expiry_time = date('Y-m-d H:i:s',strtotime('+1 hour'));
        $today = date('Y-m-d H:i:s');
        $link = '';
        $this->email = htmlspecialchars(strip_tags($this->email));
        $this->password = htmlspecialchars(strip_tags($this->password));   
        $this->mobile = htmlspecialchars(strip_tags($this->mobile));
        $userData = [
            'name' => $this->name,
            'email' => $this->email,
            'password' => $this->password,
            'mobile' => $this->mobile,
            'device' => $device_register,
            'balance' => '0',
            'signuptime' => $today
        ];        

        $userRegsql = "INSERT INTO ".$this->table_name." (name, email, password, mobile, device,balance,signuptime) VALUES (:name, :email, :password, :mobile, :device,:balance,:signuptime)";
        $stmt = $this->conn->prepare($userRegsql);
        $stmt->execute($userData); 
        $lastInsertId = $this->conn->lastInsertId();    
        if($lastInsertId > 0) {
            $pwdquery = $this->conn->query("SELECT * FROM users WHERE email='$this->email' AND password ='$this->password'");
            $pwdrow = $pwdquery->fetch();
            $userid = $pwdrow['id'];
            $haspwd = hash('sha512', $this->password . $userid);
            $this->conn->query("UPDATE users SET password = '$haspwd' WHERE id ='$userid'");
            $sentOTP = $this->otp_send($this->mobile, $userid, $link, $expiry_time, $this->email);                
            $sentData = json_decode($sentOTP);
            if($sentData->status == 'success') {
                $json_array = ['status'=>$sentData->status, 'alert'=>$sentData->alert, 'mobile'=>$sentData->mobile, 'message'=>$sentData->message, 'code'=>'201'];
            } else {
                $json_array = ['status'=>$sentData->status, 'alert'=>$sentData->alert, 'mobile'=>$sentData->mobile, 'message'=>$sentData->message, 'code'=>'401'];
            }            
            return $json_array;
        }
    
        return false;
        
    }

    // login user method
    function login(){
        $email = $this->email;
        $password = $this->password;
        $link = $this->conn;
        $data = [];
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
                                    $data = array(
                                        'id' => $res['id'],
                                        'name' => $res['name'],
                                        'email' => $res['email'],
                                        'mobile' => $res['mobile'],
                                        'profilepic' => $res['profilepic'],
                                        'device' => $res['device'],
                                        'status' => $res['status'],
                                        'created_at' => $res['created_at']
                                    );         
                                    $stmt = ['status'=>'success', 'message'=>"login success", 'data'=>$data, 'code'=>200];
                                } else {
                                    $stmt = ['status'=>'error', 'message'=>"password error", 'data'=>$data];
                                }
                            } else {
                                $stmt = ['status'=>'error', 'message'=>"email error", 'data'=>$data];                                
                            }
                        } else {
                            $stmt = ['status'=>'error', 'message'=>"please verify OTP", 'mobile'=>$verified['mobile'] ];
                        }
                    } else {
                        $stmt = ['status'=>'error','message'=>"the email or password you entered is incorrect"];
                    }
                } else {
                    $stmt = ['status'=>'error', 'message'=>"the email doesn't exist"];
                }
            } else {
                $stmt = ['status'=>'error', 'message'=>"the field should not be blank"];
            }
        return $stmt;
    }

    // OTP Verfying
    function otpVerify() {
        $verifying_sql = $this->conn->query("SELECT * FROM users WHERE mobile ='$this->mobile' AND otp = '$this->otp' ");
        $verified__otp = $verifying_sql->fetch();
        $status_flag = "1";
        if($verified__otp) {                 
            $update_data = [
                'mobile' => $this->mobile,
                'otp' =>  $this->otp,
                'status' => $status_flag
            ];
            $update_st = "UPDATE `users` SET `status` = :status WHERE `mobile` = :mobile AND `otp` = :otp ";
            $update_st1 = $this->conn->prepare($update_st);
            $update_st1->execute($update_data);
            $otpr_count = $update_st1->rowCount();  
            if($otpr_count > 0) {
                $stmt = ['status'=>'success','message'=>'otp verifying successfully'];        
            } else {
                $stmt = ['status'=>'warning', 'message'=>'otp verified'];            
            } 
        } else {
            $stmt = ['status'=>'error','message'=>"otp verification failed",'code'=>'401'];            
        }
        return $stmt;
    }


    //Notify if User with given Email or Mobile no Already exists during SignUp
    function isAlreadyExist() {
        $query = "SELECT * FROM ".$this->table_name." WHERE email='".$this->email."' OR mobile='".$this->mobile."' ";
        // prepare query statement
        $stmt = $this->conn->prepare($query);
        // execute query
        $stmt->execute();
        if($stmt->rowCount() > 0){
            return true;
        }
        else{
            return false;
        }
    }

    function otp_send($mobile, $userid, $link, $expiry_time, $email) {
        $randomnums = rand(1000, 9999);      
        $appendString = "Dear Customer, Your OTP is $randomnums Use this Passcode to complete your transaction. Thank you by Veranda.";
        $appendString1 = urlencode($appendString) ;
        $msg = str_replace("+","%20",$appendString1);        
        $urls = "http://smscampaigns.msgbell.com/API/sms.php?username=VERANDA&password=Veranda@123&from=VRANDA&to=".$mobile."&msg=".$msg."&type=1&dnd_check=0&template_id=1707161526941623022";                             
        $handle = curl_init($urls);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($handle);
        curl_close($handle);
        error_log($urls,3,"otp_error_log.txt");        
        if($contents) {
            $this->conn->query("UPDATE users SET otp = '$randomnums' , otp_count = '1', expiry_time = '$expiry_time' WHERE id ='$userid'");
            $json_array = ['status'=>'success', 'alert'=>'sendotp', 'mobile'=>$mobile, 'message'=>"otp has been sent successfully"];
        } else {
            $json_array = ['status'=>'fail', 'alert'=>'sendotp', 'mobile'=>$mobile, 'message'=>"failed to send otp"];   
        }
        return json_encode($json_array);
    }

    // forgot password 
    function forgot_password() {
        $email = $this->email;
        $link = $this->conn;
        $data = [];
        if($email != ''){
            $user_sql = $link->prepare("SELECT id, name, email FROM `users` WHERE email= :email");        
            $user_sql->bindValue(':email', $email);
            $user_sql->execute();
            if( $user_sql->rowCount() > 0 ) {
                $user_results = $user_sql->fetch(PDO::FETCH_ASSOC);
                $oauth_token = openssl_random_pseudo_bytes(16);
                $user_token = bin2hex($oauth_token);
                $update_oauth = $link->prepare("UPDATE `users` SET oauth_uid = :oauth_uid WHERE id = :id");
                $update_oauth->bindParam(':oauth_uid', $user_token);
                $update_oauth->bindValue(':id', $user_results['id']);
                if ($update_oauth->execute()) {
                    $user = $link->prepare("SELECT id, name, email, oauth_uid FROM `users` WHERE id= :id");        
                    $user->bindValue(':id', $user_results['id']);
                    $user->execute();
                    $user_data = $user->fetch(PDO::FETCH_ASSOC);
                    $data = array(
                                'email' => $user_data['email'],
                                'auth_token' => $user_data['oauth_uid'],
                            );
                    $stmt = ['status'=>'success', 'data'=>$data, 'code'=>200];
                }
            } else {
                $stmt = ['status'=>'failed', 'message'=>"email address not found", 'code'=>'401'];
            }
        } else {
            $stmt = ['status'=>'error', 'message'=>"Empty email field!", 'code'=>'401'];
        }
        return $stmt;
    }
	
    // reset password
    function reset_password() {
        $email = $this->email;
        $password = $this->password;
        $oauth_token = $this->auth_token;
        $link = $this->conn;
        if($email != '' && $oauth_token != ''){
            $get_sql = $link->prepare('SELECT id FROM `users` WHERE oauth_uid =:oauth_uid AND email =:email ');
            $get_sql->execute(['oauth_uid' => $oauth_token, 'email' => $email]);    
            $user_getData = $get_sql->fetch();        
            if(empty($user_getData)) {
                $stmt = ['status'=>'failed', 'message'=>"password update failed", 'code'=>'401'];
            } else {
                $haspwd = hash('sha512', $password . $user_getData['id']);        
                $password_data = ['password' => $haspwd, 'status'=> '1', 'oauth_uid' => $oauth_token, 'id' => $user_getData['id'] ];
                $p_sql = $link->prepare('UPDATE `users` SET password=:password, status=:status WHERE oauth_uid=:oauth_uid AND id=:id');
                $p_sql->execute($password_data);
                $stmt = ['status'=>'success', 'message'=>"password reset successfully", 'code'=>200];                
            }
        } else {
            $stmt = ['status'=>'error', 'message'=>"The email, password and auth_token should not be blank!", 'code'=>'401'];
        }
        return $stmt;
    }
}