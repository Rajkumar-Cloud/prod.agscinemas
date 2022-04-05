/* AGS Login & register jQuery functions */
/*
const preloader = document.querySelector('.Process_preload');
window.addEventListener("load", () => setTimeout(function() {        
    if (!preloader.style.opacity) { preloader.style.opacity = 1; }
    if (preloader.style.opacity > 0) { preloader.style.opacity -= 1; 
        preloader.style.display = 'none';
    } else {
        clearInterval(fadeEffect);
    }        
}, 1000));  
*/
$(document).ready(function() {
    $("#resendOtp").hide();
    $('#header_main_search').on('click', function(){
    	var $modal = $('#agsMainsearch_model');
        $modal.modal("show");
        $modal.on('shown.bs.modal', function () {
            $('#home_search_movies').focus();
        });
    });
    $('#bulkbooking-btn').on('click', function(){ 
        var theater = $('#theatername_list').val();	
        var movie = $('#movie_list').val();
        var bookingdate = $('#booking-datepic').val();
        var bookingtime = $('#booking-time').val();
        var tquantity = $('#ticket-quantity').val();
        var cname = $('#company-name').val();        
        var temail = $('#email-address').val();  
        var cpersonname = $('#contact-person-name').val();
        var contact_no = $('#contact-no').val();
        var caddress = $('#contact-address').val();
	var mobileOtp = $('#mobileNo-otp').val();
        var booking_id = $('#bulkbookingu_id').val();
        var validate = 0;    
        if(theater == "") {
            $("#error_theatre").html('Please select prefered theatre');
            validate = 1;
        } else {           
            $("#error_theatre").html('');  
        }
        if(movie == "") {
            $("#error_movie").html('Select movie');
            validate = 1;
        } else {           
            $("#error_movie").html('');  
        }
        if(bookingdate == "") {
            $("#error_bookingdate").html('Select booking date');
            validate = 1;
        } else {           
            $("#error_bookingdate").html('');  
        }
        if(bookingtime == "") {
            $("#error_bookingtime").html('Select booking time slot');
            validate = 1;
        } else {           
            $("#error_bookingtime").html('');  
        }
        if(tquantity == "") {
            $("#error_quantity").html('Enter ticket quantity');
            validate = 1;
        } else {     
            if (tquantity < 30) {
                $("#error_quantity").html('Ticket quantity minimum 30 and higher');
                validate = 1; 
            } else {
                $("#error_quantity").html(''); 
            }
        }
        if(cname == "" || cname.trim().length == 0) {
            $("#error_company").html('Enter company name');
            validate = 1;
        } else {           
            $("#error_company").html('');  
        }        
        if (temail == "") {
            $("#error_email").html('Please enter email');
            validate = 1;
        } else {
            var atpos = temail.indexOf("@");
            var dotpos = temail.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= temail.length) {
                $("#error_email").html('Please enter valid email');                 
                validate = 1;
            } else {
                $("#error_email").html(''); 
            }
        }
        if(cpersonname == "" || cpersonname.trim().length == 0) {
            $("#error_cperson").html('Enter contact person name name');
            validate = 1;
        } else {           
            $("#error_cperson").html('');  
        }  
        if (contact_no == "") {
            $("#error_contactno").html('Please enter your mobile no');
            validate = 1;
        } else {        
            if (contact_no.length < 10) {
                $("#error_contactno").html('Enter correct mobile no');                
                validate = 1;
            } else if(mobileOtp == "") {
                $("#error_contactno").html('');  
                $("#error_contactno").append('Please Enter valid OTP');  
                validate = 1;
            } else {
                $("#error_contactno").html(''); 
            }
        }         
	if(caddress == "" || caddress.trim().length == 0) {
            $("#error_caddress").html('Enter contact address');
            validate = 1;
        } else {           
            $("#error_caddress").html('');  
        }
        if (validate == 1) {
            return false;
        } else {
            $('.processLoader').show();
            $('#bulkbooking-btn').attr('disabled','disabled');
            setTimeout(function(){ 
                $.ajax({
                    type: "POST",
                    url: "classes/bulkbooking.php?bulkbookingData",
                    data: {'theater_name':theater,
                    'userId':$('#userId').val(),
                    'movie':movie,
                    'bookingdate':bookingdate,
                    'bookingtime':bookingtime,
                    'total_quantity':tquantity,
                    'company_name':cname,
                    'contact_email':temail,
                    'cpersonname':cpersonname,
                    'contact_no':contact_no,
		    'otp': mobileOtp,
                    'booking_id': booking_id,
                    'caddress':caddress              
                    },
                    beforeSend: function() {
                        $('.processLoader').show();
                        $('#bulkbooking-btn').attr('disabled','disabled');
                    }, success: function(result) {
                        $('.processLoader').hide();
                        $('#bulkbooking-btn').attr('disabled', false);
                        clearFields();
                        var data = JSON.parse(result);
                        if(data.type == "success") {
                            Swal.fire({                            
				title: '<p style="font-size:14px;">Your bulk booking request has been sent!</p>',                
				imageUrl: "assets/images/logos/ags-logo-transparent.png",
				imageHeight: 60,
				imageWidth: 80,                    
				confirmButtonText: 'Ok',
				timer:45000,
				showClass: { popup: 'animated pulse' },
				hideClass: { popup: 'animated fadeOutUp' }
                            }).then(function(){ 
                                location.reload();
                            });                                               
                        } else{
                            Swal.fire({
                                icon: 'error',
                                title: data.message,
                                title: '<p style="font-size:14px;">Given OTP details not correct. Please try again!</p>',                                
                                confirmButtonText: 'Ok',
                                focusConfirm: false,
                            });
                            setTimeout(function(){ location.reload(); }, 5000);
			}
                    }, complete: function (data) {                    
                        $('.processLoader').hide();
                    }
                });
            }, 5000);
        }
    }); 

    $('#getOtp_bulkbooking').on('click', function() {
        var validcheck = true;
        var contactno = $('#contact-no').val();            
        if (contactno == "") {
            $("#error_contactno").html('Please enter your mobile no');
            $('#contact-no').focus();
            $('#mobileNo-otp').css('display','none');
            validcheck = false;
        } else {        
            if (contactno.length < 10) {
                $("#error_contactno").html('Enter correct mobile no');                
                $('#contact-no').focus();
                $('#mobileNo-otp').css('display','none');
                validcheck = false;
            } else {
                $("#error_contactno").html('');                     
                $('#mobileNo-otp').css('display','inline-block');
                $('#mobileNo-otp').focus();
            }
        }
        if(validcheck == false) {
            return false;
        } else {
            $('#otpVerify__status').css({'display':'block'}).append('<p><i class="fa fa-info-circle" aria-hidden="true"></i> Please check your mobile will get your OTP. and enter the required field.</p>');
            $('#getOtp_bulkbooking').attr('disabled','disabled');            
            $.ajax({
                type: "POST",
                url: "classes/bulkbooking.php?bulkBooking_otpGenerate",
                data: {'mobileno':contactno },
                success: function(result) {   
                    var res_json = $.parseJSON(result);
                    if(res_json.status == "success") {
                        $('form.bulkbooking-form').append("<input type='hidden' id='bulkbookingu_id' value='"+res_json.bid+"' />")
                    } else {
                        alert("Somthing went wrong");
                        location.reload();
                    }
                }, complete: function (data) {                    
                    
                }
            });          
        }
    });

    // Reset send mail jQuery
    $('#user_resetEmail').on('keydown', function (e) {
        var keycode = (e.keyCode ? e.keyCode : e.which);
        if(keycode == 13) { // the enter key code
            $('#sendPasswordemail').trigger('click');            
            return false;
        }
    });
    $('#sendPasswordemail').on('click', function() {
        var resendemail = $('#user_resetEmail').val();
        var validate = 0;  
        if (resendemail == "") {
            $("#error_resendemail").html('Please enter registered email address');
            validate = 1;
        } else {
            var atpos = resendemail.indexOf("@");
            var dotpos = resendemail.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= resendemail.length) {
                $("#error_resendemail").html('Please enter valid email address');                 
                validate = 1;
            } else {
                $("#error_resendemail").html(''); 
            }
        }
        if (validate == 1) {
            return false;
        } else {
            $('.processLoader').show();
            $('#sendPasswordemail').attr('disabled','disabled');
            setTimeout(function() { 
                $.ajax({
                    type: "POST",
                    url: "classes/resetpassword.php?resetpassword",
                    data: { 'resend_email':resendemail },
                    beforeSend: function() {
                        $('.processLoader').show();
                        $('#sendPasswordemail').attr('disabled','disabled');
                    }, success: function(result) {
                        $('.processLoader').hide();
                        $('#sendPasswordemail').attr('disabled', false);                         
                        var data = JSON.parse(result);                        
                        if(data.type == "success") {
                            $('#resetLinksendAlert').show();         
                            $('#sendPasswordemail').attr('disabled','disabled');                    
                            setTimeout(function () { $("#resetLinksendAlert").fadeOut(); window.location.href = "index.php"; }, 8000);
                        } else {
                            $('#emailidNotregister').show();   
                            $('#user_resetEmail').val('');                         
                            setTimeout(function () { $("#emailidNotregister").fadeOut(); }, 8000);
                        }

                    }, complete: function (data) {                    
                        $('.processLoader').hide();
                    }
                });
            }, 3000);
        }
    });

    $('#resetMypassword').on('click', function() {
        var password = $("#newuserPassword").val();    
        var cpassword = $("#newuserConfirmPassword").val();        
        var validate = 0;              
        if (password == "") {
            $("#error_newpassword").html('Please enter your password');
            validate = 1;
        } else {                        
            if (password.length < 8) {            
                $("#error_newpassword").html('Please enter minimum 8 characters needed'); 
                $('#newuserPassword').val('');
                validate = 1;
            } else {
                $("#error_newpassword").html(''); 
            }
        }
        if (cpassword == "") {
            $("#error_cnewpassword").html('Please enter your confirm password');
            validate = 1;
        } else {        
            if (password != cpassword) {
                $("#error_cnewpassword").html('The password and confirm password do not match'); 
                $('#newuserConfirmPassword').val('');
                validate = 1;
            } else {
                $("#error_cnewpassword").html(''); 
            }
        }
        if (validate == 1) {
            return false;
        } else {
            $('.processLoader').show();
            $('#resetMypassword').attr('disabled','disabled');
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "classes/resetpassword.php?updatePassword",
                    data: {'password':password, 'auth_id': $('#auth_id').val(), 'email': $('#reset_email').val()},
                    beforeSend: function() {
                        $('.processLoader').show();                        
                    }, success: function(result) {
                        $('.processLoader').hide();                                             
                        var data = JSON.parse(result);                        
                        if(data.type == "success") {
                            $('#alertSuccesspwdupdate').show();                            
                            setTimeout(function () { $("#alertSuccesspwdupdate").fadeOut(); window.location.href = "index.php"; }, 6000);
                        } else {
                            $('#alertFailpwdupdate').show(); 
                            $('.reset-password-frm').trigger("reset");                           
                            setTimeout(function () { $("#alertFailpwdupdate").fadeOut(); window.location.href = "index.php"; }, 6000);
                        }
                    }, complete: function (data) {                    
                        $('.processLoader').hide();
                    }
                });
            }, 3000);
        }        
    });
});

