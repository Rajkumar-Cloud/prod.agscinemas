<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Kolkata");
    $today = date('d-m-Y');
    $rowsarr = [];
    $arr = [];
    $arr2 = [];
    $array = [];

    $CinemaID = $_POST['locationId'];
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
    $i = 0;
    for($m = 0; $m < $count3; $m++) {
        $area_no = $cinemasarr[$m]['CinemaID'];
        if ($area_no == $CinemaID) {
            $cnmt = count($cinemasarr[$m]['Films']);
            for($o = 0; $o < $cnmt; $o++) { 
                $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);  
                for($k = 0; $k < $main; $k++) {
                    $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                    $ShowDateFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                    $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                    $ShowFinishTime = date("Y-m-d g:i A",strtotime($ShowDateFinishTime));                    
                    $originalDate = strtr($ShowDateTime, '/', '-');
                    $FinishDate = strtr($ShowDateFinishTime, '/', '-');
                    if(date("d-m-Y", strtotime($originalDate)) == $today) {
                        $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                        $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                        $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                        $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                        $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                        $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));

                        array_push($array,$obj);
                    }
                $i++;
                }
            }        
        } elseif ($CinemaID == 5) {
            $cnmt = count($cinemasarr[$m]['Films']);
            for($o = 0; $o < $cnmt; $o++) { 
                $main = count($cinemasarr[$m]['Films'][$o]['Sessions']);  
                for($k = 0; $k < $main; $k++) {
                    $ShowDateTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowDateTime'];  
                    $ShowDateFinishTime = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ShowFinishTime'];  
                    $showsdate = date("Y-m-d g:i A",strtotime($ShowDateTime));                    
                    $ShowFinishTime = date("Y-m-d g:i A",strtotime($ShowDateFinishTime));                    
                    $originalDate = strtr($ShowDateTime, '/', '-');
                    $FinishDate = strtr($ShowDateFinishTime, '/', '-');
                    if(date("d-m-Y", strtotime($originalDate)) == $today) {
                        $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                        $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                        $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                        $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                        $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                        $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));

                        array_push($array,$obj);
                    }
                $i++;
                }
            }
        }
    }
    $json_array = [];
    foreach ($array as $key => $value) {
        $json_array['data'][$key] = $value;
    }
    echo json_encode($json_array);


?>