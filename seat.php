<?php 
    include ('header.php');
    $movieId = $_SESSION['movieId'];
    $Cin_Id = $_SESSION['Cin_Id'];
    $movie_Name = $_SESSION['movie_Name'];
    $movie_Language = $_SESSION['movie_Language'];
    $movie_Censor = $_SESSION['movie_Censor'];
    $movie_Genre = $_SESSION['movie_Genre'];
    $movie_runTime = $_SESSION['movie_runTime'];
    $movie_location = $_SESSION['movie_location'];
    $movie_showtime = $_SESSION['movie_showtime'];
    $movie_date = $_SESSION['movie_date'];
    $movie_screen = $_SESSION['movie_screen'];
    $movie_tickvalue = $_SESSION['movie_tickvalue'];    
  
?>   
<div class="seat__main_movie_bar">
    <div class="container">
        <div class="row">
            <div class="col-8 col-md-10">
                <div class="movie_title">
                    <div class="backbtn"><button type="button" onclick="window.history.go(-1); return false;" title="Go Back"><i class="fas fa-chevron-left"></i></button></div>
                    <div class="movie-box">
                        <h4><?php echo $movie_Name." - ".$movie_Genre?>
                        <!-- <span class="censor">UA</span></h4> -->
                        <p><i class="fas fa-map-marker-alt"></i> <?php echo $movie_location.", Chennai";?></p>
                    </div>
                </div>
            </div>
            <div class="col-3 col-md-2">
                <div class="seat_selection">
                    <p>Select seat</p>
                    <select name="noof_seats" id="noof_movie_ticket" class="form-control">                        
                        <option value="1" <?php if($movie_tickvalue == 1) echo "selected"; ?>>1 Ticket</option>
                        <option value="2" <?php if($movie_tickvalue == 2) echo "selected"; ?>>2 Tickets</option>
                        <option value="3" <?php if($movie_tickvalue == 3) echo "selected"; ?>>3 Tickets</option>
                        <option value="4" <?php if($movie_tickvalue == 4) echo "selected"; ?>>4 Tickets</option>
                        <option value="5" <?php if($movie_tickvalue == 5) echo "selected"; ?>>5 Tickets</option>                                    
                    </select>                    
                </div>
            </div>
        </div>
    </div>
    <div class="subdetail__main_movie_bar">
        <div class="container">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="showDates">
                        <p><i class="fas fa-calendar-day"></i> <?php echo date('l, d M', strtotime($movie_date)).', '.$movie_showtime; echo "&nbsp;&nbsp|&nbsp"; echo $movie_screen; ?></p>
                        <!-- <ul>
                            <li><a href="javascript:void(0)" class="btn btn-sm btn-success"><i class="far fa-clock"></i> <?php echo $movie_showtime; ?></a></li>
                        </ul> -->
            <ul id="loadedShowtime"></ul>                        
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

<section class="seat-booking-wrapper default-bg">
    <div class="container" id="seat-layout">
        <div class="row">         
            <div class="col-md-12">
                <div class="theaterseat-container"> 
             <div class="table-responsive">
                         <div id="seat-map"></div>
                     </div>
                </div>
            </div>
            <div class="col-md-12">
                <div class="mainscreen_image">  
                    <p>All eyes this way please!</p>
                    <div class="theater-projector-screen"></div>                    
                </div>
            </div>
        </div>   
    </div>
    <div class="container" id="seat-layout-error" hidden="">
        <div class="row">         
            <div class="col-md-12">
                <img src="assets/images/Oops.png" class="img-fluid" alt="oops" />
            </div>
        </div>   
    </div>
    <div class="clearfix"></div>
    <section class="seat__detailed__desc_panel">
        <ul>
            <li><span class="occupied"></span> Occupied</li>
            <li><span class="available"></span> Available</li>
            <li><span class="selected"></span> Selected</li>
            <!-- <li><span class="socialDistance fas fa-shield-virus"></span> Social Distancing Seats</li> -->        
        </ul>
    </section>
    <div class="seat__booking_confirm_panel seat-booking-btn">
        <div class="text-center">
            <button class="proceed" id="proceedto_pay" type="button" name="seat_booking" onclick="seat_proceed()" data-toggle="tooltip" title="Proceed to pay!">Pay Rs. <span id="total"></span></button>
            <div class="seat">SEATS: <p id="seat_no"></p></div>
        </div>
    </div>

</section>

<!-- Midnight show panel  -->
<div class="modal fade animated agsmidnightshow_confirmpanel" id="ags_midnight_show" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Midnight show - Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <div class="nightshow_content">
                        <span class="fas fa-exclamation-triangle"></span>
                        <p>Please note that this is a <b>MIDNIGHT</b> show.<br />Kindly confirm to go ahead with the booking.</b></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">         
                <button type="button" class="btn btn-outline-primary btn-sm" id="acceptance_agsMidnightShow" value="true"><i class="fas fa-check-circle"></i> Confirm</button>
            </div>
        </div>
    </div>  
