<?php 
    include ('header.php');
?>   

<div class="page-wrapper">
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <div class="reset-logo text-center">
                    <img class="img-responsive" src="assets/images/logos/ags-logo.jpg" alt="logo" />
                    <h5>Forgot your password? </h5>
                </div>
                <div class="col-md-6 offset-md-3">
                    <div class="reset-password-wrapper">
                        <!-- Send password reset mail link form -->
                        <form class="reset-sendmail-frm" name="reset-sendmail-frm" method="POST" action="javascript:void(0);">
                            <span class="log-icon fas fa-user-lock"></span>
                            <p><i class="fas fa-info-circle"></i> Lost your password? please enter your email address. you will receive a link to create a new password via email. </p>
                            <div class="alert alert-success alert-dismissible" id="resetLinksendAlert" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><i class="fas fa-check-circle"></i> <strong>Success!</strong> Password reset request was sent successfully. please check your email to reset your password.
                            </div>
                            <div class="alert alert-danger alert-dismissible" id="emailidNotregister" style="display:none;">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><strong><i class="fas fa-exclamation-triangle"></i></strong> Entered email address does not exist. please register first
                            </div>
                            <div class="form-group">
                                 <label for="">Please enter your registered email address</label>
                                <div class="input-group">                                    
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                    </div>
                                    <input type="email" class="form-control" id="user_resetEmail" autocomplete="off" name="user_resetEmail" placeholder="Enter your email" />
                                </div>
                                <span class="error-message" id="error_resendemail"></span>
                            </div>
                            <div class="processLoader"><img class="img-fluid" src="assets/images/ajax-loader.gif" alt="loader" /></div>
                            <div class="text-center mb-1">                                
                                <button type="button" class="btn btn-sm" id="sendPasswordemail" name="sendPasswordemail"><i class="far fa-paper-plane"></i> Send password to reset email</button>
                            </div>
                            <hr />
                            <div class="text-right">  
                                <a href="#" data-toggle="modal" data-target="#agsLoginRegister_panel" target="_self"><i class="fas fa-angle-double-right"></i> Back to Login</a>
                            </div>
                        </form>
                    </div>
                </div>                
            </div>
        </div>
    </div>
</div>

<?php include('footer.php'); ?>




