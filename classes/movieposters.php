<?php

function movieimage($moviecode) { 
  
  include "config.php";
  $moviePost = $link->query("SELECT * FROM movie_posters WHERE movieId='$moviecode' AND status= 1 ORDER BY id DESC");
  $MPDetails = $moviePost->fetch();

  try {
    if($MPDetails['movie_cover_name'])
      $cover = $MPDetails['movie_cover_name'];
    else
      $cover = $moviecode."_cover.jpg";

    if($MPDetails['movie_poster_name'])
      $poster = $MPDetails['movie_poster_name'];
    else
      $poster = $moviecode."_poster.png";

    $trailerURL = isset($MPDetails['trailer_url']) ? $MPDetails['trailer_url'] : '' ;
  } catch(Exception $e) {
    return false;
  }  
  return $poster."||".$cover."||".$trailerURL;
}

?>