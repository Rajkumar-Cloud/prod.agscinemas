<?php 
	error_reporting(0);
	$array = [];
	$trans_id = $_POST['trans_id'];
	// $json_pretty_payu = [];
	// $json_pretty_vista = [];

	// pay-u transaction log viewer
	$myData = file_get_contents("../../transaction_log/".$trans_id."_t_log.json");
	$json_pretty_payu = json_encode(json_decode($myData), JSON_PRETTY_PRINT);
	$myObject = json_decode($myData);
	$myObjectMap = $myObject->transaction_details;

	$Data = file_get_contents("../../".$trans_id.".json");
	$Details = json_decode($Data);

	// vista transaction log viewer
	$vista_trans = file_get_contents("../../commit_trans_log/".$trans_id."_ct_log.json");
	$json_pretty_vista = json_encode(json_decode($vista_trans), JSON_PRETTY_PRINT);

	// set-seat selected confirmation log viewer
	$setSeat_Data = file_get_contents("setseats_log/".$trans_id."_ss_log.json");
	$json_setSeat = json_encode(json_decode($setSeat_Data), JSON_PRETTY_PRINT);

	foreach ($myObjectMap as $key => $value) {
		$array = $value;
		$array->movie_Name = $Details[0]->movie_Name;
		$array->movieId = $Details[0]->movieId; 
		$array->movie_location = $Details[0]->movie_location; 
		$array->movie_showtime = $Details[0]->movie_showtime; 
		$array->movie_date = $Details[0]->movie_date; 
		$array->movie_screen = $Details[0]->movie_screen; 
	}

	$json_array = ['json_pretty_payu' => $json_pretty_payu, 'json_pretty_vista' => $json_pretty_vista, 'trans_data' => $array, 'setSeat_data' => $json_setSeat]; 
	
	echo json_encode($json_array);


?>