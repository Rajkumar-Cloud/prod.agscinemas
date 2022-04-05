<?php 
    include ('header.php'); 
    // include ('./classes/config.php');
    // $stmt = $link->prepare("SELECT * FROM `cinema` ORDER BY `Cin_Id` ASC");
    // $stmt->execute();
    // $theatre_count = $stmt->rowCount();

    $handle = curl_init();
    $url = "http://3.109.167.11/classes/php/moviejson.json";
    // $url = "http://123.176.34.84:8081/api/VistaRemote/SynchData";
    // $url = "http://49.207.181.204:8080/api/VistaRemote/SynchData";
    curl_setopt($handle, CURLOPT_URL, $url);    
    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($handle, CURLOPT_CONNECTTIMEOUT, 0); 
    curl_setopt($handle, CURLOPT_TIMEOUT, 300);
    $output = curl_exec($handle);    
    curl_close($handle);
    $json = json_decode($output, true);    
    $cinemasarr = $json['Cinemas'];
    $cinemasarr_count = count($cinemasarr);
    

?>
<section class="bulk-booking-wrapper default-bg ags-form-process">
    <div class="container">
        <div class="col-md-10 offset-md-1">
	    <form class="bulkbooking-form" id="bulkbooking-form" autocomplete="off">
                <input type="hidden" name="userId" id="userId" value="<?php if(isset($_COOKIE['userid']) && $_COOKIE['userid'] !='' ) { echo $_COOKIE['userid']; } ?>" />
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <h4><i class="fas fa-clipboard-list"></i> AGS - Bulk Ticket Booking</h4> <hr />
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="theater" class="label-control"><img class="img-fluid" src="assets/images/icons/film.png" alt="" /> Select Theatre</label>
                            <select class="form-control" required name="theater-list" id="theatername_list">
                                <option value="">Select Theatre</option>                                
                                <?php if($cinemasarr_count != 0) {
                                    for($i = 0; $i < $cinemasarr_count; $i++) {
                                        $CinemaID = $cinemasarr[$i]['CinemaID'];
                                        $CinemaName = $cinemasarr[$i]['CinemaName'];
                                        echo "<option value='".$CinemaName."' data-id='".$CinemaID."'>".$CinemaName."</option>";
                                    }
                                  } else {
                                        echo "<option value=''>No theater's found</option>";
                                  }
                                ?>
                            </select>
                            <span class="error-message" id="error_theatre"></span>
                        </div>                        
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="movie" class="label-control"><i class="fas fa-film"></i> Select Movie</label>
                            <select class="form-control" name="movie-list" required id="movie_list">
                                <option value="">Select Movie</option> 
                            </select>
                            <span class="error-message" id="error_movie"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="date" class="label-control"><i class="fas fa-calendar-week"></i> Select Date</label>                  
                            <input list="booking_date" class="form-control" required name="booking-date" id="booking-date" placeholder="Select date" hidden="" />
                            <datalist id="booking_date"></datalist>
                            <input type="text" class="form-control datepicker" required name="booking-datepic" id="booking-datepic" placeholder="Select date" />
                            <span class="error-message" id="error_bookingdate"></span>
                        </div>                      

                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="time" class="label-control"><i class="fas fa-clock"></i> Select Time</label> 
                            <select class="form-control" required name="booking-time" id="booking-time">
                                <option value="">Select Time</option>
                            </select>                                                       
                            <!-- <input list="booking_time" class="form-control" required name="booking-time" id="booking-time" placeholder="Select Time" hidden="" />
                            <datalist id="booking_time"></datalist>
                            <input type="text" class="form-control timepicker" required name="booking-timepic" id="booking-timepic" placeholder="Select Time" /> -->
                            <span class="error-message" id="error_bookingtime"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="quantity" class="label-control"><i class="fas fa-layer-group"></i> Ticket Quantity</label>
                            <input type="text" class="form-control validateOnlynumbers" maxlength="2" name="ticket-quantity" required id="ticket-quantity" placeholder="Enter Ticket quantity(Min 30)" />
                            <span class="error-message" id="error_quantity"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="company name" class="label-control"><i class="fas fa-building"></i> Company name</label>
                            <input type="text" class="form-control" name="company-name" required id="company-name" placeholder="Company name" />                          
                            <span class="error-message" id="error_company"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="email" class="label-control"><i class="far fa-envelope"></i> Email Address</label>
                            <input type="email" class="form-control" required name="email-address" id="email-address" placeholder="Enter Email address" />                          
                            <span class="error-message" id="error_email"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group">
                            <label for="contact person" class="label-control"><i class="fas fa-user-check"></i> Contact person name</label>
                            <input class="form-control" name="contact-person-name" required id="contact-person-name" placeholder="Enter contact person name" />                          
                            <span class="error-message" id="error_cperson"></span>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="form-group" >
                            <label for="contact no" class="label-control"><i class="fas fa-mobile-alt"></i> Contact No</label>
                            <div class="input-group" style="position:relative">
                                <div class="input-group-prepend"><span class="input-group-text"><img class="img-fluid" src="assets/images/icons/india-flag.png" alt="india-flag">&nbsp;+91</span></div>
                                <input type="text" class="form-control validateOnlynumbers" name="contact-no" maxlength="10" pattern="[0-9]*" required id="contact-no" placeholder="Enter mobile no" />
                                <button type="button" class="btn btn-sm btn-primary" id="getOtp_bulkbooking" name="getOtp_bulkbooking" title="Click the button to getting otp from given mobile no"><i class="fa fa-unlock" aria-hidden="true"></i> Send OTP</button>    
                            </div>
                            <input type="text" maxlength="4" class="form-control validateOnlynumbers" name="mobileNo-otp" id="mobileNo-otp" placeholder="Enter OTP" />
                            <div id="otpVerify__status" style="display: none;"></div>
                            <span class="error-message" id="error_contactno"></span>                            
                        </div>
		    </div>
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="address" class="label-control"><i class="far fa-address-card"></i> Address</label>
                            <textarea class="form-control" name="contact-address" id="contact-address" rows="2" required placeholder="Enter Address"></textarea>
                            <span class="error-message" id="error_caddress"></span>
                        </div>
                    </div>
                    <div class="processLoader"><img class="img-fluid" src="assets/images/gold_loader.gif" alt="loader" /></div>
                    <div class="col-md-12 pull-right">
                        <button type="button" class="btn btn-warning mr-2" name="bulkbooking-btn" id="bulkbooking-btn"><i class="fas fa-swatchbook"></i> Bulk Booking</button>
                        <button type="reset" class="btn btn-outline-danger" name="reset"><i class="fas fa-eraser"></i> Clear</button>
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
.ags-form-process .bulkbooking-form select,
.ags-form-process .bulkbooking-form textarea {
    background-color:transparent;
    border: 1px solid #ddd;
    color: #343434;
    font-size: 13px;
}
.ags-form-process .bulkbooking-form .input-group-text{
	background-color: #00000014;
    color: #343434;
    border-color: #ddd;
}
.ags-form-process .bulkbooking-form label img {
	width: 14px;
}
.ags-form-process .usermainProfilepic .circle {
    border: 4px solid #ddd;
}
#getOtp_bulkbooking {
    position: absolute;
    right: 0;
    bottom:-22px;
    font-size: 10px;
    padding: 0px 4px;
    background: #2778c4;
    border-radius: 2px;
}

