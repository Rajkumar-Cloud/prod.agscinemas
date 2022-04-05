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
$transData = $link->query("SELECT th.id AS trans_local_id, th.txnid, fd.paymentstatus AS trans_status, th.userid, fd.ordertime AS trans_date, fd.intervalTime, fd.invoiceId FROM `transactionhistory` AS th, `foodorder` AS fd WHERE fd.ordertime NOT LIKE '%0000-00-00 00:00:00%' AND fd.paymentstatus = 'success' AND fd.ordertime > '2021-12-16' AND fd.vistatxnid = th.txnid GROUP BY fd.vistatxnid ORDER BY id DESC");
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
    		$obj['vista_id'] = $json->vista_id;
    		$obj['invoice_id'] = $val[1]['invoiceId'];
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
    		$obj['food_details'] = $json->food_details;
    		if($json->dynam_foodval == 'after')
    			$obj['delivery_mode'] = 'Interval';
    		else
    			$obj['delivery_mode'] = 'Entry';

    		$obj['total_food_qty'] = $json->total_food_qty;
			$obj['total_food_price'] = $json->total_food_price;
			if($val[1]['trans_status'] == 'success')
	    			$obj['trans_status'] = $val[1]['trans_status'];
			else
				$obj['trans_status'] = $val[1]['trans_status'];

    		$obj['unmappedstatus'] = $json->unmappedstatus;
    		$obj['trans_dateTime'] = date("d-m-Y h:i:s A", strtotime($val[1]['trans_date']));
    		$obj['trans_date'] = date("d-m-Y", strtotime($val[1]['trans_date']));
    		    		
    		$array['data'][$i]=$obj;
		}

		$i++;
	}
	if(count($val) == 3 && $userLoc != 5){
		if($userLoc == isset($val[2]['bookingrecords_cinid'])){		
			$getTransLog = getTransLog($val[1]['txnid']);
			foreach ($getTransLog as $jsonkey => $json) { 	

				$obj = array();
				$obj['vista_id'] = $json->vista_id;
				$obj['invoice_id'] = $val[1]['invoiceId'];
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
				$obj['food_details'] = $json->food_details;
				if($json->dynam_foodval == 'after')
	    			$obj['delivery_mode'] = 'Interval';
	    		else
	    			$obj['delivery_mode'] = 'Entry';

				$obj['total_food_qty'] = $json->total_food_qty;
				$obj['total_food_price'] = $json->total_food_price;
				if($val[1]['trans_status'] == 'success')
		    			$obj['trans_status'] = $val[1]['trans_status'];
				else
					$obj['trans_status'] = $val[1]['trans_status'];

				$obj['unmappedstatus'] = $json->unmappedstatus;
				$obj['trans_dateTime'] = date("d-m-Y h:i:s A", strtotime($val[1]['trans_date']));
				$obj['trans_date'] = date("d-m-Y", strtotime($val[1]['trans_date']));
				
				$array['data'][$i]=$obj;
			}

			$i++;
		}
	}
}
if(count($array) == 0)
	$array['data'] = array();

$jsonData = json_encode($array);
echo $jsonData;


function getTransLog($trans_id)
{
	error_reporting(0);	
	$array = [];
	$food_details = [];
	$totalPrice = [];
	$totalQty = [];
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
		$array->food_id = $Details[0]->food_id; 
		$array->dynam_foodval = $Details[0]->dynam_foodval; 
		if($Details[0]->count_num != null) {
	        $quantity = $Details[0]->count_num;
	        $quantityArr = implode(",",$quantity);
	        $fdqnty = explode(",",$quantityArr);
	        $foodQnty = count($fdqnty);
	    }else {
	        $foodQnty = 0;
	    }
	    $CinemaId = $Details[0]->Cin_Id;
	    if($CinemaId == 1){
	        $url = file_get_contents("../../classes/foodjson/foodlist/showfood_tnagar.json");
	    }
	    else if($CinemaId == 2){
	        $url = file_get_contents("../../classes/foodjson/foodlist/showfood_navalur.json");
	    }
	    else if($CinemaId == 3){
	        $url = file_get_contents("../../classes/foodjson/foodlist/showfood_villivakkam.json");
	    }
	    else if($CinemaId == 4){
	        $url = file_get_contents("../../classes/foodjson/foodlist/showfood_allapakkam.json");
	    }
	    $json = json_decode($url);
	    $foodidarr = array();
	    $foodpricearr= array();
	    $foodnamearr= array();
	    $foodimagearr= array();
	    for($k = 0; $k< count($json); $k++) {
	        $foodidarr[] = $json[$k]->id;
	        $foodpricearr[$json[$k]->id] = $json[$k]->foodPrice;
	        $foodnamearr[$json[$k]->id] = $json[$k]->foodName;
	        $foodimagearr[$json[$k]->id] = $json[$k]->foodImage;
	    }
	    if ($array->food_id == null || $array->food_id == '') {
            $food_id = [];
        }else{
        	$food_id = $array->food_id;
        }

        foreach($food_id as $index => $code)
        {
            $food_details[] = array(
            					'foodId' => $code,
            					'foodQnty' => $quantity[$index],
            					'foodPrice' => $foodpricearr[$code],
            					'totalFoodPrice' => ($quantity[$index] * $foodpricearr[$code]),
            					'foodName' => $foodnamearr[$code],
            				);
            $totalPrice[] = $quantity[$index] * $foodpricearr[$code];
            $totalQty[] = $quantity[$index];
        }
        $array->food_details = $food_details; 
        $array->total_food_price = array_sum($totalPrice); 
        $array->total_food_qty = array_sum($totalQty); 

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