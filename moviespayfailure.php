<?php 
    include ("header.php");
    $movieId = $_SESSION['movieId'];
    $movie_Name = $_SESSION['movie_Name'];
    $movie_Language = $_SESSION['movie_Language'];
    $movie_Censor = $_SESSION['movie_Censor'];
    $movie_Genre = $_SESSION['movie_Genre'];
    $movie_runTime = $_SESSION['movie_runTime'];
    $movie_location = $_SESSION['movie_location'];
    $movie_showtime = $_SESSION['movie_showtime'];
    $movie_date = $_SESSION['movie_date'];
    $movie_screen = $_SESSION['movie_screen'];
    $myArray0 = $_SESSION['showmovie_seat'];
    $showmovie_seat = "";
    $n = 0;
    foreach($myArray0 as $my_Array0) {
        if($n == 0) {
            $showmovie_seat .= $my_Array0; 
            $n = 1;
        } else {
            $showmovie_seat .= ",".$my_Array0;  
        }      
    }

    $myArray = $_SESSION['movie_seat'];
    $movie_seat = "";
    $m = 0;
    foreach($myArray as $my_Array) {
        if($m == 0) {
            $movie_seat .= $my_Array; 
            $m=1;
        } else {
            $movie_seat .= ",".$my_Array;  
        }      
    }
    $totalamount = $_SESSION['totalamount'];
    $foodvalue = $_SESSION['foodvalue'];
    $food_id = $_SESSION['food_id'];
    $count_number = $_SESSION['count_num'];
    $conv_fees = $_SESSION['conv_fees'];
    $total_val=$totalamount+$foodvalue+$conv_fees;
    // $total_val = 1;
    $profilepic = $_COOKIE['profilepic'];
    if($profilepic =='') {
        $profilepic = "dummyimg.png";  
    } else {
        $profilepic = $_COOKIE['profilepic'];
    }
    $tiknum = $_SESSION['randticket'];
    $imageURL11 = "assets/images/movies/".$movieId."_cover.jpg";
?>

<section class="payment-wrapper default-bg">
    <div class="container">        
        <div class="row row-pay-bg">
            <div class="col-md-12">
                <div class="title-head"><h4><i class="fas fa-ticket-alt"></i> Payment Acknowledgement</h4> </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-ticket-alt"></i></li>
                                <li data-toggle="tooltip" title="<?php echo $movie_Name; ?>"><?php echo $movie_Name; ?></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-drum-steelpan"></i></li>
                                <li><?php echo $movie_Genre ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-clock"></i></li>
                                <li>Run Time - <span><?php echo $movieRuning_hours = intdiv($movie_runTime, 60).'h '. ($movie_runTime % 60).'m'; ?></span></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-star-half-alt"></i></li>
                                <li>Rating - <span><?php echo $movie_Censor; ?></span></li>
                                <li class="spacing"></li><li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>                               
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-compact-disc"></i></li>
                                <li class="block-flex"><p>Theatre</p> <span><?php echo $movie_location; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="fas fa-calendar-day"></i></li>
                                <li class="block-flex"><p>Date</p> <span><?php echo $movie_date; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="far fa-clock"></i></li>
                                <li class="block-flex"><p>Time</p> <span style="text-transform: uppercase;"><?php echo $movie_showtime; ?></span> </li>                              
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-film"></i></li>
                                <li class="block-flex"><p>Screen</p> <span><?php echo $movie_screen; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="fas fa-couch"></i></li>
                                <li class="block-flex"><p>Seat</p> <span><?php echo $showmovie_seat; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="far fa-money-bill-alt"></i></li>
                                <li class="block-flex"><p>Ticket Cost</p> <span>Rs. <?php echo $totalamount; ?></span> </li>
                                <li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-9">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-hamburger"></i></li>
                                <li class="block-flex otherlist">Food and Beverages</li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="movie-data-list">                            
                            <ul>                                 
                                <li class="data-icon icon-flex"><i class="fas fa-rupee-sign"></i></li>
                                <li class="block-flex"><p>Food Cost</p> <span>Rs.  <?php echo $foodvalue; ?></span> </li>
                                <li class="spacing"></li><li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-9">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-wallet"></i></li>
                                <li class="block-flex otherlist">Payment</li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="movie-data-list">                            
                            <ul>                                 
                                <li class="data-icon icon-flex"><i class="fas fa-rupee-sign"></i></li>
                                <li class="block-flex"><p>Total Cost</p> <span>Rs. <?php echo $total_val; ?></span> </li>
                                <li class="spacing"></li><li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-12">
                        <div class="booked-ticked-message">
                            <span class="failure far fa-times-circle"></span>
                            <h5>Sorry, <?php echo $_COOKIE['username']; ?>. Your booking status is <?php echo $_SESSION['pay_status']; ?>. </h5>                            
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>          
    </div>
</section>

<?php include('footer.php'); ?>
