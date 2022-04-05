<?php 
require_once 'vendor/autoload.php';
include "../config.php";

use PhpOffice\PhpSpreadsheet\Helper\Sample;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Writer\Xls;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Color;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


date_default_timezone_set('Asia/Kolkata');
// logical day started yesterday
$start = strtotime('yesterday 06:00:00');
$end = strtotime('today 06:00:00');

$fromDate = date('Y-m-d H:i:s', $start);
$toDate = date('Y-m-d H:i:s', $end);
$requestData = $_REQUEST;
$transHistoryData = [];
$array = [];
$transData = $link->query("SELECT id AS trans_local_id, txnid, status AS trans_status, userid, date AS trans_date FROM `transactionhistory` WHERE `date` BETWEEN '$fromDate' AND '$toDate'");
// $transData = $link->query("SELECT id AS trans_local_id, txnid, status AS trans_status, userid, date AS trans_date FROM `transactionhistory` WHERE `date` BETWEEN '2021-10-26 06:00:00' AND '2021-10-27 06:00:00'");
$transHistory = $transData->fetchAll();

if(count($transHistory) > 0){
	foreach ($transHistory as $key => $value) {
		$bookingData = $link->query("SELECT * FROM `bookingrecords` WHERE `bookingrecords_userid` = '".$value['userid']."' AND `bookingrecords_txnid` = '".$value['txnid']."'");
		$bookingRecords = $bookingData->fetch();

		$userData = $link->query("SELECT id, name, email, mobile FROM `users` WHERE `id` = '".$value['userid']."'");
		$userDetails = $userData->fetchAll();	

		array_push($userDetails, $value);
		array_push($userDetails, $bookingRecords);
		array_push($transHistoryData, $userDetails);
	}
}

$totalData = count($transHistoryData);
    $totalFiltered = $transHistoryData;
if(count($transHistoryData) > 0){
	foreach ($transHistoryData as $key1 => $val) {		
		$getTransLog = getTransLog($val[1]['txnid']);
		foreach ($getTransLog as $jsonkey => $json) { 	

    		$obj = array();
    		$obj[] = $val[2]['bookingrecords_bookingno'];
    		$obj[] = $json->vista_id;
    		$obj[] = $val[1]['txnid'];
    		$obj[] = $val[0]['name'];
    		$obj[] = $val[0]['email'];
    		$obj[] = $val[0]['mobile'];
    		$obj[] = $json->movie_name;
    		$obj[] = $json->movie_location;
    		$obj[] = $json->movie_screen;
    		$obj[] = $json->movie_date;
    		$obj[] = $json->movie_showtime;
    		$seat_no = implode(",",$json->movie_seats);
    		$obj[] = $seat_no;
    		$obj[] = 'Rs.'.$json->movie_amt;
    		$obj[] = 'Rs.'.$json->conv_fees;
    		$obj[] = 'Rs.'.$json->total_amt;
    		$obj[] = $val[1]['trans_status'];
    		$obj[] = $val[1]['trans_date'];

    		$array[]=$obj;
		}

	}
}

$json_data = array(
			    "draw"      => intval( $requestData['draw'] ),  
			    "recordsTotal"    => intval( $totalData ), 
				"recordsFiltered" => intval( $totalFiltered ), 
				"data"            => $array   
			);

$jsonData = json_encode($json_data);
$RecordCount = count($array);
$column_array = array("Booking ID", "Vista ID", "Transaction No","Name", "Email", "Mobile", "Movie Name", "Movie Location", "Screen", "Show Date", "Show Time", "Seats", "Movie Amount", "Conv Fees", "Total Amount", "Status", "Transaction Date");
$title_array = array("Transaction Report");
$x = 'Daily Report [ ' . $fromDate .' - '. $toDate .' ]';
$sub_title_array = array($x);

if($RecordCount != 0)
	array_unshift($array,$column_array);

array_unshift($array,$sub_title_array);

if($RecordCount != 0)
	array_unshift($array,$title_array);

$fDate = preg_replace('/[ ,:-]+/', '_', trim($fromDate));
$tDate = preg_replace('/[ ,:-]+/', '_', trim($toDate));

$fileName = "daily_report_".$fDate."_".$tDate.".xlsx";
$i = 1;
$spreadsheet = new Spreadsheet();
$spreadsheet->setActiveSheetIndex(0);

$styleArray = array(
    'font'  => array(
	        'bold'  => true,
	        'color' => array('rgb' => '#212529'),
	        'size'  => 12
	    )
	);

$spreadsheet->getActiveSheet()->mergeCells("A1:Q1");
$spreadsheet->getActiveSheet()->mergeCells("A2:Q2");

$spreadsheet->getActiveSheet()->getStyle('A1:Q1')->applyFromArray($styleArray);
$spreadsheet->getActiveSheet()->getStyle('A2:Q2')->applyFromArray($styleArray);
$spreadsheet->getActiveSheet()->getStyle('A3:Q3')->applyFromArray($styleArray);

$spreadsheet->getActiveSheet()->getStyle('A1:Q1')->getAlignment()->setHorizontal('center');	
$spreadsheet->getActiveSheet()->getStyle('A2:Q2')->getAlignment()->setHorizontal('center');	
$spreadsheet->getActiveSheet()->getStyle('A3:Q3')->getAlignment()->setHorizontal('center');	

