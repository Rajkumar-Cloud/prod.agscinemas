<footer class="footer">
    <div class="container">        
        <div class="row">                
            <div class="col-md-3 col">
                <div class="footer-contact">
                    <a href="index.php"><img class="img-fluid" src="assets/images/logos/ags.png" alt="logo" /></a>
                    <h4>CONTACT ASSISTANCE</h4>
                    <p><i class="far fa-paper-plane"></i> Email : <a href="mailto:wecare@agscinemas.com">wecare@agscinemas.com</a></p>
                    <p><i class="fab fa-whatsapp"></i> WhatsApp : <a href="https://wa.me/8754542222/?text=Hi" target="_blank">+91-8754542222</a></p>
                    <p><i class="fas fa-mobile-alt"></i> Call : <a href="tel:044-40167777">044-40167777</a></p>
                </div>
            </div> 
             
            <div class="col-md-3 col">
                <div class="footer-nav">
                    <ul>
                        <h5>General Links</h5>	
                        <li><a href="about-us.php"><i class="fas fa-angle-double-right"></i>About Us</a></li>	
                        <li><a href="contact-us.php"><i class="fas fa-angle-double-right"></i>Contact Us</a></li>	
                        <li><a href="faq.php"><i class="fas fa-angle-double-right"></i>Faq's</a></li>
                        <!-- <li><a href="#"><i class="fas fa-angle-double-right"></i>Sitemap</a></li>
                        <li><a href="#"><i class="fas fa-angle-double-right"></i>Career</a></li>
                        <li><a href="#"><i class="fas fa-angle-double-right"></i>Events</a></li> -->
                    </ul>
                </div>
            </div>
            <!--
            <div class="col-md-2">
                <div class="footer-nav">
                    <ul>
                        <h5>Our Brands</h5>
                        <li><a href="#" target="_self"><i class="fas fa-angle-double-right"></i>AGS Pictures</a></li>
                        <li><a href="#" target="_self"><i class="fas fa-angle-double-right"></i>AGS IMAX</a></li>
                        <li><a href="#" target="_self"><i class="fas fa-angle-double-right"></i>AGS 4DX</a></li>
                        <li><a href="#" target="_self"><i class="fas fa-angle-double-right"></i>AGS GOLD</a></li>
                    </ul>
                </div>
            </div>
            -->
            <div class="col-md-3">
                <div class="footer-nav">
                    <ul>
                        <h5>Legal</h5>	
                        <li><a href="privacy-policy.php"><i class="fas fa-angle-double-right"></i>Privacy Policy</a></li>                            	
                        <li><a href="terms-and-condition.php"><i class="fas fa-angle-double-right"></i>Terms and conditions</a></li>
                    </ul>
                </div>
            </div>
            <div class="col-md-3">
                <div class="footer-nav">
                    <ul>
                        <h5>AGS CINEMAS</h5>
                      <!--  <li><a href="theatres.php" target="_self"><i class="fas fa-angle-double-right"></i>Cinemas</a></li>
                        <li><a href="movies.php" target="_self"><i class="fas fa-angle-double-right"></i>Movies</a></li>
                        <li><a href="show-times.php" target="_self"><i class="fas fa-angle-double-right"></i>Show Timing</a></li> -->
                        <li><a href="bulk-booking.php" target="_self"><i class="fas fa-angle-double-right"></i>Bulk Ticket Booking</a></li>
			<h5 class="feedback">Feedback and Queries</h5>
                        <a href="mailto:wecare@agscinemas.com"><i class="far fa-edit"></i> wecare@agscinemas.com</a>
                    </ul>
                </div>
            </div>
            <div class="col-md-0"></div>
        </div>
        <div class="row"> 
            <div class="col-md-12">
                <div class="connectwith-us">
                    <hr />
                    <div class="clearfix"></div>
                    <h4>Connect with us</h4>
                    <ul>
                        <li><a href="https://www.instagram.com/AGSCinemas" target="_blank" class="fab fa-instagram" title="Instagram"></a></li>
                        <li><a href="https://twitter.com/agscinemas" target="_blank" class="fab fa-twitter" title="Twitter"></a></li>
                        <li><a href="https://www.facebook.com/agscinemas" target="_blank" class="fab fa-facebook-f" title="Facebook"></a></li>                        
                    </ul>
                    <p> <i class="far fa-copyright"></i> <?php echo date("Y");?> <a href="<?php echo $SERVER_NAME; ?>" style="font-weight:500"> AGS Cinemas</a> | All Rights Reserved. </p>
                </div>                         
            </div>
        </div>        
    </div>    
