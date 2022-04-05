<?php
  include "../config.php";
  date_default_timezone_set('Asia/Kolkata');
  $rowsarr = [];
  $arr = [];
  $arr2 = [];
  $array = [];
  $Cin_id = $_POST["Cin_id"];
  $handle = curl_init();
 
  $url = "http://3.109.167.11/classes/php/moviejson.json";
  // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
  // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
  // Set the url
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
    // if($cinemasarr[$m]['CinemaID'] == $Cin_id){
    $area_no = $cinemasarr[$m]['CinemaID'];
    $CurrentOrder = $cinemasarr[$m]['CinemaName'];
    $cnmt = count($cinemasarr[$m]['Films']);
    for($o=0;$o<$cnmt;$o++) {
      $MovieId                = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
      $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);   
      for($k=0;$k<$main;$k++){
          $FilmCode       = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode']; 
          $Sessions              = $cinemasarr[$m]['Films'][$o]['Sessions'];
          $FilmCode       = substr($FilmCode, 1);
          if(count($Sessions) > 0) {
            $obj['imageURL']            = '';
            $obj['trailerURL']            = '';
            $obj['trailerImageURL2']            = '';
            $obj['trailerURL2']            = '';
            $obj['Screen_id']            = '';
            $obj['movieType']            = '';
            $obj['Cin_Id']            = $cinemasarr[$m]['CinemaID'];
            $obj['Cin_Loc']           = $cinemasarr[$m]['CinemaName'];
            $obj['movieName']         = $cinemasarr[$m]['Films'][$o]['FilmTitle'];
            $obj['Language']          = $cinemasarr[$m]['Films'][$o]['Genere'];
            $obj['runTime']           = $cinemasarr[$m]['Films'][$o]['Duration'];
            $obj['Censor']            = $cinemasarr[$m]['Films'][$o]['Censor'];
            $obj['Crew']              = "";
            $obj['Cast']              = $cinemasarr[$m]['Films'][$o]['Cast'];
            $obj['Genre']            = '';
            $obj['moviesDescription']  = $cinemasarr[$m]['Films'][$o]['Description'];
            $obj['trailerImageURL']   = "";
            $obj['coverImage']        = $cinemasarr[$m]['Films'][$o]['coverImage'];
            $FilmCode                 = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['FilmCode'];   
            $obj['MovieId']           = substr($FilmCode, 1);
            $obj['showId']         = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];   
            $ShowDateTime             = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
            $showsdate                = date("Y-m-d",strtotime($ShowDateTime));
            $obj['showTime']          = date("g:i a",strtotime($ShowDateTime));
            $obj['showDate1']          = $showsdate;
            $obj['showDate']              = date('d', strtotime($showsdate));
            $obj['showDay']             = date('D', strtotime($showsdate));
            $ShowFinishTime           = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
            $ScreenName               = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
            $SeatAvailaible           = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SeatAvailaible'];
            array_push($array,$obj);
          }
      } 
    }
  }
  echo json_encode($array);

?>