<?php 
    include_once '../../config.php';
    date_default_timezone_set('Asia/Kolkata');
    $NewDate = date('Y-m-d',strtotime("+7 day"));
    $today = date('Y-m-d');
    $time=date("H:i:s");

    $stmt=$link->prepare("SELECT *,Movie_details.mov_id as abc FROM show_schedule INNER JOIN Movie_details ON (show_schedule.Movie_code = Movie_details.mov_code) where (show_schedule.show_date >=? AND Movie_details.Screen!='prebooking' AND  show_schedule.show_status='confirmed' AND Movie_details.mov_status = 'active' AND show_schedule.status='active' AND show_schedule.method_WWW!=0)GROUP BY Movie_details.mov_name ORDER BY Movie_details.mov_name ASC,show_schedule.Mov_Id ASC, show_schedule.show_date ASC,show_schedule.show_date ASC"); 
    $stmt->bind_param('s', $today);
    $stmt->execute();  
    $result =$stmt->get_result();

//$sql=mysqli_query($link,"SELECT * FROM Movie where Screen!='prebooking'");

    $array = array();

while ($row =$result->fetch_assoc()) 
{
    $obj=new stdClass();

    $obj->M_id=$row["abc"];
   
    $obj->M_name=$row["mov_name"];
  
    array_push($array,$obj);
 

}

echo json_encode($array);

mysqli_close($link);

?>