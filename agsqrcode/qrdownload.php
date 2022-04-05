<?php
include "qrlib.php";
$qr = $_REQUEST['qr'];
// create a QR Code with this text and display it
$filepath = rand(11111,99999).'.png';
QRcode::png($qr, $filepath);

if(file_exists($filepath)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($filepath));
    flush(); // Flush system output buffer
    readfile($filepath);
//    exit;
}

if (!unlink($filepath)) {
   // echo "Error deleting ".$filepath;
} else {
   // echo "Deleted ".$filepath;
}

?>