<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include ('config.php');
$txnid = $_POST['txnid'] ? $_POST['txnid'] : '';
$type = $_POST['type'];
$requestData = $_REQUEST;
$TicketDetails = [];
// $array = [];
// $jsonData = '';

// GROUP BY BR.bookingrecords_txnid

if($txnid == '' && $type == 'history')
{

	$transData = $link->query("SELECT id AS trans_local_id, txnid, status AS trans_status, userid, date AS trans_date FROM `transactionhistory` WHERE date NOT LIKE '%0000-00-00 00:00:00%' AND date > '2021-10-10' AND status = 'success' ORDER BY id DESC");
	$transHistory = $transData->fetchAll();
	foreach ($transHistory as $key => $value) {
		$bookingData = $link->query("SELECT * FROM `bookingrecords` WHERE `bookingrecords_userid` = '".$value['userid']."' AND `bookingrecords_txnid` = '".$value['txnid']."'");
		$bookingRecords = $bookingData->fetch();

		$userData = $link->query("SELECT id, name, email, mobile FROM `users` WHERE `id` = '".$value['userid']."'");
		$userDetails = $userData->fetchAll();	

		array_push($userDetails, $value);
		array_push($userDetails, $bookingRecords);
		array_push($TicketDetails, $userDetails);
	}

	$i = 0;
	$j = 1;
	foreach ($TicketDetails as $key => $val) {
		if(count($val) == 3){    		
			$getTransLog = getFile($val[1]['txnid']);    		
		
			foreach ($getTransLog as $jsonkey => $json) { 	
				
	    		$obj = array();
	    		$obj['s_no'] = $j;
	    		$obj['name'] = $val[0]['name'];
	    		$obj['email'] = $val[0]['email'];
	    		$obj['mobile'] = $val[0]['mobile'];
	    		$obj['movie_name'] = $json->movie_name;
	    		$obj['movie_location'] = $json->movie_location;
	    		$obj['booking_id'] = $val[2]['bookingrecords_bookingno'];
	    		$obj['txnid'] = $val[1]['txnid'];
	    		$obj['status'] = '<span class="badge badge-success">'.$val[1]['trans_status'].'</span>';
	    		$obj['total_amt'] = $json->conv_fees;
	    		$obj['booking_date'] = $val[2]['bookingrecords_datetime'];
	    		$obj['ticket_qty'] = $val[2]['bookingrecords_qty'];
	    		$obj['source'] = $val[2]['bookingrecords_device'];
	    		$obj['movie_date'] = $json->movie_date;
	    		$obj['movie_showtime'] = $json->movie_showtime;
	    		$obj['action'] = '<button type="button" id="'.$val[1]['txnid'].'" class="btn btn-sm btn-outline-primary" title="View Ticket" data-toggle="modal" data-target="#mivieTicket_model" onclick="showtickets('.$val[0]['id'].','.$val[1]['txnid'].');"><i class="fas fa-eye"></i></button>';

	    		$array['data'][$i]=$obj;
			}
			$i++;
			$j++;
		}
	}

	$jsonData = json_encode($array);

}else{

	$userId = $_POST['userId'];
	$data = getFile($txnid);

	$bookingDetails=$link->query("SELECT * FROM bookingrecords AS BR JOIN transactionhistory AS TH ON TH.userid = BR.bookingrecords_userid WHERE BR.bookingrecords_userid = '$userId' AND TH.status = 'success' AND BR.bookingrecords_txnid = '$txnid' ORDER BY BR.bookingrecords_txnid DESC");
    $bookingRecords = $bookingDetails->fetch();
    // print_r($bookingRecords);
    // $TicketDetails[] = array();
	foreach ($data as $jsonkey => $json) { 	

		$TicketDetails = array(
			'ticket_num' => $bookingRecords['bookingrecords_bookingno'],
			'showmovie_seat' => $json->movie_seats,
			'movie_seat' => $json->movie_seats,
			'movieId' => $json->movieId,
			'movie_name' => $json->movie_name,
			'movie_Language' => $json->movie_Language,
			'movie_Censor' => $json->movie_Censor,
			'movie_Genre' => $json->movie_Genre,
			'movie_runTime' => $json->movie_runTime,
			'movie_location' => $json->movie_location,
			'movie_showtime' => $json->movie_showtime,
			'movie_date' => $json->movie_date,
			'movie_screen' => $json->movie_screen,
			'movie_amt' => $json->movie_amt,
			'foodvalue' => $json->foodvalue,
			'conv_fees' => $json->conv_fees,
			'total_amt' => ($json->movie_amt + $json->foodvalue + $json->conv_fees),
		);
		
	}

	$jsonData = json_encode($TicketDetails);


}
echo $jsonData;


function getFile($trans_id) {
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
		$array->movie_Language = $Details[0]->movie_Language; 
		$array->movie_Genre = $Details[0]->movie_Genre; 
		$array->movie_Censor = $Details[0]->movie_Censor; 
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