<?php 
    if(!isset($_GET["auth"])) {
        header('Location:login.php');    
    }
?>   
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AGS Cinemas Dashboard Login</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="description" content="AGS Cinemas" />
    <meta name="keywords" content="AGS Cinemas">
    <meta name="author" content="AGS Cinemas" />
    <link rel="icon" href="assets/images/ags_favicon.png" type="image/x-icon">
    <link rel="stylesheet" href="assets/css/fontawesome/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/custom.css">
    <link rel="stylesheet" href="assets/js/plugins/toaster/jquery.toast.css">
</head>


<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
    <div class="auth-content">
        <div class="card">
            <div class="row align-items-center text-center">
                <div class="col-md-12">
                    <form id="userResetPwdFrm" name="userResetPwdFrm" action="">
                        <div class="card-body">
                            <img src="assets/images/ags-logo-transparent.png" alt="logo" class="img-fluid loginlogo mb-1">
                            <h4 class="mb-4 f-w-400">Reset your password!</h4>
                            <input type="hidden" id="auth_id" name="auth_id" value="<?php echo $_GET["auth"]; ?>" />
                            <input type="hidden" id="reset_email" name="reset_email" value="<?php echo $_GET["email"]; ?>" />

                            <div class="form-group">
                                <div class="input-group">                                    
                                    <div class="input-group-prepend mr-2">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" autocomplete="off" id="newuserPassword" name="newuserPassword" placeholder="Enter new password" />
                                </div>
                                <span class="error__message" id="error_newpassword"></span>
                            </div>
                            <div class="form-group">
                                <div class="input-group">                                    
                                    <div class="input-group-prepend mr-2">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" autocomplete="off" id="newuserConfirmPassword" name="newuserConfirmPassword" placeholder="Enter confirm password" />
                                </div>
                                <span class="error__message" id="error_cnewpassword"></span>
                            </div>
			    <div class="text-center">
	                        <button class="btn btn-sm mr-2 btn-block btn-primary" type="submit" id="resetMypassword" name="userResetPwd"><i class="fas fa-unlock"></i> Reset</button>
                            	<button class="btn btn-sm btn-block btn-warning" type="reset"><i class="fas fa-eraser"></i> Clear</button>
			    </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- [ auth-signin ] end -->

<!-- Required Js -->
<script src="assets/js/vendor-all.min.js"></script>
<script src="assets/js/plugins/bootstrap.min.js"></script>
<script src="assets/js/ripple.js"></script>
<script src="assets/js/pcoded.min.js"></script>
<script src="assets/js/plugins/toaster/jquery.toast.js"></script>    


<script type="text/javascript"> 
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
                $("#error_cnewpassword").html('The password and confirm password does not match'); 
                $('#newuserConfirmPassword').val('');
                validate = 1;
            } else {
                $("#error_cnewpassword").html(''); 
            }
        }
        if (validate == 1) {
            return false;
        } else {
            $('#resetMypassword').attr('disabled','disabled');
            setTimeout(function() {
                $.ajax({
                    type: "POST",
                    url: "classes/userControl.php?userAdmin_updatePassword",
                    data: {'password':password, 'auth_id': $('#auth_id').val(), 'email': $('#reset_email').val()},
                    success: function(result) {                                            
                        var data = JSON.parse(result);
                        console.log(data); 
                        if(data.status == "success") {
			$.toast({
                            heading: 'Successfully reset!',
                            text: 'Your password has been reset successfully!',
                            showHideTransition: 'fade',
                            icon: 'success',
                            position: 'top-center',
                            stack: false,
                            hideAfter: 8000
                        });
                            setTimeout(function () { window.location.href = "logout.php"; }, 6000);
                        } else {
			  $.toast({
                            heading: 'Reset error',
                            text: 'Failed to reset your password!',
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'top-center',
                            stack: false,  
                            hideAfter: 6000                            
                          });
                            setTimeout(function () { window.location.href = "logout.php"; }, 6000);
                        }
                    }
                });
            }, 3000);
        }        
    });
</script>
</body>
</html>




