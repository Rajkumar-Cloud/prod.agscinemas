<?php 
    include ('header.php');    
    include ('./classes/config.php');
    $stmt = $link->prepare("SELECT * FROM `users` as u WHERE u.id='".$_COOKIE['userid']."' ");
    $stmt->execute();
    $u_count = $stmt->rowCount();
    $userData = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($userData['profilepic'] == '' || $userData['profilepic'] == null) 
        $userData['profilepic'] = 'assets/images/icons/userImg.jpg';
    else
        $userData['profilepic'] = 'assets/Profile/'.$userData['profilepic'];  


?>
<section class="bulk-booking-wrapper default-bg ags-form-process">
    <div class="container">
        <div class="col-md-8 offset-md-2">
            <form id="userprofile_Data" name="userprofile_Data" action="">
		<div class="row bulkbooking-form ags-registering-forms">
                    <div class="col-md-12">
                        <h4><i class="fas fa-user-check"></i> Profile Details</h4>                        
                        <hr />                                       
                    </div>     
                    <div class="col-md-12">
                        <div class="alert alert-success alert-dismissible animated" style="display:none" id="alert_Success">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            your profile details has been updated <strong>successfully!</strong>.
                        </div>
                        <div class="alert alert-danger alert-dismissible animated" style="display:none" id="alert_Error">
                            <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                            your profile detail updating error. <strong>please try again!</strong>.
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="username" class="label-control"><i class="fas fa-user-check"></i> Username</label>
                            <input class="form-control" name="username" required readonly id="username" placeholder="" value="<?php echo $userData['name']; ?>" />                                                      
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="email" class="label-control"><i class="fas fa-envelope"></i> Email</label>
                            <input class="form-control" name="email" required id="userEmail" placeholder="" value="<?php echo $userData['email']; ?>" />                                                      
                            <span class="error-message" id="error_email"></span>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="mobile no" class="label-control"><i class="fas fa-mobile"></i> Mobile No</label>
                            <input class="form-control validateOnlynumbers" name="mobile" maxlength="10" required pattern="[0-9]*" id="userMobile" placeholder="" value="<?php echo $userData['mobile']; ?>" />                                                      
                            <span class="error-message" id="error_contactno"></span>
                        </div>
                    </div>
                    <div class="col-md-6 usermainProfilepic">
                        <div class="form-froup">
                            <label for="mobile no" class="label-control"><i class="fas fa-image"></i> Profile Picture</label>
                        </div>
                        <div class="insidePos">
                            <div class="circle upload-button">
                                <img class="profile-pic img-fluid" src="<?php echo $userData['profilepic']; ?>" />
                            </div>
                            <div class="p-image">
                                <i class="fa fa-camera"></i>
                                <input class="file-upload" type="file" id="userProfile_pic" required accept="image/*" />
                            </div>
                        </div>
                        <span class="error-message" id="error_profilepic"></span>
                    </div>
                    <div class="processLoader"><img class="img-fluid" src="assets/images/gold_loader.gif" alt="loader"></div>
                    <div class="col-md-12 mt-3">
                        <div class="form-group">
                            <button type="button" class="btn btn-sm btn-warning" name="updateuser_Profile" id="update_Userprofile"><i class="far fa-edit"></i> Update Profile</button> &nbsp; &nbsp;
                            <button type="button" class="btn btn-sm btn-outline-danger" onclick="window.location.href='index.php'" name="goback" id="goBack"><i class="fas fa-share fa-rotate-180"></i> Back</button>                            
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<style>
.ags-form-process form#userprofile_Data {
    border: 1px solid #ddd;	
}
.ags-form-process .bulkbooking-form h4 {
	color: #343434;
}
.ags-form-process .bulkbooking-form hr{
	border-top: 1px solid #ddd;
}
.ags-form-process .bulkbooking-form label {
	font-family: 'Open Sans', sans-serif;
    font-size: 12px;
	color: #343434;
    text-shadow: 0px 0px 1px#343434;
}
.ags-form-process .bulkbooking-form input,
.ags-form-process .bulkbooking-form textarea {
    background-color:transparent;
    border: 1px solid #ddd;
    color: #343434;
    font-size: 13px;
}
.ags-form-process .usermainProfilepic .circle {
    border: 4px solid #ddd;
}

</style>
<script type="text/javascript">    
$(document).ready(function() {        
    $('#update_Userprofile').on('click', function(){ 
        var username = $('#username').val();
        var userEmail = $('#userEmail').val();
        var userMobile = $('#userMobile').val();
        var userprofileimg = $('#userProfile_pic').val();        
        var validate = 0;    
        if (userEmail == "") {
            $("#error_email").html('Please enter email');
            validate = 1;
        } else {
            var atpos = userEmail.indexOf("@");
            var dotpos = userEmail.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= userEmail.length) {
                $("#error_email").html('Please enter valid email');                 
                validate = 1;
            } else {
                $("#error_email").html(''); 
            }
        }
        if (userMobile == "") {
            $("#error_contactno").html('Please enter your mobile no');
            validate = 1;
        } else {        
            if (userMobile.length < 10) {
                $("#error_contactno").html('Enter correct mobile no');                
                validate = 1;
            } else {
                $("#error_contactno").html(''); 
            }
        }
        
        if (validate == 1) {
            return false;
        } else {
            $('.processLoader').show();
            $('#update_Userprofile').attr('disabled', true);
            setTimeout(function(){ 

                var fd = new FormData();
                var profilepic = $('#userProfile_pic')[0].files;
                fd.append('email',userEmail);
                fd.append('mobileno',userMobile);

                // Check file selected or not
                if(profilepic.length > 0 )
                    fd.append('profilepic',profilepic[0]);


                $.ajax({
                    type: "POST",
                    url: "classes/updateProfile.php?profileUpdate",
                    data: fd,
                    cache:false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        $('.processLoader').show();
                        $('#update_Userprofile').attr('disabled', true);
                    }, success: function(result) {
                        $('.processLoader').hide();
                        $('#update_Userprofile').attr('disabled', false);                        
                        var data = JSON.parse(result);
                        if(data.type == "success") { 
                            $('#alert_Success').fadeIn();
                            setTimeout(function(){ location.reload(); }, 8000);
                        } else{
                            $('#alert_Error').fadeIn();
                        }
                    }, complete: function (data) {                                         
                        $('.processLoader').hide();
                    }
                });
            }, 5000);
        }
    });      
    var readURL = function(input) {
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('.profile-pic').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    }    
    $(".upload-button").on('click', function() { 
        $(".file-upload").click();         
    });
    $('#userProfile_pic').on('change', function(){
        $("#error_profilepic").html('');
        var ext = $(this).val().split('.').pop().toLowerCase();
        if($.inArray(ext, ['png','jpg','jpeg']) == -1) {            
            $(this).val('');            
            $("#error_profilepic").html('Allowed only jpg and png formats');
            $('img.profile-pic').attr('src', 'assets/images/icons/userImg.jpg');
        } else {
            readURL(this);
            $("#error_profilepic").html('');
        }
    });    
});
</script>