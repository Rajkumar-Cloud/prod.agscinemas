<?php
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    session_start();
    include("config.php");
    $get_path = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
    if(isset($_REQUEST['movie_Posters'])) {       
        $movieId = $_POST['movieId_name'];
        $movieName = $_POST['movie__hid_arr'];
        $trailerUrl = $_POST['movie_trailer_link'];
        $data = [
            'movieId' => $movieId,
            'movieName' => $movieName, 
            'who_posted' => $_SESSION['username'],
            'trailer_url' => $trailerUrl
        ];        
        $movieSql = "INSERT INTO `movie_posters` (movieId, movieName, who_posted, trailer_url) VALUES (:movieId, :movieName, :who_posted, :trailer_url)";
        $m_stmt= $link->prepare($movieSql);
        $m_stmt->execute($data);
        $lastInsertId = $link->lastInsertId();        
        if($lastInsertId > 0) {
            $json_arr = ['type'=>'success', 'message'=>"inserted", 'dataId'=>$lastInsertId, 'movieId'=>$movieId,'code'=>'201'];
        } else {
            $json_arr = ['type'=>'fail', 'message'=>"insert_error", 'code'=>'401'];
        }
    }

    if(isset($_REQUEST['addMovieimgs'])) {       
        $RowId = $_REQUEST['rowId'];
        $movieId = $_REQUEST['movieId'];        
        if(isset($_FILES['movie_poster_image'])) {
            $pfile_name = $_FILES['movie_poster_image']['name'];
            $temp_pfile_name = explode(".", $pfile_name);            
            $poster_new_filename = $movieId . '_poster' . '.'.end($temp_pfile_name);
            $pfile_size = $_FILES['movie_poster_image']['size'];            
            $pfilesize = round($pfile_size / 1024, 2)."kb";         
            $pfile_tmp = $_FILES['movie_poster_image']['tmp_name'];
            $pfile_type = $_FILES['movie_poster_image']['type'];
            $target_path = $_SERVER['DOCUMENT_ROOT'] . '/assets/images/movies/'. basename($poster_new_filename);         
            $p_sql = "UPDATE `movie_posters` SET movie_poster_name=:movie_poster_name, poster_img_url=:poster_img_url, poster_img_size=:poster_img_size WHERE id=:id";        
            $pData = ['movie_poster_name' => $poster_new_filename,'poster_img_url' => $get_path.'/assets/images/movies/'.$poster_new_filename,'poster_img_size' => $pfilesize,'id' => $RowId];
            $p_stmt = $link->prepare($p_sql);
            $p_stmt->execute($pData);
            move_uploaded_file($pfile_tmp, $target_path);
        }
        if(isset($_FILES['movie_cover_image'])) {
            $cfile_name = $_FILES['movie_cover_image']['name'];
            $temp_cfile_name = explode(".", $cfile_name); 
            $cover_new_filename = $movieId . '_cover' . '.'.end($temp_cfile_name);
            $cfile_size = $_FILES['movie_cover_image']['size'];            
            $cfilesize = round($cfile_size / 1024, 2)."kb";         
            $cfile_tmp = $_FILES['movie_cover_image']['tmp_name'];
            $cfile_type = $_FILES['movie_cover_image']['type'];
            $c_target_path = $_SERVER['DOCUMENT_ROOT'].'/assets/images/movies/'. basename($cover_new_filename);         
            $c_sql = "UPDATE `movie_posters` SET movie_cover_name=:movie_cover_name, cover_img_url=:cover_img_url, cover_img_size=:cover_img_size WHERE id=:id";        
            $cData = ['movie_cover_name' => $cover_new_filename,'cover_img_url' => $get_path.'/assets/images/movies/'.$cover_new_filename,'cover_img_size' => $cfilesize,'id' => $RowId];
            $c_stmt = $link->prepare($c_sql);
            $c_stmt->execute($cData);            
            if(move_uploaded_file($cfile_tmp, $c_target_path))
               $json_arr = ['type'=>'success', 'message'=>"success", 'code'=>'201'];
            
        }
    }

    if(isset($_REQUEST['delete_PosterImages'])) {
        $del_id = $_REQUEST['rowId'];
        $poster_img = $_REQUEST['posterImg'];
        $cover_img = $_REQUEST['coverImg'];
        $unlink_path = $_SERVER['DOCUMENT_ROOT'].'/assets/images/movies/';         
        if(isset($poster_img)) { unlink($unlink_path . "/" . $poster_img); }
        if(isset($cover_img)) { unlink($unlink_path . "/" . $cover_img); }

        $del_sql = 'DELETE FROM `movie_posters` WHERE id = :id';
        $user_st = $link->prepare($del_sql);
        $user_st->bindParam(':id', $del_id, PDO::PARAM_INT);
        $user_st->execute();
        $del_count = $user_st->rowCount();
        if($del_count > 0) {
            $json_arr = ['type'=>'response', 'status'=> 'success', 'message'=>'deleted', 'code'=>'201'];        
        } else {
            $json_arr = ['type'=>'response', 'status'=> 'error', 'message'=>'delete-error', 'code'=>'401'];            
        }
    }

    echo json_encode($json_arr);