</div>

<!-- Covid show panel  -->
<div class="modal fade animated covid_confirmpanel" id="ags_covid" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Covid 19 Vaccine - Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="col-md-12 text-center">
                    <div class="nightshow_content">
                        <span class="fas fa-exclamation-triangle"></span>
                        <p><b>As per the State Government Guidelines, In order to enter the cinema, It is mandatory to have Covid 19 Vaccine, for patrons above 18 years old. Vaccination certificate will be verified at the cinema entry, no entry will be permitted for non-vaccinated patrons and tickets will not be refunded.</b></p>
                    </div>
                </div>
            </div>
            <div class="modal-footer text-center">
                <button type="button" class="cancel btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="fas fa-undo-alt"></i> Cancel</button>
                <button type="button" class="accept btn btn-primary btn-sm" id="acceptance_covid" value="true"><i class="fas fa-check-circle"></i> Accept</button>
            </div>
        </div>
    </div>  
</div>

<?php include('footer.php'); ?>
<style>
ul#loadedShowtime li .show-timing {
font-size:11px;
}
</style>
<script type="text/javascript"> 
    $("#seat-layout-error").hide(); 
    $("#seat-layout-error").css('visibility', 'hidden');   
    function alertify(tri) {
        Swal.fire({      
            allowOutsideClick: false,
            title: 'Do you want to leave this page?',                
            icon: 'info',
            width: 600,
            padding: '15px',
            background: '#fff url(assets/images/tree-bg.png)',    
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Accept'
        }).then((result) => {
            var showid = "<?php echo $_SESSION['movie_showid']; ?>";
            
            var datas = {'seat':movie_seat,'showid':showid};
            $.ajax({
                type: "POST",
                url: "classes/php/session_details9.php",
                data: datas
            }).done(function(data) {
                sessionStorage.removeItem('Dategetting');
                window.location.href = tri;
            });
        });
    }
    var movie_id = "<?php echo $_SESSION['movieId']; ?>";
    var Cin_Id = "<?php echo $_SESSION['Cin_Id']; ?>";
    var SelShowTime = "<?php echo $_SESSION['movie_showtime']; ?>";

    var p17 = "<?php  echo isset($_COOKIE['userid']); ?>";
    var timeleftsec='';
    var isWaiting = false;
    var isRunning = false;
    var seconds = 300;
    var countdownTimer;
    var finalCountdown = false;

    if (localStorage.getItem("seconds") !== null) {
        seconds = localStorage.getItem("seconds");
    }

// Header and Footer Visibility jQuery
$(function() {
        $('.main__wrapper').hide();
        $('.footer').hide();
        $('.seat__booking_confirm_panel').hide();
    // $('.main__wrapper').css('visibility','hidden');
        // $('.footer').css('visibility','hidden');
        // $('.seat__booking_confirm_panel').css('visibility','hidden');
}); 


