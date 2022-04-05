<?php
    include_once ('../movieposters.php');
    $movieid = $_POST['movieId'];
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];
    $handle = curl_init();
    $url = "http://3.109.167.11/classes/php/moviejson.json";
    // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
    // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
    curl_setopt($handle, CURLOPT_URL, $url);    
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

    for($m = 0; $m < $count3; $m++) {
        $area_no = $cinemasarr[$m]['CinemaID'];
        $CurrentOrder = $cinemasarr[$m]['CinemaName'];
        $cnmt = count($cinemasarr[$m]['Films']);
        
        for($o = 0; $o < $cnmt; $o++) {
            $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode']; 
            $MovieIds       = substr($MovieId, 1);
            if($movieid == $MovieIds){
                $movieimagearr = explode("||", movieimage($MovieIds));
                $cinemasarr[$m]['Films'][$o]['coverimage'] = $movieimagearr[1];
                $cinemasarr[$m]['Films'][$o]['posterimage'] = $movieimagearr[0];
                $cinemasarr[$m]['Films'][$o]['trailerURL'] = $movieimagearr[2];
                $FilmOpeningDate = date("m-d-Y h:i:s", strtotime($cinemasarr[$m]['Films'][$o]['FilmOpeningDate']));
                $cinemasarr[$m]['Films'][$o]['FilmOpeningDate'] = $FilmOpeningDate;
                $main = $cinemasarr[$m]['Films'][$o];
                array_push($array,$main);
            }     
        }
    }
    echo json_encode($array);
?>