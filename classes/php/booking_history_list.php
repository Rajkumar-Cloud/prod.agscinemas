<?php 
include ('../config.php');
$userId = $_POST['userid'];
$txnid = $_POST['txnid'] ? $_POST['txnid'] : '';
$type = $_POST['type'];
$requestData = $_REQUEST;
$TicketDetails = [];
$array = [];
$jsonData = '';

// GROUP BY BR.bookingrecords_txnid

if($userId != '' && $type == 'history')
{
    /*$bookingDetails=$link->query("SELECT * FROM bookingrecords AS BR JOIN transactionhistory AS TH ON TH.userid = BR.bookingrecords_userid WHERE BR.bookingrecords_userid = '$userId' AND TH.status = 'success' ORDER BY BR.bookingrecords_txnid DESC");
    $bookingRecords = $bookingDetails->fetchAll();*/
    $bookingrecords=$link->query("SELECT * FROM bookingrecords AS BR WHERE BR.bookingrecords_userid = '$userId' ORDER BY BR.bookingrecords_txnid DESC");
    $BRecords = $bookingrecords->fetchAll();

    $transactionhistory=$link->query("SELECT * FROM transactionhistory AS TH WHERE TH.userid = '$userId' AND TH.status = 'success' ORDER BY TH.txnid DESC");
    $TRecords = $transactionhistory->fetchAll();

    $bookingDetails = [];
    foreach ($BRecords as $key1 => $val1) {
    	if ($val1['bookingrecords_txnid'] == $TRecords[$key1]['txnid']) {
    		$bookingDetails[$key1] = array(
    			'bookingrecords_txnid' => $val1['bookingrecords_txnid'], 
    			'bookingrecords_bookingno' => $val1['bookingrecords_bookingno'],
    			'status' => $TRecords[$key1]['status'],
    			'bookingrecords_datetime' => $val1['bookingrecords_datetime']
    		); 
    	}
    }

    $totalData = count($bookingDetails);
    $totalFiltered = $bookingDetails;
    if (count($bookingDetails) > 0) {
    	$i = 1;
    	foreach ($bookingDetails as $key => $value) {
    		    		
    		$data = getFile($value['bookingrecords_txnid']);    		

    		foreach ($data as $jsonkey => $json) { 	
    			
	    		$obj = array();
	    		$obj[] = $i;
	    		$obj[] = $_COOKIE['username'];
	    		$obj[] = $json['movie_Name'];
	    		$obj[] = $value['bookingrecords_bookingno'];
	    		$obj[] = $json['transac_id'];
	    		$obj[] = '<span class="badge badge-success">'.$value['status'].'</span>';
	    		$obj[] = 'Rs.'.$json['foodvalue'];
	    		$obj[] = 'Rs.'.$json['movie_amt'];
	    		$obj[] = $value['bookingrecords_datetime'];
	    		$obj[] = $json['movie_date'];
	    		$obj[] = '<button type="button" id="'.$json['transac_id'].'" class="btn btn-sm btn-outline-primary" title="View Ticket" data-toggle="modal" data-target="#mivieTicket_model" onclick="showtickets('.$json['transac_id'].');"><i class="fas fa-eye"></i></button>';

	    		$array[]=$obj;
    		}
    		$i++;
    	}
    }

    $json_data = array(
		            "draw"      => intval( $requestData['draw'] ),  
		            "recordsTotal"    => intval( $totalData ), 
					"recordsFiltered" => intval( $totalFiltered ), 
					"data"            => $array   
				);

	$jsonData = json_encode($json_data);

}else{


	$data = getFile($txnid);

	$bookingDetails=$link->query("SELECT * FROM bookingrecords AS BR JOIN transactionhistory AS TH ON TH.userid = BR.bookingrecords_userid WHERE BR.bookingrecords_userid = '$userId' AND TH.status = 'success' AND BR.bookingrecords_txnid = '$txnid' ORDER BY BR.bookingrecords_txnid DESC");
    $bookingRecords = $bookingDetails->fetch();
    // print_r($bookingRecords);
    // $TicketDetails[] = array();
	
	$foodItemHistory = $link->query("SELECT fi.foodname, fo.quantity, fo.intervalTime, fi.foodprice FROM `foodorder` AS fo INNER JOIN `fooditems` AS fi ON fo.foodid = fi.id WHERE fo.userid = '$userId' AND fo.transid = '$txnid' ORDER BY `foodorder_id` DESC");
        $FIRecords = $foodItemHistory->fetchAll(PDO::FETCH_ASSOC);
	$foodDetails = [];
	if(count($FIRecords) > 0) {	
		$foodDetailsRow = [];	
		foreach ($FIRecords as $foodkey => $foodRows) {
			$foodDetailsRow[$foodkey]['foodname'] = $foodRows['foodname'];
			$foodDetailsRow[$foodkey]['quantity'] = $foodRows['quantity'];
			$foodDetailsRow[$foodkey]['intervalTime'] = $foodRows['intervalTime'];
			$foodDetailsRow[$foodkey]['foodprice'] = $foodRows['foodprice'];
		}
		$foodDetails['foodData'] = $foodDetailsRow;
		$foodDetails['food_order_count'] = count($FIRecords);		
	} else {
		$foodDetails['row'] = '0';
	}

	foreach ($data as $jsonkey => $json) { 	

		$TicketDetails = array(
			'ticket_num' => $bookingRecords['bookingrecords_bookingno'],
			'showmovie_seat' => $json['showmovie_seatsss'],
			'movie_seat' => $json['showmovie_seatsss'],
			'movieId' => $json['movieId'],
			'movie_Name' => $json['movie_Name'],
			'movie_Language' => $json['movie_Language'],
			'movie_Censor' => $json['movie_Censor'],
			'movie_Genre' => $json['movie_Genre'],
			'movie_runTime' => $json['movie_runTime'],
			'movie_location' => $json['movie_location'],
			'movie_showtime' => $json['movie_showtime'],
			'movie_date' => $json['movie_date'],
			'movie_screen' => $json['movie_screen'],
			'movie_amt' => $json['movie_amt'],
			'foodvalue' => $json['foodvalue'],
			'conv_fees' => $json['conv_fees'],
			'total_amt' => ($json['movie_amt'] + $json['foodvalue'] + $json['conv_fees']),
		);
		
	}
	$movieData_arr = array_merge($TicketDetails, $foodDetails);
	$jsonData = json_encode($movieData_arr);

}
echo $jsonData;


function getFile($jsonfilename) {

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

	return $json;
}



?>