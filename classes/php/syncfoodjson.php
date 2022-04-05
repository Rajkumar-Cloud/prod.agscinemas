<?php 
include "../config.php";
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
error_reporting(0);
date_default_timezone_set('Asia/Kolkata');


$foodDetails = [];
$foodTypeDetails = [];
$array = [];
$TNR = [];
$NVL = [];
$VLK = [];
$ALA = [];
$foodData = $link->query("SELECT * FROM `fooditems` WHERE `foodImage_name` != 'NULL' AND status = 1");
$foodDetails = $foodData->fetchAll();

$foodTypeData = $link->query("SELECT id, foodtype, status FROM `fooditems` WHERE `foodImage_name` != 'NULL' AND status = 1 GROUP BY foodtype");
$foodTypeDetails = $foodTypeData->fetchAll();


$cinemaData = $link->query("SELECT Cin_Id, Cin_Loc FROM `cinema`");
$cinemaDetails = $cinemaData->fetchAll();

$i = 1;
foreach ($cinemaDetails as $key2 => $val2) {
	if ($cinemaDetails[$key2]['Cin_Id'] == 1) 
		foreach ($foodTypeDetails as $key1 => $val1) {
			$obj_TNR = array();
			$obj_TNR['id'] = $i;
			$obj_TNR['foodType'] = $foodTypeDetails[$key1]['foodtype'];
			$obj_TNR['cin_id'] = $cinemaDetails[$key2]['Cin_Id'];		
			$TNR[]=$obj_TNR;	
			$i++;
		}

	if ($cinemaDetails[$key2]['Cin_Id'] == 2) 
		foreach ($foodTypeDetails as $key1 => $val1) {
			$obj_NVL = array();
			$obj_NVL['id'] = $i;
			$obj_NVL['foodType'] = $foodTypeDetails[$key1]['foodtype'];
			$obj_NVL['cin_id'] = $cinemaDetails[$key2]['Cin_Id'];		
			$NVL[]=$obj_NVL;	
			$i++;
		}

	if ($cinemaDetails[$key2]['Cin_Id'] == 3) 
		foreach ($foodTypeDetails as $key1 => $val1) {
			$obj_VLK = array();
			$obj_VLK['id'] = $i;
			$obj_VLK['foodType'] = $foodTypeDetails[$key1]['foodtype'];
			$obj_VLK['cin_id'] = $cinemaDetails[$key2]['Cin_Id'];		
			$VLK[]=$obj_VLK;	
			$i++;
		}

	if ($cinemaDetails[$key2]['Cin_Id'] == 4) 
		foreach ($foodTypeDetails as $key1 => $val1) {
			$obj_ALA = array();
			$obj_ALA['id'] = $i;
			$obj_ALA['foodType'] = $foodTypeDetails[$key1]['foodtype'];
			$obj_ALA['cin_id'] = $cinemaDetails[$key2]['Cin_Id'];		
			$ALA[]=$obj_ALA;	
			$i++;
		}
}

$jsonData_TNR = json_encode($TNR);
$jsonData_NVL = json_encode($NVL);
$jsonData_VLK = json_encode($VLK);
$jsonData_ALA = json_encode($ALA);

$foodcat_filename_TNR = "../foodjson/foodcat/foodtype_tnagar.json";   
chmod($foodcat_filename_TNR, 0777);
unlink($foodcat_filename_TNR);
$myfileTN = fopen($foodcat_filename_TNR, "w");
fwrite($myfileTN, $jsonData_TNR);
fclose($myfileTN);

$foodcat_filename_ALA = "../foodjson/foodcat/foodtype_allapakkam.json";   
chmod($foodcat_filename_ALA, 0777);
unlink($foodcat_filename_ALA);
$myfileALM = fopen($foodcat_filename_ALA, "w");
fwrite($myfileALM, $jsonData_ALA);
fclose($myfileALM);

$foodcat_filename_NVL = "../foodjson/foodcat/foodtype_navalur.json";   
chmod($foodcat_filename_NVL, 0777);
unlink($foodcat_filename_NVL);
$myfileNLR = fopen($foodcat_filename_NVL, "w");
fwrite($myfileNLR, $jsonData_NVL);
fclose($myfileNLR);

$foodcat_filename_VLK = "../foodjson/foodcat/foodtype_villivakkam.json";   
chmod($foodcat_filename_VLK, 0777);
unlink($foodcat_filename_VLK);
$myfileVKM = fopen($foodcat_filename_VLK, "w");
fwrite($myfileVKM, $jsonData_VLK);
fclose($myfileVKM);


foreach ($foodDetails as $key => $val) {
	$obj = array();
	$obj['id'] = $foodDetails[$key]['id'];
	$obj['foodName'] = $foodDetails[$key]['foodname'];
	$obj['foodPrice'] = $foodDetails[$key]['foodprice'];
	$obj['foodImage'] = $foodDetails[$key]['foodImage_name'];
	$obj['foodType'] = $foodDetails[$key]['foodtype'];
	
	$array[]=$obj;	
}

$jsonData = json_encode($array);

$foodlist_filename_TNR = "../foodjson/foodlist/showfood_tnagar.json";   
chmod($foodlist_filename_TNR, 0777);
unlink($foodlist_filename_TNR);
$myfileTN = fopen($foodlist_filename_TNR, "w");
fwrite($myfileTN, $jsonData);
fclose($myfileTN);

$foodlist_filename_ALA = "../foodjson/foodlist/showfood_allapakkam.json";   
chmod($foodlist_filename_ALA, 0777);
unlink($foodlist_filename_ALA);
$myfileALM = fopen($foodlist_filename_ALA, "w");
fwrite($myfileALM, $jsonData);
fclose($myfileALM);

$foodlist_filename_NVL = "../foodjson/foodlist/showfood_navalur.json";   
chmod($foodlist_filename_NVL, 0777);
unlink($foodlist_filename_NVL);
$myfileNLR = fopen($foodlist_filename_NVL, "w");
fwrite($myfileNLR, $jsonData);
fclose($myfileNLR);

$foodlist_filename_VLK = "../foodjson/foodlist/showfood_villivakkam.json";   
chmod($foodlist_filename_VLK, 0777);
unlink($foodlist_filename_VLK);
$myfileVKM = fopen($foodlist_filename_VLK, "w");
fwrite($myfileVKM, $jsonData);
fclose($myfileVKM);


// echo($jsonData_ALA);
// echo($jsonData_NVL);
// echo($jsonData_TNR);
// echo($jsonData_VLK);
// echo($jsonData);


?>