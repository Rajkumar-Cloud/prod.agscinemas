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
                                <li>Run Time - <span><?php echo $movieRuning_hours = intdiv($movie_runTime, 60).'h '. ($movie_runTime % 60).'m'; ?></span></li>                                <li class="spacing"></li>
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
                            <span class="success far fa-check-circle"></span>                            
                            <h5>Your Ticket has been booked successfully</h5>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-4" name="viewTicket" data-toggle="modal" data-target="#mivieTicket_model"><i class="fas fa-receipt"></i> View Ticket</button>
                        </div>
                    </div>
                    
                </div>
            </div>
        </div>          
    </div>
</section>

<div class="modal fade animated mivieTicket_model" id="mivieTicket_model" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
          <img class="img-fluid" src="assets/images/logos/ags-logo.jpg" alt="logo" />
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="ticket-data-list">
                      <label class="form-label" style="display:inline"><i class="fas fa-film"></i> Movie Name:</label>
                      <p style="display:inline-block"><?php echo $movie_Name; ?></p>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-data-list">
                      <label class="form-label"><i class="fas fa-calendar-day"></i> Date</label>
                      <p><?php echo $movie_date; ?></p>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-data-list">
                      <label class="form-label"><i class="fas fa-clock"></i> Time</label>
                      <p><?php echo $movie_showtime; ?></p>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 pr-1">
                  <div class="ticket-data-list">
                        <img src="<?php echo $imageURL11; ?>" class="img-fluid" alt="movie poster" />
                  </div>
              </div>
              <div class="col-md-8 pl-0">
                  <div class="ticket-data-list">
                      <table class="table table-border">
                          <tbody>
                            <tr><td>Theatre Location: </td><td><?php echo $movie_location; ?></td></tr>
                            <tr><td>Ticket No: </td><td><?php echo $tiknum; ?></td></tr>
                            <tr><td>Screen: </td><td><?php echo $movie_screen; ?></td></tr>
                            <tr><td>Seat No: </td><td><?php echo $showmovie_seat; ?></td></tr>                          
                          </tbody>                         
                       </table>
                  </div>
              </div>              
          </div>
          <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="paymentreceiptaccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#paymentreceiptaccordion" href="#collapseOne"> View payment details <span class="fas fa-arrow-circle-down" style="float: right;"></span></a></h5>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in show">
                                <div class="panel-body">
                                    <ul>
                                        <li>Seat Cost: <span><i class="fas fa-rupee-sign"></i> <?php echo $totalamount; ?></span></li>
                                        <li>Food Cost: <span><i class="fas fa-rupee-sign"></i> <?php echo $foodvalue; ?></span></li>
                                        <li>Booking Cost: <span><i class="fas fa-rupee-sign"></i> <?php echo $conv_fees; ?></span></li>
                                        <li>Total Amount: <span><i class="fas fa-rupee-sign"></i> <?php echo $total_val; ?></span></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="col-md-5">
                  <div class="ticket-qrbarcode">
                        <div id="qrcodesss"></div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-qrbarmessage">
                        <p>Scan your QR Code <br />for more details</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
<script type="text/javascript" src="assets/js/qrcode.js"></script>
<script type="text/javascript">  
    var tiknum = "<?php  echo $tiknum ?>";  	
    var qrcode = new QRCode(document.getElementById('qrcodesss'),{width : 65,height : 65}); 
    qrcode.makeCode(tiknum);
    $("#mivieTicket_model").modal('show');
</script>