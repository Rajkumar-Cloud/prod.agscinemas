<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];
    $cinema_id = $_POST['cinemas_id'];

    $ch = curl_init();

    $data = array('CinemaId' => $cinema_id);                                                                    
    $data_string = json_encode($data);

    // $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/InitBook');   // where to post   
    $ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/InitBook');   // where to post                                                                   
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)) );                                                                                                                   

    $result = curl_exec($ch);
    $json = json_decode($result, true);
    $result = $json['blnSuccess'];
    $tempbooking = $json['strBookingEx'];
    $temptransid = $json['strTempTransId'];
    $strException = $json['strException'];

    if($result == true) {
        $obj['trans_id']=$temptransid;
        $obj['strException']=$strException;
        $obj['result1']='success';
        array_push($array,$obj);
    } else {
        $obj['result1']='failure';
        $obj['strException']=$strException;
        array_push($array,$obj);
    }
    echo json_encode($array);
?>