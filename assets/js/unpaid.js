$(document).ready(function() {
    setTimeout(function(){

    }, 800);

    $(".validateOnlynumbers").keypress(function(event) {
        if (event.keyCode == 13) {
            return true;
        } else if (this.value.length == 0 && event.which == 48 ){
            return false;
        } else {
            return /\d/.test(String.fromCharCode(event.keyCode));
        }
    });

    $('#submit_userdetails').on('click', function() {
        var username = $('#username').val();
        var email = $('#emailId').val();
        var contact_no = $('#mobileNo').val();
        var validate = 0;
        if(username == '') {
            $("#username_err").html('Username field is required');
            validate = 1;
        } else {      
            if (username.trim().length < 3) {
                $("#username_err").html('Enter valid name');                
                validate = 1;
            } else {
                $("#username_err").html('');
            }            
        }
        if (email == "") {
            $("#emailId_err").html('Email address field is required');
            validate = 1;
        } else {
            var atpos = email.indexOf("@");
            var dotpos = email.lastIndexOf(".");
            if (atpos < 1 || dotpos < atpos + 2 || dotpos + 2 >= email.length) {
                $("#emailId_err").html('Enter valid email address');                 
                validate = 1;
            } else {
                $("#emailId_err").html('');
            }
        }
        if (contact_no == "") {
            $("#mobileno_err").html('Mobile number field is required');
            validate = 1;
        } else {        
            if (contact_no.length < 10) {
                $("#mobileno_err").html('Enter valid mobile no');                
                validate = 1;
            } else {
                $("#mobileno_err").html('');
            }
        }
        if (validate == 1) {
            return false;
        } else {
            // $('.processLoader').css('display','flex');
            // $.ajax({
            //     type: "POST",
            //     url: "classes/unpaid_payment.php?unpaid_payment",
            //     data: {"username": username, "email": email, "mobileno": contact_no },                
            //     success:function(response) {  
                    
            //     }
            // });
        }      
    });

    $('#reset_values').on('click', function() {
        $("#username_err").html('');
        $("#emailId_err").html('');
        $("#mobileno_err").html('');
    });
    
    
});
