<?php
    // Merchant key here as provided by Payu
    $MERCHANT_KEY = "lzk5Ju";
    $hash_string = '';   
    $SALT = "8UXqyhGY";
    $txnid = "20001604481";
    $username = "Rajkumar";
    $email = "rajkumar.v@verandalearning.com";
    $mobile = "9750826613";
    $amount = 230;
    $productinfo = "AGS_Cinemas 9125 K8,K9";
    $surl = "http://localhost/agscinemas/seatresponse_success.php";
    $furl = "http://localhost/agscinemas/seatresponse_failure.php";
    // $action = "https://test.payu.in/_payment";

    // $action = "https://sandboxsecure.payu.in"; // for production mode
    $action = "https://secure.payu.in/_payment"; // for production mode
    
    // Hash Sequence
    $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    $hashString = $MERCHANT_KEY."|".$txnid."|".$amount."|".$productinfo."|".$username."|".$email;
    $hash = strtolower(hash('sha512', $hashString))
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>AGS Cinemas - Secure Payment</title>  
  <meta name="keywords" content="AGS Cinemas Secure payment for ticket booking">
  <meta name="description" content="AGS Cinemas Secure payment for ticket booking">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/x-icon" href="assets/images/logos/ags_favicon.png">
  <link rel="stylesheet" href="assets/plugins/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/plugins/animate/animate.min.css">  
  <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
  <link rel="stylesheet" href="assets/css/unpaid.css">