$(document).ready(function() {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/php/getallshow1json.php?getLocationShowTime",
            data: {'movieId': movie_id, 'Cin_id': Cin_Id },
            success: display_movie
        });    
  });

       function display_movie(data) {
        var select = $('#loadedShowtime');
    var ClsName = '' ;
        $('#loadedShowtime').empty();
    
        $.each(data, function (key, cat) {

            if(SelShowTime == cat.showtime)
                ClsName = 'CurrentTime';
        else
                ClsName = '';

            if (cat.hasOwnProperty("Cin_Loc") && cat.showDate == "<?php echo $movie_date;?>") {                                                
                if(cat.checkcount == '#F285A2') {              
                    var option = "<li><div class='show-timing occupied "+ ClsName +"' style='cursor: not-allowed;'><div style='disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                    option +="</div></div></li>";
                } else if(cat.red_col == 'red') {              
                    var option = "<li><div class='show-timing mmm "+ ClsName +"' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div style='color:#33a054; opacity:0.3;' disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                    option +="</div></div></li>";
                } else if(cat.checkcount == '#D4AF37') {                
                    var option = "<li><div class='show-timing fast-filling "+ ClsName +" data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";               
                    option +="</div></div></li>";
                } else {               
                    var option = "<li><div class='show-timing "+ ClsName +" data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"' style='cursor: pointer;'><div class='showtimings' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";             
                    option +="</div></div></li>";                        
                }
                select.append(option);
            }            
        });
    }

    function GameTimer() {
      if (isWaiting) { return; }
      var minutes = Math.round((seconds - 30) / 60);
      var remainingSeconds = seconds % 60;
      if (remainingSeconds < 10) {
          remainingSeconds = "0" + remainingSeconds;
      }

      document.getElementById('waiting_time').innerHTML = minutes + ":" + remainingSeconds;
      timeleftsec = minutes * 60+ remainingSeconds;

      if (seconds == 0) {
            if (finalCountdown) {
                clearInterval(countdownTimer);
                $.ajax({
                    url: "classes/php/session_clear.php",
                }).done(function( data ) {
                    Swal.fire({
                        title: "Your session has Expired",   
                        icon: 'warning',
                        width: 600,
                        padding: '15px',
                        background: '#fff url(assets/images/tree-bg.png)',
                        showCancelButton: false,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Okay',
                        showClass: { popup: 'animated pulse' },
                        hideClass: { popup: 'animated fadeOutUp' }
                    }).then(function(){
                        sessionStorage.removeItem('Dategetting');
                        window.location.href = "movies.php";
                    });
                });
            } else {
                finalCountdown = true;
            }
      } else { seconds--; }
      localStorage.setItem("seconds",seconds);
    }

    // countdownTimer = setInterval(GameTimer, 1000);
    var k3 = 1;
    var trans_ids;

    function seat_proceed() {
        var p1 = "<?php echo isset($_COOKIE['userid']); ?>";
        var p177 = "<?php echo $_SESSION['movie_Name']; ?>";
        var t1 = selectedseat.length;
        var seatval =  seatnumber;
        var rowcjdj =  gridrowid;
        if(t1 == 0) {
            Swal.fire({  
        title: '<p style="font-size:16px;">Select a seat</p>',
        imageUrl: "assets/images/logos/ags-logo-transparent.png",
        imageHeight: 60, 
                imageWidth: 80,
                focusConfirm: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok',
                showClass: { popup: 'animated pulse' },
                hideClass: { popup: 'animated fadeOutUp' }
            });
        } else if(t1 != dynam) {           
            Swal.fire({
                title: '<p style="font-size:16px;">Select '+dynam+' seat</p>',
                imageUrl: "assets/images/logos/ags-logo-transparent.png",
                imageHeight: 60, 
                imageWidth: 80,
                showCancelButton: false,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Ok'
            });
        } else {
            $('#proceedto_pay').prop('disabled', true);
            var datas1 = {'cinemas_id':cin_id}; 
            $.ajax({
                type: "POST",
                dataType:"json",
                url: "classes/php/initbook.php",
                data: datas1
            }).done(function(data) {
                var status1 = data[0].result1;
                trans_ids = data[0].trans_id;
                if(status1 == 'success') {      
                    setseats_book(trans_ids);
                }
        if(status1 == 'failure') { 
                    var movie_location = "<?php echo $_SESSION['movie_location']; ?>";
                    var datas2 = {'message': data[0].strException, 'movie_location': movie_location};
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        url: "classes/php/send_log_mail.php",
                        data: datas2
                    }).done(function(data) {     
                        Swal.fire({
                         title: '<p style="font-size:16px;">Whoa!. Something is not right. <br><span style="font-size:14px;font-weight:400;line-height:18px;display:block;margin-top: 12px">There seems to be a connectivity issue with the venue. you could try again in some time or choose a different venue.</span></p>',
                             imageUrl: "assets/images/logos/ags-logo-transparent.png",
                             imageHeight: 60, 
                             imageWidth: 80,
                             showCancelButton: false,
                             confirmButtonColor: '#3085d6',
                             cancelButtonColor: '#d33',
                             confirmButtonText: 'Ok',
                             showClass: { popup: 'animated pulse' },
                             hideClass: { popup: 'animated fadeOutUp' }
                        }).then(function(){
                            window.location.href = "movies-time.php";
                        }); 
                    });
                }
            });
        }
    }

    function setseats_book(trans_ids) {
        var p1="<?php echo isset($_COOKIE['userid']); ?>";
        var urlstring = '';
        var t1 = selectedseat.length;
        urlstring += '|'+t1;

        for(i = 0; i < zerothval.length; i++) {
            if(tickettype == 'first-class'){
                var colnum = firstval[i].replace(/[^0-9.]/g, "");
                urlstring += '|0000000001|2|'+secondval[i]+'|'+colnum;
            } else{
                var colnum = firstval[i].replace(/[^0-9.]/g, "");
                urlstring += '|0000000002|1|'+secondval[i]+'|'+colnum;
            }
        }

        urlstring += '|';        
        var t0 = zerothval;
        var t1 = firstval;
        var minsec = timeleftsec;
        var seatlength = dynam;
        if(tickettype == 'first-class') {
            var seat_cat_type_id=1;
            var ticketypeaddseats = catcode1;
        } else {
            var  seat_cat_type_id=2; 
            var ticketypeaddseats = catcode2;
        }

        var datasaddseats = {"CinemaId": cin_id,"TempTransId": trans_ids,"SessionId": id,"TicketType": ticketypeaddseats,"Qty":seatlength,"UserSelectedSeats": true};        
        $.ajax({
            type: "POST",
            dataType:"json",
            async: false,
            url: "classes/php/addseats.php",
            data: datasaddseats
        }).done(function(data) { 
            var status1=data[0].result1;
        }); 

        var datas1 = {'cinemas_id':cin_id, 'TempTransId':trans_ids ,'SessionId':id,'SelectedSeats':urlstring,'showseat':t0,'seat':t1,'timelefts':minsec,'seatlength':seatlength,'seat_cat_type_id':seat_cat_type_id, "catcode": ticketypeaddseats};        

        $.ajax({
            type: "POST",
            dataType:"json",
            url: "classes/php/setseats.php",
            data: datas1
        }).done(function(data) {
            var status1=data[0].result1;
            var trans_ids=data[0].trans_id;
            if(status1 == "success") {
                if(p1 == '') {
                    k3 = 2;
                    $('#agsLoginRegister_panel').modal({
                        backdrop:'static',
                        keyboard:false
                    });
                    $('#agsLoginRegister_panel').modal("show");
                    $('#seat_proceed_login').val(k3);
                    $('#seat_proceed_register').val(k3);
                } else {
                    localStorage.removeItem("seconds");
                    window.location.href = 'foodorder.php';
                    /*var continuetransdatas = {'CinemaId':cin_id, 'TempTransId':trans_ids}
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "classes/php/continuetrans.php",
                        data: continuetransdatas,
                    }).done(function(data) {                        
                        var status1=data[0].result1;
                        if(status1 == "success"){
                            window.onbeforeunload = null;
                            window.location = 'moviespayment.php';
                        }
                    });*/
                }
            } else if($('#seat_proceed_login').val() != '' || $('#seat_proceed_register').val() != '' ) {
                $('#agsLoginRegister_panel').modal("show");
            } else {       
            	Swal.fire({
                    title: '<p style="font-size:16px;">Whoa!. Something is not right. <br><span style="font-size:14px;font-weight:400;line-height:18px;display:block;margin-top: 12px">Please select different seat(s)!</span></p>',
                    imageUrl: "assets/images/logos/ags-logo-transparent.png",
                    imageHeight: 60, 
                    imageWidth: 80,
                    showCancelButton: false,
                    confirmButtonColor: '#343a40',
                    cancelButtonColor: '#fff',
                    confirmButtonText: 'Refresh',
                    allowOutsideClick:false,
                    showClass: { popup: 'animated pulse' },
                    hideClass: { popup: 'animated fadeOutUp' }
                }).then(function(){
                    window.location.replace("movie-details.php");
                });
	    }
        });
    }

    function seat_proceed2() {
        var showid = "<?php echo $_SESSION['movie_showid']; ?>";
        var t0 = zerothval;
        var t1 = firstval;
        var t2 = $("#total").text();
        var t3 = secondval;
        var minsec = timeleftsec;
        var categoryamount = categoryamt;
        var seatlength = dynam;

        sessionStorage.removeItem('Dategetting');
        window.location.href = 'foodorder.php';
        /*var continuetransdatas = {'CinemaId':cin_id, 'TempTransId':trans_ids}
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/php/continuetrans.php",
            data: continuetransdatas,
        }).done(function(data) {
            var status1=data[0].result1;
            if(status1 == "success"){
                window.onbeforeunload = null;
                window.location = 'moviespayment.php';
            }
        });*/
    }

    var zerothval =  new Array();
    var firstval =  new Array();
    var secondval = new Array();

    function seatselected() {
        zerothval = [];
        firstval = [];
        secondval = [];
        $('#seat_no').empty();
        var txt = '';
        for(i = 0; i < selectedseat.length; i++) {
            var res = selectedseat[i].split("//");            
            zerothval.push(res[0]);
            firstval.push(res[1]);//gridseatno
            secondval.push(res[2]);//rowid            
        }        
        if(zerothval.length == 0){
            $('.seat__booking_confirm_panel').fadeOut();
        } else {
            $('.seat__booking_confirm_panel').fadeIn();            
        }
        for(i = 0; i < zerothval.length; i++) {            
            if(i == 0) {
                txt +=zerothval[i].replace(/\s+/g, ''); // USING SHOW TOOLTIP IN TXT
                $('#seat_no').append(zerothval[i].replace(/\s+/g, ''));                
            } else {
                txt +=","+zerothval[i].replace(/\s+/g, ''); // USING SHOW TOOLTIP IN TXT
                $('#seat_no').append(", "+zerothval[i].replace(/\s+/g, ''));
            }
            $("#seat_no").tooltip('hide').attr('data-original-title', txt).tooltip('_fixTitle');
        }
    }

    var selectedseat = new Array() ;
    var markers = [];  
    var rownames = []; 
    var pricess = 0;   //set dynamic price=0;
    var categoryamt = 0;
    var seatnumber;
    var gridrowid;
    var unavail_Array = new Array();
    var socialdistance_Array = new Array();
    var id = <?php echo $_SESSION['movie_showid'];?>;
    var cin_id = <?php echo $_SESSION['Cin_Id'];?>;
    var catcode1 = "<?php echo $_SESSION['catcode1']; ?>";  
    var catcode2 = "<?php echo $_SESSION['catcode2']; ?>";
    
    $(document).ready(function() {
        var newImg = new Image;
        newImg.onload = function() {
            //  _img.src = this.src;
        }
        newImg.src = 'assets/images/seat-layout/Booked.png';
        var datas = {'movieId':id,'cinema_id':cin_id}     ;
        $("#seat-layout-error").hide();
        $.ajax({
            type:"POST",
            dataType:"json",
            url:"classes/php/getseat.php",
            data:datas
        }).done(function(data) {  
        
        if(data.length != 0) {
        if(data[0].Success == false) {
                    $("#seat-layout").hide();
                    $("#seat-layout-error").removeAttr('hidden');
                    $("#seat-layout-error").show();
                    $("#seat-layout-error").css('visibility', 'visible'); 

                    var movie_location = "<?php echo $_SESSION['movie_location']; ?>";
                    var datas2 = {'message': data[0].strException, 'movie_location': movie_location};
                    $.ajax({
                        type: "POST",
                        dataType:"json",
                        url: "classes/php/seat_fetching_error.php",
                        data: datas2
                    }).done(function(data) {   
                        Swal.fire({
                title: '<p style="font-size:17px;font-weight:bold;display:block;"><span style="color:#dc3545;">Sorry!</span> Something is not right.</p><p style="font-size:12px;">There seems to be a connectivity issue with the venue and time. You could try again in some time or choose a different venue.</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
                            imageHeight: 60, 
                            imageWidth: 80, 
                            confirmButtonColor: '#babbbb',                            
                            confirmButtonText: 'Refresh',
                            showClass: { popup: 'animated pulse' },
                            hideClass: { popup: 'animated fadeOutUp' }                        
            }).then(function(){
                            window.location.href = "movies-time.php";
                        });  
                    });
                }else{
            $("#seat-layout-error").hide();
            $("#seat-layout-error").css('visibility', 'hidden');
            // data.sort(function(a,b){  
            // return a.category_id > b.category_id ? 1 : -1; 
            // });          
            var pealcat_counts=0;
            var Array_amount=new Array(); 
            var totalseatsarray=new Array();
            var catnameArr= [];
            var catnameArr1 = [];
            $.each(data, function(index, value) {
                var Seat_Row_num = value.row;
                var seatarrange_rowid=value.seat_id;
                var Seat_Column = value.strA;
                var Seat_Amount = value.Amount;              
                if ($.inArray(value.catname, catnameArr) == -1) 
                catnameArr.push(value.catname);

                if ($.inArray(value.Amount, catnameArr1) == -1) 
                catnameArr1.push(value.Amount);

                categoryamt=value.category_id;
                Array_amount[index]=value.Amount;
                var seatcolnumber = value.seatgridno;
                var seatactnumber = value.seatgridseatno;
                var seatcolnumberarr = seatcolnumber.split(",");
                var seatactnumberrarr = seatactnumber.split(",");
                gridrowid = value.row_id;
                markers[index] = value.strA+'//'+value.seat_id+'//'+value.seatgridno+'//'+value.seatgridseatno;
                uniqueamt = Array.from(new Set(Array_amount)); //ARRAY VALUES SET UNIQUE(120,10)
                if(categoryamt == 2) { pealcat_counts++; }
                if(value.row == '_') {
                    rownames[index] = '';
                } else {
                    rownames[index] = value.row;
                }
                var j=1; //SET FROM SEAT ROW NUMBER
                for(i=0; i<Seat_Column.length; i++) {
                    var res = Seat_Column.charAt(i);
                    if(res == 'U' || res == 'D' || res =='B' ||res =='H' || res =='P' || res== 'Q') {
                        var kj=i+1;
                        //var con=Seat_Row_num + '' + j + '//' + Seat_Row_num +''+kj+ '//'+ seatarrange_rowid; 
                        var con=Seat_Row_num + '' + seatactnumberrarr[i] + '//' + Seat_Row_num +''+seatcolnumberarr[i]+ '//'+ seatarrange_rowid+ '//'+ i;
                        unavail_Array.push(con);   
                        totalseatsarray.push(con);
                    } else if(res == 'S') {
                        var con = Seat_Row_num + '' + seatactnumberrarr[i] + '//' + Seat_Row_num +''+seatcolnumberarr[i]+ '//'+ seatarrange_rowid+ '//'+ i;
                        socialdistance_Array.push(con);   
                        totalseatsarray.push(con);                    
                    } else {
                        var kj=i+1;
                        if(res =='_') {
                            var con=Seat_Row_num + '0//' + Seat_Row_num +''+seatcolnumberarr[i]+'//'+ seatarrange_rowid+ '//'+ i; 
                        } else {
                            var con=Seat_Row_num + '' + seatactnumberrarr[i] + '//' + Seat_Row_num +''+seatcolnumberarr[i]+ '//' +seatarrange_rowid+ '//'+ i; 
                        }
                        totalseatsarray.push(con);
                    }
                    if(res !='_') { j++; }
                }                
            });
            
            var seat_cost = [];
            $.each(catnameArr, function(index, item) {              
                seat_cost.push(catnameArr1[index]);              
            }); 
           
            var $cart = $('#selected-seats'),
            $counter = $('#counter'),
            $total = $('#total'),
            sc = $('#seat-map').seatCharts({
                map: markers,
                seats: {
                    A: {
                        price   : uniqueamt[0],
                        classes : 'first-class', //your custom CSS class
                        category: 'First Class'
                    },
                    C: {
                        price   : uniqueamt[1],
                        classes : 'economy-class', //your custom CSS class
                        category: 'Economy Class'
                    },
                    Q: {
                        price: uniqueamt[0],
                        classes: 'bmss-class', //your custom CSS class
                        category: 'BMS Class'
                    },
                    S: {
                        price: uniqueamt[0],
                        classes: 'sd-class',  //your custom CSS class
                        category: 'SD Class'
                    }
                },
                naming : {
                    top : false,
                    getLabel : function (character, row, column) {
                        return column;                        
                    },
                },
                legend : {
                    node : $('#legend'),
                    items : [
                        [ 'A', 'available',   'First Class' ],
                        [ 'C', 'available',   'Economy Class'],
                        [ 'A', 'unavailable', 'Already Booked'],
                        [ 'S', 'socialdistance', 'Social Distance']
                    ]                   
                },
                click: function () {
                    if (this.status() == 'available') {
                        // debugger;
                        var ms = sc.find('selected').length;
                        var maxSeats = Number(dynam);
                        var ms = selectedseat.length;
                        if (ms < maxSeats) { //select separate 10 and 120 rs seat selected                    
                            var maxSeats = Number(dynam);
                            var ms = selectedseat.length;
                            /** Diamond & Pearls restricted Parallel selection  **/

                            if(pricess==0) {
                                pricess = this.data().price;
                            }
                            if(pricess == this.data().price || pricess == 0){
                                $counter.text(sc.find('selected').length+1);
                                var t=$total.text((Number(recalculateTotal(sc))+Number(this.data().price)).toFixed(2)); 
                            } else {
                                pricess = this.data().price;
                                sc.status(selectedseat, 'available');
                                //sc.find('selected').status('available');
                                selectedseat = [];
                                ms = selectedseat.length;
                            }
                            
                            /**End Diamond & Pearls restricted Parallel selection  **/

                            var a = totalseatsarray.indexOf(this.settings.id);
                            var len = maxSeats - ms;
                            selectedseat.push(this.settings.id);
                            newdataa = sc.get(this.settings.id);
                            tickettype = newdataa.data().classes;
                            for(t=1; t<len; t++) {
                                var tt = a+t;
                                var totalseatsettingid = sc.find('A');
                                var totalseatsettingid1 = sc.find('C');
                                var newarray = totalseatsettingid.seatIds;
                                var newarray1 = totalseatsettingid1.seatIds;
                                var b = newarray.indexOf(totalseatsarray[tt]);
                                var c = newarray1.indexOf(totalseatsarray[tt]);
                                var oldseat = sc.get(totalseatsarray[a]);
                                var newseat = sc.get(totalseatsarray[tt]);
                                var oldstatus = oldseat.data().classes;
                                if(newseat != undefined) {
                                    var newstatus = newseat.data().classes;
                                } else {
                                    var newstatus = "not-valid";
                                }
                                if(newstatus != oldstatus) {
                                    break;
                                } else if(b == -1 && c == -1) {
                                    break;
                                } else if(sc.status( totalseatsarray[tt] ) == "available") {
                                    var samerow = totalseatsarray[a].charAt(0);
                                    var samerow1 = totalseatsarray[tt].charAt(0);
                                    if(samerow == samerow1) {
                                        sc.get(totalseatsarray[tt]).status('selected');
                                        selectedseat.push(totalseatsarray[tt]);
                                    } else {
                                        break;
                                    }
                                } else {
                                    break;
                                }
                            }
                            $counter.text(sc.find('selected').length+1);
                            var t = $total.text((Number(recalculateTotal(sc))+Number(this.data().price)).toFixed(2));
                            seatselected();
                            return 'selected';
                        } else if (ms >= maxSeats) {
                            sc.find('selected').status('available');
                            selectedseat = [];
                            ms = selectedseat.length;
                            //   if(pricess==0){
                            //               pricess = this.data().price;
                            //          }
                            //   if(pricess == this.data().price || pricess == 0){
                            //          sc.find('selected').status('available');
                            //          selectedseat = [];
                            //      }
                            //      else{
                            pricess = this.data().price;
                            sc.find('selected').status('available');
                            selectedseat = [];
                            ms = selectedseat.length;
                            //   }
                            var a = totalseatsarray.indexOf(this.settings.id);
                            var len = maxSeats - ms;
                            selectedseat.push(this.settings.id);
                            newdataa = sc.get(this.settings.id);
                            tickettype = newdataa.data().classes;
                            for(t=1;t<len;t++) {
                                var tt = a+t;
                                var totalseatsettingid = sc.find('A');
                                var totalseatsettingid1 = sc.find('C');
                                var newarray = totalseatsettingid.seatIds;
                                var newarray1 = totalseatsettingid1.seatIds;
                                var b = newarray.indexOf(totalseatsarray[tt]);
                                var c = newarray1.indexOf(totalseatsarray[tt]);
                                var oldseat = sc.get(totalseatsarray[a]);
                                var newseat = sc.get(totalseatsarray[tt]);
                                var oldstatus = oldseat.data().classes;
                                if(newseat != undefined) {
                                    var newstatus = newseat.data().classes;
                                } else{
                                    var newstatus = "not-valid";
                                }
                                if(newstatus != oldstatus){
                                    break;
                                } else if(b == -1 && c == -1){
                                    break;
                                } else if(sc.status( totalseatsarray[tt] ) == "available"){
                                    var samerow = totalseatsarray[a].charAt(0);
                                    var samerow1 = totalseatsarray[tt].charAt(0);
                                    if(samerow == samerow1){
                                        sc.get(totalseatsarray[tt]).status('selected');
                                        selectedseat.push(totalseatsarray[tt]);
                                    } else {
                                        break;
                                    }
                                } else {
                                    break;
                                }
                            }
                            seatselected();
                            $counter.text(sc.find('selected').length+1);
                            var t=$total.text((Number(recalculateTotal(sc))+Number(this.data().price)).toFixed(2));
                            return 'selected';
                        }
                        // return 'available';
                    } else if (this.status() == 'selected') {
                        $counter.text(sc.find('selected').length-1);
                        $total.text((recalculateTotal(sc)-this.data().price).toFixed(2));
                        var removeItem = this.settings.id;
                        selectedseat.splice( $.inArray(removeItem,selectedseat) ,1 );
                        seatselected();
                        return 'available';
                    } else if (this.status() == 'unavailable') {
                        return 'unavailable';
                    } else if (this.status() == 'socialdistance') {
                        return 'socialdistance';
                    } else {
                        return this.style();
                    }
                }
            });
            sc.get(unavail_Array).status('unavailable');
            sc.get(socialdistance_Array).status('socialdistance');
            $('.seatCharts-row').first().parent().before('<div class="newsa1">Diamond - Rs.'+seat_cost[0]+'</div>');
            // $('.economy-class').first().parent().before('<div class="newsa">Pearl - Rs.'+seat_cost[1]+'</div>');
            $('.seatCharts-row:nth-last-child('+pealcat_counts+')').before('<div class="newsa">Pearl - Rs.'+seat_cost[1]+'</div>'); 
            }  
        }else {
                $("#seat-layout").hide();
        $("#seat-layout-error").removeAttr('hidden');
                $("#seat-layout-error").show();
        $("#seat-layout-error").css('visibility', 'visible');
            }        
        });
    });

    function recalculateTotal(sc) {
        var total = Number(0);
        //basically find every selected seat and sum its price
        sc.find('selected').each(function () {
            total += Number(this.data().price);
        });
        return total;
    }

    var dynam = "<?php echo $movie_tickvalue ?>";
    $('#noof_movie_ticket').on('change', function() {
        dynam = this.value;
    });

    function session_value(ids, censor, cinid) {        

        dynamvalue = 2;
        var time = $(".data-midnight-"+ids+" .time_click").text();
        var hours = Number(time.match(/^(\d+)/)[1]);
        var minutes = Number(time.match(/:(\d+)/)[1]);
        var AMPM = time.match(/\s(.*)$/)[1];
        if(AMPM == "PM" && hours < 12) hours = hours+12;
        if(AMPM == "AM" && hours == 12) hours = hours-12;
        var sHours = hours.toString();
        var sMinutes = minutes.toString();
        if(hours<10) sHours = "0" + sHours;
        if(minutes<10) sMinutes = "0" + sMinutes;

        $('#ags_covid').modal('show');
        $('#acceptance_covid').on('click', function(){
            var confirm = $(this).attr('value');
            if (confirm == 'true') {   
                $.ajax({
                    dataType:"json",
                    type: "POST",
                    url: "classes/php/covid_session.php",
                    data: {'covidConfirm' : confirm}
                });

                if(sHours + ":" + sMinutes <= "06:00" && sHours + ":" + sMinutes > "00:00"){
                    $('#ags_midnight_show').modal('show');         
                    $('#acceptance_agsMidnightShow').on('click', function(){
                        var confirm = $(this).attr('value');
                        if (confirm == 'true') {
                            $('#ags_midnight_show').modal('hide');
                            if(censor == 'A') {
                                Swal.fire({      
                                    allowOutsideClick: false,
                        title: '<p style="font-size:14px;color:#f00;">This movie is rated "A" <br />and is for audiences above the age of 18.</p>',                
                        imageUrl: "assets/images/logos/ags-logo-transparent.png",
                        imageHeight: 60, 
                        imageWidth: 80,                    
                        showConfirmButton: false,
                        timer:3000
                                }).then((result) => {             
                                        var name01 = ids;
                                        var tickvalue = dynamvalue;
                                        var datas = {'id':name01, 'movieticket':tickvalue, 'cinid':cinid }
                                        $.ajax({
                                            dataType:"json",
                                            type: "POST",
                                            url: "classes/php/getsession_value.php",
                                            data: datas
                                        }).done(function(data) {
                                            var session_close = data[Object.keys(data)[0]].session_close;
                                            var getting_date = data[Object.keys(data)[0]].gettingshowDate;
                                            if(session_close =='session_close') {
                                                window.location.href ='movies.php';
                                            } else { 
                                                window.location.href = 'seat.php';
                                                window.localStorage.clear(); //clearing seat count time
                                            }
                                        });                            
                                });
                            } else {
                                var name01=ids;
                                var tickvalue=dynamvalue;      
                                var datas = {'id': name01, 'movieticket': tickvalue, 'cinid': cinid}
                                $.ajax({
                                    dataType:"json",
                                    type: "POST",
                                    url: "classes/php/getsession_value.php",
                                    data: datas
                                }).done(function(data) {
                                    var session_close=data[Object.keys(data)[0]].session_close;
                                    var getting_date=data[Object.keys(data)[0]].gettingshowDate;
                                    if(session_close == 'session_close') {
                                        window.location.href = 'movies.php';
                                    } else {  
                                        window.location.href = 'seat.php';
                                        sessionStorage.setItem("Dategetting", getting_date);
                                        window.localStorage.clear(); //clearing seat count time     
                                    }     
                                });
                            }
                        }
                    });
                }else {
                    if(censor == 'A') {
                        Swal.fire({      
                            allowOutsideClick: false,
                    title: '<p style="font-size:14px;color:#f00;">This movie is rated "A" <br /> and is for audiences above the age of 18.</p>',
                            imageUrl: "assets/images/logos/ags-logo-transparent.png",
                            imageHeight: 60, 
                            imageWidth: 80,
                            showConfirmButton: false,
                        timer:3000
                        }).then((result) => {  
                            if (result.isConfirmed) {              
                                var name01 = ids;
                                var tickvalue = dynamvalue;
                                var datas = {'id':name01, 'movieticket':tickvalue, 'cinid':cinid }
                                $.ajax({
                                    dataType:"json",
                                    type: "POST",
                                    url: "classes/php/getsession_value.php",
                                    data: datas
                                }).done(function(data) {
                                    var session_close = data[Object.keys(data)[0]].session_close;
                                    var getting_date = data[Object.keys(data)[0]].gettingshowDate;
                                    if(session_close =='session_close') {
                                        window.location.href ='movies.php';
                                    } else { 
                                        window.location.href = 'seat.php';
                                        window.localStorage.clear(); //clearing seat count time
                                    }
                                });
                            }
                        });
                    } else {
                        var name01=ids;
                        var tickvalue=dynamvalue;      
                        var datas = {'id': name01, 'movieticket': tickvalue, 'cinid': cinid}
                        $.ajax({
                            dataType:"json",
                            type: "POST",
                            url: "classes/php/getsession_value.php",
                            data: datas
                        }).done(function(data) {
                            var session_close=data[Object.keys(data)[0]].session_close;
                            var getting_date=data[Object.keys(data)[0]].gettingshowDate;
                            if(session_close == 'session_close') {
                                window.location.href = 'movies.php';
                            } else {  
                                window.location.href = 'seat.php';
                                sessionStorage.setItem("Dategetting", getting_date);
                                window.localStorage.clear(); //clearing seat count time     
                            }     
                        });
                    }
                }
            }
        });
    }

</script>