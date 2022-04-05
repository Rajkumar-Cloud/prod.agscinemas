<?php 

include("../ags_mail.php");

$movie_location = $_POST['movie_location'];
$message = $_POST['message'];
$contact_email = "thandauthabani.c@agscinemas.com";

$service_type = $movie_location." - Seat Booking Error";                       
$template_body = "
<div style='width:100%;background-color:transparent;display:block;text-align:left;'>
    <img src='https://pbs.twimg.com/profile_images/935001716285612032/fhRidd97_400x400.jpg' style='width: 10%; margin-left:12px;' alt='logo' />
    <p style='margin:1rem auto;font-weight:bold;color:#000'>Hi, </p>
    <p style='margin:1rem auto;color:#000;'><b>".$movie_location."</b> - ".$message."</p>
    <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Our AGS technical team contact soon. </p>
    <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Warm Regards by<br/>AGS Team </p>
</div>";
$sendMail = send_mail($contact_email, $template_body, $service_type);   
echo json_encode($sendMail);
 ?>