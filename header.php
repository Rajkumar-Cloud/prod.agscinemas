<?php    
    global $SERVER_NAME;
    $SERVER_NAME = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";    
    $active_url = basename($_SERVER['REQUEST_URI'], '?' . $_SERVER['QUERY_STRING']);
    session_start();
    include ('imageconfig.php');
    // When Session MovieId is Empty, the page will navigate to Default Place
    if(/*$active_url == "movie-details.php" || */$active_url == "movies-time.php" || $active_url == "seat.php" || $active_url == "moviespaysuccess.php" || $active_url == "moviespayfailure.php") {
        if(!isset($_SESSION['movieId']) || (trim($_SESSION['movieId'])) == '') {
            header("location:movies.php");
            exit();
        }
    }
    if($active_url == "movie-details.php") {
        if(isset($_GET['temp'])){
            $_SESSION['movieId'] = $_GET['temp'];
        }
        if(!isset($_SESSION['movieId']) || (trim($_SESSION['movieId'])) == '') {
            header("location:movies.php");
            exit();
        }
    }    
    if($active_url == "user-profile.php" || $active_url == "booking-history.php") {
        if(!isset($_COOKIE['userid']) || (trim($_COOKIE['userid'])) == '') {
            header("location:index.php");
            exit();
        }
    }
    
    if (isset($_COOKIE['profilepic']) && ($_COOKIE['profilepic'] == ' ' || $_COOKIE['profilepic'] == null)) {
        $_COOKIE['profilepic'] = 'assets/images/icons/user-icon.png';
    }else
        $_COOKIE['profilepic'] = 'assets/Profile/'.$_COOKIE['profilepic'];
?>
<!DOCTYPE html>
<html lang="en">
<head>  
  <meta charset="utf-8">
  <title>AGS Cinemas - Chennai Movie show times, buy cinema tickets online</title>  
  <meta name="keywords" content="AGS Cinemas, chennai movies, chennai ags, ags, movies, movie show times, theatre, movie theater, movie theatres, movie theater, ags theatre, ags theater, ags cinemas, ags, ags entertainment, ags navalur, ags villivakkam, ags tnagar, tnagar cinemas, navalur cinemas, cinema dolby atmos, atmos, auro, auro 3d">
  <meta name="description" content="AGS Cinemas buy tickets online and see movies">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="assets/images/logos/ags_favicon.png">
  <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/animate/animate.min.css">  
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/plugins/sweetalert/sweetalert2.min.css">  
  <?php if( $active_url == 'seat.php' || $active_url == 'seat') { ?>
  <!-- Seat Booking CSS Styles -->
  <link rel="stylesheet" href="assets/plugins/seat-charts/seat-charts.css">
  <?php } ?>
  <link rel="stylesheet" href="assets/css/styles.css">  
  <?php if( $active_url == 'movies.php' || $active_url == 'movies' || $active_url == 'index.php' || $active_url == 'theatres.php' || $active_url == 'cinemas' || $_SERVER['REQUEST_URI'] == '/') { ?>
  <link rel="stylesheet" href="assets/plugins/slider/jssor.css"> 
  <?php } ?>
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500&display=swap" rel="stylesheet">
  <?php if($active_url == 'index.php' || $_SERVER['QUERY_STRING'] == '' || $_SERVER['REQUEST_URI'] == '/') { ?>
  <link rel="stylesheet" href="assets/plugins/OwlCarousel/owl.carousel.min.css" >
  <?php } ?>
  <?php if($active_url == 'bulk-booking.php' || $active_url == 'bulk-booking') { ?>
  <!-- Date Picker Control -->
  <link href="assets/plugins/datepicker/bootstrap-datepicker.min.css" rel="stylesheet"/>
  <?php } ?>
</head>
<body>
<!--<div class="Process_preload">
    <img class="img-fluid" src="assets/images/logos/ags_loader.gif" />