</footer>
<a id="back2Top"><i class="fas fa-angle-up"></i></a>
</body>
</html>
<!-- Login / Register trigger Model Window -->
<div class="modal fade animated agsLoginRegister_panel" id="agsLoginRegister_panel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">        
        <h5 class="modal-title">Get Started With AGS</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times-circle"></i></button>
      </div>
      <div class="modal-body">
          <div class="tab loginRegisterTabs" role="tabpanel">
            <ul class="nav nav-tabs card-header-tabs" role="tablist">
                <li role="presentation">
                    <a data-toggle="tab" class="active" href="#ags_login" role="tab" aria-controls="login" aria-selected="true"><i class="fas fa-key"></i> Login</a>
                </li>
                <li role="presentation">
                    <a data-toggle="tab" href="#ags_register" role="tab" aria-controls="register" aria-selected="false"><i class="fas fa-user"></i> Register</a>
                </li>
            </ul>
            <div class="tab-content tabs">
                <div class="tab-pane fade show active" id="ags_login" role="tabpanel" aria-labelledby="login">                    
                    <form method="POST" id="loginSignin_form" name="loginSignin_form">
                        <input type="hidden" name="seat_proceed_login" id="seat_proceed_login" value="" />
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                <input type="text" name="userEmailid" id="userEmailid" class="form-control" autocomplete="on" placeholder="Enter your email address.." />
                            </div>
                            <span class="error-message" id="error_useremail"></span>
                        </div>
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                <input type="password" name="userPassword" id="userPassword" autocomplete="on" class="form-control" placeholder="Enter your password.." />
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-eye togglePassword" onclick="togglePassword();"></i></span></div>
                            </div>                            
                            <span class="error-message" id="error_userpassword"></span>
                        </div>                    
                        <div class="form-group rememberuser text-left"> 
                            <span class="text-left"><input type="checkbox" name="remember-login" id="rememberLogin"  /> Remember me</span>
                        </div>
                        <div class="processLoader"><img class="img-fluid" src="assets/images/ajax-loader.gif" alt="loader" /></div>
                        <div class="form-group">
                            <button type="button" class="mr-2 btn-sm btn btn-outline-primary" name="userlogin" id="userLogin" onclick="setLoginOnSubmit();"><i class="fas fa-key"></i> Login</button>
                            <button type="reset" class="btn-sm btn btn-outline-danger" name="userreset"><i class="fas fa-eraser"></i> Reset</button>
                        </div>
                    </form>
                    <div class="forgot__password_section">
                        <a href="resetlink.php" target="_self"><i class="fas fa-lock-open"></i> Forgot Password</a>
                    </div>
                    <!--<p class="text-center">OR</p>-->
                    <!--<ul class="main-login-option">-->
                    <!--    <li><a href="#" target="_self"><img class="img-fluid" src="assets/images/icons/social/googlelogo.svg" alt="Google" />Continue with Google</a></li>-->
                    <!--    <li><a href="#" target="_self"><img class="img-fluid" src="assets/images/icons/social/facebook.svg" alt="Facebook" />Continue with Facebook</a></li>       -->
                    <!--</ul>                -->
                </div>
                <div class="tab-pane fade" id="ags_register" role="tabpanel" aria-labelledby="register">
                    <form method="POST" action="" id="userSignup_form" name="userSignup_form">
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-user"></i></span></div>
                                <input type="text" name="username" id="username" autocomplete="on" class="form-control" placeholder="Enter your name.." />
                            </div>
                            <span class="error-message" id="error_name"></span>
                        </div>
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-envelope"></i></span></div>
                                <input type="text" name="userEmailaddress" id="userEmailaddress" class="form-control" placeholder="Enter your email address.." />
                            </div>
                            <span class="error-message" id="error_email"></span>
                        </div>
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                <input type="password" name="usersignupPassword" autocomplete="on" id="usersignupPassword" class="form-control" placeholder="Enter your password.." />
                                <div class="input-group-append"><span class="input-group-text"><i class="fas fa-eye toggleregPassword" onclick="toggleRegPassword();"></i></span></div>
                            </div>
                            <span class="error-message" id="error_signuppassword"></span>
                        </div>
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><i class="fas fa-key"></i></span></div>
                                <input type="password" name="usercPassword" autocomplete="on" id="usercPassword" class="form-control" placeholder="Enter confirm password.." />
                            </div>
                            <span class="error-message" id="error_cpassword"></span>
                        </div>
                        <div class="form-group"> 
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text"><img class="img-fluid" src="assets/images/icons/india-flag.png" alt="india-flag" />&nbsp;+91</span></div>
                                <input type="text" name="loginMobile_no" id="loginMobile_no" maxlength="10" pattern="[0-9]*" class="form-control validateOnlynumbers" placeholder="Enter mobile number" />
                            </div>
                            <span class="error-message" id="error_mobileno"></span>
                        </div>
                        <div class="processLoader"><img class="img-fluid" src="assets/images/ajax-loader.gif" alt="loader" /></div>
                        <div class="form-group">
                            <button type="button" class="mr-2 btn btn-sm btn-outline-primary" name="userRegister" id="userRegister" onclick="setregisterOnSubmit();"><i class="fas fa-user"></i> Register</button>
                            <button type="reset" class="btn btn-sm btn-outline-danger" name="reset"><i class="fas fa-eraser"></i> Reset</button>
                        </div>
                    </form>
                </div>         
            </div>
          </div>
      </div>
      <div class="modal-footer">
        <p>I agree to the <a href="terms-and-condition.php" target="_self">Terms & Conditions</a> & <a href="privacy-policy.php" target="_self">Privacy Policy</a>.</p>
      </div>
    </div>
  </div>
