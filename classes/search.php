<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    include_once "movieposters.php";
    
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];
    $handle = curl_init();
    $url = "http://3.109.167.11/classes/php/moviejson.json";
    // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
    // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
     
    curl_setopt($handle, CURLOPT_URL, $url);
    // Set the result output to be a string.
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($handle, CURLOPT_TIMEOUT, 300);
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
            $Sessions = $cinemasarr[$m]['Films'][$o]['Sessions'];
            $MovieIds  = substr($MovieId, 1); 

            if(count($Sessions) > 0) {
                if (!in_array($MovieIds, $arr)) {
                    array_push($arr,$MovieIds);  
                    $movieimagearr = explode("||", movieimage($MovieIds));                    
                    $obj = new stdClass();  
                    $obj->movieId         = $MovieIds;  
                    $obj->movieName       = $cinemasarr[$m]['Films'][$o]['FilmTitle'];   
                    $obj->Language        = $cinemasarr[$m]['Films'][$o]['Genere'];
                    $obj->Genere          = $cinemasarr[$m]['Films'][$o]['Genere'];
                    $obj->FilmDuration    = $cinemasarr[$m]['Films'][$o]['Duration']; 
                    $obj->FilmOpeningDate = $cinemasarr[$m]['Films'][$o]['FilmOpeningDate'];
                    $obj->Censor          = $cinemasarr[$m]['Films'][$o]['Censor'];
                    $obj->prebooking      = "";   
                    $obj->coverimage  = $movieimagearr[1];   
                    $obj->posterimage = $movieimagearr[0];
                    array_push($array,$obj);     
                    // unset($array);
                }
            }
        }
    }
$dum_array = [];
    foreach ($array as $key => $value) {
        if($array[$key]->Genere == 'TAMIL'){
            $dum_array[$array[$key]->Genere] = $array[$key];
        }
    }
    print_r($dum_array);
    echo json_encode($array);
?>