</head>
<body>
<?php if ( isset( $_GET['bid'] ) && !empty( $_GET['bid'] ) ) { ?>
<div class="container-fluid unpaid-wrapper">
    <div class="container">
        <div class="col-md-5 header-logo">
            <a href="index.php"><img class="img-fluid" title="AGS Cinemas Logo" src="assets/images/logos/ags_cinemas_logo.png" alt="ags logo" /></a>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class="container p-sm-0">
        <div class="row">
            <div class="col-md-8">                                
                <div class="unpaid-payment-panel">
                    <div class="panel-group" id="payment__accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading active" role="tab" id="contacthead_detail">
                                <h4 class="panel-title">
                                    <a role="button" data-toggle="collapse" data-parent="#payment__accordion" href="#userContact_head" aria-expanded="true" aria-controls="Contact Details"><i class="fa fa-address-book" aria-hidden="true"></i> Share your Contact Details</a>
                                </h4>
                            </div>
                            <div id="userContact_head" class="panel-collapse collapse show" role="tabpanel" aria-labelledby="contacthead_detail">
                                <div class="panel-body">                                    
                                    <form action="<?php echo $action; ?>" method="post" name="payuForm" enctype="multipart/form-data" class="clickcheck">
                                        <div class="row">                                            
                                            <div class="col-md-12 hints"><p>Note: Kindly share your correct details for booking confirmation.</p> </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Name <sup>*</sup></label>                                                    
                                                    <input type="text" class="form-control" id="username" name="username" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Enter your name" />
                                                    <span class="emptyErr-field" id="username_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Email <sup>*</sup></label>                                                    
                                                    <input type="email" class="form-control" id="emailId" name="emailId" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Enter your email" />
                                                    <span class="emptyErr-field" id="emailId_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">Mobile No <sup>*</sup></label>
                                                    <div class="input-group input-group-sm">
                                                        <div class="input-group-prepend">
                                                            <span class="input-group-text">+91</span>
                                                        </div>                                                    
                                                        <input type="text" class="form-control validateOnlynumbers" id="mobileNo" maxlength="10" name="mobileNo" aria-label="Small" aria-describedby="inputGroup-sizing-sm" placeholder="Enter your mobile no" />
                                                    </div>
                                                    <span class="emptyErr-field" id="mobileno_err"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-12 hidden_values">
                                                <input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
                                                <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
                                                <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />                        
                                                <input type="hidden" name="surl" value="<?php echo $surl ?>">
                                                <input type="hidden" name="furl" value="<?php echo $furl ?>">
                                                <input type="hidden" name="amount" value="<?php echo $amount ?>" />            
                                                <input type="hidden" name="firstname" id="firstname" value="<?php echo $username ?>" />
                                                <input type="hidden" name="email" id="email" value="<?php echo $email ?>" />
                                                <input type="hidden" name="phone" value="<?php echo $mobile ?>" />  
                                                <input type="hidden" name="productinfo" value="<?php echo $productinfo ?>" />
                                            </div>
                                            <div class="col-md-12"><hr />
                                                <div class="form-group btn-action-group">
                                                    <?php if($hash) { ?>                       
                                                    <button type="submit" class="btn btn-sm" id=""><i class="fa fa-angle-double-right" aria-hidden="true"></i> Make Payment</button>
                                                    <?php } ?>
                                                    <button type="reset" class="btn btn-sm" id="reset_values"><i class="fa fa-eraser" aria-hidden="true"></i> Clear</button>
                                                </div>
                                            </div>
                                        </div>   
                                        
                                    </form>
                                </div>
                                <div class="processLoader">
                                    <img class="img-fluid" src="assets/images/ajax-loader.gif" alt="loader" />
                                </div>
                            </div>
                        </div>                                               
                    </div>
                </div>
                <div class="payment-and-notes d-none d-sm-block">
                    <ul>    
                        <h5>Notes:</h5>
                        <li>Registrations/Tickets once booked cannot be exchanged, cancelled or refunded.</li>
                        <li>In case of Credit/Debit card bookings, the Credit/Debit Card and Card Holder must be present  at the ticket counter while collecting the ticket(s).</li>
                    </ul>
                    <p>
                        <i class="far fa-copyright"></i> 2022 <a href="https://www.agscinemas.com"> AGS Cinemas</a>. &nbsp;
                        <a href="privacy-policy.php">Privacy Policy</a> | <a href="contact-us.php">Contact Us</a>
                    </p>
                </div>
            </div>
            <div class="col-md-4 p-sm-l0">
                <div class="movie-card-wrapper">
                    <h3>Order Summary</h3><hr />
                    <ul>
                        <li>
                            <div class="movieData">
                                <h4 id="movieName">Etharkkum Thunindhavan (U/A)</h4>
                                <div class="countCount">1 <span>Ticket</span></div>
                                <h5 id="movieLang">Tamil, 2D</h5>
                                <h5 id="movieLocation">AGS Cinemas OMR: Navlur (SCREEN 4)</h5>
                                <span>DIAMOND - G4</span>
                                <span class="__date">Sat, 19 Mar, 2022</span>
                                <span class="__time">10:30 PM</span>
                            </div>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <div class="priceSummary">
                                <div class="subTotalDiv">Sub Total <h5>Rs.182</h5></div>
                                <div class="convenienceDiv">+ Convenience fees<h5>Rs.35</h5></div>
                                <div class="othersDiv">Base Amount<h5>Rs.30</h5></div>
                                <div class="othersDiv">Integrated GST (IGST) @ 18%<h5>Rs.5.40</h5></div>
                            </div>
                        </li>
                        <li class="totalSummary">
                            <div class="payebleTotalDiv">Amount Payable <h3 id="totalPayable">Rs.252</h5></div>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 d-block d-sm-none mt-3">
                <div class="payment-and-notes">
                    <ul>    
                        <h5>Notes:</h5>
                        <li>Registrations/Tickets once booked cannot be exchanged, cancelled or refunded.</li>
                        <li>In case of Credit/Debit card bookings, the Credit/Debit Card and Card Holder must be present  at the ticket counter while collecting the ticket(s).</li>
                    </ul>
                    <p>
                        <i class="far fa-copyright"></i> 2022 <a href="https://www.agscinemas.com"> AGS Cinemas</a>. &nbsp;
                        <a href="privacy-policy.php">Privacy Policy</a> | <a href="contact-us.php">Contact Us</a>
                    </p>
                </div>
            </div>
        </div>        
    </div>
</div>
<footer>
    <div class="container">
        <div class="col-md-12">
            <div class="connectwith-us">
                <p> <i class="far fa-copyright"></i> 2022 <a href="https://www.agscinemas.com" style="font-weight:500"> AGS Cinemas</a> | All Rights Reserved. </p>
            </div>
        </div>
    </div>
</footer>
</body>
</html>
<?php } else { ?>
<div class="invalid-overlay">
    <div class="modelOverlay">
        <div class="model-title">
            <h5>Oop's Error</h5>
        </div>
        <div class="model-body">
            <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="col-md-4">
                    <div class="agslogo">
                        <img class="img-fluid" src="assets/images/logos/ags-logo.jpg" alt="logo" />
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="agserror_desc">
                        <h4><span>Sorry!</span> Something is not right.</h4>
                        <p>Something went wrong while getting your booking details. Please try again after sometime.</p>
                        <a href="index.php" class="btn btn-md btn-danger">Home</a>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
</div>
<?php } ?>
<!-- Jquery Plugins -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/unpaid.js" type="text/javascript"></script>
<script type="text/javascript">
 $(document).ready(function() {     
    $('.panel-collapse').on('show.bs.collapse', function () {
        $(this).siblings('.panel-heading').addClass('active');
    });

    $('.panel-collapse').on('hide.bs.collapse', function () {
        $(this).siblings('.panel-heading').removeClass('active');
    });
});
</script>
