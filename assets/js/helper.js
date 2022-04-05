/*
    AGS Customize common jquery functions
*/

$(document).ready(function() {
    setTimeout(function(){
		$('body').addClass('agspreWebloaded');
	}, 800);

    $(".validateOnlynumbers").keypress(function(event) {
        if (event.keyCode == 13) {
            return true;
        } else {
            return /\d/.test(String.fromCharCode(event.keyCode));
        }  
    }); 
    // OTP Box jQuery   
    $("#otp1").keyup(function() {
        if (this.value.length == this.maxLength) {
            $('#otp2').focus();
        }
    });
    $("#otp2").keyup(function() {
        if (this.value.length == this.maxLength) {
            $('#otp3').focus();
        }
    });
    $("#otp3").keyup(function() {
        if (this.value.length == this.maxLength) {
            $('#otp4').focus();
        }
    });
    $("#otp4").keyup(function() {
        if (this.value.length == this.maxLength) {
            $('#otp4').blur();
        }
    });
});
$(window).scroll(function() {
    if ($(window).scrollTop() > 300) {
        $('#back2Top').addClass('show');
    } else {
        $('#back2Top').removeClass('show');
    }
});
$('#back2Top').on('click', function(e) {
    e.preventDefault();
    $('html, body').animate({scrollTop:0}, '300');
});
  

function togglePassword() {
    if ($("#userPassword").attr("type") == "password") {
        $("#userPassword").attr("type", "text");
        $('.togglePassword').removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        $("#userPassword").attr("type", "password");
        $('.togglePassword').removeClass("fa-eye-slash").addClass("fa-eye");
    }
}

function toggleRegPassword() {
    if ($("#usersignupPassword").attr("type") == "password") {
        $("#usersignupPassword").attr("type", "text");
        $('.toggleregPassword').removeClass("fa-eye").addClass("fa-eye-slash");
    } else {
        $("#usersignupPassword").attr("type", "password");
        $('.toggleregPassword').removeClass("fa-eye-slash").addClass("fa-eye");
    }
}

// Play Movie Trailer Function

function movie_trailer($url) {
	
    if($url != '')
        var html = '<iframe width="100%" height="352" src="'+ $url +'" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>';
    else
        var html = '<img width="100%" height="100%" src="assets/images/video-not-found.png">';

    Swal.fire({
        heightAuto: false,
        customClass: { container: 'swalMovietrailer-window' },
        allowOutsideClick: false,
        title: '',
        padding: '0',
        html:  html,
        showConfirmButton: false,        
        showCloseButton: true,        
        showClass: { popup: 'animated pulse' },
        hideClass: { popup: 'animated fadeOutUp' }
    })
}


