<?php 
    include ("header.php");
    error_reporting(0);
    // echo $_SESSION["movie_Name"];
    if (!isset($_SESSION["movie_Name"]) && $_SESSION["movie_Name"] == ''){
        header("Location:movies.php");
    }
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
    $Cin_Id = $_SESSION['Cin_Id'];
    $catcode = $_SESSION['catcode'];
    $myArray0 = $_SESSION['showmovie_seat'];
    $showmovie_seat = "";
    $n = 0;
    foreach($myArray0 as $my_Array0) {
        if($n == 0) {
            $showmovie_seat .= $my_Array0; 
            $n=1;
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
    $dynam_intervalval = $_SESSION['dynam_foodval'];
    $time_lefts = $_SESSION['timelefts'];
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
    // Merchant key here as provided by Payu
    $MERCHANT_KEY = "lzk5Ju";
    $hash_string = '';   
    $SALT = "8UXqyhGY";
    $PAYU_BASE_URL = "https://secure.payu.in";
    $action = '';
    $posted = array();
    if(!empty($_POST)) {
        foreach($_POST as $key => $value) {    
            if($key == "amount") {
                $posted["amount"] = $total_val; 
            } else {
                $posted[$key] = $value; 
            }        
        }
    }

    $formError = 0;
    $storearray = array();
    $storeobj['userid'] = $_COOKIE['userid'];
    $storeobj['movie_showid'] = $_SESSION['movie_showid'];
    $storeobj['food_id'] = $food_id;
    $storeobj['count_num'] = $count_number;
    $storeobj['showmovie_seatsss'] = $_SESSION['showmovie_seat'];
    $storeobj['dynam_foodval'] = $dynam_intervalval;
    $storeobj['movie_seatsss'] = $_SESSION['showmovie_seat'];
    $storeobj['sess_seatrowid'] = '';
    $storeobj['seat_cat_type_id'] = $_SESSION['seat_cat_type_id'];
    $storeobj['movie_amt'] = $totalamount;
    $storeobj['foodvalue'] = $foodvalue;
    $storeobj['conv_fees'] = $conv_fees;
    $storeobj['three_d_charge'] = '0';
    $storeobj['transac_id'] = $_SESSION['transac_id']; 
    $storeobj['Cin_Id'] = $_SESSION['Cin_Id']; 
    $storeobj['movieId'] = $_SESSION['movieId'];
    $storeobj['movie_Name'] = $_SESSION['movie_Name'];
    $storeobj['movie_Language'] = $_SESSION['movie_Language'];
    $storeobj['movie_Censor'] = $_SESSION['movie_Censor'];
    $storeobj['movie_Genre'] = $_SESSION['movie_Genre'];
    $storeobj['movie_runTime'] = $_SESSION['movie_runTime'];
    $storeobj['movie_location'] = $_SESSION['movie_location'];
    $storeobj['movie_showtime'] = $_SESSION['movie_showtime'];
    $storeobj['movie_date'] = $_SESSION['movie_date'];
    $storeobj['movie_screen'] = $_SESSION['movie_screen']; 
    $storeobj['catcode'] = $catcode; 
    $storeobj['covid_confirm'] = $_SESSION['covidConfirm'];
    $txnid = $_SESSION['transac_id'];
    array_push($storearray,$storeobj);
    $jsondata = json_encode($storearray);
    $cudatetime = date("Y_m_d_H_i_s");
    $filename = $txnid.".json";   
    chmod($filename, 0777);
    unlink($filename);
    $fh = fopen($filename, "w");
    fwrite($fh, $jsondata);
    fclose($fh);
    if(empty($posted['productinfo'])) {
    // Generate random transaction id         
        $productinfo = "AGS_Cinemas ".$_SESSION['movie_showid']." ". $showmovie_seat;
    } else {
      $productinfo = $posted['productinfo'];
    }
    $hash = '';
    // Hash Sequence
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    if(empty($posted['hash']) && sizeof($posted) > 0) {
        if( empty($posted['key']) || empty($posted['txnid']) || empty($posted['amount']) || empty($posted['firstname']) || empty($posted['email']) || empty($posted['phone']) || empty($posted['productinfo'])) {
            $formError = 1;
        } else {        
            $hashVarsSeq = explode('|', $hashSequence);
            foreach($hashVarsSeq as $hash_var) {
                $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                $hash_string .= '|';
            }
            $hash_string .= $SALT;
            $hash = strtolower(hash('sha512', $hash_string));
            $action = $PAYU_BASE_URL . '/_payment';
        }
    } elseif(!empty($posted['hash'])) {
        $hash = $posted['hash'];
        $action = $PAYU_BASE_URL . '/_payment';
    }

?>

<section class="payment-wrapper default-bg">
    <div class="container">        
        <div class="row row-pay-bg">
            <div class="col-md-12">
                <div class="title-head"><h4><i class="fas fa-ticket-alt"></i> Booking Details</h4> </div>
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
                                <li><?php echo $movie_Language ?> - <?php echo $movie_Genre ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-clock"></i></li>
                                <li>Run Time - <span><?php echo $hours = intdiv($movie_runTime, 60).'h '. ($movie_runTime % 60).'m'; ?></span></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-star-half-alt"></i></li>
                                <li>Rating - <span><?php echo $movie_Censor; ?></span></li>
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
                                <li class="block-flex"><p>Food Price</p> <span>Rs. <?php echo $foodvalue; ?></span> </li>
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
                                <li class="block-flex"><p>Total Price</p> <span>Rs. <?php echo $total_val; ?></span> </li>
                                <li class="spacing"></li><li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-12">
                        <div class="panel-group" id="paymentaccordion">
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#paymentaccordion" href="#collapseOne"> View payment details <span class="fas fa-arrow-circle-down" style="float: right;"></span></a></h5>
                                </div>
                                <div id="collapseOne" class="panel-collapse collapse in show">
                                    <div class="panel-body">
                                        <table class="table table-border table-hover mt-3">
                                            <thead>
                                                <tr>
                                                    <th>Description</th>
                                                    <th>Amount <i class="fas fa-rupee-sign"></i></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>Ticket Price</td>
                                                    <td>Rs.<span><?php echo $totalamount ?></span></td>                                                
                                                </tr>
                                                <tr>
                                                    <td>Food Price</td>
                                                    <td>Rs.<span><?php echo $foodvalue; ?></span></td>                                                
                                                </tr>
                                                <tr>
                                                    <td>Conv.Fees(Incl.taxes)</td>
                                                    <td>Rs.<span><?php echo $conv_fees; ?></span></td>                                                
                                                </tr>
                                                <tr>
                                                    <td>Total Price</td>
                                                    <td>Rs. <span><?php echo $total_val; ?></span></td>                                                
                                                </tr>                                           
                                            </tbody>
                                        </table>    
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12 mt-3 text-center">
                        <form action="<?php echo $action; ?>" method="post" name="payuForm" enctype="multipart/form-data" class="clickcheck">        
                            <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />                        
                            <input type="hidden" name="surl" value="https://www.agscinemas.com/seatresponse_success.php" >   <!--Please change this parameter value with your success page absolute url like http://mywebsite.com/response.php. -->
                            <input type="hidden" name="furl" value="https://www.agscinemas.com/seatresponse_failure.php" ><!--Please change this parameter value with your failure page absolute url like http://mywebsite.com/response.php. -->
                            <input type="hidden" name="amount" value="<?php echo $total_val ?>" />            
                            <input type="hidden" name="firstname" id="firstname" value="<?php  echo $_COOKIE['username']; ?>" />            
                            <input type="hidden" name="email" id="email" value="<?php  echo $_COOKIE['email']; ?>" />            
                            <input type="hidden" name="phone" value="<?php  echo $_COOKIE['mobile']; ?>" />             
                            <input type="hidden" name="productinfo" value="<?php echo $productinfo; ?>" />    
                            <?php if(!$hash) { ?>                       
                            <button type="submit" class="btn btn-outline-danger btn-sm proceed" id="paynow_btn"><i class="fas fa-shopping-cart"></i> Paynow</button>
                            <?php } ?>
                        </form>                        
                    </div>
                </div>
            </div>
        </div>          
    </div>
</section>

<?php include('footer.php'); ?>
<script type="text/javascript">  
    var hash = '<?php echo $hash ?>'; 
    var p17 = "<?php  echo $_COOKIE['userid']; ?>"; 
    /* var thre_d_val = "<?php  echo $three_d_charge ?>";//using 3D
    var fooddiscountvalue = "<?php echo $fooddiscountvalue ?>";//new*/
    $(function () {        
        submitPayuForm();
    });
    function submitPayuForm() {
        if(hash == '') { return; }
        var payuForm = document.forms.payuForm;
        payuForm.submit(); 
    }
    $(document).ready(function() {
        if(p17=='') {
            var showid="<?php echo $_SESSION['movie_showid']; ?>";
            var movie_seat="<?php echo $movie_seat ?>";
            var datas={'seat':movie_seat,'showid':showid} 
            $.ajax({
                type: "POST",
                url: "classes/php/session_clear.php",
                data: datas
            }).done(function(data) {
                window.location.href = 'movies.php';
            });
        } 
    });

    /*var seat="<?php echo $movie_seat ?>";
    var show_seatss="<?php echo $showmovie_seat ?>";
    var amount="<?php echo $totalamount ?>";
    var food_amt=<?php echo $foodvalue ?>;
    var dynaminterval_val="<?php echo $dynam_intervalval?>"; 
    var totalvalue="<?php echo $total_val ?>"; 
    var totalvalue11="<?php echo $conv_fees?>";*/


</script>