</div>

<div class="modal fade animated" id="agsOTPlogin_panel" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <img src="assets/images/logos/agscienmas.png" class="img-fluid" alt="logo" />
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body">
                <h4>Validate OTP</h4>                
                <form class="agsOtpconfirm_form" id="agsOtpconfirm_form" name="agsOtpconfirm_form" method="$_POST">
                    <div class="alert"> <i class="fas fa-check-circle"></i> One Time Password(OTP) has been sent to your registred mobile no. <strong id="otpMobileno"></strong> </div>
                    <input type="hidden" id="otpMobile" name="otpMobile" value="" />
                    <input type="hidden" name="seat_proceed_register" id="seat_proceed_register" value="" /> 
                    <div class="countdown otp_press">                   
                        <input class="form-control otp_boxes validateOnlynumbers" autocomplete="off" id="otp1" maxlength="1" type="text" /> 
                        <input class="form-control otp_boxes validateOnlynumbers" autocomplete="off" id="otp2" maxlength="1" type="text" />
                        <input class="form-control otp_boxes validateOnlynumbers" autocomplete="off" id="otp3" maxlength="1" type="text" />
                        <input class="form-control otp_boxes validateOnlynumbers" autocomplete="off" id="otp4" maxlength="1" type="text" />
                    </div>
                    <div class="otherOtp_option">
                        <p class="timing"><i class="fas fa-history"></i> Time Left <span id="resendTime">1:00</span></p>
                        <p class="resentotp hide" id="resendOtp" onclick="resendOtp()"><i class="far fa-share-square"></i> Resend OTP</p>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary" type="button" onclick="verifyOTP()"><i class="fas fa-unlock-alt"></i> Verify OTP</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <p> <i class="far fa-copyright"></i> <?php echo date("Y");?> <a href="<?php echo $SERVER_NAME; ?>"> AGS Cinemas</a> | All Rights Reserved. </p>
            </div>
        </div>
    </div>
</div>