function verifyOTP() {
    var otp1 = $("#otp1").val();
    var otp2 = $("#otp2").val();
    var otp3 = $("#otp3").val();
    var otp4 = $("#otp4").val();
    if(otp1 == '')       
    $('#otp1').css("border","1px solid #dc3545");
    else 
    $('#otp1').css("border","1px solid #ffffff54");

    if(otp2 == '')       
    $('#otp2').css("border","1px solid #dc3545");
    else 
    $('#otp2').css("border","1px solid #ffffff54");

    if(otp3 == '')       
    $('#otp3').css("border","1px solid #dc3545");
    else 
    $('#otp3').css("border","1px solid #ffffff54");

    if(otp4 == '')       
    $('#otp4').css("border","1px solid #dc3545");
    else 
    $('#otp4').css("border","1px solid #ffffff54");

    if($('#seat_proceed_register').val() == '') 
	req = '';
    else
        req = $('#seat_proceed_register').val();
    
    if(otp1 != "" && otp2 != "" && otp3 != "" && otp4 != ""){    
        var otp = otp1+""+otp2+""+otp3+""+otp4;         
        var mobile = $('#otpMobile').val();
        var signs = 'signups';         
        var otpDatas = {'mobile':mobile,'otp':otp,'signs':signs};            
        $.ajax({
            type: "POST",
            url: "classes/verify_otp.php",
            data: otpDatas
        }).done(function(success) {
            var data = JSON.parse(success);
            var checkonce=data.alert;
            if(checkonce=='registered') {
		if(req == 2) {   
                    $('#seat_proceed_login').val('');  
                    $("#seat_proceed_register").val('');    
                    $("#otpMobile").val('');         
                    seat_proceed2();
                } else {
                    $("#otpMobile").val('');
                    localStorage.removeItem("seconds");
                    Swal.fire({                            
		       title: '<p style="font-size:14px;">Your details has been Registered successfully!</p>', 
		       imageUrl: "assets/images/logos/ags-logo-transparent.png",               
                       imageHeight: 60,
                       imageWidth: 80,
                       timer: 4500,
                       confirmButtonText: 'Ok',
                       showClass: { popup: 'animated pulse' },
                       hideClass: { popup: 'animated fadeOutUp' }
                    }).then(function(){ location.reload(); }); 
		}                  
            } else if(checkonce =='tryagain') {
                Swal.fire({
		    title: '<p style="font-size:14px;">Please try after one hour!</p>',
                    imageUrl: "assets/images/logos/ags-logo-transparent.png",               
                    imageHeight: 60,
                    imageWidth: 80,
                    timer: 4500,
                    confirmButtonColor: "#8CD4F5",
                    confirmButtonText: "OK",
                    closeOnConfirm: false
                },
                function(){
                    location.reload();
                });
            } else {
                Swal.fire("check Your OTP");
            }
        });
    }      
}

