<?php
  date_default_timezone_set('Asia/Kolkata');
  $rowsarr = [];
  $arr = [];
  $arr2 = [];
  $array = [];

  $cinema_id = $_POST['cinema_id'];
  $movieId   = $_POST['movieId'];

  $handle = curl_init(); 
  $url = "http://3.109.167.11/classes/php/moviejson.json";
  // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
  // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";   
  curl_setopt($handle, CURLOPT_URL, $url);
  // Set the result output to be a string.
  curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
  curl_setopt($handle, CURLOPT_TIMEOUT, 300); //timeout in seconds
  curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);

  $output = curl_exec($handle);
  curl_close($handle);
  $json = json_decode($output, true);
  $json['ReturnCode'];
  $json['ReturnDescription'];
  $cinemasarr = $json['Cinemas'];
  $countsnew = 0;
  $count3 = count($cinemasarr);

  for($m=0;$m<$count3;$m++) {
    if($cinemasarr[$m]['CinemaID'] == $cinema_id){
      $area_no = $cinemasarr[$m]['CinemaID'];
      $CurrentOrder = $cinemasarr[$m]['CinemaName'];
      $cnmt = count($cinemasarr[$m]['Films']);

      for($o=0;$o<$cnmt;$o++) {
        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
        $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   
          for($k=0;$k<$main;$k++) {
            $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
            $FilmCode       = substr($FilmCode, 1);

            if($movieId == $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId']) {
              $catprice1 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['TicketPrice'];
              $catprice2 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['TicketPrice'];
              $catareacode1 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][0]['AreaCategoryCode'];
              $catareacode2 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['TicketTypes'][1]['AreaCategoryCode'];
              break 3;
            }
          } 
      }
    }
  }
  $animation = "2D";
  if($catareacode1 == "DIAMOND 3D") {
      $animation = "3D";
  } else {
      $animation = "2D";
  }
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
  $strException = $json['strException'];
  $Success = $json['Success'];

  if($count3 != 0) {
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

        if ($ticketcategory == 'DIAMOND') {
          $obj->Amount = $catprice1;
        } else {
          $obj->Amount = $catprice2;
        }
         
        $obj->row   = $row_name;   
        $obj->seat_id  = $seatarr[$m]['rows'][$o]['intGridRowID'];
        $main = count($seatarr[$m]['rows'][$o]['seats']);
        $arrayss = array();

        for($k=0;$k<$main;$k++) {
          $arr[] = $seatarr[$m]['rows'][$o]['seats'][$k]['strGridSeatNum'];  //kjj
          $arr2[] = $seatarr[$m]['rows'][$o]['seats'][$k]['strSeatNumber'];
          $seatstatus = $seatarr[$m]['rows'][$o]['seats'][$k]['strSeatStatus'];

      if($seatstatus == '0') {
            if ($ticketcategory == 'DIAMOND') {
                $arrayss[] = 'A';
            } else {
                $arrayss[] = 'C';
            }               
          } else if($seatstatus == '3') {
            $arrayss[] = 'S'; 
          } else if($seatstatus == '10') {
                $arrayss[] = '_';  
          } else { $arrayss[] = 'U'; }
              
             $stra = implode("",$arrayss);
             $strb = implode(",",$arr);
             $strc = implode(",",$arr2);
        }

        $obj->strA  = $stra;
        $obj->seatgridno = $strb;
        $obj->seatgridseatno = $strc;
        $arr =[];
        $arr2 =[];
        array_push($array,$obj);
      }

    }
  }else{
    $obj=new stdClass();
    $obj->strException = $strException;
    $obj->Success = $Success;
    array_push($array,$obj);
  }
  
  sort($array);
  echo json_encode($array);
?>