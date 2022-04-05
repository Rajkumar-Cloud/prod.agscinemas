<?php

include_once "config.php";
include "../dynamictime_config.php";
session_start();


date_default_timezone_set('Asia/Kolkata');
$NewDate = date('Y-m-d',strtotime("+7 day"));
 $today = date('Y-m-d');
 $time=date("H:i:s");
$convertedTime = date('H:i:s',strtotime($dynamic_webtime.'minutes',strtotime($time)));

$stmt=$link->prepare("select * from show_schedule INNER JOIN Movie_details ON (show_schedule.Movie_code = Movie_details.mov_code) INNER JOIN Cinema ON (show_schedule.Cinemas_Id = Cinema.Cin_Id) where (show_schedule.show_date > ?  AND Movie_details.Screen!='prebooking' AND show_schedule.show_status='confirmed' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0) OR (show_schedule.show_date = ? AND show_schedule.show_time > ? AND show_schedule.show_status='confirmed' AND Movie_details.Screen!='prebooking' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0) GROUP BY show_schedule.show_date  ORDER BY show_schedule.show_date ASC,show_schedule.show_time ASC");

$stmt->bind_param('sss',$today,$today,$time);
$stmt->execute(); 

 $result = $stmt->get_result();
$array=array();

while($row=mysqli_fetch_array($result))
{
     $obj=new stdClass();
     $obj->showId =$row['session_id'];
     $obj->MovieId=$row['Movie_code'];  
     $obj->showTime=date("g:i a", strtotime($row['show_time']));
     $showsdate =$row['show_date'];
     $obj->showDate=date('d', strtotime($showsdate));
     $obj->showDay=date('D', strtotime($showsdate));
     $obj->showDate1=$row['show_date'];
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
     $obj->trailerImageURL =$row['trailerImageURL'];
     $obj->trailerURL =$row['mov_trailerURL'];
     $obj->trailerImageURL2 =$row['trailerImageURL2'];
     $obj->trailerURL2=$row['trailerURL2'];
    
    	array_push($array, $obj);
    }

echo json_encode($array);

?> 