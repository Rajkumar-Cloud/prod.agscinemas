<?php
session_start(); 
include "config.php";
// error_reporting(0);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$userLoc = $_SESSION['userData']->locationId;

$requestData = $_REQUEST;
$transHistoryData = [];
$transHistoryData1 = [];
$array = [];
$transData = $link->query("SELECT id AS trans_local_id, txnid, status AS trans_status, userid, date AS trans_date FROM `transactionhistory` WHERE date NOT LIKE '%0000-00-00 00:00:00%' AND date > '2021-10-10' AND status = 'success' ORDER BY id DESC");
$transHistory = $transData->fetchAll();

foreach ($transHistory as $key => $value) {
	if($userLoc == 5){
		$bookingData = $link->query("SELECT * FROM `bookingrecords` WHERE `bookingrecords_userid` = '".$value['userid']."' AND `bookingrecords_txnid` = '".$value['txnid']."'");
		$bookingRecords = $bookingData->fetch();
	}
	if($userLoc != 5){
		$bookingData = $link->query("SELECT * FROM `bookingrecords` WHERE `bookingrecords_userid` = '".$value['userid']."' AND `bookingrecords_txnid` = '".$value['txnid']."' AND `bookingrecords_cinid` = '".$userLoc."';");
		$bookingRecords = $bookingData->fetch();

	}

	$userData = $link->query("SELECT id, name, email, mobile FROM `users` WHERE `id` = '".$value['userid']."'");
	$userDetails = $userData->fetchAll();	

	array_push($userDetails, $value);
	array_push($userDetails, $bookingRecords);
	array_push($transHistoryData, $userDetails);
}

$totalData = count($transHistoryData);
$totalFiltered = $transHistoryData;
$i = 0;
foreach ($transHistoryData as $key1 => $val) {	
	if(count($val) == 3 && $userLoc == 5){
		$getTransLog = getTransLog($val[1]['txnid']);
		foreach ($getTransLog as $jsonkey => $json) { 	

    		$obj = array();
    		
    		$obj['movie_location'] = $json->movie_location;
    		$obj['movie_name'] = $json->movie_name;
    		$obj['movie_date'] = $json->movie_date;
    		$obj['movie_showtime'] = $json->movie_showtime;
    		$obj['ticket_qty'] = (int)$val[2]['bookingrecords_qty'];
    		$obj['movie_amt'] = $json->movie_amt;
    		$obj['conv_fees'] = $json->conv_fees;
    		$obj['total_amt'] = $json->total_amt;
    		$obj['trans_count'] = count($transHistoryData);
    		$seat_no = implode(",",$json->movie_seats);
    		$obj['seat_no'] = $seat_no;

    		$array['data'][$i]=$obj;
		}

		$i++;
	}
	if(count($val) == 3 && $userLoc != 5){
		if($userLoc == isset($val[2]['bookingrecords_cinid'])){
			$getTransLog = getTransLog($val[1]['txnid']);
			foreach ($getTransLog as $jsonkey => $json) { 	

	    		$obj = array();
	    		
	    		$obj['movie_location'] = $json->movie_location;
	    		$obj['movie_name'] = $json->movie_name;
	    		$obj['movie_date'] = $json->movie_date;
	    		$obj['movie_showtime'] = $json->movie_showtime;
	    		$obj['ticket_qty'] = (int)$val[2]['bookingrecords_qty'];
	    		$obj['movie_amt'] = $json->movie_amt;
	    		$obj['conv_fees'] = $json->conv_fees;
	    		$obj['total_amt'] = $json->total_amt;
	    		$obj['trans_count'] = count($transHistoryData);
	    		$seat_no = implode(",",$json->movie_seats);
	    		$obj['seat_no'] = $seat_no;

	    		$array['data'][$i]=$obj;
			}

			$i++;
		}
	}
}

$jsonData = json_encode($array);
echo $jsonData;


function getTransLog($trans_id)
{
	error_reporting(0);	
	$array = [];
	$trans_id = $trans_id;
	$myData = file_get_contents("../../transaction_log/".$trans_id."_t_log.json");
	// $json_pretty_payu = json_encode(json_decode($myData), JSON_PRETTY_PRINT);
	$myObject = json_decode($myData);
	$myObjectMap = $myObject->transaction_details;

	$Data = file_get_contents("../../".$trans_id.".json");
	$Details = json_decode($Data);

	$vista_trans = file_get_contents("../../commit_trans_log/".$trans_id."_ct_log.json");
	$json_vista = json_decode($vista_trans);

	foreach ($Details as $key => $value) {
		$array = $myObjectMap->$trans_id;
		$array->movie_name = $Details[0]->movie_Name;
		$array->movieId = $Details[0]->movieId; 
		$array->movie_location = $Details[0]->movie_location; 
		$array->movie_showtime = $Details[0]->movie_showtime; 
		$array->movie_date = $Details[0]->movie_date; 
		$array->movie_screen = $Details[0]->movie_screen;  
		$array->movie_seats = $Details[0]->movie_seatsss; 
		$array->movie_amt = $Details[0]->movie_amt; 
		$array->conv_fees = $Details[0]->conv_fees; 
		$total = $Details[0]->movie_amt + $Details[0]->conv_fees;
		if(isset($myObjectMap->$trans_id->field9) || $myObjectMap->$trans_id->field9 != null || $myObjectMap->$trans_id->field9 != '')
			$array->unmappedstatus = $myObjectMap->$trans_id->field9;
		else
			$array->unmappedstatus = $myObjectMap->$trans_id->unmappedstatus;
		
		$array->vista_id = $json_vista->lngAuditNumber; 
		$array->total_amt = $total; 
	}

	$json_array = ['trans_data' => $array]; 
	return $json_array;
}



?>