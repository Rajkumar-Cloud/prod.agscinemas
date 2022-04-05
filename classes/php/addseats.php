<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    // include('../config.php');
    date_default_timezone_set('Asia/Kolkata'); 
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];
    $CinemaId = $_POST['CinemaId'];
    $TempTransId = $_POST['TempTransId'];
    $SessionId = $_POST['SessionId'];    
    $TicketType = $_POST['TicketType']; 
    $Qty = $_POST['Qty'];
    $UserSelectedSeats = $_POST['UserSelectedSeats'];
    $ch = curl_init();
    $data = array('CinemaId' => $CinemaId, 'TempTransId' => $TempTransId, 'SessionId' => $SessionId, 'TicketType' => $TicketType, 'Qty' => $Qty, 'UserSelectedSeats' => $UserSelectedSeats);                                                                     
    $data_string = json_encode($data);

    $log_file = "initbook_logs.log";
    $logEntry = array();
    $logEntry = "[".date('d-M-Y H:i:s T')."] => ".$data_string.PHP_EOL;
    error_log($logEntry,3, $log_file);
    // error_log($data_string,3,"ddfff.txt");

    // $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/AddSeats');   // where to post  
    $ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/AddSeats');   // where to post                                                                   
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)) ); 
    $result = curl_exec($ch);
    $json = json_decode($result, true);
    $result = $json['blnSuccess'];
    $tempbooking = $json['strBookingEx'];
    $temptransid = $json['strTempTransId'];

    if($result == true) {
        $obj['trans_id']=$temptransid;
        $obj['result1']='success';
        array_push($array,$obj);
    } else {
        $obj['result1']='failure';
        array_push($array,$obj);
    }

    echo json_encode($array);
?>