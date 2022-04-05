<?php
  session_start();
  $rowsarr = [];
  $arr = [];
  $arr2 = [];
  $array = [];
  $show_id=$_POST['id'];
  $movie_tickvalue=$_POST['movieticket'];
  $cinid=$_POST['cinid'];
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

  for($m=0;$m<$count3;$m++) {
    $area_no = $cinemasarr[$m]['CinemaID'];
    $CurrentOrder = $cinemasarr[$m]['CinemaName'];
    $cnmt = count($cinemasarr[$m]['Films']);

    if($cinid == $cinemasarr[$m]['CinemaID']) {

      for($o=0;$o<$cnmt;$o++) {
        $MovieId                = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
        $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   
        
        for($k=0;$k<$main;$k++) {
           $session_id       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId']; 

           if($show_id == $session_id) {
              $obj['session_close']     = ''; 
              $CinemaId                 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['CinemaId']; 
              $obj['CinemaId']          = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['CinemaId']; 
              $obj['Cin_Loc']           = $cinemasarr[$m]['CinemaName'];
              $ShowDateTime             = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];
              $originalDate             = strtr($ShowDateTime, '/', '-');
              $showTime                 = date("g:i A", strtotime($originalDate));
              $showDate                 = date("d-m-Y", strtotime($originalDate));
              $obj['showTime']          = $showTime;
              $obj['gettingshowDate']   = $showDate;
              
              $ShowDateTime = date("d-m-Y", strtotime($originalDate));
              $obj['showDate']          = date("d-m-Y", strtotime($ShowDateTime));
              $MovieId                  = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
              $MovieIdss                = substr($MovieId, 1); 
              $obj['MovieId']           = $MovieIdss;
              $m_name                   = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
              $obj['m_Name']            = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
              $obj['m_Language']        = $cinemasarr[$m]['Films'][$o]['Genere'];
              $obj['m_Censor']          = $cinemasarr[$m]['Films'][$o]['Censor'];
              $obj['m_Genre']           = $cinemasarr[$m]['Films'][$o]['Genere'];
              $obj['movie_runTime']     = $cinemasarr[$m]['Films'][$o]['Duration']; 
              $obj['Screen_No']         = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
              $obj['SeatAvailaible']    = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];
              $obj['CinemaName']        = $cinemasarr[$m]['CinemaName'];
              $obj['balance']           = '500'; 
              $obj['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
              $obj['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
              $obj['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
              $obj['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
              $obj['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
              $obj['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
               
              array_push($array,$obj);
              $_SESSION['movieId']=$MovieIdss; 
              $_SESSION['movie_Name']=$m_name;
              $_SESSION['movie_Language']=$obj['m_Language'];
              $_SESSION['movie_Censor']=$obj['m_Censor'];
              $_SESSION['movie_Genre']=$obj['m_Genre'];
              $_SESSION['movie_runTime']=$obj['movie_runTime'];
              $_SESSION['movie_location']=$obj['Cin_Loc'];
              $_SESSION['movie_showtime']=$obj['showTime']; 
              $_SESSION['movie_date']=$obj['showDate'];
              $_SESSION['movie_screen']=$obj['Screen_No'];
              $_SESSION['movie_showid']=$session_id;
              $_SESSION['three_valuecg']= isset($d3_charge);
              $_SESSION['movie_tickvalue']=$movie_tickvalue;
              $_SESSION['Cin_Id']=$CinemaId; 
              $_SESSION['catcode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['Code'];
              $_SESSION['catcode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['Code'];
              $_SESSION['catprice1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
              $_SESSION['catprice2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
              $_SESSION['catareacode1'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
              $_SESSION['catareacode2'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];               
           }
        }       
      }
    }
  }
  
  echo json_encode($array);
 
?>