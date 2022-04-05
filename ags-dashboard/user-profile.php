<?php 
    $title = "User Profile";
    $description = "User Profile details";
    $keywords = "User Profile details";
    include('header.php');

?>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Your profile details</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $_SESSION['userData']->name; ?> profile</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Update Your Details</h5>                        
                    </div>
                    <div class="card-body">
                        <h5><mark>Profile Details</mark></h5>                        
                        <hr>
                        <form class="userUpdateProfile_form" id="userUpdateProfile_form" name="userUpdateProfile_form" method="POST" action="">
                            <input type="hidden" id="user_profile_id" name="user_profile_id" value="<?php echo $_SESSION['userData']->id; ?>" />
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="floating-label" for="name"><i class="feather icon-user-check"></i> Your name</label>
                                        <input type="text" class="form-control" id="user_profile_name" name="user_profile_name" placeholder="" value="<?php echo $_SESSION['userData']->name; ?>" disabled style="cursor: not-allowed;background-color:transparent;" />
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label class="floating-label" for="Email"><i class="feather icon-mail"></i> Email</label>
                                        <input type="email" class="form-control" id="user_profile_email" name="user_profile_email" placeholder="" value="<?php echo $_SESSION['userData']->email; ?>" <?php if($_SESSION['userData']->user_role != 1) { ?> disabled style="cursor: not-allowed;background-color:transparent;" <?php } ?> />
                                        <span class="error__message" id="error_email"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="floating-label" for="mobile"><i class="feather icon-phone"></i> Mobile No</label>
                                        <input type="text" maxlength="10" class="form-control" id="user_profile_mobile" name="user_profile_mobile" placeholder="" value="<?php echo $_SESSION['userData']->mobile; ?>" <?php if($_SESSION['userData']->user_role != 1) { ?> disabled style="cursor: not-allowed;background-color:transparent;" <?php } ?> />
                                        <span class="error__message" id="error_mobile"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="floating-label" for="role"><i class="feather icon-briefcase"></i> Role</label>
                                        <input type="hidden" class="form-control" id="user_profile_role" name="user_profile_role" placeholder="" value="<?php echo $_SESSION['userData']->role; ?>" disabled />                                        
                                        <span class="mt-4 badge badge-light-primary" style="cursor: not-allowed;"><?php echo $_SESSION['userData']->role; ?></span>
                                    </div>
                                </div>                                 
                                <?php 
                                if($_SESSION['userData']->locationId == 1) {
                                    $user_location = "AGS T.Nagar";
                                } else if($_SESSION['userData']->locationId == 2) {
                                    $user_location = "AGS Navalur";
                                } else if($_SESSION['userData']->locationId == 3) {
                                    $user_location = "AGS Villivakkam";
                                } else if($_SESSION['userData']->locationId == 4) {
                                    $user_location = "AGS Alapakkam";
                                } else if($_SESSION['userData']->locationId == 5) {
                                    $user_location = "All AGS Location";
                                } else {
                                    $user_location = "Not available";
                                }                    
                                ?>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="floating-label" for="location"><i class="feather icon-map-pin"></i> Location</label>
                                        <input type="hidden" class="form-control" id="user_profile_location" name="user_profile_location" placeholder="" value="<?php echo $user_location; ?>" disabled />                                        
                                        <span class="mt-4 badge badge-light-dark" style="cursor: not-allowed;"><?php echo $user_location; ?></span>
                                    </div>
                                </div>
                                <?php 
                                if($_SESSION['userData']->status == 1) {
                                    $user_status = "Active";
                                } else {
                                    $user_status = "In Active";
                                } ?>
                                <div class="col-md-6 mt-2">
                                    <div class="form-group">
                                        <label class="floating-label" for="status"><i class="feather icon-list"></i> Status</label>
                                        <input type="hidden" class="form-control" id="user_profile_status" name="user_profile_status" placeholder="" value="<?php echo $user_status; ?>" disabled />                                        
                                        <span class="mt-4 badge badge-light-primary" style="cursor: not-allowed;"><?php echo $user_status; ?></span>
                                    </div>
                                </div>  
                                <div class="col-md-12 text-right"><hr />   
                                    <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div>                                 
                                    <?php if($_SESSION['userData']->user_role == 1) { ?>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="userprofileUpdate_submitbtn" name="userprofileUpdate_submitbtn"><i class="mr-2 feather icon-edit"></i> Update</button>
				    <?php } ?>
                                    <!-- <button type="button" class="btn btn-sm btn-outline-warning" onClick="window.location.reload();"><i class="feather icon-corner-up-right"></i> Cancel</button>  -->
                                </div>                                                                    
                            </div>
                        </form>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {        
        $("#userprofileUpdate_submitbtn").on('click', function () {            
            var userEmail = $('#user_profile_email').val();
            var userMobile = $('#user_profile_mobile').val();
            var validate = 0;   
            if (userEmail == "") {
                $("#error_email").html('Please enter your email');
                validate = 1;
            } else { 
                var atpos = userEmail.indexOf("@");
                var dotpos = userEmail.lastIndexOf(".");
                if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= userEmail.length) {
                    $("#error_email").html('Please enter valid email'); 
                    $('#user_profile_email').val('');
                    validate = 1;
                } else {
                    $("#error_email").html(''); 
                }
            }    
            if (userMobile == "") {
                $("#error_mobile").html('Please enter your mobile number');
                validate = 1;
            } else {        
                if (userMobile.length < 10) {
                    $("#error_mobile").html('Enter valid mobile number'); 
                    $('#error_mobile').val('');
                    validate = 1;
                } else {
                    $("#error_mobile").html(''); 
                }
            }       
            
            if (validate == 1) {
                return false;
            } else {                
                $('#userprofileUpdate_submitbtn').attr('disabled', true);
                $('.processLoader').show();
                setTimeout(function() {
                    var userData = $('#userUpdateProfile_form').serialize();
                    $.ajax({ 
                        url: "classes/userControl.php?userProfile_update",
                        type: "POST", 
                        data: userData,                        
                        success: function(data) {  
                            $('.processLoader').hide();
                            $('#userprofileUpdate_submitbtn').attr('disabled', false);
                            var data = JSON.parse(data);
                            if(data.status == "success") {                                
                                $.toast({
                                    heading: 'Your profile details has been updated successfully.',                                    
                                    text: [
                                    'If you want to see your updated changes, ', 
                                    'Please <a href="logout.php">click here</a> to re-login your account.'                                    
                                    ],
                                    showHideTransition: 'fade',
                                    icon: 'success',
                                    position: 'top-center',
                                    stack: false,
                                    hideAfter: false
                                });                                                                                                
                            } else {
                                $.toast({
                                    heading: 'Information',                                    
                                    text: [
                                        'Your changes has been not affected our database. ', 
                                        'Please do any changes to update'                                    
                                    ],
                                    showHideTransition: 'fade',
                                    icon: 'info',
                                    position: 'top-center',
                                    stack: false,
                                    hideAfter: 8000
                                });                                
                            }
                        }
                    });
                }, 2000);
            }
        });
    });    
</script>