</div> -->
<div class="main__wrapper">
    <section class="header-wrapper">
        <div class="container">
            <div class="row">
                <div class="col-md-2 col-sm-2">
                    <div class="header-logo">
                       <a href="index.php" target="_self"><img class="img-fluid" src="assets/images/logos/ags_cinemas_logo.png" alt="logo" /></a>
                    </div>
                </div>
                <div class="col-md-6 col-sm-6">
                	<div class="header-search">
                        <form action="#" method="post" id="header_search_frm" name="header_search_frm">                       
                         <!--   <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-search"></i></span></div>
                                <input type="search" autocomplete="off" name="header_main_search" id="header_main_search" class="form-control" placeholder="Search for Movies, Events, Plays, Sports and Activities" />
                            </div>  -->
                        </form>
                    </div>
		</div>
                <div class="col-md-4 col-sm-4">
                    <div class="header-access-menu">
                        <button type="button" class="btn" id="header-location-btn"><i class="fas fa-map-marker-alt"></i> Chennai  
                         <!-- &nbsp;<i class="fas fa-caret-down"></i> -->
			</button>
                        <?php if(isset($_COOKIE['username']) && $_COOKIE['username'] != ""){ ?>
                        <!-- Example single danger button -->
                        <div class="btn-group userprofile_dropdown">
                            <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="img-fluid" src="<?php echo $_COOKIE['profilepic']; ?>" alt="user" />Hi, <?php echo $_COOKIE['username']; ?>  
                            </button>
                            <div class="dropdown-menu">
                                <a class="dropdown-item" href="user-profile.php"><i class="far fa-user"></i> User profile</a>
                               <!-- <a class="dropdown-item" href="preference.php"><i class="fas fa-sliders-h"></i> Preference</a>
                                <a class="dropdown-item" href="reset-password.php"><i class="fas fa-unlock"></i> Reset Password</a> -->
                                <a class="dropdown-item" href="booking-history.php"><i class="fas fa-ticket-alt"></i> Booking History</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="classes/logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                        <?php } else { ?>
                            <button type="button" class="btn btn-warning btn-sm" id="header-signin-popup" data-toggle="modal" data-target="#agsLoginRegister_panel"><i class="fas fa-sign-in-alt"></i> Login / Signup</button>
                        <?php } ?>
                        <!-- <button type="button" class="" id="header-siderbar-setting"><i class="fas fa-bars"></i></button> -->
                    </div>
                </div>
            </div>
        </div>
    </section>

    <nav class="navbar navbar-expand-lg navbar-dark ags-nav-bg">
      <div class="container">
          <!-- <a class="navbar-brand logo " href="#">AGS</a> -->
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
          </button> 
          <div class="collapse navbar-collapse" id="navbarSupportedContent">
              <div class="row w-100">
                  <div class="col-md-7">
                      <ul class="navbar-nav mr-auto">
                          <li class="nav-item active">
                              <a class="nav-link" href="index.php"> <i class="fas fa-home"></i> Home <span class="sr-only">(current)</span></a>
                          </li>
                          <li class="nav-item">
                              <a class="nav-link" href="movies.php"><i class="fas fa-video"></i> Movies</a>
                          </li>
                          <li class="nav-item">                          
                              <a class="nav-link" href="theatres.php"><i class="fas fa-theater-masks"></i> Cinemas</a>
                          </li>                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                                       
                          <li class="nav-item">
                              <a class="nav-link" href="show-times.php"><i class="fas fa-clock"></i> Show Times</a>
                          </li>
                          <!-- <li class="nav-item">
                              <a class="nav-link" href="#"><i class="far fa-id-card"></i> Ticket Booking</a>
                          </li> -->
                      </ul>
                  </div>
                  <div class="col-md-5 text-center">
                      <ul class="navbar-nav right-nav-menu">
                          <li class="nav-item">
                              <a class="nav-link btn btn-sm btn-quicktickets" href="bulk-booking.php"><i class="fas fa-ticket-alt"></i> Bulk Booking</a>
                          </li>
                          <!-- <li class="nav-item dropdown">
                              <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false"><i class="fas fa-money-bill-wave"></i> Offers</a>
                              <div class="dropdown-menu">
                                  <a class="dropdown-item" href="/"><i class="fas fa-gifts"></i> Gift Vouchers</a>
                              </div>
                          </li> -->
                      </ul>
                  </div>
              </div>
          </div>
      </div>
    </nav>
</div>
