<?php
    ini_set('display_errors', 0);
    // ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    require_once('classes/detect.php');
    include("classes/config.php");
    include("classes/php/getip.php");
    include 'classes/ags_mail.php';

    session_start();
    date_default_timezone_set('Asia/Kolkata');
    $status = $_POST["status"];
    $firstname = $_POST["firstname"];
    $amount = $_POST["amount"]; //Please use the amount value from database
    $txnid = $_POST["txnid"];
    $posted_hash = $_POST["hash"];
    $key = $_POST["key"];
    $productinfo = $_POST["productinfo"];
    $jsonfilename = $txnid; 
    // print_r($jsonfilename);
    $email = $_POST["email"];
    $salt = "8UXqyhGY"; //Please change the value with the live salt for production environment

    $url = "http://3.109.167.11/".$jsonfilename.".json";
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    $json = json_decode($output, true);
    $userid=$json[0]['userid']; //$_COOKIE[''];
    $show_id=$json[0]['movie_showid'];
    $CinemaId = $json[0]['Cin_Id'];
    $transac_id = $json[0]['transac_id'];
    $food_id = $json[0]['food_id'];
    /*$quantity = $json[0]['count_num'];
    $quantityArr = implode(",",$quantity);
    $fdqnty = explode(",",$quantityArr);
    $foodQnty = count($fdqnty);*/
    if($json[0]['count_num'] != null) {
        $quantity = $json[0]['count_num'];
        $quantityArr = implode(",",$quantity);
        $fdqnty = explode(",",$quantityArr);
        $foodQnty = count($fdqnty);
    }else {
        $foodQnty = 0;
    }
    $seatvalue =$json[0]['movie_seatsss'];
    $seat_email =$json[0]['showmovie_seatsss'];
    // $seat_email123 =explode(",",$json[0]['showmovie_seatsss']);
    $seat_no = implode(",",$seat_email);
    $seat_email123 =explode(",",$seat_no);
    $conv_fees =$json[0]['conv_fees'];
    $interval=$json[0]['dynam_foodval'];
    $catcode=trim($json[0]['catcode']);
    $showdate = $json[0]['movie_date'];
    $showtime = $json[0]['movie_showtime'];
    $language = $json[0]['movie_Language'];
    $runningtime = $json[0]['movie_runTime'];
    $movieimage = 'http://3.109.167.11/assets/images/movies/'.$json[0]['movieId'].'_cover.jpg';
    $moviename = $json[0]['movie_Name'];
    $transac_id = $json[0]['transac_id'];
    $totalamount = $amount;
    $location = $json[0]['movie_location'];
    $screenname = $json[0]['movie_screen'];
    $covid_confirm = $json[0]['covid_confirm'];
    if($CinemaId == 1){
        $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_tnagar.json";
    }
    else if($CinemaId == 2){
        $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_navalur.json";
    }
    else if($CinemaId == 3){
        $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_villivakkam.json";
    }
    else if($CinemaId == 4){
        $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_allapakkam.json";
    }

    $_SESSION['showmovie_seat'] = $json[0]['showmovie_seatsss'];
    $_SESSION['movie_seat'] = $json[0]['showmovie_seatsss'];
    $_SESSION['movieId'] = $json[0]['movieId'];
    $_SESSION['movie_Name'] = $json[0]['movie_Name'];
    $_SESSION['movie_Language'] = $json[0]['movie_Language'];
    $_SESSION['movie_Censor'] = $json[0]['movie_Censor'];
    $_SESSION['movie_Genre'] = $json[0]['movie_Genre'];
    $_SESSION['movie_runTime'] = $json[0]['movie_runTime'];
    $_SESSION['movie_location'] = $json[0]['movie_location'];
    $_SESSION['movie_showtime'] = $json[0]['movie_showtime'];
    $_SESSION['movie_date'] = $json[0]['movie_date'];
    $_SESSION['movie_screen'] = $json[0]['movie_screen'];
    $_SESSION['totalamount'] = $json[0]['movie_amt'];
    $_SESSION['foodvalue'] = $json[0]['foodvalue'];
    $_SESSION['conv_fees'] = $json[0]['conv_fees'];
    $_SESSION['food_id'] = $json[0]['food_id'];
    $_SESSION['count_num'] = $json[0]['count_num'];
    $_SESSION['fooddiscountvalue'] = 0;

    $seatvalue = explode(",",$seat_no);
    $id_count=count($seatvalue);
    $today = date('Y-m-d');
    $seatrowid=explode(",",$json[0]['sess_seatrowid']);
    $seat_cst =$json[0]['movie_amt']; 
    $food_cst =$json[0]['foodvalue'];
    $curr_date =date('Y-m-d');
    $curr_time=date("H:i:s");
    $currenttime11 = date('Y-m-d H:i:s');
    $seat_cat_type_id= $json[0]['seat_cat_type_id'];
    $movie_amt=$json[0]['movie_amt']; 
    $foodvalue=$json[0]['foodvalue'];
    $conv_fees=$json[0]['conv_fees'];
    $three_d_charge=$json[0]['three_d_charge'];
    $total_val=$movie_amt+$foodvalue+$conv_fees+$three_d_charge;
    $handle = curl_init();
    curl_setopt($handle, CURLOPT_URL, $url);
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
    curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
    $output = curl_exec($handle);
    curl_close($handle);
    $json = json_decode($output, true);
    $foodidarr = array();
    $foodpricearr= array();
    $foodnamearr= array();
    $foodimagearr= array();
    for($k = 0; $k< count($json); $k++) {
        $foodidarr[] = $json[$k]['id'];
        $foodpricearr[$json[$k]['id']] = $json[$k]['foodPrice'];
        $foodnamearr[$json[$k]['id']] = $json[$k]['foodName'];
        $foodimagearr[] = $json[$k]['foodImage'];
    }
    $fooddiscountvalue=$_SESSION['fooddiscountvalue'];
    $checktxnquery = $link->query("SELECT * FROM bookingrecords WHERE bookingrecords_txnid ='$txnid'");
    $checktxnrow = $checktxnquery->fetchAll();

    $payukey = 'lzk5Ju';
    $command = 'verify_payment';
    $hash = hash('sha512',$payukey.'|'.$command.'|'.$txnid.'|'."$salt");
    $r = array('key' =>$payukey, 'hash' =>$hash , 'var1' => $txnid, 'command' => $command);  
    $wsUrl = 'https://info.payu.in/merchant/postservice.php?form=2';
    $qs = http_build_query($r);
    
    $c = curl_init();
    curl_setopt($c, CURLOPT_URL, $wsUrl);
    curl_setopt($c, CURLOPT_POST, 1);
    curl_setopt($c, CURLOPT_POSTFIELDS, $qs);
    curl_setopt($c, CURLOPT_CONNECTTIMEOUT, 30);
    curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($c, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($c, CURLOPT_SSL_VERIFYPEER, 0);
    $o = curl_exec($c);
    $varstring = print_r($o, true);
    $result = json_decode($varstring,true);
    $oparray = $result["transaction_details"];
    $oparr = array_values($oparray);
    
    $filename = "transaction_log/".$txnid."_t_log.json";   
    chmod($filename, 0777);
    unlink($filename);
    $fh = fopen($filename, "w") or die("File not found");
    fwrite($fh, $o);
    fclose($fh);

    foreach ($oparr as $inner_array) {
       $payu_checkstatus = $inner_array["status"];
    }
    if (isset($_POST["additionalCharges"])) {
        $additionalCharges=$_POST["additionalCharges"];
        $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
    } else {   
         $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key; 
    }
    $hash = hash("sha256", $retHashSeq);
    if ($hash == $posted_hash) {
      echo "Transaction has been tampered. Please try again";
    } else {
        $paymentarr = array();
        $ch = curl_init();
        $objpayment['CardNumber'] = "4111111111111111";
        $objpayment['CardType'] = "W";
        $objpayment['CardExpiryMonth'] = "12";
        $objpayment['CardExpiryYear'] = "2020";
        $objpayment['CardCVC'] = "111";
        $objpayment['NameOnCard'] = "User";
        array_push($paymentarr,$objpayment);

        $Paid = "true";
        $Comment = 'hi';
        $PhoneNo = '1111111111';
        $PickupName = 'Test';
        $data = array('CinemaId' => $CinemaId, 'TempTransId' => $transac_id, 'SessionId' => $show_id, 'Paid' => $Paid, 'Comment' => $Comment, 'PhoneNo' => $PhoneNo, 'PickupName' => $PickupName ,"PaymentInfo" => $objpayment);  
                                                                            
        $data_string = json_encode($data);  

        // $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/CommitTrans');   // where to post
	$ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/CommitTrans');   // where to post                                                                   
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
        ); 

        $result = curl_exec($ch);
        $json = json_decode($result, true);

        $filename1 = "commit_trans_log/".$txnid."_ct_log.json";   
        chmod($filename1, 0777);
        unlink($filename1);
        $fh1 = fopen($filename1, "w") or die("File not found");
        fwrite($fh1, $result);
        fclose($fh1);

        $result = $json['blnSuccess'];
        $intBookId = $json['intBookId'];
        $strBookId = $json['strBookId'];
	
	if($result == false){
            $sql77=$link->query("SELECT * FROM users WHERE id='$userid'");
            $sql77row = $sql77->fetch();

            $cus_email =$sql77row["email"]; 
            $cus_name=$sql77row['name']; 
            $cus_mobile = "91".$sql77row["mobile"];

            $message = $strException;
            $contact_email = "thandauthabani.c@agscinemas.com";

            $service_type = "Transaction Successfull, but seat not confirmed in VISTA";                       
            $template_body = "
            <div style='width:100%;background-color:transparent;display:block;text-align:left;'>
                <img src='https://pbs.twimg.com/profile_images/935001716285612032/fhRidd97_400x400.jpg' style='width: 10%; margin-left:12px;' alt='logo' />
                <p style='margin:1rem auto;font-weight:bold;color:#000'>Hi Team, please find the below details</p>                
                <p style='margin:1rem auto;color:#000;'>Transaction Successfull, but seat not confirmed in VISTA. </p>
                <table style='width:100%;display:block;'>
                    <thead>
                        <tr>
                            <td style='padding: 5px 1rem;background-color: #312c2c5e;color: #000;font-weight: bold;border-right: 1px solid #fff;'>Field's </td>
                            <td style='padding: 5px 1rem;background-color: #312c2c5e;color: #000;font-weight: bold;'>Details</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Name </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$cus_name</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Email </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$cus_email</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Contact No </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$cus_mobile</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Theater </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$location</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Movie Name </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$moviename</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Screen </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$screenname</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Show Date </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$showdate</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Show Time </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$showtime</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Seat No </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$seat_no</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Seat Amount </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$seat_cst</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Conv Fees </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$conv_fees</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>Total Amount </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;font-size:12px'>$total_val</td>
                        </tr>
                    </tbody>
                </table>
                <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;font-size:12px;'>Our AGS technical team contact soon. </p>
                <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;font-size:13px'>Warm Regards by<br/>AGS Team </p>
            </div>";
            $sendMail = send_mail($contact_email, $template_body, $service_type);     
        }

        if($result == true) {
            $ch = curl_init();
            $Paid = "true";
            $data = array('CinemaId' => $CinemaId, 'strKey' => $PhoneNo, 'lngBookingId' => $intBookId, 'SessionId' => $show_id, 'TicketType' => $catcode, 'Qty' => $id_count, 'Paid' => $Paid);                                              
            $data_string = json_encode($data);
            // $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/VerifyBooking');
	    $ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/VerifyBooking');                                                                   
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
            curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
            'Content-Type: application/json',                                                                                
            'Content-Length: ' . strlen($data_string))                                                                       
            );                                                                                                                   
            $result = curl_exec($ch);            
            $json = json_decode($result, true);

            $verifyBooking = "verify_booking_log/".$txnid."_vb_log.json";   
            chmod($verifyBooking, 0777);
            unlink($verifyBooking);
            $vblog = fopen($verifyBooking, "w") or die("File not found");
            fwrite($vblog, $result);
            fclose($vblog);

            $result = $json['blnSuccess'];
        }

        if($result === true && $show_id !='' && count($seatvalue) > 0 && $userid !='' && $payu_checkstatus=='success') {
            $sql9 = $link->query("SELECT * FROM  cinema WHERE Cin_Id='$CinemaId'");     
            $sql9row = $sql9->fetch();
            
            $Cin_Loc=$sql9row["Cin_Loc"]; 
            $keyword = $sql9row["keyword"]; 

            if(count($checktxnrow) == 0)
             {
                $fooddetails = '';
                if ($food_id == null || $food_id == '') {
                    $food_id = [];
                }

                foreach($food_id as $index => $code)
                { 
                
                    $keyvalue = array_search($food_id,$foodidarr);
                    $foodPrice = $foodpricearr[$code]*$quantity[$index];
                    $discount_new_price=0;
                    $result112=$link->query("INSERT INTO foodorder (foodid,quantity,currentfoodamount,vistatxnid,intervalTime,userid,date,ordertime,paymentstatus,transid,discountamt,session_id) VALUES ('".$code."','".$quantity[$index]."','$foodPrice','$txnid','$interval','$userid','$today','$currenttime11','$status','$txnid','$discount_new_price','$show_id')");//new
                    $fooddetails .= " ".$foodnamearr[$code] ." ".$quantity[$index] ." Nos";

                    $result1 = $link->query("SELECT * FROM foodorder ORDER BY foodorder_id  DESC");
                    $resultrow = $result1->fetch();
                    $last_id = $resultrow['foodorder_id'];


                }
                if(isset($result112) && $result112 == true)
                {
                    $invoicefood = $keyword."FD".$last_id;
                    $res46 = $link->query("UPDATE `foodorder` SET `invoiceId`='$invoicefood' WHERE `vistatxnid`='$txnid'");
                }  
             }

            $ua = getBrowser();
            $userBrowser_platform = "Browser: " . $ua['name'] . " " . $ua['version'] . " on " .$ua['platform'] . " reports: <br >" .$ua['userAgent'];
	    $res1 = $link->query("INSERT INTO transactionhistory (txnid,status,userid,food,ticket,wallet) VALUES ('$txnid','$status','$userid','$foodQnty','$id_count','0')"); 

            $link->query("INSERT INTO `bookingrecords`(`bookingrecords_userid`, `bookingrecords_txnid`, `bookingrecords_ip`, `bookingrecords_datetime`,bookingrecords_cinid,bookingrecords_qty,bookingrecords_vistatxnid,bookingrecords_bookingid,bookingrecords_areacode,bookingrecords_device,bookingrecords_bookingno,bookingrecords_sessionid,bookingrecords_amt) VALUES ('$userid','$txnid','$ipfind','$currenttime11','$CinemaId','$id_count','$txnid','$intBookId','$catcode','$userBrowser_platform','$strBookId','$show_id','$totalamount')");


            $id_count=count($seatvalue);            

            $sql7=$link->query("SELECT * FROM users WHERE id='$userid'");
            $sql7row = $sql7->fetch();

            $email =$sql7row["email"]; 
            $name=$sql7row['name']; 
            $mobile = "91".$sql7row["mobile"];




            // $bookingdetail = "BOOKING ID:$strBookId | Cinema:$location | Movie Name: $moviename | Screen: $screenname | DateTime:$showdate $showtime | Seat No(s):$seat_no";
	    $bookingdetail = "Dear $name, Booking ID $strBookId for $moviename $showdate $showtime at $screenname AGS Cinemas $location $seat_no. Show QR code for Entry.";        
            /*if(isset($fooddetails) && $fooddetails != "")
            {
               $bookingdetail .= "Food Details : ".$fooddetails;
            }*/
            $url3 = 'http://3.109.167.11/agsqrcode/qrdownload.php?qr='.$strBookId;

            $login = 'hsemak';
            $appkey = 'R_ebdf9c13673f48d483b57d90e348f2d1';

            $ch5 = curl_init('http://api.bitly.com/v3/shorten?login='.$login.'&apiKey='.$appkey.'&longUrl='.$url3);
            curl_setopt($ch5, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch5, CURLOPT_SSL_VERIFYPEER, false);

            $resultrags = curl_exec($ch5);
            $result1rags = (json_decode($resultrags));
            $temprags = $result1rags->data->url;   
            
            // $bookingdetail.= " Please download the QR Code with following link:".$temprags;
            ob_start();
            $bookingmsg = str_replace("+","%20",urlencode($bookingdetail));
            $urls = "https://control.msg91.com/api/sendhttp.php?authkey=161404AqQqRTYF594ce5e6&mobiles=$mobile&message=$bookingmsg&sender=AGSWTK&route=4&country=91";//$mobile
            $handle = curl_init($urls);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, false);
            $contents = curl_exec($handle);
            curl_close($handle);

            $movieRuning_hours = intdiv($runningtime, 60).'h '. ($runningtime % 60).'m';

            include("classes/php/QRGenerator.php");
            $ex3 = new QRGenerator($strBookId,100,'ISO-8859-1');
            // require_once 'classes/ags_mail.php';
            $sub = "Booking Confirmation";
            $body = '<html>
            <head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">
                <title></title>
            </head>
            <body>
                <div id="container">
                    <div style="background-image: url(\'http://3.109.167.11/assets/images/img/bg.png\') !important;background-size: cover !important;background-repeat: no-repeat !important;">
                        <h3 style="text-align: center;font-size: 22px;color: #fff;letter-spacing: 1px;padding:40px;margin:0px;font-weight:200;">Hi '.$name.'! Your ticket has been confirmed</h3>
                        <table style="width:100%;">
                            <tr>
                                <td style="width:50%;">
                                    <div style="margin: 30px 0px 10px;text-align:center;"><img src="http://3.109.167.11/assets/images/email/mail_logo.png" style="width: 250px;"></div>
                                </td>
                                <td>
                                    <hr style="color: #fff;margin: 0px;border: 1px solid #fff;height: 100px;">
                                </td>
                                <td style="width:50%;">
                                    <div style="margin-left: 40px;text-align:center;">
                                        <div class="ticketfirst" style="background-image: url(\'http://3.109.167.11/assets/images/email/his1.png\') !important;width: 370px !important;height: 525px !important;padding: 0px;margin: 15px;">
                                            <div style="margin:0px 0px 5px 0px"><img src="http://3.109.167.11/assets/images/email/agsblack.png" style="width: 60px;margin-top:0px; height: 60px;"></div>
                                            <table style="width:100%;">
                                                <tr>
                                                    <td>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 15px;color: #a5a0a0;">Date</p>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 15px;color: #a5a0a0 !important;">'.$showdate.'</p>
                                                    </td>
                                                    <td>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0;">Time</p>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0 !important;">'.$showtime.'</p>
                                                    </td>
                                                    <td>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0;">Language</p>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0 !important;">'.$language.'</p>
                                                    </td>
                                                    <td>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0;">Duration</p>
                                                        <p style="font-size: 13px;margin: 0px 5px 8px 8px;color: #a5a0a0 !important;">'.$movieRuning_hours.'</p>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <hr style="margin: 0px 12px 0px 0px;width: 90%;color: lightgray;border-top: 0px solid #e7e7e7;">
                                                    </td>
                                                </tr>
                                            </table>
                                            <table style="margin: 5px 0px;">
                                                <tr>
                                                    <td><img src="'.$movieimage.'" style="width: 120px;height: 165px;margin: 0px 10px 0px 10px;"></td>
                                                    <td style="width: 100%">
                                                        <table style="width: 100%;height: 190px;">
                                                            <tbody>
                                                                <tr>
                                                                    <td>
                                                                        <div style="width: 100%;display: inline-flex;">
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 90px;color: #a5a0a0;text-align:left;">Movie Name</p>
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;text-align:left;color: #a5a0a0 !important;">'.$moviename.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div style="width: 100%;display: inline-flex;">
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 90px;color: #a5a0a0;text-align:left;">Ticket No</p>
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;text-align:left;color: #a5a0a0 !important;">'.$strBookId.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                                <tr>
                                                                    <td>
                                                                        <div style="width: 100%;display: inline-flex;">
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 90px;text-align:left;color: #a5a0a0;">Cost</p>
                                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;text-align:left;color: #a5a0a0 !important;">'.$totalamount.'</p>
                                                                        </div>
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr style="display: none;margin: 0px 12px 0px 0px;width: 200%;color: lightgray;border-top: 0px solid #e7e7e7;">
                                            <table style="width: 100%;padding-left: 5px;">
                                                <tr>
                                                    <td>
                                                        <div style="margin: 0px;font-size: 13px;margin-left: 20px;">
                                                            <p style="font-size: 13px;margin: 10px 0px;width: 150px;text-align:left;color: #a5a0a0;">Theater Location</p>
                                                            <p style="font-size: 13px;margin: 10px 0px;text-align:left;color: #a5a0a0 !important;">'.$location.'</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width: 200%;margin: 0px;font-size: 13px;">
                                                            <p style="font-size: 13px;margin: 10px 0px;width: 80px;text-align:left;color: #a5a0a0;">Screen</p>
                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;text-align:left;color: #a5a0a0 !important;">'.$screenname.'</p>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div style="width: 150%;margin: 0px;font-size: 13px;">
                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;color: #a5a0a0;text-align:left;">Seat</p>
                                                            <p style="font-size: 13px;margin: 10px 0px;width: 100px;text-align:left;text-align:left;color: #a5a0a0 !important;">'.$seat_no.'</p>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </table>
                                            <hr style="display: none;margin: 0px auto;width: 250%;color: lightgray;border-top: 0px solid #e7e7e7;">
                                            <table style="width: 100%;">
                                                <tr>
                                                    <td></td>
                                                </tr>
                                                <tr>
                                                    <td>
                                                    <div style="text-align:center;margin:0px;"><img src="'.$ex3->generate().'" style="width:75px;"></div>
                                                    </td>
                                                    <td>
                                                        <div style="margin: 10px 0px;">
                                                            <p style="text-align:center;font-size:13px;color:#a5a0a0;">Scan your QR code<br>
                                                            for more details</p>
                                                            <p style="margin:0px;text-align: right;padding-right: 12px;"></p>
                                                        </div>
                                                        <div style="text-align:right;padding-right:12px;"><img src="http://3.109.167.11/assets/images/email/Info.png" style="width:15px;margin: 0px;"></div>
                                                    </td>
                                                </tr>
                                            </table>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        </table>
                        <h3 style="text-align: center;font-size: 21px;color: #fff;letter-spacing: 1px;padding:40px;margin:0px;font-weight:200;font-style:italic;">Thank you for booking in AGS cinemas</h3>
                    </div>
                </div>            
                <div class="col-md-12 col-xs-12 col-sm-12 terms">
                    <p style="font-size: 14px;color:#343434;margin:20px 0px 0px;text-transform:uppercase;">Terms and conditions</p>
                    <div class="condtion">
                        <table>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#f61818;margin:5px 0px 0px;">1.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#f61818;margin:5px 0px 0px;">As per the State Government Guidelines, In order to enter the cinema, It is mandatory to have Covid 19 Vaccine, for patrons above 18 years old. Vaccination certificate will be verified at the cinema entry, no entry will be permitted for non-vaccinated patrons and tickets will not be refunded.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;">2.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;">Tickets once purchased cannot be cancelled, exchanged or refunded.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;">3.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Tickets purchased online are not eligible for discounts, schemes or promotions of any kind.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">4.</p>
                                </td>
                                <td colspan="2">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;margin:0px;">To collect tickets from the Box Office, it is mandatory for the cardholder to be present in person with the card used ofr thetransation,</p>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;margin:0px;">along with the booking confirmation (SMS/computer printout) to helop minize the risk of fraud.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">5.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Online bookings on our site are carried out over a secure payment gateway.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">6.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Tickets purchased online for a particular multiplex are valid for that multiplex only.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">7.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Children below the age of 18 cannot be admitted for movies certified A.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">8.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Please carry proof of age for movies certified A.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">9.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Please purchase ticket for children above the age of 3.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">10.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">To counter unforeseen delays, please collect your tickets half an hour before show time.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">11.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Outside food and beverages are not allowed inside the cinema premises.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">12.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">A convenience fee per ticket is levied on all tickets booked online.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">13.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">ticket holders are required to abide by the policies laid down by the AGS Cinemas management.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">14.</p>
                                </td>
                                <td>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">Smoking is strictly prohibited inside the theatre premises.</p>
                                </td>
                            </tr>
                            <tr>
                                <td class="termcon">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">15.</p>
                                </td>
                                <td colspan="3" style="padding-top: 13px;">
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">We as a merchant shall be under no liability whatsoever in respect of any loss or damage arising directly or indirectly out of the decline of</p>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">authorization for any Transaction, on Account of the Cardholder having exceeded the preset limit mutually agreed by us with our acquiring bank</p>
                                    <p style="font-size: 14px;color:#343434;margin:5px 0px 0px;margin:5px 0px 0px;">from time to time.</p>
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>            
            </body>
            </html>';

            send_mail($email, $body, $sub);       

            $_SESSION['randticket'] = $strBookId;
