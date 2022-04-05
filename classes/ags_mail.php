<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once 'php/vendor/autoload.php';
function send_mail($mail, $body, $service_type) {
    $email = $mail;
    $subject = $service_type;
    $mail_body = $body;
    // $cc_mail = '';
    // $alt_body = '';
    $mail = new PHPMailer(true);
    $mail->SMTPDebug = false;
    $mail->isSMTP();     
    $mail->SMTPAuth = true;                          
    // $mail->Username = 'AKIASED4WTLLWZ62DNFP';
    // $mail->Password = 'BAQSEdMODYC1J75hmGGXrlHvsh6IozG13fyUt+cKUdIw';
    // $mail->Host = 'email-smtp.ap-south-1.amazonaws.com';
    $mail->Username = 'agse-ticket@agscinemas.com';
    $mail->Password = 'Cdkp@min0143';
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPSecure = "tls";
    $mail->Port = 587;
    // $mail->setFrom('webticketing@agscinemas.com', 'AGS cinemas');
    $mail->setFrom('agse-ticket@agscinemas.com', 'AGS Cinemas');
    $mail->addAddress($email, 'AGS Cinemas');
    $mail->isHTML(true);
    if($service_type == "Bulk Ticket Booking") {
       $mail->addCC('bulkbookings@agscinemas.com');
    }
    if($service_type == "Booking Confirmation") {
       // $mail->addCC('agse-ticket@agscinemas.com');
    }
    if($service_type != "Reset your password") {
	// $mail->addBCC('prabhakaran.n@verandalearning.com');
	// $mail->addBCC('kalasalingam.s@verandalearning.com');
	// $mail->addBCC('simiyon.v@verandalearning.com');
        // $mail->addBCC('thandauthabani.c@agscinemas.com');
	// $mail->addBCC('rajkumar.v@verandalearning.com');
    }	
    if($service_type == "Transaction Successfull, but seat not confirmed in VISTA") {        
        $mail->addBCC('senthilkumar.a@agscinemas.com');
    }
    // $mail->addBCC($cc_mail);
    $mail->Subject = $subject;
    $mail->Body = $mail_body;
    // $mail->AltBody = $alt_body;
    try {
        $mail->send();
        $json_array = ['type'=>'Mail_success', 'message'=>"Mail has been sent successfully", 'code'=>'201'];
    } catch (Exception $e) {
        $json_array = ['type'=>'Mailer_Error', 'message'=>$mail->ErrorInfo, 'code'=>'401'];   
    }
    return json_encode($json_array);
}
