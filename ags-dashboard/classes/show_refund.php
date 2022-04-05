<?php
    session_start();
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    date_default_timezone_set("Asia/Kolkata");
    include "config.php";

    $CinemaID = $_SESSION['userData']->locationId;

    if (isset($_REQUEST['getMovieDetails'])) {        
        $today = date('d-m-Y');
        $rowsarr = [];
        $arr = [];
        $arr2 = [];
        $array = [];
        $handle = curl_init();
        
        $url = "http://3.109.167.11/classes/php/moviejson.json";
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
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $Sessions = $cinemasarr[$m]['Films'][$o]['Sessions'];
                        $MovieIds  = substr($MovieId, 1);
                        if(date("d-m-Y", strtotime($originalDate)) == $today) {
                            if (!in_array($MovieIds, $arr)) {
                                array_push($arr,$MovieIds);  
                                $obj['movie_id'] = $MovieIds;
                                $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                                $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                                $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                                $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));
                                $obj['movie_showDateTime'] = date("d-m-Y g:i A", strtotime($showsdate));
                                $obj['movie_sessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];

                                array_push($array,$obj);
                            }
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
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $Sessions = $cinemasarr[$m]['Films'][$o]['Sessions'];
                        $MovieIds  = substr($MovieId, 1);
                        if(date("d-m-Y", strtotime($originalDate)) == $today) {
                            if (!in_array($MovieIds, $arr)) {
                                array_push($arr,$MovieIds);  
                                $obj['movie_id'] = $MovieIds;
                                $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                                $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                                $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                                $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));
                                $obj['movie_showDateTime'] = date("d-m-Y g:i A", strtotime($showsdate));
                                $obj['movie_sessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];

                                array_push($array,$obj);
                            }
                        }
                    $i++;
                    }
                }
            }
        }
        echo json_encode($array);
    }

    if (isset($_REQUEST['getMovieShowDateTimeDetails'])) {        
        $today = date('d-m-Y');
        $rowsarr = [];
        $arr = [];
        $arr2 = [];
        $array = [];
        $handle = curl_init();
        
        $url = "http://3.109.167.11/classes/php/moviejson.json";
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
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $Sessions = $cinemasarr[$m]['Films'][$o]['Sessions'];
                        $MovieIds  = substr($MovieId, 1);
                        if(date("d-m-Y", strtotime($originalDate)) == $today) {
                            if (!in_array($ShowDateTime, $arr)) {
                                array_push($arr,$ShowDateTime);  
                                $obj['movie_id'] = $MovieIds;
                                $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                                $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                                $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                                $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));
                                $obj['movie_showDateTime'] = date("d-m-Y g:i A", strtotime($showsdate));
                                $obj['movie_sessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];

                                array_push($array,$obj);
                            }
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
                        $MovieId = $cinemasarr[$m]['Films'][$o]['FilmCode'];  
                        $Sessions = $cinemasarr[$m]['Films'][$o]['Sessions'];
                        $MovieIds  = substr($MovieId, 1);
                        if(date("d-m-Y", strtotime($originalDate)) == $today) {
                            if (!in_array($ShowDateTime, $arr)) {
                                array_push($arr,$ShowDateTime);  
                                $obj['movie_id'] = $MovieIds;
                                $obj['movie_location'] = $cinemasarr[$m]['CinemaName'];
                                $obj['movie_screen'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['ScreenName'];
                                $obj['movie_name'] = $cinemasarr[$m]['Films'][$o]['FilmTitle']; 
                                $obj['movie_showtime'] = date("g:i A",strtotime($originalDate));
                                $obj['movie_date'] = date("d-m-Y", strtotime($originalDate));
                                $obj['movie_showEndtime'] = date("g:i A", strtotime($FinishDate));
                                $obj['movie_showDateTime'] = date("d-m-Y g:i A", strtotime($showsdate));
                                $obj['movie_sessionId'] = $cinemasarr[$m]['Films'][$o]['Sessions'][$k]['SessionId'];

                                array_push($array,$obj);
                            }
                        }
                    $i++;
                    }
                }
            }
        }
        echo json_encode($array);
    }

    if (isset($_REQUEST['addMovieShowRefund'])) {
        $movieId = $_POST['movieId'];
        $movieName = $_POST['movie__hname_arr'];
        $show_date_time = $_POST['show_date_time'];
        $movie_location = $_POST['movie_location'];
        $remark = $_POST['movie_remark'];
        $data = [
            'movieId' => $movieId,
            'movieName' => $movieName, 
            'who_posted' => $_SESSION['username'],
            'remark' => $remark,
            'show_date_time' => $show_date_time,
            'movie_location' => $movie_location,
        ];        
        $movieShowRefundSql = "INSERT INTO `movie_show_refund` (movieId, movieName, who_posted, remark, show_date_time, movie_location) VALUES (:movieId, :movieName, :who_posted, :remark, :show_date_time, :movie_location)";
        $m_stmt= $link->prepare($movieShowRefundSql);
        $m_stmt->execute($data);
        $lastInsertId = $link->lastInsertId();        
        if($lastInsertId > 0) {
            $json_arr = ['type'=>'success', 'message'=>"success",'code'=>'201'];
        } else {
            $json_arr = ['type'=>'fail', 'message'=>"insert_error", 'code'=>'401'];
        }

        echo json_encode($json_arr);
    }

    if (isset($_REQUEST['GetShowRefund'])) {

        $data = [];  
        $location = "";    
        $movieShowRefundSql = $link->query("SELECT * FROM `movie_show_refund` WHERE status = '1'");
        $i = 0;
        while ($showRefund = $movieShowRefundSql->fetch()) {

            if($showRefund['movie_location'] == 1)
                $location = "AGS TNAGAR";
            if($showRefund['movie_location'] == 2)
                $location = "AGS NAVALUR";
            if($showRefund['movie_location'] == 3) 
                $location = "AGS VILLVAKKAM"; 
            if($showRefund['movie_location'] == 3) 
                $location = "AGS ALAPAKKAM";          

            $data['data'][$i] = array(
                'movieId' => $showRefund['movieId'],
                'movieName' => $showRefund['movieName'],
                'location' => $location,
                'showDateTime' => $showRefund['show_date_time'],
                'whoPosted' => $showRefund['who_posted'],
                'remark' => $showRefund['remark'],
            );
            $i++;
        }       

        echo json_encode($data);
    }


?>