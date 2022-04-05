<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(0);
include "../config.php";
date_default_timezone_set('Asia/Kolkata');
$handle = curl_init();
// $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
$url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
// $url = "http://3.109.167.11/classes/php/json_2021_10_26_10_15_01.json";
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
$output = curl_exec($handle);
curl_close($handle);

if($output){
  $insertdatetime = date("Y-m-d H:i:s");
  $datetime = date("Y_m_d_H_i_s");
  $filename = "json_".$datetime.".json";
  chmod($filename, 0777);
  unlink($filename);
  $myfile = fopen($filename, "w");
  fwrite($myfile, $output);
  fclose($myfile);
 
  unlink("moviejson.json");
  $myfile = fopen("moviejson.json", "w");

  fwrite($myfile, $output);
  fclose($myfile);
  $link->query("INSERT INTO `syncfiledatetime`( `file_name`, `synced_datetime`) VALUES ('$filename','$insertdatetime')");
  
}


?>