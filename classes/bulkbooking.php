<?php 
ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include("config.php");
    include("ags_mail.php");
    date_default_timezone_set('Asia/Kolkata');
    $today = date('Y-m-d H:i:s');
    if(isset($_REQUEST['userId'])) { $userId = $_REQUEST['userId']; } else { $userId = ''; }
    if(isset($_REQUEST['bulkbookingData'])) { 
        $theater_name = $_POST['theater_name'];
        $movie = $_POST['movie'];
	$b_id = $_POST['booking_id'];
        $otp = $_POST['otp'];
        
        $originalDate = strtr($_POST['bookingdate'], '/', '-');
        $bookingdate = date("Y-m-d", strtotime($originalDate));   
        $bookingdate1 = date("d-m-Y", strtotime($originalDate));

        $bookingtime = $_POST['bookingtime'];
        $total_quantity = $_POST['total_quantity'];
        $company_name = $_POST['company_name'];
        $contact_email = $_POST['contact_email'];
        $cpersonname = $_POST['cpersonname'];
        $contact_no = $_POST['contact_no'];
        $caddress = $_POST['caddress'];
	$update_booking = [
            'id' => $b_id,
            'userid' => $userId,
            'theaterid' => $theater_name,
            'movieid' => $movie,
            'showdate' => $bookingdate,
            'showtime' => $bookingtime,
            'ticketcount' => $total_quantity,
            'companyname' => $company_name,
            'email' => $contact_email,            
            'address' => $caddress,
            'name' => $cpersonname,
            'otp' => $otp,
            'contactnumber' => $contact_no
        ];

        $bulk_booking_sql = "UPDATE bulkbooking SET userid=:userid, theaterid=:theaterid, movieid=:movieid, showdate=:showdate, showtime=:showtime, ticketcount=:ticketcount, companyname=:companyname, email=:email, address=:address, name=:name, otp=:otp WHERE id=:id AND otp=:otp AND contactnumber=:contactnumber";

        $bulk_stmt = $link->prepare($bulk_booking_sql);
        $bulk_stmt->execute($update_booking);
        $bulk_rows = $bulk_stmt->rowCount();
        if($bulk_rows) {            
	    $service_type = "Bulk Ticket Booking";                       
            $template_body = "
            <div style='width:100%;background-color:transparent;display:block;text-align:left;'>
                <img src='https://pbs.twimg.com/profile_images/935001716285612032/fhRidd97_400x400.jpg' style='width: 10%; margin-left:12px;' alt='logo' />
                <p style='margin:1rem auto;font-weight:bold;color:#000'>Hello, </p>
                <p style='margin:1rem auto;color:#000;'>Thanks for choosing AGS Cinemas. Please find the details of your booking below. Kindly confirm the same. </p>
                <table style='width:100%;display:block;'>
                    <thead>
                        <tr>
                            <td style='padding: 5px 1rem;background-color: #312c2c5e;color: #000;font-weight: bold;'>Field's </td>
                            <td style='padding: 5px 1rem;background-color: #312c2c5e;color: #000;font-weight: bold;'>Details</td>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Name </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$cpersonname</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Email </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$contact_email</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Contact No </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$contact_no</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Company Name </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$company_name</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Theater </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$theater_name</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Movie Name </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$movie</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Booking Date </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$bookingdate1</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Show Time </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$bookingtime</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Ticket Quantity </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$total_quantity</td>
                        </tr>
                        <tr>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>Address </td>
                            <td style='border: 1px solid #ccc;padding: 5px 1rem;color:#000;'>$caddress</td>
                        </tr>
                    </tbody>
                </table>
                <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Our team will contact you soon. <br>Hope you enjoy a Safe Cinema Experience with us.  </p>
                <p style='margin-top:1rem;color:#000;letter-spacing:1px; padding:6px;'>Warm Regards,<br/>Team AGS </p>
            </div>";
            $sendMail = send_mail($contact_email, $template_body, $service_type);   
            // Contact Message Trigger
            $appendString = "Thanks for choosing AGS Cinemas for bulk booking. our technical team will you soon for further process. Thank you by AGS.";
            $msg = str_replace("+","%20",urlencode($appendString));
            // $urls = "http://smscampaigns.msgbell.com/API/sms.php?username=VERANDA&password=Veranda@123&from=VRANDA&to=".$contact_no."&msg=".$msg."&type=1&dnd_check=0&template_id=1707161526941623022";
            $urls = "https://control.msg91.com/api/sendhttp.php?authkey=161404AqQqRTYF594ce5e6&mobiles=".$contact_no."&message=".$msg."&sender=AGSPWD&route=4&country=91";
            $handle = curl_init($urls);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_exec($handle);
            curl_close($handle);
            $json_array = ['type'=>'success', 'alert'=>'success', 'message'=>"bulk booking added successfully!", 'code'=>'201'];
        } else {
	    $del_bulk = $link->prepare("DELETE FROM bulkbooking WHERE id =:id AND contactnumber=:contactnumber");
            $del_bulk->bindParam(':id', $b_id);
            $del_bulk->bindParam(':contactnumber', $contact_no);
            $del_bulk->execute();
	    $json_array = ['type'=>'error', 'status'=>'success', 'message'=>"Your given details does not match. please enter correct details.", 'code'=>'401'];
        }
    }

    if(isset($_REQUEST['bulkbookingMovieData'])) { 
        $theaterId = $_POST['theaterID'];
        $cinemaId = $_POST['cinemaID'];
        $json_array = [];    
        $output = AllMoviesData();
        $json = json_decode($output, true);
        $cinemasarr = $json['Cinemas'];
        $cinemasarr_count = count($cinemasarr);
        foreach ($cinemasarr as $key => $value) {
            if($cinemaId == $cinemasarr[$key]['CinemaID']){
                foreach ($cinemasarr[$key]['Films'] as $key1 => $value1) {
                    $obj['CinemaID'] = $cinemasarr[$key]['CinemaID'];  
                    $obj['FilmCode'] = $value1['FilmCode'];  
                    $obj['FilmTitle'] = $value1['FilmTitle'];
                    array_push($json_array,$obj);
                }    
            }
        }
    }

    if(isset($_REQUEST['bulkbookingSelectedMovieDate'])) { 
        $cinemaID = $_POST['cinemaID'];
        $FilmCode = $_POST['FilmCode'];
        $json_array = [];    
        $output = AllMoviesData();
        $json = json_decode($output, true);
        $cinemasarr = $json['Cinemas'];
        $cinemasarr_count = count($cinemasarr);
        foreach ($cinemasarr as $key => $value) {
            if($cinemaID == $cinemasarr[$key]['CinemaID']){
                foreach ($cinemasarr[$key]['Films'] as $key1 => $value1) {
                    if($FilmCode == $value1['FilmCode']){
                        $Sessions = $value1['Sessions'];
                        for ($i=0; $i < count($Sessions); $i++) { 
                            if($cinemaID == $Sessions[$i]['CinemaId'] && $FilmCode == $Sessions[$i]['FilmCode']) { 
                                $obj['CinemaID'] = $Sessions[$i]['CinemaId'];  
                                $obj['FilmCode'] = $Sessions[$i]['FilmCode'];  
                                $obj['FilmTitle'] = $value1['FilmTitle'];
                                $date = strtr($Sessions[$i]['ShowDateTime'], '/', '-');
                                $obj['ShowDate'] = date("d/m/Y", strtotime($date));;
                                $obj['SessionId'] = $Sessions[$i]['SessionId'];
                                array_push($json_array,$obj);
                            }
                        }
                    }
                }    
            }
        }
    }

    if(isset($_REQUEST['bulkbookingSelectedMovieDateTime'])) { 
        $cinemaID = $_POST['cinemaID'];
        $FilmCode = $_POST['FilmCode'];
        $ShowDate = strtr($_POST['ShowDate'], '/', '-');

        $json_array = [];    
        $output = AllMoviesData();
        $json = json_decode($output, true);
        $cinemasarr = $json['Cinemas'];
        $cinemasarr_count = count($cinemasarr);
        foreach ($cinemasarr as $key => $value) {
            if($cinemaID == $cinemasarr[$key]['CinemaID']){
                foreach ($cinemasarr[$key]['Films'] as $key1 => $value1) {
                    if($FilmCode == $value1['FilmCode']){
                        $Sessions = $value1['Sessions'];
                        for ($i=0; $i < count($Sessions); $i++) { 
                            if($cinemaID == $Sessions[$i]['CinemaId'] && $FilmCode == $Sessions[$i]['FilmCode'] && strpos($Sessions[$i]['ShowDateTime'], $ShowDate) !== false) { 
                                $obj['CinemaID'] = $Sessions[$i]['CinemaId'];  
                                $obj['FilmCode'] = $Sessions[$i]['FilmCode'];  
                                $obj['FilmTitle'] = $value1['FilmTitle'];
                                $date = strtr($Sessions[$i]['ShowDateTime'], '/', '-');
                                $obj['ShowDate'] = date("d-m-Y", strtotime($date));;
                                $obj['ShowTime'] = date("h:i:s A", strtotime($date));;
                                $obj['SessionId'] = $Sessions[$i]['SessionId'];
                                array_push($json_array,$obj);
                            }
                        }
                    }
                }    
            }
        }
    }

    function AllMoviesData()
    {
        $handle = curl_init();    
        $url = "http://3.109.167.11/classes/php/moviejson.json";
        // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
        // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
        curl_setopt($handle, CURLOPT_URL, $url);    
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($handle, CURLOPT_TIMEOUT, 300);
        $output = curl_exec($handle);    
        curl_close($handle);
        return $output;
    }

    if(isset($_REQUEST['bulkBooking_otpGenerate'])) {
        $otp_mobile_no = $_POST['mobileno'];
        $randomNo = rand(1000, 9999);
        $appendString = "Dear AGS Customer, your OTP for Completion of Account Registration is $randomNo This will expire in 30 Minutes.";
        $appendString1 = urlencode($appendString);
        $msg = str_replace("+","%20",$appendString1);
        $urls = "https://control.msg91.com/api/sendhttp.php?authkey=161404AqQqRTYF594ce5e6&mobiles=".$otp_mobile_no."&message=".$msg."&sender=AGSROT&route=4&country=91";
        $handle = curl_init($urls);
        curl_setopt($handle, CURLOPT_POST, true);
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        $contents = curl_exec($handle);
        curl_close($handle);
        $bulk_data = [
            'contactnumber' => $otp_mobile_no,
            'otp' => $randomNo
        ];        
        $b_sql = "INSERT INTO bulkbooking (contactnumber, otp) VALUES (:contactnumber, :otp)";
        $res_book = $link->prepare($b_sql)->execute($bulk_data);
        if($res_book) {
            $lastId = $link->lastInsertId();
            $json_array = ['status'=>'success', 'message'=> 'otp-success', 'bid'=> $lastId];
        }
    }

    echo json_encode($json_array);

?>