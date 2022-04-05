<?php 
    $movieimg="assets/Movie";
    $soundimg="assets/Sound";
    $profileimg="assets/Profile";
    $foodimg="assets/Food";
    $cinemaimg = "assets/Movie";
    if (!isset($_COOKIE['profilepic']))
        setcookie("profilepic", " ", time() + (86400 * 30), "/");
?>