#mobileNo-otp {
    display: none;
    margin-top: 4px;
    width: 35%;
    padding: 4px 5px;
    font-size: 14px;
    font-weight: 800;
    line-height: 0;
    height: auto;
}
#mobileNo-otp::placeholder {
    font-weight: bold;
    font-size: 10px;
}
#otpVerify__status p {
    font-size: 12px;
    color: #2778c4;
    font-weight: 600;
    margin: 0 auto;
}


</style>
<script type="text/javascript">
     $(function () {           
        $('.datepicker').datetimepicker({
            // defaultDate: new Date(),
            format:'DD/MM/YYYY',
            // maxDate: new Date
        });
       /* $('.timepicker').datetimepicker({
            format: 'hh:mm:ss a'
        });*/
    });
    $('.datepicker, .timepicker').keypress(function(e) { e.preventDefault(); });

    
    $(document).ready(function() {
        // Get Theater List From Cinema Table

        $("#movie_list").prop("disabled", true);
        $("#booking-date").prop("disabled", true);
        $("#booking-time").prop("disabled", true);
        $(".datepicker").prop("disabled", true);

        $("#theatername_list").on('change', function() {
            $('#booking_date').find('option').remove().end().append('<option value=""></option>').val('');
            $('#booking-time').find('option').remove().end().append('<option value=""></option>').val('');
            $('#movie_list').find('option').remove().end().append('<option value="">Select Movie</option>').val(''); 
            $("#movie_list").prop("disabled", true);
            $("#booking-date").prop("disabled", true);
            $("#booking-time").prop("disabled", true);
            $(".datepicker").prop("disabled", true);

            $("#movie_list").val('');
            $("#booking-date").val('');
            $("#booking-time").val('');
            var theaterID = $(this).find("option:selected").text();
            var cinemaID = $(this).find("option:selected").data("id");            
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/bulkbooking.php?bulkbookingMovieData",
                data: {theaterID: theaterID, cinemaID:cinemaID },
                beforeSend: function() {
                    $("#movie_list").prop("disabled", true);
                },
                success:function(result) {  
                $('#movie_list').find('option').remove().end().append('<option value="">Select Movie</option>').val('');      
                    $("#movie_list").prop("disabled", false);           
                    $.each(result,function(i,obj) {                      
                        var movie_list = '<option value="'+obj.FilmTitle+'" data-cinemaid="'+obj.CinemaID+'" data-filmcode="'+obj.FilmCode+'">'+obj.FilmTitle+'</option>';
                        $(movie_list).appendTo('#movie_list');
                    }); 
                }
            });
        });

        $('#movie_list').on('change', function() {
            var cinemaID = $(this).find("option:selected").data("cinemaid");
            var FilmCode = $(this).find("option:selected").data("filmcode");
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/bulkbooking.php?bulkbookingSelectedMovieDate",
                data: {cinemaID: cinemaID, FilmCode:FilmCode },
                beforeSend: function() {
                    $("#booking-date").prop("disabled", true);
                    $(".datepicker").prop("disabled", true);

                },
                success:function(result) {  
                    $('#booking_date').find('option').remove().end().append('<option value=""></option>').val(''); 
                    $("#booking-date").prop("disabled", false);  
                    $(".datepicker").prop("disabled", false);

                    var groups = [];
                    var groupedPeople;
                    
                    result.sort(function (x, y) {
                        let a = x.ShowDate,
                        b = y.ShowDate;
                        return new Date(b) - new Date(a);
                    });
                    result.sort(function (x, y) {
                        let a = x.SessionId,
                        b = y.SessionId;
                        return a - b;
                    });
                    var groupedPeople = groupBy(result, 'ShowDate'); 
                    var i = result.length - 1;


                    $.each(groupedPeople,function(k,obj2) {
                        var date = k;
                        var movie_time = '<option value="'+date+'" data-cinemaid="'+obj2[0].CinemaID+'" data-filmcode="'+obj2[0].FilmCode+'" data-Showdate="'+date+'">';
                        $(movie_time).appendTo('#booking_date');                    
                    });  


                    $('.datepicker').data("DateTimePicker").minDate(result[0].ShowDate);
                    $('.datepicker').data("DateTimePicker").maxDate(result[i].ShowDate);
                }
            });    
        });

       

        $("#booking-datepic").on('dp.change', function (e) {
            $('#booking-time').find('option').remove().end().append('<option value="">Select Time</option>').val('');
            var val = e.date._i;
            $("#booking-date option").val(this.value);
            if($('#booking_date option').filter(function(){
                return this.value.toUpperCase() === val.toUpperCase();        
            }).length) {
                var cinemaID = $('#booking_date option').filter(function() { return this.value.toUpperCase() === val.toUpperCase(); }).data("cinemaid");
                var FilmCode = $('#booking_date option').filter(function() { return this.value.toUpperCase() === val.toUpperCase(); }).data("filmcode");

                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "classes/bulkbooking.php?bulkbookingSelectedMovieDateTime",
                    data: {cinemaID: cinemaID, FilmCode:FilmCode, ShowDate: val },
                    beforeSend: function() {
                        $('#booking-time').find('option').remove().end().append('<option value="">Select Time</option>').val('');
                        $("#booking-time").prop("disabled", true);
                    },
                    success:function(result) {  
                        $('#booking-time').find('option').remove().end().append('<option value="">Select Time</option>').val('');
                        $("#booking-time").prop("disabled", false);                       
                        $.each(result,function(i,obj) {  
                            var movie_time = '<option value="'+obj.ShowTime+'" data-cinemaid="'+obj.CinemaID+'" data-filmcode="'+obj.FilmCode+'" data-showdate="'+obj.ShowDate+'">'+obj.ShowTime+'</option>';
                            $(movie_time).appendTo('#booking-time');                        
                        });  
                    }
                });
            }
        });

        /*$("#booking-date").on('input', function () {
            var val = this.value;
            if($('#booking_date option').filter(function(){
            return this.value.toUpperCase() === val.toUpperCase();        
            }).length) {
                var cinemaID = $('#booking_date option').filter(function() { return this.value.toUpperCase() === val.toUpperCase(); }).data("cinemaid");
                var FilmCode = $('#booking_date option').filter(function() { return this.value.toUpperCase() === val.toUpperCase(); }).data("filmcode");
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "classes/bulkbooking.php?bulkbookingSelectedMovieDateTime",
                    data: {cinemaID: cinemaID, FilmCode:FilmCode, ShowDate: val },
                    beforeSend: function() {
                        $("#booking-time").prop("disabled", true);
                    },
                    success:function(result) {  
                        $('#booking_time').find('option').remove().end().append('<option value=""></option>').val('');
                        $("#booking-time").prop("disabled", false);                       
                        $.each(result,function(i,obj) {  
                            var movie_time = '<option value="'+obj.ShowTime+'" data-cinemaid="'+obj.CinemaID+'" data-filmcode="'+obj.FilmCode+'" data-showdate="'+obj.ShowDate+'">';
                            $(movie_time).appendTo('#booking_time');                        
                        });  
                    }
                });
            }
        });*/
          
    });

    function groupBy(objectArray, property) {
        return objectArray.reduce((acc, obj) => {
            const key = obj[property];
            if (!acc[key]) { acc[key] = []; }        
            acc[key].push(obj);
            return acc;
        }, {});
    }
</script>