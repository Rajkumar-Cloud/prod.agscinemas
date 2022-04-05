<?php 
    if(!isset($_GET["auth"])) {
        header('Location:index.php');    
    }
    include ('header.php');
?>   

<div class="page-wrapper">
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="reset-logo text-center">
                    <img class="img-responsive" src="assets/images/logos/ags-logo.jpg" alt="logo" />
                    <h5>Update your new password! </h5>
                </div>
                <div class="col-md-6 offset-md-3">
                    <div class="reset-password-wrapper">
                        <!-- Forgot New Password Form -->
                        <form class="reset-password-frm" name="reset-password-frm" action="">
                            <input type="hidden" id="auth_id" name="auth_id" value="<?php echo $_GET["auth"]; ?>" />
                            <input type="hidden" id="reset_email" name="reset_email" value="<?php echo $_GET["email"]; ?>" />
                            <span class="log-icon fas fa-lock-open"></span>
                            <div class="alert alert-success alert-dismissible" id="alertSuccesspwdupdate" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fas fa-check-circle"></i> Your password has been updated <strong>successfully!</strong>.
                            </div>
                            <div class="alert alert-danger alert-dismissible" id="alertFailpwdupdate" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><i class="fas fa-exclamation-triangle"></i> Failed </strong>to update your password. the parameter is incorrect.
                            </div>
                            <p>Enter a new password for account: <mark><span id="registeredForgotEmail"><?php echo $_GET["email"]; ?></span></mark></p>
                            <div class="form-group">
                                 <label for="password">New password</label>
                                <div class="input-group">                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" autocomplete="off" id="newuserPassword" name="newuserPassword" placeholder="Enter new password" />
                                </div>
                                <span class="error-message" id="error_newpassword"></span>
                            </div>
                            <div class="form-group">
                                 <label for="password">Confirm new password</label>
                                <div class="input-group">                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                    </div>
                                    <input type="password" class="form-control" autocomplete="off" id="newuserConfirmPassword" name="newuserConfirmPassword" placeholder="Enter confirm new password" />
                                </div>
                                <span class="error-message" id="error_cnewpassword"></span>
                            </div>
                            <div class="processLoader"><img class="img-fluid" src="assets/images/ajax-loader.gif" alt="loader" /></div>
                            <div class="text-center mb-1">                                
                                <button type="button" class="btn btn-sm" id="resetMypassword" name="resetMypassword"><i class="fas fa-unlock"></i> Reset my password</button>
                                <button type="reset" class="btn btn-sm reset"><i class="fas fa-eraser"></i> Clear</button>
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>




