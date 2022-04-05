<?php session_start(); ?>
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
</head>

<!-- [ auth-signin ] start -->
<div class="auth-wrapper">
	<div class="auth-content">
		<div class="card">
			<div class="row align-items-center text-center">
				<div class="col-md-12">
                    <form id="userloginFrm" name="userloginFrm" action="classes/userControl.php" method="POST" autocomplete="off">
                        <div class="card-body">
                            <img src="assets/images/ags-logo-transparent.png" alt="logo" class="img-fluid loginlogo mb-4">
                            <h4 class="mb-3 f-w-400">Signin</h4>
                            <div class="form-group mb-3">
                                <label class="floating-label" for="Email">Email address</label>
                                <input type="email" required class="form-control" id="userEmail" name="userEmail" placeholder="" />
                            </div>
                            <div class="form-group mb-4">
                                <label class="floating-label" for="Password">Password</label>
                                <input type="password" required class="form-control" id="userPassword" name="userPassword" autocomplete="off" placeholder="" />
                            </div>
                            <div class="custom-control custom-checkbox text-left mb-2 mt-2">
                                <input type="checkbox" class="custom-control-input" id="customCheck1">
                                <label class="custom-control-label" for="customCheck1">Save credentials.</label>
                                <?php
                                if(isset($_SESSION["error"])) {
                                    $error = $_SESSION["error"];
                                    echo "<p class='error__message'><i class='fas fa-exclamation-triangle'></i> $error</p>";
                                }
                            ?>
                            <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader" /></div>
                            </div>  
                            <button class="btn btn-block btn-primary" type="submit" name="userLogin">Signin</button>
                            <!-- <p class="mb-2 text-muted">Forgot password? <a href="auth-reset-password.html" class="f-w-400">Reset</a></p> -->
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
<?php unset($_SESSION["error"]); ?>
