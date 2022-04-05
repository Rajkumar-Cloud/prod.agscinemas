<?php
	global $GLOBALS, $SERVER_NAME;
	function api_url($base_api) {
		// $globalIP = "http://123.176.34.84:8081/";
		$globalIP = "http://49.207.181.204:8080/";
		$VistaAPI = $globalIP."api/VistaRemote/";
		$GLOBALS['globalIP'] = $globalIP;
		$GLOBALS['SynchData'] = $VistaAPI."SynchData";
		$GLOBALS['CommitTrans'] = $VistaAPI."CommitTrans";
		$GLOBALS['VerifyBooking'] = $VistaAPI."VerifyBooking";
		$GLOBALS['InitBook'] = $VistaAPI."InitBook";
		$GLOBALS['GetSeatLayOut'] = $VistaAPI."GetSeatLayOut";
		$GLOBALS['AddSeats'] = $VistaAPI."AddSeats";
		$GLOBALS['SetSeats'] = $VistaAPI."SetSeats";
		$GLOBALS['AddConcessions'] = $VistaAPI."AddConcessions";
		$GLOBALS['SetFnbPickupOrDelivery'] = $VistaAPI."SetFnbPickupOrDelivery";
		$GLOBALS['SetFnbPickupOrDeliveryEx'] = $VistaAPI."SetFnbPickupOrDeliveryEx";
		$GLOBALS['CancelConcessions'] = $VistaAPI."CancelConcessions";
		$GLOBALS['ContinueTrans'] = $VistaAPI."ContinueTrans";
		$GLOBALS['CancelTrans'] = $VistaAPI."CancelTrans";
		$GLOBALS['VerifyBooking'] = $VistaAPI."VerifyBooking";
		$GLOBALS['BookingStatus'] = $VistaAPI."BookingStatus";
		$GLOBALS['CancelBook'] = $VistaAPI."CancelBook";
		$GLOBALS['UnpaidToPaid'] = $VistaAPI."UnpaidToPaid";
		$GLOBALS['GetPickupStream'] = $VistaAPI."GetPickupStream";
		$GLOBALS['BookingCollected'] = $VistaAPI."BookingCollected";
		
		return $GLOBALS[$base_api];
	}

	function page_pathInfo($param) {
		$SERVER_NAME['domain'] = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
		$SERVER_NAME['pathInfo'] = pathinfo($SERVER_NAME['domain']);
		return $SERVER_NAME[$param];
	}

	

 ?>