?>
        <script> window.location.href = "moviespaysuccess.php"; </script>
<?php
        } else {
            unset($_SESSION['movie_Name']);
            unset($_SESSION['movie_Language']);
            unset($_SESSION['movie_Censor']);
            unset($_SESSION['movie_Genre']);
            unset($_SESSION['movie_runTime']);
            unset($_SESSION['movie_location']);
            unset($_SESSION['movie_showtime']);
            unset($_SESSION['movie_date']);
            unset($_SESSION['movie_screen']);
            unset($_SESSION['movie_tickvalue']);
            unset($_SESSION['movie_seat']);
            unset($_SESSION['movie_amt']);
            unset($_SESSION['status']);
            unset($_SESSION['movie_amt']);
            unset($_SESSION['three_d_charge']);
            unset($_SESSION['sess_seatrowid']);
            unset($_SESSION['food_id']);
	    unset($_SESSION['count_num']);
?>
    <script> window.location.href = "movies.php"; </script>
<?php            
        }    
    }

    //Generate Ticket number Random (no repeat random number)
    function crypto_rand_secure($min, $max) {
        $range = $max - $min;
        if ($range < 1) return $min; // not so random...
            $log = ceil(log($range, 2));
            $bytes = (int) ($log / 8) + 1; // length in bytes
            $bits = (int) $log + 1; // length in bits
            $filter = (int) (1 << $bits) - 1; // set all lower bits to 1
        do {
            $rnd = hexdec(bin2hex(openssl_random_pseudo_bytes($bytes)));
            $rnd = $rnd & $filter; // discard irrelevant bits
        } while ($rnd > $range);

        return $min + $rnd;
    }

    function getToken($length) {
        $token = "";
        // $codeAlphabet = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $codeAlphabet= "0123456789";
        $max = strlen($codeAlphabet);
        for ($i=0; $i < $length; $i++) {
            $token .= $codeAlphabet[crypto_rand_secure(0, $max-1)];
        }
        return $token;
    }
?>