<!-- Home Search Panel -->
<div class="modal fade animated" id="agsMainsearch_model" tabindex="-1" data-keyboard="false" data-backdrop="static" role="dialog" aria-labelledby="helpModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">        
        <div class="modal-header">            
            <button type="button" class="close" data-dismiss="modal"><i class="fas fa-times" aria-hidden="true"></i></button>            
            <div class="main__search">
                <form class="search__form">
                    <div class="form-group">
                        <input type="text" autocomplete="off" list="search_movies" class="form-control"  id="home_search_movies" placeholder="Search movies and events your last activities" />
                        <datalist id="search_movies">
                                                    
                        </datalist>
                    </div>
                </form>
            </div>
        </div>
        <div class="modal-body">   
            <div class="container">                                                                          
                <div class="col-md-12">    
                    <ul class="nav nav-tabs" id="mainsearchList" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="movies-tab" data-toggle="tab" href="#homemovies_item" role="tab" aria-controls="Movies" aria-selected="true">Movies</a>
                        </li>
                       
                    </ul>
                    <div class="tab-content homemovies_content">
                        <div class="tab-pane fade show active" id="homemovies_item" role="tabpanel" aria-labelledby="all-tab">
                            <div class="row">
	                         <div class="col-md-12">
                                    <ul>
                                        
                                    </ul>
                                 </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
       </div>   
    </div>
  </div>
</div>

<!-- Jquery Plugins -->
<script src="assets/plugins/jquery/jquery.min.js"></script>
<script src="assets/plugins/jquery/popper.min.js"></script>
<script src="assets/plugins/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/plugins/sweetalert/sweetalert.min.js" type="text/javascript"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/modernizr/2.8.3/modernizr.js"></script>
<script src="assets/js/helper.js" type="text/javascript"></script>
<script src="assets/js/custom.js" type="text/javascript"></script>
<?php if($active_url == 'index.php' || $active_url == 'theatres.php'|| $_SERVER['REQUEST_URI'] == '/') { ?>
<script src="assets/plugins/slider/jssor.slider-28.1.0.min.js" type="text/javascript"></script>
<script src="assets/plugins/slider/jssor.init.js" type="text/javascript"></script>
<script type="text/javascript">
    // Slider Init Call jQuery
    (function( $ ){ jssor_1_slider_init(); })( jQuery );
</script>
<?php } ?>
<?php if($active_url == 'index.php' || $_SERVER['QUERY_STRING'] == ''|| $_SERVER['REQUEST_URI'] == '/' ) { ?>
<script src="assets/plugins/OwlCarousel/owl.carousel.min.js" type="text/javascript"></script>
<script type="text/javascript">
    // Owl Carousel Slider
    var owl = $('.owl-carousel');
    owl.owlCarousel({
        items:5,
        loop:true,
        margin:15,
        autoplay:true,
        autoplayTimeout:3000,
        autoplayHoverPause:true,
        responsiveClass:true,
        responsive:{
            0:{
                items:1,
                nav:true
            },
            600:{
                items:3,
                nav:false
            },
            1000:{
                items:5,
                nav:true,
                loop:false
            }
        }
    });
    $('.play').on('click',function(){
        owl.trigger('play.owl.autoplay',[1000])
    })
    $('.stop').on('click',function(){
        owl.trigger('stop.owl.autoplay')
    });
</script>
<?php } ?>

<?php if( $active_url == 'seat.php') { ?>
<!-- Seat Booking jQuery Plugins -->
<script src="assets/plugins/seat-charts/jquery.seat-charts.js?v=<?php echo date('Y-m-d H:i:s'); ?>"></script>
<?php } ?>

<?php if($active_url == 'bulk-booking.php') { ?>
<!-- Date Picker Control -->
<script src="assets/plugins/datepicker/moment.min.js"></script>
<script src="assets/plugins/datepicker/bootstrap-datepicker.min.js"></script>
<?php } ?>

<script type="text/javascript">
 $(document).ready(function() {    
    $.ajax({
        type: "GET",
        dataType: "json",
        url: "classes/search.php",                     
        success: function(data) {
            var movieArr ='';
            $.each(data, function (key, value) {                                 
                movieArr +="<option value='"+data[key].movieName+"'></option>";
            });
            $("#search_movies").html(movieArr);
        }
    });
});
</script>