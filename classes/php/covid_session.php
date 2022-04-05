<?php 
session_start();
$covidConfirm = $_POST['covidConfirm'];
if($covidConfirm)
	$_SESSION['covidConfirm'] = $covidConfirm;
?>