function setLoginOnSubmit(req) {
    var useremail = $("#userEmailid").val();
    var userpassword = $("#userPassword").val();
    var uservalidate = 0;    
    if (useremail == "") {
        $("#error_useremail").html('Please enter your email');
        uservalidate = 1;
    } else { 
        var atpos = useremail.indexOf("@");
        var dotpos = useremail.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= useremail.length) {
            $("#error_useremail").html('Please enter valid email'); 
            $('#userEmailid').val('');
            uservalidate = 1;
        } else {
            $("#error_useremail").html(''); 
        }
    }
    if (userpassword == "") {
        $("#error_userpassword").html('Please enter your password');
        uservalidate = 1;
    } else {
        $("#error_userpassword").html(''); 
    }
    if($('#seat_proceed_login').val() == '') {
        req = '';
    } else {
        req = $('#seat_proceed_login').val();
    }
    if (uservalidate == 1) {
        return false;
    } else {
        $('.processLoader').show();
        $('#userLogin').attr('disabled','disabled');
        setTimeout(function(){ 
            $.ajax({
                type: "POST",
                url: "classes/userLogin.php",
                data: {'email':useremail,'password':userpassword },
                beforeSend: function() {
                    $('.processLoader').show();
                    $('#userLogin').attr('disabled','disabled');
                }, success: function(response) {
                    $('.processLoader').hide();
                    $('#userLogin').attr('disabled', false);                    
                    var data = JSON.parse(response);
                    if(data.alert == "login") {
                        if(req == 2) {
                            $('#seat_proceed_login').val('');  
                            $("#seat_proceed_register").val('');                
                            seat_proceed2();
                        } else {  
                            Swal.fire({        
                                title: '<p style="font-size:14px;">Login successfully!</p>',                  
		                imageUrl: "assets/images/logos/ags-logo-transparent.png",
		                imageHeight: 60, 
                    		imageWidth: 80,
                                padding: '0',
                                timer:3000,
                                confirmButtonText: 'Ok',
                                showClass: { popup: 'animated pulse' },
                                hideClass: { popup: 'animated fadeOutUp' }
                            }).then(function(){ location.reload(); });
                        }
                    } else if(data.alert == "emailwrong"){
                        Swal.fire({
                            title: '<p style="font-size:14px;">'+data.message+'</p>',
			    imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            padding: '0',
                            timer: 3500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        });
                    } else if(data.alert == "passwrong"){
                        Swal.fire({
			    title: '<p style="font-size:14px;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            padding: '0',                            
                            timer: 3500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        });
                    } else if(data.alert == "otpverify"){
                        $("#agsLoginRegister_panel").modal('hide');
                        $("#agsOTPlogin_panel").modal('show');  
                        $("#otpMobile").val(data.mobile);
                        $("#otpMobileno").html(data.mobile);
                        seconds = 60;
                        localStorage.setItem("seconds",60);
                        $('#resendTime').html("1:00");
                        $("#resendOtp").hide();
                        GameTimer();
                        countdownTimer = setInterval(GameTimer, 1000);
                    } else {
                        Swal.fire({
                            title: '<p style="font-size:14px;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            timer: 3500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        }); 
                    }
                }, complete: function (data) {                    
                    $('.processLoader').hide();
                }
            });
        });
    }
}

function setregisterOnSubmit() {
    var username = $("#username").val();
    var email = $("#userEmailaddress").val();
    var password = $("#usersignupPassword").val();    
    var cpassword = $("#usercPassword").val();
    var mobileno = $("#loginMobile_no").val();
    var validate = 0;
    if (username == "") {
        $("#error_name").html('Please enter your name'); 
        // username.focus();
        validate = 1;
    } else { $("#error_name").html(''); }
    if (email == "") {
        $("#error_email").html('Please enter your email');
        validate = 1;
    } else { 
        var atpos = email.indexOf("@");
        var dotpos = email.lastIndexOf(".");
        if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
            $("#error_email").html('Please enter valid email'); 
            $('#userEmailaddress').val('');
            validate = 1;
        } else {
            $("#error_email").html(''); 
        }
    }
    if (password == "") {
        $("#error_signuppassword").html('Please enter your password');
        validate = 1;
    } else {                        
        if (password.length < 8) {            
            $("#error_signuppassword").html('Please enter minimum  8 characters needed'); 
            $('#usersignupPassword').val('');
            validate = 1;
        } else {
            $("#error_signuppassword").html(''); 
        }
    }
    if (cpassword == "") {
        $("#error_cpassword").html('Please enter your password');
        validate = 1;
    } else {        
        if (password != cpassword) {
            $("#error_cpassword").html('Password and confirm password not matched'); 
            $('#usercPassword').val('');
            validate = 1;
        } else {
            $("#error_cpassword").html(''); 
        }
    }
    if (mobileno == "") {
        $("#error_mobileno").html('Please enter your mobile no');
        validate = 1;
    } else {        
        if (mobileno.length < 10) {
            $("#error_mobileno").html('Enter correct mobile no'); 
            $('#loginMobile_no').val('');
            validate = 1;
        } else {
            $("#error_mobileno").html(''); 
        }
    }
    if (validate == 1) {
        return false;
    } else {
        $('.processLoader').show();
        $('#userRegister').attr('disabled','disabled');
        setTimeout(function(){ 
            $.ajax({
                type: "POST",
                url: "classes/userRegister.php",
                data: {'name':username,'email':email,'password':password,'mobileno':mobileno },
                beforeSend: function() {
                    $('.processLoader').show();
                    $('#userRegister').attr('disabled','disabled');
                }, success: function(response) {
                    $('.processLoader').hide();
                    $('#userRegister').attr('disabled', false);
                    clearFields();
                    var data = JSON.parse(response);                    
                    if(data.alert == "Sendotp") {
                        $('#agsLoginRegister_panel').modal('hide');
                        $('#agsOTPlogin_panel').modal('show');
                        $("#otpMobile").val(data.mobile);
                        $("#otpMobileno").html(data.mobile);
                        seconds = 60;
                        localStorage.setItem("seconds",60);
                        $('#resendTime').html("1:00");
                        GameTimer();
                        countdownTimer = setInterval(GameTimer, 1000);
                        $("#resendOtp").hide();
                        /*Swal.fire({                            
                           title: "Your details has been Registred successfully!",   
                            icon: 'success',
                            showCancelButton: false,
                            timer: 4500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        }).then(function(){ location.reload(); });*/
                    } else if(data.alert == "email_mobile"){                           
                        Swal.fire({
                            title: '<p style="font-size:14px;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            timer: 4500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        });
                    } else if(data.alert == "email"){
                        Swal.fire({
			    title: '<p style="font-size:14px;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            timer: 4500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        });  
                    } else if(data.alert == "mobile"){
                        Swal.fire({
			    title: '<p style="font-size:14px;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            timer: 4500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        }); 
                    } else{
                        Swal.fire({
                            title: '<p style="font-size:14px;color:#dc3545;">'+data.message+'</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
		            imageHeight: 60, 
                    	    imageWidth: 80,
                            timer: 4500,
                            confirmButtonText: 'Ok',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }
                        });  
                    }
                }, complete: function (data) {                    
                    $('.processLoader').hide();
                }
            });
        }, 5000);
    }
}

function clearFields() {
    $("#username").val('');
    $("#userEmailaddress").val('');
    $("#usersignupPassword").val('');    
    $("#usercPassword").val('');
    $("#loginMobile_no").val('');
}

var timeleftsec='';
var isWaiting = false;
var isRunning = false;
var seconds = 60;
var countdownTimer;
var finalCountdown = false;

if (localStorage.getItem("seconds") !== null) {
    seconds = localStorage.getItem("seconds");
}

function GameTimer() {
    if (isWaiting) {
        return;   
    }
    var minutes = Math.round((seconds - 30) / 60);
    var remainingSeconds = seconds % 60;
    if (remainingSeconds < 10) {
        remainingSeconds = "0" + remainingSeconds;
    }
    $('#resendTime').html(minutes + ":" + remainingSeconds);
    timeleftsec = minutes * 60+ remainingSeconds;
    if (seconds == 0) {
        // localStorage.removeItem("seconds");
        if (finalCountdown) {
            clearInterval(countdownTimer);
            $("#resendOtp").show();
        } else {
            finalCountdown = true;
        }
    } else {             
        seconds--;
    }
    localStorage.setItem("seconds",seconds);
}

countdownTimer = setInterval(GameTimer, 1000);
function resendOtp(argument) {
    var mobile=$('#otpMobile').val();
    var otp1 = $("#otp1").val('');
    var otp2 = $("#otp2").val('');
    var otp3 = $("#otp3").val('');
    var otp4 = $("#otp4").val('');
    var data = {'mobile':mobile};
    $.ajax({
        type:"POST",
        url:"classes/resend_otp.php",
        data:data
    }).done(function(success){
        data = JSON.parse(success);
        if(data.type == "Success"){                     
            seconds = 60;
            localStorage.setItem("seconds",60);
            $('#resendTime').html("1:00");
            GameTimer();
            countdownTimer = setInterval(GameTimer, 1000);
            $("#resendOtp").hide();                       
        }else{
            console.log(data.type);  
        }
    });
}
