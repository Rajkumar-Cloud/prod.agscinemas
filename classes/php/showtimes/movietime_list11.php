<?php

include "config.php";
include "../dynamictime_config.php";
session_start();


$showdate =$_POST["showdate"];

date_default_timezone_set('Asia/Kolkata');
$NewDate = date('Y-m-d',strtotime("+7 day"));
$today = date('Y-m-d');
$time=date("H:i:s");
$convertedTime = date('H:i:s',strtotime($dynamic_webtime.'minutes',strtotime($time)));

 if($today == $showdate)
 {
    $stmt=$link->prepare("SELECT *,show_schedule.session_id as abc,show_schedule.show_time,show_schedule.show_soundsys FROM show_schedule INNER JOIN Movie_details ON (show_schedule.Movie_code = Movie_details.mov_code) INNER JOIN Cinema ON (show_schedule.Cinemas_Id = Cinema.Cin_Id) where (show_schedule.show_date =? AND show_schedule.show_time >? AND Movie_details.Screen!='prebooking' AND show_schedule.show_status='confirmed' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0) ORDER BY Movie_details.mov_name ASC,show_schedule.show_date ASC,show_schedule.show_time ASC");
    $stmt->bind_param('ss', $showdate,$time);
    $stmt->execute();  
    $result = $stmt->get_result();
     
 }
else
{
    $stmt=$link->prepare("SELECT *,show_schedule.session_id as abc,show_schedule.show_time,show_schedule.show_soundsys FROM show_schedule INNER JOIN Movie_details ON (show_schedule.Movie_code = Movie_details.mov_code) INNER JOIN Cinema ON (show_schedule.Cinemas_Id = Cinema.Cin_Id) where (show_schedule.show_date =?  AND Movie_details.Screen!='prebooking' AND show_schedule.show_status='confirmed' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0) OR (show_schedule.show_date =? AND show_schedule.show_time >? AND Movie_details.Screen!='prebooking' AND show_schedule.show_status='confirmed' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0) ORDER BY Movie_details.mov_name ASC,show_schedule.show_date ASC,show_schedule.show_time ASC");
    
$stmt->bind_param('sss', $showdate,$showdate,$time);
$stmt->execute(); 
 $result = $stmt->get_result();
    
}

$myArray = array();
$array=array();

while($row=$result->fetch_assoc())
{
    $obj=new stdClass();
   
   
   
     $showTime=$row['show_time'];
     
    
    
      if($convertedTime > $showTime && $today == $showdate)
    {
       
         $obj->red_col='red';
    }
    else
    {
        $obj->red_col='#33a054';
    }
   
   
   
     $obj->showId =$row['session_id'];
     $obj->showId11 =$row['abc'];
     $obj->MovieId=$row['Movie_code'];  
      $obj->showTime7=$row['show_time'];  
     $obj->showTime=date("g:i a", strtotime($row['show_time']));
     $showsdate=$row['show_date'];
     $obj->showDate=date('d', strtotime($showsdate));
     $obj->showDay=date('D', strtotime($showsdate));
     $obj->Cin_Id = $row['Cinemas_Id'];
     $obj->Screen_id =$row['Scrn_id'];
     $obj->Cin_Loc= $row['Cin_Loc'];
     $obj->movieName =$row['mov_name'];  
     $obj->Language=$row['mov_Lang'];
     $obj->runTime= $row['mov_runTime'];
     $obj->imageURL =$row['mov_imageURL'];
     $obj->Censor= $row['mov_censor'];
     $obj->from_Date =$row['mov_from_Date'];
     $obj->to_Date = $row['mo_to_Date'];
     $obj->movieType = $row['movieType'];
     $obj->coverImage =$row['mov_coverImage'];
     $obj->Genre=$row['mov_genre'];
     $obj->Crew =$row['mov_crew'];
     $obj->Cast=$row['mov_cast'];
     $obj->moviesDescription =$row['mov_desc'];
     $obj->trailerImageURL =$row['mov_trailerImageURL'];
     $obj->trailerURL =$row['mov_trailerURL'];
     $obj->trailerImageURL2 =$row['trailerImageURL2'];
     $obj->trailerURL2=$row['trailerURL2'];
     
     $myArray='';
     $myArray[] = $row['show_soundsys'];
     
     $rowtext = "";
     $input = '(' . implode(',', $myArray) . ')';
    
     $result111=mysqli_query($link,"select * from soundsystem where id IN $input");
        while($row1 = mysqli_fetch_array($result111))
         {
            $rowtext .=$row1["Image"].",";
         }
       $obj->soundsysimg=rtrim($rowtext,',');  //rtrim used for after image name show COMMA (Remove last character of COMMA)    
         
     $totseat=$row["Total_seats"];
    $availseats=$row["Available_seats"];
     $totseat1=$row["booked_seats"];
     $totseat2=$totseat/2;
     
    	if($availseats==0)
       {
    	   $col1='#F285A2'; 
    	    
       }
        else if($totseat2>=$availseats)
        {
            $col1='#D4AF37'; 
        }
    	else
    	{
    	     $col1='#33a054'; 
    	} 
    	$obj->checkcount =$col1;  
     
     
     array_push($array, $obj);
  
     
    }

echo json_encode($array);

?> 