foreach(range('A', 'O') as $columnID) {
  $spreadsheet->getActiveSheet()->getColumnDimension($columnID)->setAutoSize(true);
}

if($RecordCount == 0){
	$spreadsheet->getActiveSheet()->mergeCells("A3:Q3");
	$spreadsheet->getActiveSheet()->setCellValue('A1', $x);
	$spreadsheet->getActiveSheet()->setCellValue('A2', 'Transaction Report');
	$spreadsheet->getActiveSheet()->setCellValue('A3', 'No Reports');
}else{
	foreach ($array as $key => $value) {
		foreach ($value as $key1 => $val) {
		    $spreadsheet->getActiveSheet()
	            ->setCellValue("A" . $i, $array[$key][0])
	            ->setCellValue("B" . $i, $array[$key][1])
	            ->setCellValue("C" . $i, $array[$key][2])
	            ->setCellValue("D" . $i, $array[$key][3])
	            ->setCellValue("E" . $i, $array[$key][4])
	            ->setCellValue("F" . $i, $array[$key][5])
	            ->setCellValue("G" . $i, $array[$key][6])
	            ->setCellValue("H" . $i, $array[$key][7])
	            ->setCellValue("I" . $i, $array[$key][8])
	            ->setCellValue("J" . $i, $array[$key][9])
	            ->setCellValue("K" . $i, $array[$key][10])
	            ->setCellValue("L" . $i, $array[$key][11])
	            ->setCellValue("M" . $i, $array[$key][12])
	            ->setCellValue("N" . $i, $array[$key][13])
	            ->setCellValue("O" . $i, $array[$key][14])
	            ->setCellValue("P" . $i, $array[$key][15])
	            ->setCellValue("Q" . $i, $array[$key][16]);
		}
    	$i++;
	}
}



header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="'.$fileName.'"');
header('Cache-Control: max-age=0');
header('Cache-Control: max-age=1');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
header('Cache-Control: cache, must-revalidate');
header('Pragma: public');
$writer = new Xlsx($spreadsheet);
$writer->save("daily_report/".$fileName);



$message = $x;
// $contact_email = "anuruth.vs@verandalearning.com";
$contact_email = "thandauthabani.c@agscinemas.com";
$service_type = "Daily Report";                       
$template_body = "
<div style='width:100%;background-color:transparent;display:block;text-align:left;'>
    <img src='https://pbs.twimg.com/profile_images/935001716285612032/fhRidd97_400x400.jpg' style='width: 10%; margin-left:12px;' alt='logo' />
    <p style='margin:1rem auto;font-weight:bold;color:#000'>Hi, </p>
    <p style='margin:1rem auto;color:#000;'>".$message."</p>
    <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Warm Regards by<br/>AGS Team </p>
</div>";
$sendMail = send_mail($contact_email, $template_body, $service_type, $fileName);

if($sendMail == 'success'){
	echo $jsonData;
}

function getTransLog($trans_id)
{
	error_reporting(0);	
	$array = [];
	$trans_id = $trans_id;

	$myData = file_get_contents("../../transaction_log/".$trans_id."_t_log.json");
	$json_pretty_payu = json_encode(json_decode($myData), JSON_PRETTY_PRINT);
	$myObject = json_decode($myData);
	$myObjectMap = $myObject->transaction_details;

	$Data = file_get_contents("../../".$trans_id.".json");
	$Details = json_decode($Data);

	$vista_trans = file_get_contents("../../commit_trans_log/".$trans_id."_ct_log.json");
	$json_pretty_vista = json_encode(json_decode($vista_trans), JSON_PRETTY_PRINT);
	$json_vista = json_decode($vista_trans);

	foreach ($myObjectMap as $key => $value) {
		$array = $value;
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
		$array->total_amt = $total; 
		$array->vista_id = $json_vista->lngAuditNumber; 
	}

	$json_array = [/*'json_pretty_payu' => $json_pretty_payu, 'json_pretty_vista' => $json_pretty_vista,*/ 'trans_data' => $array]; 
	return $json_array;
}


function send_mail($mail, $body, $service_type, $fileName) {
    $official_mail = "wecare@agscinemas.com";
    $email = $mail;
    $subject = $service_type;
    $mail_body = $body;

    $mail = new PHPMailer(true);
    $mail->SMTPDebug = false;
    $mail->isSMTP();     
    $mail->SMTPAuth = true;                          
    $mail->Username = 'AKIASED4WTLLWZ62DNFP';
    $mail->Password = 'BAQSEdMODYC1J75hmGGXrlHvsh6IozG13fyUt+cKUdIw';
    $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    $mail->setFrom('webticketing@agscinemas.com', 'AGS cinemas');
    $mail->addAddress($email, 'AGS Cinemas');
    $mail->isHTML(true);
    $mail->addAttachment("daily_report/".$fileName);
    $mail->addBCC('rajkumar.v@verandalearning.com');
    $mail->addBCC('anuruth.vs@verandalearning.com');
    $mail->Subject = $subject;
    $mail->Body = $mail_body;

    try {
        $mail->send();
        return 'success';
    } catch (Exception $e) {
        return 'failed';   
    }
}

?>