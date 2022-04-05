<?php
// include database and object files
include_once '../config/database.php';
include_once '../objects/movie.php';
 

// get database connection
$database = new Database();
$db = $database->getConnection();
 
// prepare movie object
$movie = new Movie($db);

// read the details of movie poster
$stmt = $movie->moviePoster();
// make it json format
echo(json_encode($stmt));
?>