<?php
session_start();
$userid=$_COOKIE['userid'];
$food_idd=$_POST['food_id'];
$count_numm=$_POST['count_num'];
$food_sum=0;
$checkingvariable=0;
$cinid = $_POST['cinemaid'];

if($cinid == 1){
    $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_tnagar.json";
}
else if($cinid == 2){
    $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_navalur.json";
}
else if($cinid == 3){
    $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_villivakkam.json";
}
else if($cinid == 4){
    $url = "http://3.109.167.11/classes/foodjson/foodlist/showfood_allapakkam.json";
}
$handle = curl_init();
curl_setopt($handle, CURLOPT_URL, $url);
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

$output = curl_exec($handle);
curl_close($handle);
$json = json_decode($output, true);
$foodidarr = array();
$foodpricearr= array();
for($k=0;$k<count($json);$k++){
    $foodidarr[] = $json[$k]['id'];
    $foodpricearr[] = $json[$k]['foodPrice'];
}

if($food_idd != '')
{

foreach ($food_idd as $code => $item ) 
 {
     
    $keyvalue = array_search($item,$foodidarr);
        if($keyvalue>=0)
        {
        $foodPrice = $foodpricearr[$keyvalue];
        $food_sum=$food_sum+($foodPrice*abs($count_numm[$code]));
        $checkingvariable++;
        }
     
 }


 

if(count($food_idd)==$checkingvariable)
{
    $_SESSION['foodvalue']=$food_sum;//$_POST['amtvalues'];
    $_SESSION['food_id']=$_POST['food_id'];
    $_SESSION['count_num']=$_POST['count_num'];
    $_SESSION['dynam_foodval']=$_POST['dynam_foodval'];   
    
}
else
{
    $_SESSION['foodvalue']=0;
    $_SESSION['food_id']='';
    $_SESSION['count_num'] = '';
}

}else
{
    $_SESSION['foodvalue']=0;
    $_SESSION['food_id'] = '';
    $_SESSION['count_num'] = '';
}




$_SESSION['timelefts']=$_POST['timelefts'];

$_SESSION['movie_seatsss']=$_POST['movie_seat'];
$_SESSION['showmovie_seatsss']=$_POST['showmovie_seat'];

?>