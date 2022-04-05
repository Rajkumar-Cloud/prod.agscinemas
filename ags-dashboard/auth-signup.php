<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>AGS Cinemas Dashboard Register</title>
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
</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
                    <form id="userRegisterFrm" name="userRegisterFrm" action="classes/userControl.php" method="POST">
                        <input type="hidden" id="roleType" name="roleType" value="2" />
                        <div class="card-body">
                            <img src="assets/images/ags-logo-transparent.png" alt="logo" class="img-fluid loginlogo mb-4">
                            <h4 class="mb-3 f-w-400">Sign Up</h4>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Email">User Name</label>
                                <input type="text" required class="form-control" id="userName" name="userName" placeholder="" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Email">Email address</label>
                                <input type="email" required class="form-control" id="userEmail" name="userEmail" placeholder="" />
                            </div>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="mobile no">Mobile No</label>
                                <input type="text" maxlength="10" required class="form-control" id="userMobileno" name="userMobileno" placeholder="" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Password</label>
                                <input type="password" required class="form-control" id="userPassword" name="userPassword" autocomplete="off" placeholder="" />
                            </div>                            
                            <div class="form-group mb-4">
                                <label class="floating-label" style="top:-11px;left: 4px;" for="location">Location Access</label>
                                <select class="form-control" required id="locationAccess" name="locationAccess">
                                    <option value="">Select Location Access</option>
                                    <option value="all">All</option>
                                    <option value="1">T.Nagar</option>
                                    <option value="2">Navallur</option>
                                    <option value="3">Allapakkam</option>
                                    <option value="4">Villivakkam</option>
                                </select>
                            </div>
                            <div class="custom-control text-left mb-2 mt-2">                                
                                <?php
                                    if(isset($_SESSION["status"])) {
                                        $status = $_SESSION["status"];
                                        echo "<p class='error__message' style='color:#008000'><i class='fas fa-check-circle'></i> $status</p>";
                                    }
                                ?>
                                <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader" /></div>
                            </div>  
                            <div class="d-flex">
                                <button class="btn btn-sm btn-primary mb-2 mr-2" type="submit" name="userRegister">Register</button>                            
                                <button class="btn btn-sm btn-danger mb-2" type="reset" name="reset">Reset</button>                            
                            </div>
                            <p class="mb-0 text-muted">Already register? Please <a href="login.php" class="f-w-400">Login</a></p>
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
</body>
</html>
<?php unset($_SESSION["status"]); ?>
<script>
$(document).ready(function() {  
  $("#userMobileno").on("blur", function() {
        var mobNum = $(this).val();
        var filter = /^\d*(?:\.\d{1,2})?$/;
        if (filter.test(mobNum)) {            
        } else {
              alert('Mobile no not valid');              
              $("#userMobileno").val('');
              return false;
        }    
  });
  
});
</script>