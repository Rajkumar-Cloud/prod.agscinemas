<?php
include("classes/helper.php");
session_start();
if(!isset($title)){ $title = "AGS Cinemas Dashboard -- Home"; }
if(!isset($description)){ $description = "AGS Cinemas Dashboard -- Home"; }
if(!isset($keywords)){ $keywords = "AGS Cinemas Dashboard"; }

if(!isset($_SESSION['username'])) {
    echo $_SESSION['username'];
    header('location:login.php');
}
$actual_path = page_pathInfo('pathInfo');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title><?= $title;?></title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="keywords" content="<?= $keywords;?>" />
    <meta name="description" content="<?= $description;?>" /> 
    <meta name="author" content="AGS Cinemas" />
    <link rel="icon" href="assets/images/ags_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/js/plugins/toaster/jquery.toast.css">
    <?php if($actual_path['filename'] == "index") { ?>
        <link rel="stylesheet" href="assets/css/plugins/bars-1to10.css">
    <?php } ?>
    <?php
    if($actual_path['filename'] == "ags-users" || $actual_path['filename'] == "cinema-transaction" || $actual_path['filename'] == "cinema-show-transaction" || 
    $actual_path['filename'] == "failure-transaction" || $actual_path['filename'] == "view-food-items" || $actual_path['filename'] == "user-ticket-history"
    || $actual_path['filename'] == "old-customer-mail-trigger" || $actual_path['filename'] == "index" || $actual_path['filename'] == "admin_register" || $actual_path['filename'] == "movie-resources" || $actual_path['filename'] == "summary" || $actual_path['filename'] == "refund" || $actual_path['filename'] == "schedule" || $actual_path['filename'] == "food-transaction" || $actual_path['filename'] == "failure-refund" || $actual_path['filename'] == "show-refund") { ?>
    <link rel="stylesheet" href="assets/js/plugins/dataTable/css/jquery.dataTables.min.css">    
    <link rel="stylesheet" href="assets/js/plugins/dataTable/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="assets/js/plugins/dataTable/css/dataTables.dateTime.min.css">
    <link rel="stylesheet" href="assets/css/jquery-ui.css">
    <link rel="stylesheet" href="assets/js/plugins/dataTable/css/fixedHeader.dataTables.min.css">
    <?php } ?>
</head>
<body>
	<!-- Pre-loader -->
	<div class="loader-bg">
		<div class="loader-track"> <div class="loader-fill"></div> </div>
	</div>

<?php include('sidebar-menu.php'); ?>

    	<!-- Header Main Bar -->
	<header class="navbar pcoded-header navbar-expand-lg navbar-light header-blue">			
        <div class="m-header">
            <a class="mobile-menu" id="mobile-collapse" href="javascript:void(0)"><span></span></a>
            <a href="index.php" class="b-brand">						
                <img src="assets/images/ags_cinemas_white.png" title="AGS Cinemas" alt="AGS Logo" class="logo" />
                <img src="assets/images/ags_cinemas_white.png" title="AGS Cinemas" alt="AGS Logo" class="logo-thumb" /> 
            </a>
            <a href="javascript:void(0)" class="mob-toggler">
                <i class="feather icon-more-vertical"></i>
            </a>
        </div>
        <div class="collapse navbar-collapse">
<!--
            <ul class="navbar-nav mr-auto">
                <li class="nav-item">
                    <a href="javascript:void(0)" class="pop-search"><i class="feather icon-search"></i></a>
                    <div class="search-bar">
                        <input type="text" class="form-control border-0 shadow-none" placeholder="Search hear">
                        <button type="button" class="close" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </li>
            </ul> -->
            <ul class="navbar-nav ml-auto">
                <!-- <li>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown"><i class="icon feather icon-bell"></i></a>
                        <div class="dropdown-menu dropdown-menu-right notification">
                            <div class="noti-head">
                                <h6 class="d-inline-block m-b-0">Notifications</h6>
                                <div class="float-right">
                                    <a href="javascript:void(0)" class="m-r-10">mark as read</a>
                                    <a href="javascript:void(0)">clear all</a>
                                </div>
                            </div>
                            <ul class="noti-body">
                                <li class="n-title">
                                    <p class="m-b-0">NEW</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="assets/images/user/user-icon.png" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>John Doe</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>5 min</span></p>
                                            <p>New ticket Added</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="n-title">
                                    <p class="m-b-0">EARLIER</p>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="assets/images/user/user-icon.png" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>10 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="assets/images/user/user-icon.png" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Sara Soudein</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>12 min</span></p>
                                            <p>currently login</p>
                                        </div>
                                    </div>
                                </li>
                                <li class="notification">
                                    <div class="media">
                                        <img class="img-radius" src="assets/images/user/user-icon.png" alt="Generic placeholder image">
                                        <div class="media-body">
                                            <p><strong>Joseph William</strong><span class="n-time text-muted"><i class="icon feather icon-clock m-r-10"></i>30 min</span></p>
                                            <p>Prchace New Theme and make payment</p>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                            <div class="noti-footer">
                                <a href="javascript:void(0)">show all</a>
                            </div>
                        </div>
                    </div>
                </li> -->
                <li>
                    <div class="dropdown drp-user">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="feather icon-user"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-notification">
                            <div class="pro-head">
                                <img src="assets/images/user/user-icon.png" class="img-radius" alt="User image" />
                                <span><?php echo $_SESSION['username']; ?></span>
                                <a href="logout.php" class="dud-logout" title="Logout">
                                    <i class="feather icon-log-out"></i>
                                </a>
                            </div>
                            <ul class="pro-body">
                                <li><a href="user-profile.php" class="dropdown-item"><i class="feather icon-user"></i> Profile</a></li>
                                <!-- <li><a href="email_inbox.php" class="dropdown-item"><i class="feather icon-mail"></i> My Messages</a></li> -->
                                <li><a href="logout.php" class="dropdown-item"><i class="feather icon-lock"></i> Lock Screen</a></li>
                            </ul>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
	</header>