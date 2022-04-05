<?php

    $CinemaId = $_POST['CinemaId'];
    $TempTransId = $_POST['TempTransId'];   
    $array = array();
    $ch = curl_init();

    $data = array('CinemaId' => $CinemaId, 'TempTransId' => $TempTransId);                                                                     
    $data_string = json_encode($data);  


//  $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/ContinueTrans');   // where to post      
    $ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/ContinueTrans');   // where to post                                                                   
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array(                                                                          
    'Content-Type: application/json',                                                                                
    'Content-Length: ' . strlen($data_string))  );                                                                                                                   

    $result = curl_exec($ch);
    $json = json_decode($result, true);
    $result = $json['blnSuccess'];

    if($result == true) {
        $obj['result1']='success';
        array_push($array,$obj);
    } else {
        $obj['result1']='failure';
        array_push($array,$obj);
    }

    echo json_encode($array);
?>