<?php
include "config.php";

session_start();
$showdate =$_POST["showdate"];
$M_id =$_POST["M_id"];
$C_id =$_POST["C_id"];
$fromtime =$_POST["fromtime"];
$totime =$_POST["totime"];
date_default_timezone_set('Asia/Kolkata');
$NewDate = date('Y-m-d',strtotime("+7 day"));
$today = date('Y-m-d');
$time=date("H:i:s");

if($M_id !='' && $C_id !='' && $fromtime!='')
{
     $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.MovieId=? AND Add_show.Cin_Id=? AND Add_show.showTime BETWEEN ? AND ?) ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
$stmt->bind_param('sssss',$showdate,$M_id,$C_id,$fromtime,$totime);
$stmt->execute(); 
$result = $stmt->get_result();
     
    
}

else if($M_id !='' && $C_id !='')
{
  $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.MovieId=? AND Add_show.Cin_Id=?) ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
  
$stmt->bind_param('sss',$showdate,$M_id,$C_id);
$stmt->execute(); 
$result = $stmt->get_result();
  
}
else if($C_id !='' && $fromtime!='')
{
   $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND  Add_show.Cin_Id=? AND Add_show.showTime BETWEEN ? AND ?)  ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");  
   $stmt->bind_param('ssss',$showdate,$C_id,$fromtime,$totime);
$stmt->execute(); 
$result = $stmt->get_result();
   
    
}
else if($M_id !='' && $fromtime!='')
{
       $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.MovieId=? AND Add_show.showTime BETWEEN ? AND ?)  ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
$stmt->bind_param('ssss',$showdate,$M_id,$fromtime,$totime);
$stmt->execute(); 
$result = $stmt->get_result();
}
else if($M_id !='')
{
    $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.MovieId=? ) ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
    $stmt->bind_param('ss',$showdate,$M_id);
$stmt->execute(); 
$result = $stmt->get_result();
}
else if($C_id !='')
{
    $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.Cin_Id=?) ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
    $stmt->bind_param('ss',$showdate,$C_id);
$stmt->execute(); 
$result = $stmt->get_result();
}
else if($fromtime !='')
{
    $stmt=$link->prepare("SELECT *,Add_show.id as abc,Add_show.showTime FROM Add_show INNER JOIN Movie ON (Add_show.MovieId = Movie.id) INNER JOIN Cinema ON (Add_show.Cin_Id = Cinema.Cin_Id) where (Add_show.showDate =? AND Movie.to_Date >= CURRENT_DATE AND Movie.Screen!='prebooking' AND Add_show.showTime BETWEEN ? AND ?) ORDER BY Add_show.showDate ASC,Add_show.showTime ASC");
    
$stmt->bind_param('sss',$showdate,$fromtime,$totime);
$stmt->execute(); 
$result = $stmt->get_result();
}

$array=array();

while($row=mysqli_fetch_array($result))
{
    $obj=new stdClass();
   
     $obj->showId =$row['id'];
     $obj->showId11 =$row['abc'];
     $obj->MovieId=$row['MovieId'];  
     $obj->showTime=date("g:i a", strtotime($row['showTime']));
     $showsdate=$row['showDate'];
     $obj->showDate=date('d', strtotime($showsdate));
     $obj->showDay=date('D', strtotime($showsdate));
     $obj->Cin_Id = $row['Cin_Id'];
     $obj->Screen_id =$row['Screen_id'];
     $obj->Cin_Loc= $row['Cin_Loc'];
     $obj->movieName =$row['Name'];  
     $obj->Language=$row['Language'];
     $obj->runTime= $row['runTime'];
     $obj->imageURL =$row['imageURL'];
     $obj->Censor= $row['Censor'];
     $obj->from_Date =$row['from_Date'];
     $obj->to_Date = $row['to_Date'];
     $obj->movieType = $row['movieType'];
     $obj->coverImage =$row['coverImage'];
     $obj->Genre=$row['Genre'];
     $obj->Crew =$row['Crew'];
     $obj->Cast=$row['Cast'];
     $obj->moviesDescription =$row['MoviesDescription'];
     $obj->trailerImageURL =$row['trailerImageURL'];
     $obj->trailerURL =$row['trailerURL'];
     $obj->trailerImageURL2 =$row['trailerImageURL2'];
     $obj->trailerURL2=$row['trailerURL2'];
     array_push($array, $obj);
  
     
    }

echo json_encode($array);


?>