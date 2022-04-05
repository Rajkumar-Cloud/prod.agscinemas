<?php
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);
include("classes/config.php");
session_start();
error_reporting(0);
ini_set('display_errors',1);
// $userid=$_COOKIE['userid'];

$status=$_POST["status"];
$firstname=$_POST["firstname"];
$amount=$_POST["amount"]; 
$txnid=$_POST["txnid"];
$posted_hash=$_POST["hash"];
$key=$_POST["key"];
$productinfo=$_POST["productinfo"];
$email=$_POST["email"];
$salt="8UXqyhGY"; //Please change the value with the live salt for production environment
$jsonfilename = $txnid;
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
$_SESSION['pay_status'] = $status;

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
    $foodpricearr[] = $json[$k]['foodPrice'];
    $foodnamearr[] = $json[$k]['foodName'];
    $foodimagearr[] = $json[$k]['foodImage'];
}
$fooddiscountvalue=$_SESSION['fooddiscountvalue'];

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
$data = json_decode($o);
$filename = "transaction_log/".$txnid."_t_log.json";   
chmod($filename, 0777);
unlink($filename);
$fh = fopen($filename, "w");
fwrite($fh, $o);
fclose($fh);


//Validating the reverse hash
if (isset($_POST["additionalCharges"])) {
    $additionalCharges=$_POST["additionalCharges"];
    $retHashSeq = $additionalCharges.'|'.$salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
} else {	  
    $retHashSeq = $salt.'|'.$status.'|||||||||||'.$email.'|'.$firstname.'|'.$productinfo.'|'.$amount.'|'.$txnid.'|'.$key;
}
$hash = hash("sha256", $retHashSeq);
if ($hash != $posted_hash) {
    $res1 = $link->query("INSERT INTO transactionhistory (txnid,status,userid,food,ticket,wallet) VALUES ('$txnid','$status','$userid','$foodQnty','$id_count','0')"); 
} else {
    /*echo "<h3>Thank You, " . $firstname .".Your order status is ". $status .".</h3>";
    echo "<h4>Your Transaction ID for this transaction is ".$txnid.".</h4>";*/
}         
?>	
<script>
 window.location.href="moviespayfailure.php";
</script>