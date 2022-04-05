<?php 
$title = "Admin User Creation";
$description = "Admin User Cration and Admin Approval to register";
$keywords = "Admin User Cration and Admin Approval to register";
include("classes/config.php");
$role_sql = $link->query("SELECT `role`,`role_code`,`status` FROM `roles` WHERE `status`='1' GROUP BY `role_code` ORDER BY `role_code` ASC");
include('header.php');
?>

<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Admin Approvals</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Admin access approvals</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
						<h5>Admin Accessibility</h5>
					</div>
                    <div class="card-body">
						<ul class="nav nav-tabs mb-3" role="tablist">
							<li class="nav-item">
								<a class="nav-link active text-captitalize" id="adduser-tab" data-toggle="tab" href="#adminuser_creation" role="tab" aria-controls="add profile" aria-selected="true"><span class="feather f-15 icon-user-plus"></span> Add Dashboard Users</a>
							</li>
							<li class="nav-item">
								<a class="nav-link text-captitalize" id="viewuser-tab" data-toggle="tab" href="#admin_profile_list" role="tab" aria-controls="delete profile" aria-selected="false"><span class="feather f-15 icon-eye"></span> View Dashboard Profiles</a>
							</li>
						</ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="adminuser_creation" role="tabpanel" aria-labelledby="adduser-tab">
                                <form id="userRegisterFrm" name="userRegisterFrm" method="POST" action="">                                
                                    <div class="row mt-4">                                        
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="floating-label" for="username">User Name</label>
                                                <input type="text" required class="form-control" id="userName" autocomplete="off" name="userName" placeholder="" />
                                                <span class="error__message" id="error_username"></span>
                                            </div>
                                        </div> 
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label class="floating-label" for="Email">Email address</label>
                                                <input type="email" required class="form-control" id="userEmail" autocomplete="off" name="userEmail" placeholder="" />
                                                <span class="error__message" id="error_email"></span>  
                                            </div>
                                        </div>  
                                        <div class="col-md-4">
                                            <div class="form-group mb-3">
                                                <label class="floating-label" for="mobile no">Mobile No</label>
                                                <input type="text" maxlength="10" required class="form-control numberonly" id="userMobileno" name="userMobileno" placeholder="" />
                                                <span class="error__message" id="error_mobile"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label class="floating-label" for="Password">Password</label>
                                                <input type="password" required class="form-control" id="userPassword" name="userPassword" autocomplete="off" placeholder="" />
                                                <span class="error__message" id="error_password"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group mb-4">
                                                <label class="floating-label" for="Password">Confirm Password</label>
                                                <input type="password" required class="form-control" id="userconfirmPassword" name="userconfirmPassword" autocomplete="off" placeholder="" />
                                                <span class="error__message" id="error_cpassword"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                          
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <label for="assign role" class="col-sm-3 col-form-label">Assign Role</label>
                                                    <div class="col-sm-9">
                                                    <?php while ($role_data = $role_sql->fetch()) { ?>                                                        
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userRoleassign" id="<?php echo preg_replace('/\s+/', '', $role_data['role']); ?>Role" value="<?php echo $role_data['role_code'];?>" />
                                                            <label class="form-check-label" for="<?php echo $role_data['role'];?>"><?php echo $role_data['role'];?></label>
                                                        </div>
                                                    <?php } ?>    
                                                    <span class="error__message" id="error_role"></span>                                                    
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div> 
                                        <div class="col-md-6">                                          
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <label for="assign location" class="col-sm-5 col-form-label">Location Access</label>
                                                    <div class="col-sm-7">                                                                                                         
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userLocationaccess" value="5" />
                                                            <label class="form-check-label" for="All">All</label>
                                                        </div> 
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userLocationaccess" value="1" />
                                                            <label class="form-check-label" for="TNagar">AGS T.Nagar</label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userLocationaccess" value="2" />
                                                            <label class="form-check-label" for="Navalur">AGS Navalur</label>
                                                        </div>   
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userLocationaccess" value="3" />
                                                            <label class="form-check-label" for="Villivakkam">AGS Villivakkam</label>
                                                        </div> 
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" name="userLocationaccess" value="4" />
                                                            <label class="form-check-label" for="Alapakkam">AGS Alapakkam</label>
                                                        </div>     
                                                        <span class="error__message" id="error_userlocation"></span>                                                                                                                                                 
                                                    </div>
                                                </div>
                                            </fieldset>
                                        </div>                                        
                                        <div class="col-md-6">                                          
                                            <fieldset class="form-group">
                                                <div class="row">
                                                    <label for="assign location" class="col-sm-5 col-form-label">Give Access</label>
                                                    <div class="col-sm-7 mt-2">                                                                                                         
                                                        <div class="custom-control custom-switch">
                                                            <input type="checkbox" class="custom-control-input" name="userAccessper_status" id="customswitch1" value="1" checked="" />
                                                            <label class="custom-control-label badge badge-light-success" id="customswitch1_lbl" for="customswitch1" style="cursor:pointer;">Active</label>
                                                        </div>
                                                    </div> 
                                                </div> 
                                            </fieldset>
                                        </div>               
                                        <div class="col-md-12"><div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div></div>                       
                                        <div class="col-md-12 text-right"> <hr />
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="addadmin_newuser_btn" name="addadmin_newuser_btn mr-2"><i class="feather icon-check-circle"></i> Submit</button>
                                            <button type="reset" class="btn btn-sm btn-outline-warning has-ripple"><i class="feather icon-delete"></i> Reset<span class="ripple ripple-animate" style="height: 71.625px; width: 71.625px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -17.2031px; left: 9.17969px;"></span></button>
                                        </div>                                                                                                                                                        
                                    </div>
                                </form>
							</div>
							<div class="tab-pane fade" id="admin_profile_list" role="tabpanel" aria-labelledby="viewuser-tab">
                                <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div>
                                <div class="table-responsive">
                                    <table id="adminProfileList_tbl" class="table display dataTable table-condensed mb-2">
                                        <thead>
                                            <tr>                                                                  
                                                <th>User Id</th>
                                                <th>User Name</th>
                                                <th>Email</th>
                                                <th>Mobile No</th>                                                
                                                <th>User Role</th> 
                                                <th>Location</th>                                                                                      
                                                <th>Status</th>           
                                                <th>Created Date</th>
                                                <th>Action</th>                          
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                    </table>                            
                                </div>
                            </div>							
						</div>
					</div>
                </div>
            </div>                
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        $('input:checkbox[name="userAccessper_status"]').change(function() {          
            if (this.checked) {                
                $('input:checkbox[name="userAccessper_status"]').val('1');
                $('#customswitch1_lbl').text("Active");
                $('#customswitch1_lbl').removeClass('badge-light-danger');
                $('#customswitch1_lbl').addClass('badge-light-success');
            } else {                
                $('input:checkbox[name="userAccessper_status"]').val('0');
                $('#customswitch1_lbl').text("In Active");
                $('#customswitch1_lbl').removeClass('badge-light-success');
                $('#customswitch1_lbl').addClass('badge-light-danger');
            }
        });
        $("#addadmin_newuser_btn").on('click', function () {
            var userName = $("#userName").val();
            var userEmail = $('#userEmail').val();                    
            var userMobileno = $('#userMobileno').val();
            var userPassword = $('#userPassword').val();
            var confirmPassword = $('#userconfirmPassword').val();
            var roleAssign = $("input[name='userRoleassign']:checked").val();
            var user_location = $("input[name='userLocationaccess']:checked").val();
            var access_status = $("input[name='userAccessper_status']").prop("checked") ? 1 : 0 ;            
            var validate = 0;   
            if (userName == "") {
                $("#error_username").html('Please enter your name');
                validate = 1;
            } else {    
                $("#error_username").html('');             
            }            
            if (userEmail == "") {
                $("#error_email").html('Please enter your email');
                validate = 1;
            } else { 
                var atpos = userEmail.indexOf("@");
                var dotpos = userEmail.lastIndexOf(".");
                if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= userEmail.length) {
                    $("#error_email").html('Please enter valid email'); 
                    $('#userEmail').val('');
                    validate = 1;
                } else {
                    $("#error_email").html(''); 
                }
            }
            if (userMobileno == "") {
                $("#error_mobile").html('Please enter your mobile no');
                validate = 1;
            } else {        
                if (userMobileno.length < 10) {
                    $("#error_mobile").html('Enter valid mobile no'); 
                    $('#error_mobile').val('');
                    validate = 1;
                } else {
                    $("#error_mobile").html(''); 
                }
            }
            if (userPassword == "") {
                $("#error_password").html('Please enter your password');
                validate = 1;
            } else {                        
                if (userPassword.length < 8) {            
                    $("#error_password").html('Password should be a minimum  8 characters'); 
                    $('#userPassword').val('');
                    validate = 1;
                } else {
                    $("#error_password").html(''); 
                }
            }
            if (confirmPassword == "") {
                $("#error_cpassword").html('Please enter confirm password');
                validate = 1;
            } else {        
                if (userPassword != confirmPassword) {
                    $("#error_cpassword").html('Password and confirm password does not match.'); 
                    $('#userconfirmPassword').val('');
                    validate = 1;
                } else {
                    $("#error_cpassword").html(''); 
                }
            }
            if($("input[name='userRoleassign']").is(":checked")) {                
                $("#error_role").html('');                
            } else {
                $("#error_role").html('Please select assign role');
                validate = 1;
            }
            if($("input[name='userLocationaccess']").is(":checked")) {                             
                $("#error_userlocation").html('');                
            } else {
                $("#error_userlocation").html('Please select any one location');
                validate = 1;
            }
            if (validate == 1) {
                return false;
            } else {
                $('.processLoader').show();
                $('#addadmin_newuser_btn').attr('disabled', true);
                setTimeout(function() { 
                    $.ajax({ 
                        url: "classes/userControl.php?userRegister",
                        type: "POST", 
                        data: {
                            userName: userName, 
                            userEmail: userEmail,
                            userMobileno: userMobileno,
                            userPassword: userPassword,
                            roleAssign: roleAssign,
                            user_location: user_location,
                            access_status: access_status                        
                        },                        
                        success: function(response) {   
                            var data = JSON.parse(response);      
                            $('#addadmin_newuser_btn').attr('disabled', false);                       
                            if(data.status == "success") {
                                $.toast({
                                    heading: 'Success',
                                    text: 'This user details has been registered successfully',
                                    showHideTransition: 'fade',
                                    icon: 'success',
                                    position: 'top-center',
                                    stack: false,
                                    hideAfter: 6000
                                });                                
                                $('#userRegisterFrm')[0].reset();
                            } else if(data.status == "exist") {
                                $.toast({
                                    heading: 'Email Id Exist',
                                    text: 'Given email address already registered in our database.',
                                    showHideTransition: 'fade',
                                    icon: 'warning',
                                    position: 'top-center',
                                    stack: false,
                                    hideAfter: 8000
                                });  
                                $('#userEmail').val('');             
                            } else {
                                $.toast({
                                    heading: 'Error',
                                    text: 'Failed to update your record',
                                    showHideTransition: 'fade',
                                    icon: 'error',
                                    position: 'top-center',
                                    stack: false                                  
                                });
                                $('#userRegisterFrm')[0].reset();
                            }                                
                        },
                        complete: function (data) {                                         
                            $('.processLoader').hide();
                        },
                        error: function(data) {

                        } 
                    });
                }, 3000);
            }
        });
        $('.numberonly').keypress(function (e) {        
            var charCode = (e.which) ? e.which : event.keyCode    
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                return false;                        
        });

        $('#adminProfileList_tbl').DataTable({
            "processing": true,
            "serverSide": true,                    
            "ajax": "../ags-dashboard/classes/admin_user_profiles.php",
            "order": [[ 0, "asc" ]],       
            fixedHeader: {
               header: true,
               footer: true
            },
            "columnDefs": [  
               {
                targets: 5,
                render: function (data1, type, row, meta) {
                  if (type === 'display') {
                    if(data1 == 1) { data1 = '<span>T.Nagar</span>'; }
                    else if(data1 == 2) { data1 = '<span>Navalur</span>'; }                    
                    else if(data1 == 3) { data1 = '<span>Villivakkam</span>'; } 
                    else if(data1 == 4) { data1 = '<span>Alapakkam</span>'; }
                    else if(data1 == 5) { data1 = '<span>All</span>'; }
                  }
                  return data1;
                }                
              },  
              {
                targets: 6,
                render: function (data2, type, row, meta) {
                  if (type === 'display') {
                    if(data2 == 1) { data2 = '<button type="button" name="userstatus_update" onclick="userStatus_update('+row['0']+','+row['6']+');" class="badge badge-light-success">Active</button>'; }                    
                    else { data2 = '<button type="button" name="userstatus_update" onclick="userStatus_update('+row['0']+','+row['6']+');" class="badge badge-light-danger">In Active</button>'; } 
                  }
                  return data2;
                }                
              },           
              {
                targets: 8,
                "orderable": false,
                className: 'text-center',
                render: function (data_action, type, row, meta) {
                  if (type === 'display') {                                                             
                    data_action = '<button type="button" title="Reset password" onclick="pwdResetAdmin_user('+row['0']+');" class="btn btn-sm btn-icon btn-outline-primary has-ripple" style="width:22px;height:22px;font-size: 10px;"><i class="feather icon-unlock"></i><span class="ripple ripple-animate" style="height:30px; width:30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -2.21094px; left: -8.92188px;"></span></button> | <button type="button" title="Delete User" onclick="deleteAdmin_user('+row['0']+');" class="btn btn-sm btn-icon btn-outline-danger has-ripple" style="width:22px;height:22px;font-size: 10px;"><i class="feather icon-trash"></i><span class="ripple ripple-animate" style="height:30px; width:30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -2.21094px; left: -8.92188px;"></span></button>';
                  }
                  return data_action;
                }                
              }
            ]            
        });
        $('#viewuser-tab').on('click', function(){
            $('#adminProfileList_tbl').DataTable().ajax.reload();
        });
        
    });
    function deleteAdmin_user(rowId) {
        if (confirm('Sure want to delete this user?')) {
            setTimeout(function() { 
                $.ajax({ 
                    url: "classes/userControl.php?userAdmin_deletion",
                    type: "POST", 
                    data: { rowId: rowId },                        
                    success: function(response) {   
                        var data = JSON.parse(response);                            
                        if(data.status == "success") {
                            $.toast({
                                heading: 'Success',
                                text: 'This user has been deleted successfully!',
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'top-center',
                                stack: false,
                                hideAfter: 6000
                            });                              
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: 'Failed to delete this record!',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-center',
                                stack: false,  
                                hideAfter: 4000                            
                            });
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        }                             
                    },
                    complete: function (data) {                                         
                        $('.processLoader').hide();
                    }
                });
            }, 100);
        }
    }
    function pwdResetAdmin_user(rowId) {
            setTimeout(function() { 
                $.ajax({ 
                    url: "classes/userControl.php?userAdmin_pwdreset",
                    type: "POST", 
                    data: { rowId: rowId },                        
                    success: function(response) {   
                        var data = JSON.parse(response);                         
                        if(data.status == "success") {
                            $.toast({
                                heading: 'Success',
                                text: 'Reset password link has been sent. please check your email!',
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'top-center',
                                stack: false,
                                hideAfter: 8000
                            });                              
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: data.message,
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-center',
                                stack: false,  
                                hideAfter: 6000                            
                            });
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        }                             
                    },
                    complete: function (data) {                                         
                    }
                });
            }, 100);
    }
function userStatus_update(rowId, status) {
        if(status == 1) { status = 0; } else { status = 1; }  
        if (confirm('Sure want to update this user status?')) {
            setTimeout(function() { 
                $.ajax({ 
                    url: "classes/userControl.php?userAdmin_statusUpdation",
                    type: "POST", 
                    data: { rowId: rowId, status: status },                        
                    success: function(response) {   
                        var data = JSON.parse(response);                            
                        if(data.status == "success") {
                            $.toast({
                                heading: 'Success',
                                text: 'This user status has been updated!',
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'top-center',
                                stack: false,
                                hideAfter: 4000
                            });                              
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        } else {
                            $.toast({
                                heading: 'Error',
                                text: 'Failed to update this record!',
                                showHideTransition: 'fade',
                                icon: 'error',
                                position: 'top-center',
                                stack: false,  
                                hideAfter: 4000                            
                            });
                            $('#adminProfileList_tbl').DataTable().ajax.reload();
                        }                             
                    },
                    complete: function (data) { }
                });
            }, 100);
        }
    }
</script>