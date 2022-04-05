<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require_once '../classes/php/vendor/autoload.php';

// function send_mail($mail, $body, $data, $service_type) {
    $email = 'rajkumar.v@verandalearning.com'; 
    $mail = new PHPMailer(true);

$mail->SMTPDebug = 3;                               

$mail->isSMTP();            

$mail->SMTPAuth = true;                          

/*$mail->Username = 'agscinemas';
$mail->Password = 'SV.~H@mSqf%V';
$mail->Host = '3-109-149-150.cprapid.com';*/  
// $mail->Host = 'mail.agscinema.dev';
$mail->Username = 'AKIASED4WTLLWZ62DNFP';
$mail->Password = 'BAQSEdMODYC1J75hmGGXrlHvsh6IozG13fyUt+cKUdIw';
$mail->Host = 'email-smtp.ap-south-1.amazonaws.com';   

// $mail->SMTPSecure = "ssl"; 
$mail->SMTPSecure = "tls";                           

$mail->Port = 587;                                   

$mail->setFrom('webticketing@agscinemas.com', 'AGS cinemas');

$mail->addAddress($email, 'AGS cinemas');

$mail->isHTML(true);
// $mail->addBCC('prabhakaran.n@verandalearning.com');
   // $mail->addBCC('kalasalingam.s@verandalearning.com');
    // $mail->addBCC('simiyon.v@verandalearning.com');
    // $mail->addBCC('rajkumar.v@verandalearning.com');
    $mail->addBCC('anuruth.vs@verandalearning.com');
$mail->Subject = "Hi, Test Mail";
$mail->Body = "Testing Mail";
$mail->AltBody = "This is the plain text version of the email content";

try {
    $mail->send();
    echo "Message has been sent successfully";
} catch (Exception $e) {
    echo "Mailer Error: " . $mail->ErrorInfo;
}
// }
