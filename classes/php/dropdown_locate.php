<?php
  include "../config.php";
  session_start();
  $user_id=$_COOKIE['userid'];
  date_default_timezone_set('Asia/Kolkata');
  $today = date('Y-m-d');
  $time=date("H:i:s");
  $array=array();
  $preferredtheater=1;
  if($_POST['secu']=='secureddd') {
    $sql=mysqli_query($link,"select * from users where id='$user_id'");
    while($row=mysqli_fetch_array($sql)) {    
      $preferredtheater=$row['preferredtheater'];
    }
    $result=mysqli_query($link,"select * from Cinema ORDER BY Cin_Id DESC");   
    while($row1=mysqli_fetch_array($result)) {  
      $obj = new stdClass();
      $obj->Cin_Id=$row1['Cin_Id'];
      $obj->prefertheater=$preferredtheater;
      $obj->Cin_Loc=$row1['Cin_Loc'];
      $obj->Cin_Capacity=$row1['Cin_Capacity'];
      $obj->Cin_No_Screens=$row1['Cin_No_Screens'];
      $obj->coverimage=$row1['coverImage'];
      $obj->latitude=$row1['latitude'];
      $obj->longitude=$row1['longitude'];
      $obj->address=$row1['address'];
      $tikimg='click.png';
      $obj->clicking=$tikimg;
      array_push($array,$obj);
    }

    echo json_encode($array);
  }
?> 