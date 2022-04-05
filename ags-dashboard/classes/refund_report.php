<?php 
session_start();
include "config.php";

if(isset($_REQUEST['AddRefund'])){
	$transId = $_POST['trans_id'];

	$transData = $link->query("SELECT * FROM `transactionhistory` WHERE date NOT LIKE '%0000-00-00 00:00:00%' AND date > '2021-10-10' AND id = '".$transId."'");
	$transHistory = $transData->fetch();

	if(count($transHistory) > 0){

		$trans_id = $transId;
		$userid = $transHistory['userid'];
		$txnid = $transHistory['txnid'];
		$trans_status = $transHistory['status'];
		$trans_date = $transHistory['date'];
		$who_posted = $_SESSION['username'];
		$status = 1;

		$transRefund = $link->query("INSERT INTO `transaction_refund`(`userid`, `txnid`, `trans_id`, `trans_status`, `who_posted`, `trans_date`, `status`) VALUES ('$userid','$txnid','$trans_id','$trans_status','$who_posted','$trans_date','$status')");

		$json_array = ['status'=>'success', 'code'=>201];
		echo json_encode($json_array);
	}
} else {

	$transHistoryData = [];
	$array = [];
	$transData = $link->query("SELECT th.id AS trans_local_id, th.txnid, th.status AS trans_status, th.userid, th.date AS trans_date FROM `transactionhistory` AS th, `transaction_refund` AS tr WHERE date NOT LIKE '%0000-00-00 00:00:00%' AND date > '2021-10-10' AND tr.txnid = th.txnid ORDER BY th.id DESC");
	$transHistory = $transData->fetchAll();

	foreach ($transHistory as $key => $value) {
		$bookingData = $link->query("SELECT * FROM `bookingrecords` WHERE `bookingrecords_userid` = '".$value['userid']."' AND `bookingrecords_txnid` = '".$value['txnid']."'");
		$bookingRecords = $bookingData->fetch();

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
		if(count($val) == 3){
			$getTransLog = getTransLog($val[1]['txnid']);
			foreach ($getTransLog as $jsonkey => $json) { 	

	    		$obj = array();
	    		$obj['vista_id'] = $json->vista_id;
	    		$obj['booking_id'] = $val[2]['bookingrecords_bookingno'];
	    		$obj['txnid'] = $val[1]['txnid'];
	    		$obj['name'] = $val[0]['name'];
	    		$obj['email'] = $val[0]['email'];
	    		$obj['mobile'] = $val[0]['mobile'];
	    		$obj['movie_name'] = $json->movie_name;
	    		$obj['movie_location'] = $json->movie_location;
	    		$obj['movie_screen'] = $json->movie_screen;
	    		$obj['movie_date'] = $json->movie_date;
	    		$obj['movie_showtime'] = $json->movie_showtime;
	    		$seat_no = implode(",",$json->movie_seats);
	    		$obj['seat_no'] = $seat_no;
	    		$obj['ticket_qty'] = $val[2]['bookingrecords_qty'];
	    		$obj['movie_amt'] = $json->movie_amt;
	    		$obj['conv_fees'] = $json->conv_fees;
	    		$obj['total_amt'] = $json->total_amt;
				if($val[1]['trans_status'] == 'success')
		    			$obj['trans_status'] = $val[1]['trans_status'];
				else
					$obj['trans_status'] = $val[1]['trans_status'];

	    		$obj['unmappedstatus'] = $json->unmappedstatus;
	    		$obj['trans_dateTime'] = date("d-m-Y h:i:s A", strtotime($val[1]['trans_date']));
	    		$obj['trans_date'] = date("d-m-Y", strtotime($val[1]['trans_date']));
	    		// if($val[1]['trans_status'] == 'failure' || $json->vista_id == null || $json->vista_id == 0){

	    			$transRefundData = $link->query("SELECT * FROM `transaction_refund` WHERE `txnid` = '".$val[1]['txnid']."' AND `status` = 1");
	    			$transRefund = $transRefundData->fetchAll();
	    			// print_r($transRefund[0]['who_posted']);
	    			// print_r($transRefund[0]->who_posted);
	    			if(count($transRefund) == 0){
	    				if($transRefund[0]['who_posted'] != null)
	    					$obj['who_posted'] = $transRefund[0]['who_posted'];
	    				else
	    					$obj['who_posted'] = '';

	    				$obj['action'] = '<button id="'.$val[1]['trans_local_id'].'" onclick="addRecordRefund(this.id);" class="btn btn-sm btn-outline-warning">Refund</button>';
	    			}else{
	    				$obj['action'] = '';
	    				$obj['who_posted'] = '';
	    			}

	    		/*}else{
	    			$obj['action'] = '';
	    		}*/

	    		$array['data'][$i]=$obj;
			}

			$i++;
		}
	}

	if(count($array) == 0)
		$array['data'] = array();

	echo json_encode($array);

}


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