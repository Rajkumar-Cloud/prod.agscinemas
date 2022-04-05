<?php
    include("config.php");    
    $table = 'movie_posters';
    $primaryKey = 'id';
    $columns = array(
        array( 'db' => 'id', 'dt' => 0,  'field' => 'id' ),
        array( 'db' => 'movieId',  'dt' => 1,  'field' => 'movieId' ),
        array( 'db' => 'movieName',  'dt' => 2,  'field' => 'movieName' ),
        array( 'db' => 'who_posted',  'dt' => 3,  'field' => 'who_posted' ),
        array( 'db' => 'poster_img_url',  'dt' => 4,  'field' => 'poster_img_url' ),        
        array( 'db' => 'cover_img_url',  'dt' => 5,  'field' => 'cover_img_url' ),        
        array( 'db' => 'trailer_url',  'dt' => 6,  'field' => 'trailer_url' ),
        array(
            'db'        => 'created_date',
            'dt'        => 7,
            'formatter' => function( $d, $row ) {
                return date( 'jS M y', strtotime($d));
            }
        ),   
        array( 'db' => 'movie_poster_name',  'dt' => 8,  'field' => 'movie_poster_name' ),
        array( 'db' => 'poster_img_size',  'dt' => 9,  'field' => 'poster_img_size' ),
        array( 'db' => 'movie_cover_name',  'dt' => 10,  'field' => 'movie_cover_name' ),
        array( 'db' => 'cover_img_size',  'dt' => 11,  'field' => 'cover_img_size' )        
    );
 
    require('ssp.class.php');
 
    echo json_encode(
        SSP::simple( $_GET, $link, $table, $primaryKey, $columns )
    );