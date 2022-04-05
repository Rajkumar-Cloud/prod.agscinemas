<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once ("movieposters.php");
    date_default_timezone_set("Asia/Kolkata");
    $today = date('d-m-Y');
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];

    if(isset($_REQUEST['getAllShowTime'])){

        $movieid = $_POST['movieId'];
        $Cin_id = $_POST['Cin_id'];
        $handle = curl_init();

        $url = "http://3.109.167.11/classes/php/moviejson.json";
        // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
        // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";


        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
        $output = curl_exec($handle);

        curl_close($handle);
        $json = json_decode($output, true);
        $json['ReturnCode'];
        $json['ReturnDescription'];
        $cinemasarr = $json['Cinemas'];
        $countsnew = 0;
        $count3 = count($cinemasarr);
        for($m = 0; $m < $count3; $m++) {
            $area_no = $cinemasarr[$m]['CinemaID'];
            if(empty($Cin_id) != 1) {

                if($Cin_id == $area_no) {
                    // echo("Cin_id:".empty($Cin_id));
            // }
                    $CurrentOrder = $cinemasarr[$m]['CinemaName'];
                    $cnmt = count($cinemasarr[$m]['Films']);

                    for($o = 0; $o < $cnmt; $o++) { 
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   

                        for($k = 0; $k < $main; $k++) {
                            $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
                            $FilmCode       = substr($FilmCode, 1);

                            if($movieid == $FilmCode) {                    
                                $movieimagearr = explode("//",movieimage($movieid));
                                $obj['Cin_Loc'] = $cinemasarr[$m]['CinemaName'];
                                $obj['Cin_id'] = $cinemasarr[$m]['CinemaID'];
                                $filmOp_date = strtr($cinemasarr[$m]['Films'][$o]['FilmOpeningDate'], '/', '-');
                                $obj['filmOpeningDate'] = date("M d, Y", strtotime($filmOp_date));
                                $obj['movieName'] = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
                                $obj['Genere'] = $cinemasarr[$m]['Films'][$o]['Genere'];
                                $obj['Runtime'] = $cinemasarr[$m]['Films'][$o]['Duration'];
                                $obj['Censor'] = $cinemasarr[$m]['Films'][$o]['Censor'];
                                $obj['crew'] = "";
                                $obj['cast'] = $cinemasarr[$m]['Films'][$o]['Cast'];
                                $obj['moviedescription'] = $cinemasarr[$m]['Films'][$o]['Description'];
                                $obj['trailerImageURL'] = "";
                                $obj['coverImage'] = $movieimagearr[1];
                                $FilmCode = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode'];   
                                $obj['MovieId'] = substr($FilmCode, 1);
                                $obj['SessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];   
                                $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                                $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                                $originalDate = strtr($ShowDateTime, '/', '-');
				$obj['showDatetime'] = $showsdate;
                                $obj['showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['showDate'] = date("d-m-Y", strtotime($originalDate));
                                $obj['date'] = date('d', strtotime($obj['showDate']));
                                $obj['month'] = date('M', strtotime($obj['showDate']));

                                if(date('D', strtotime($today)) == date('D', strtotime($obj['showDate'])) && $obj['showDate'] == $today)
                                    $obj['days'] = "Today";
                                else
                                    $obj['days'] = date('D', strtotime($obj['showDate']));
                                
                                $ShowFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                                $ScreenName = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $SeatAvailaible = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];

                                // $seatDetails = seatDetails($obj['Cin_id'], $obj['SessionId']);
                                // $total = 50;
                                // $booked = 25;
                                // foreach (json_decode($seatDetails) as $key => $value) {
                                //    $total = $total + $value->totalSeats; 
                                //    $booked = $booked + $value->totalBooked; 
                                // }

                                $TotalSeats = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];
                                $bookedSeats = $TotalSeats - $SeatAvailaible;
                                $obj['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
                                $obj['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
                                $obj['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
                                $obj['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
                                $obj['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
                                $obj['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
                                $obj['TotalSeats'] = $SeatAvailaible;
                                $obj['SeatAvailaible'] = $TotalSeats;
                                $obj['bookedSeats'] = $bookedSeats;
                                $obj['ScreenCapacity'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];

                                $totseat=$TotalSeats;
                                $availseats=$SeatAvailaible;
                                $totseat1=$bookedSeats;
                                $totseat2=$totseat/2;
                                if($availseats==0)
                                    $col1='#F285A2';
                                else if($totseat2>=$availseats)
                                    $col1='#D4AF37'; 
                                else
                                    $col1='#33a054'; 
                                $obj['checkcount'] =$col1; 

                                array_push($array,$obj);
                            }
                        }
                    } 
            
            // if(empty($Cin_id) != 1) {   
                }/*else{
                    echo "Cin_id->".$Cin_id;
                }*/
            }else {
                $CurrentOrder = $cinemasarr[$m]['CinemaName'];
                    $cnmt = count($cinemasarr[$m]['Films']);

                    for($o = 0; $o < $cnmt; $o++) { 
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   

                        for($k = 0; $k < $main; $k++) {
                            $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
                            $FilmCode       = substr($FilmCode, 1);

                            if($movieid == $FilmCode) {                    
                                $movieimagearr = explode("//",movieimage($movieid));
                                $obj['Cin_Loc'] = $cinemasarr[$m]['CinemaName'];
                                $obj['Cin_id'] = $cinemasarr[$m]['CinemaID'];
                                $filmOp_date = strtr($cinemasarr[$m]['Films'][$o]['FilmOpeningDate'], '/', '-');
                                $obj['filmOpeningDate'] = date("M d, Y", strtotime($filmOp_date));
                                $obj['movieName'] = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
                                $obj['Genere'] = $cinemasarr[$m]['Films'][$o]['Genere'];
                                $obj['Runtime'] = $cinemasarr[$m]['Films'][$o]['Duration'];
                                $obj['Censor'] = $cinemasarr[$m]['Films'][$o]['Censor'];
                                $obj['crew'] = "";
                                $obj['cast'] = $cinemasarr[$m]['Films'][$o]['Cast'];
                                $obj['moviedescription'] = $cinemasarr[$m]['Films'][$o]['Description'];
                                $obj['trailerImageURL'] = "";
                                $obj['coverImage'] = $movieimagearr[1];
                                $FilmCode = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode'];   
                                $obj['MovieId'] = substr($FilmCode, 1);
                                $obj['SessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];   
                                $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                                $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                                $originalDate = strtr($ShowDateTime, '/', '-');
				$obj['showDatetime'] = $showsdate;
                                $obj['showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['showDate'] = date("d-m-Y", strtotime($originalDate));
                                $obj['date'] = date('d', strtotime($obj['showDate']));
                                $obj['month'] = date('M', strtotime($obj['showDate']));

                                if(date('D', strtotime($today)) == date('D', strtotime($obj['showDate'])) && $obj['showDate'] == $today)
                                    $obj['days'] = "Today";
                                else
                                    $obj['days'] = date('D', strtotime($obj['showDate']));
                                
                                $ShowFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                                $ScreenName = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $SeatAvailaible = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];

                                // $seatDetails = seatDetails($obj['Cin_id'], $obj['SessionId']);
                                // $total = 50;
                                // $booked = 25;
                                // foreach (json_decode($seatDetails) as $key => $value) {
                                //    $total = $total + $value->totalSeats; 
                                //    $booked = $booked + $value->totalBooked; 
                                // }

                                $TotalSeats = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];
                                $bookedSeats = $TotalSeats - $SeatAvailaible;
                                $obj['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
                                $obj['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
                                $obj['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
                                $obj['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
                                $obj['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
                                $obj['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
                                $obj['TotalSeats'] = $SeatAvailaible;
                                $obj['SeatAvailaible'] = $TotalSeats;
                                $obj['bookedSeats'] = $bookedSeats;
                                $obj['ScreenCapacity'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];

                                $totseat=$TotalSeats;
                                $availseats=$SeatAvailaible;
                                $totseat1=$bookedSeats;
                                $totseat2=$totseat/2;
                                if($availseats==0)
                                    $col1='#F285A2';
                                else if($totseat2>=$availseats)
                                    $col1='#D4AF37'; 
                                else
                                    $col1='#33a054'; 
                                $obj['checkcount'] =$col1; 

                                array_push($array,$obj);
                            }
                        }
                    }
            }
        }

    $ord = array();
    foreach ($array as $key => $value){
        $ord[] = strtotime($value['showtime']);
    }
    array_multisort($ord, SORT_ASC, $array);


        echo json_encode($array);

    }

    if(isset($_REQUEST['getLocationShowTime'])){

        $movieid = $_POST['movieId'];
        $Cin_id = $_POST['Cin_id'];
        $handle = curl_init();

        $url = "http://3.109.167.11/classes/php/moviejson.json";
        // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
        // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";

        curl_setopt($handle, CURLOPT_URL, $url);
        // Set the result output to be a string.
        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
        curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
        $output = curl_exec($handle);

        curl_close($handle);
        $json = json_decode($output, true);
        $json['ReturnCode'];
        $json['ReturnDescription'];
        $cinemasarr = $json['Cinemas'];
        $countsnew = 0;
        $count3 = count($cinemasarr);

        for($m = 0; $m < $count3; $m++) {
            $area_no = $cinemasarr[$m]['CinemaID'];
            if($Cin_id == $area_no) {
                $CurrentOrder = $cinemasarr[$m]['CinemaName'];
                $cnmt = count($cinemasarr[$m]['Films']);

                for($o = 0; $o < $cnmt; $o++) { 
                    $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                    $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   

                    for($k = 0; $k < $main; $k++) {
                        $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
                        $FilmCode       = substr($FilmCode, 1);

                        if($movieid == $FilmCode) {                    
                            $movieimagearr = explode("//",movieimage($movieid));
                            $obj['Cin_Loc'] = $cinemasarr[$m]['CinemaName'];
                            $obj['Cin_id'] = $cinemasarr[$m]['CinemaID'];
                            $filmOp_date = strtr($cinemasarr[$m]['Films'][$o]['FilmOpeningDate'], '/', '-');
                            $obj['filmOpeningDate'] = date("M d, Y", strtotime($filmOp_date));
                            $obj['movieName'] = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
                            $obj['Genere'] = $cinemasarr[$m]['Films'][$o]['Genere'];
                            $obj['Runtime'] = $cinemasarr[$m]['Films'][$o]['Duration'];
                            $obj['Censor'] = $cinemasarr[$m]['Films'][$o]['Censor'];
                            $obj['crew'] = "";
                            $obj['cast'] = $cinemasarr[$m]['Films'][$o]['Cast'];
                            $obj['moviedescription'] = $cinemasarr[$m]['Films'][$o]['Description'];
                            $obj['trailerImageURL'] = "";
                            $obj['coverImage'] = $movieimagearr[1];
                            $FilmCode = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode'];   
                            $obj['MovieId'] = substr($FilmCode, 1);
                            $obj['SessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];   
                            $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                            $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                            $originalDate = strtr($ShowDateTime, '/', '-');
			    $obj['showDatetime'] = $showsdate;
                            $obj['showtime'] = date("g:i A",strtotime($originalDate));
                            $obj['showDate'] = date("d-m-Y", strtotime($originalDate));
                            $obj['date'] = date('d', strtotime($obj['showDate']));
                            $obj['month'] = date('M', strtotime($obj['showDate']));

                            if(date('D', strtotime($today)) == date('D', strtotime($obj['showDate'])) && $obj['showDate'] == $today)
                                $obj['days'] = "Today";
                            else
                                $obj['days'] = date('D', strtotime($obj['showDate']));
                            
                            $ShowFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                            $ScreenName = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                            $SeatAvailaible = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];

                            // $seatDetails = seatDetails($obj['Cin_id'], $obj['SessionId']);
                            // $total = 50;
                            // $booked = 25;
                            // foreach (json_decode($seatDetails) as $key => $value) {
                            //    $total = $total + $value->totalSeats; 
                            //    $booked = $booked + $value->totalBooked; 
                            // }

                            $TotalSeats = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];
                            $bookedSeats = $TotalSeats - $SeatAvailaible;
                            $obj['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
                            $obj['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
                            $obj['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
                            $obj['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
                            $obj['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
                            $obj['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
                            $obj['TotalSeats'] = $SeatAvailaible;
                            $obj['SeatAvailaible'] = $TotalSeats;
                            $obj['bookedSeats'] = $bookedSeats;
                            $obj['ScreenCapacity'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];

                            $totseat=$TotalSeats;
                            $availseats=$SeatAvailaible;
                            $totseat1=$bookedSeats;
                            $totseat2=$totseat/2;
                            if($availseats==0)
                                $col1='#F285A2';
                            else if($totseat2>=$availseats)
                                $col1='#D4AF37'; 
                            else
                                $col1='#33a054'; 
                            $obj['checkcount'] =$col1; 

                            array_push($array,$obj);
                        }
                    }
                } 
            }
	    if(empty($Cin_id) == 1) {
                $CurrentOrder = $cinemasarr[$m]['CinemaName'];
                    $cnmt = count($cinemasarr[$m]['Films']);

                    for($o = 0; $o < $cnmt; $o++) { 
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   

                        for($k = 0; $k < $main; $k++) {
                            $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
                            $FilmCode       = substr($FilmCode, 1);

                            if($movieid == $FilmCode) {                    
                                $movieimagearr = explode("//",movieimage($movieid));
                                $obj['Cin_Loc'] = $cinemasarr[$m]['CinemaName'];
                                $obj['Cin_id'] = $cinemasarr[$m]['CinemaID'];
                                $filmOp_date = strtr($cinemasarr[$m]['Films'][$o]['FilmOpeningDate'], '/', '-');
                                $obj['filmOpeningDate'] = date("M d, Y", strtotime($filmOp_date));
                                $obj['movieName'] = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
                                $obj['Genere'] = $cinemasarr[$m]['Films'][$o]['Genere'];
                                $obj['Runtime'] = $cinemasarr[$m]['Films'][$o]['Duration'];
                                $obj['Censor'] = $cinemasarr[$m]['Films'][$o]['Censor'];
                                $obj['crew'] = "";
                                $obj['cast'] = $cinemasarr[$m]['Films'][$o]['Cast'];
                                $obj['moviedescription'] = $cinemasarr[$m]['Films'][$o]['Description'];
                                $obj['trailerImageURL'] = "";
                                $obj['coverImage'] = $movieimagearr[1];
                                $FilmCode = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode'];   
                                $obj['MovieId'] = substr($FilmCode, 1);
                                $obj['SessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];   
                                $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                                $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                                $originalDate = strtr($ShowDateTime, '/', '-');
				$obj['showDatetime'] = $showsdate;
                                $obj['showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['showDate'] = date("d-m-Y", strtotime($originalDate));
                                $obj['date'] = date('d', strtotime($obj['showDate']));
                                $obj['month'] = date('M', strtotime($obj['showDate']));

                                if(date('D', strtotime($today)) == date('D', strtotime($obj['showDate'])) && $obj['showDate'] == $today)
                                    $obj['days'] = "Today";
                                else
                                    $obj['days'] = date('D', strtotime($obj['showDate']));
                                
                                $ShowFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                                $ScreenName = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $SeatAvailaible = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];

                                // $seatDetails = seatDetails($obj['Cin_id'], $obj['SessionId']);
                                // $total = 50;
                                // $booked = 25;
                                // foreach (json_decode($seatDetails) as $key => $value) {
                                //    $total = $total + $value->totalSeats; 
                                //    $booked = $booked + $value->totalBooked; 
                                // }

                                $TotalSeats = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];
                                $bookedSeats = $TotalSeats - $SeatAvailaible;
                                $obj['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
                                $obj['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
                                $obj['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
                                $obj['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
                                $obj['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
                                $obj['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
                                $obj['TotalSeats'] = $SeatAvailaible;
                                $obj['SeatAvailaible'] = $TotalSeats;
                                $obj['bookedSeats'] = $bookedSeats;
                                $obj['ScreenCapacity'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenCapacity'];

                                $totseat=$TotalSeats;
                                $availseats=$SeatAvailaible;
                                $totseat1=$bookedSeats;
                                $totseat2=$totseat/2;
                                if($availseats==0)
                                    $col1='#F285A2';
                                else if($totseat2>=$availseats)
                                    $col1='#D4AF37'; 
                                else
                                    $col1='#33a054'; 
                                $obj['checkcount'] =$col1; 

                                array_push($array,$obj);
                            }
                        }
                    }
            }
        }

        echo json_encode($array);

    }




function seatDetails($cinema_id, $movieId){
    $array1 = [];
    $ch = curl_init();

    $data = array('CinemaId' => $cinema_id, 'TempTransId' => '', 'SessionId' => $movieId, 'ScreenOnTop' => true, 'ExtendedProperty' => true);                                                                    
    $data_string = json_encode($data); 

    // $ch = curl_init('http://123.176.34.84:8081/api/VistaRemote/GetSeatLayOut');   // where to post
    $ch = curl_init('http://49.207.181.204:8080/api/VistaRemote/GetSeatLayOut');   // where to post                                                                   
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");                                                                     
    curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);                                                                  
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);                                                                      
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Content-Length: ' . strlen($data_string)) );                                                                                                                   
    $result = curl_exec($ch);
    $json = json_decode($result, true);
    $json['SessionId'];
    $json['CinemaId'];
    $seatarr = $json['area'];
    $count3 = count($seatarr);

    for($m=0;$m<$count3;$m++) {
    $area_no = $seatarr[$m]['strAreaNum'];
    $CurrentOrder = $seatarr[$m]['strHasCurrentOrder'];
    $cnmt = count($seatarr[$m]['rows']);

    for($o=$cnmt-1;$o>=0;$o--) {
      $row_name   = $seatarr[$m]['rows'][$o]['strRowPhyID'];   
      $obj=new stdClass();
      $obj->catname = $seatarr[$m]['strAreaDesc']; 
      $obj->catcode = $seatarr[$m]['strAreaCode'];
      $catcode = $seatarr[$m]['strAreaCode'];
      $obj->category_id = substr($catcode, -1); 
      $ticketcategory  = $seatarr[$m]['strAreaDesc']; 

       
      $obj->row   = $row_name;   
      $obj->seat_id  = $seatarr[$m]['rows'][$o]['intGridRowID'];
      $main = count($seatarr[$m]['rows'][$o]['seats']);
      $arrayss = array();
      $totalSeat = [];
      $totalBooked = [];

      for($k=0;$k<$main;$k++) {
        $arr[] = $seatarr[$m]['rows'][$o]['seats'][$k]['strGridSeatNum'];  //kjj
        $arr2[] = $seatarr[$m]['rows'][$o]['seats'][$k]['strSeatNumber'];
        $seatstatus = $seatarr[$m]['rows'][$o]['seats'][$k]['strSeatStatus'];

        # Like 0 means Available
        # Like 1 means Booked
        # Like 3 means Social distance
        # Like 4 means Spl seat
        # Like 10 means Space


        if($seatstatus == '0') {
          if ($ticketcategory == 'DIAMOND') {
            $totalSeat[] = 'A';
              $arrayss[] = 'A';
          } else {
              $arrayss[] = 'C';
            $totalSeat[] = 'C';
          }               
        } else if($seatstatus == '10') {
              $arrayss[] = '_';  
        } else if($seatstatus == '3') {
              $arrayss[] = 'S';  
        } else { 
            $arrayss[] = 'U';
            $totalBooked[] = 'U'; 
        }

           $stra = implode("",$arrayss);
           $strb = implode(",",$arr);
           $strc = implode(",",$arr2);
      }
           $totalS = count($totalSeat);
           $totalB = count($totalBooked);

      $obj->totalSeats  = $totalS;
      $obj->totalBooked  = $totalB;
      $obj->strA  = $stra;
      $obj->seatgridno = $strb;
      $obj->seatgridseatno = $strc;
      $arr =[];
      $arr2 =[];
      array_push($array1,$obj);
    }

    }

    return json_encode($array1);
}


?>