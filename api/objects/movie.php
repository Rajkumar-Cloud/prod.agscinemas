<?php
    // ini_set('display_errors', 1);
    // ini_set('display_startup_errors', 1);
    // error_reporting(E_ALL);
    error_reporting(0);
/*
    Author:- AGS Cinemas
    Date:- 08-12-2021
    Purpose:- Movie Class to manage actions: cover, poster and trailer link with movie details.
*/

class Movie{
 
    // database connection and table name
    private $conn;
    private $table_name = "movie_posters";
 
    // constructor with $db as database connection
    public function __construct($db){
        $this->conn = $db;
    }

    // Get Movie Poster
    function moviePoster(){
        $link = $this->conn;
        $data = [];       
        $stmt=$link->query("SELECT id, movieId, movieName, poster_img_url, cover_img_url, trailer_url, status  FROM `movie_posters` WHERE status = 1 ORDER BY `id` DESC");
        $res = $stmt->fetchAll();
        if(count($res) > 0) { 
            foreach ($res as $key => $val) {
                $obj = array(
                    'movieId' => $val['movieId'],
                    'movieName' => $val['movieName'],
                    'poster_img_url' => $val['poster_img_url'],
                    'cover_img_url' => $val['cover_img_url'],
                    'trailer_url' => $val['trailer_url'],
                    'status' => $val['status']
                );         
                $data[$key] = $obj;
            }

            $home_carousal = [
		'slider1' => 'https://www.agscinemas.com/assets/images/ags-home1.jpg',
		'slider2' => 'https://www.agscinemas.com/assets/images/Home Page Regular combo_1600 x 560.png',
		'slider3' => 'https://www.agscinemas.com/assets/images/Home Page large combo_1600 x 560.png',
		'slider4' => 'https://www.agscinemas.com/assets/images/banner-food.jpg',
		'slider5' => 'https://www.agscinemas.com/assets/images/banner-staff-vacin.jpg'
	    ];
	    $theatre_carousal = [
		'slider1' => 'https://www.agscinemas.com/assets/images/loc_alapakkam_new3.jpg',
		'slider2' => 'https://www.agscinemas.com/assets/images/loc_navalur.png',
		'slider3' => 'https://www.agscinemas.com/assets/images/loc_villivakkam.png',
		'slider4' => 'https://www.agscinemas.com/assets/images/loc_tng.png'
	    ];
            $stmt = ['status'=>'success', 'data'=>$data, 'home_slider'=>$home_carousal,'theatre_slider'=>$theatre_carousal, 'code'=>200];
        } else {
            $stmt = ['status'=>'error', 'data'=>$data];
        }       
        return $stmt;
    }
}