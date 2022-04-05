<?php
session_start();
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');
$rowsarr = [];
$arr = [];
$arr2 = [];
$array = [];

$cinema_id        = $_POST['cinemas_id'];
$temptrans_id     = $_POST['TempTransId'];
$movieId          = $_POST['SessionId'];    
$selected_seats   = $_POST['SelectedSeats']; 

$showseat         = $_POST['showseat'];
$seats            = $_POST['seat'];
$timeleft         = $_POST['timelefts'];
$seatlength       = $_POST['seatlength'];
$seat_cat_type_id = $_POST['seat_cat_type_id'];
$catcode = $_POST['catcode'];
$_SESSION['catcode']        = $catcode;
$_SESSION['showmovie_seat']        = $showseat;
$_SESSION['movie_seat']            = $seats;
$_SESSION['timelefts']             = $timeleft;
$_SESSION['seatlength']            = $seatlength;
$_SESSION['seat_cat_type_id']      = $seat_cat_type_id;
$_SESSION['transac_id']            = $temptrans_id;




if($seat_cat_type_id == 2){
    $_SESSION['totalamount'] = $_SESSION['catprice2']*$seatlength;
    $_SESSION['conv_fees'] = 30*$seatlength;
}
else{
    $_SESSION['totalamount'] = $_SESSION['catprice1']*$seatlength;
    $_SESSION['conv_fees'] = 30*$seatlength;
}


$ch = curl_init();

$data = array('CinemaId' => $cinema_id, 'TempTransId' => $temptrans_id, 'SessionId' => $movieId, 'SelectedSeats' => $selected_seats);                                                                     
$data_string = json_encode($data);  


// $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/SetSeats');   // where to post   
$ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/SetSeats');   // where to post                                                                   
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);  
curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))                                                                       
);                                                                                                                   
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);                                                                    

$result = curl_exec($ch);
$raw = $result;
$json = json_decode($result, true);
$result = $json['blnSuccess'];
$tempbooking = $json['strBookingEx'];
$temptransid = $json['strTempTransId'];

if($result == true)
{
    $filename = "setseats_log/".$temptransid."_ss_log.json";   
    chmod($filename, 0777);
    unlink($filename);
    $fh = fopen($filename, "w") or die("File not found");
    fwrite($fh, $raw);
    fclose($fh);
    $obj['trans_id']=$temptransid;
    $obj['result1']='success';
    array_push($array,$obj);
}
else
{
    $obj['result1']='failure';
    array_push($array,$obj);
}

echo json_encode($array);
?>