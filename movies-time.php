<?php 
    include ('header.php');    
?>   
<div class="showTime_details_info">
    <div class="backbtn">
        <button type="button" onclick="window.history.go(-1); return false;" title="Go Back"><i class="fas fa-chevron-left"></i></button>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="movie_session_detail">
                    <h4><img src="assets/images/icons/film.png" alt="movie" /><span id="movieName"></span></h4>
                    <ul>
                        <!-- <li class="circle" id="movieCensor"></li> -->
                        <li class="badge" id="movieGenre"></li>                        
                        <li><i class="fas fa-calendar-day"></i> <span id="MovieRelesedDate"></span></li>
                        <li><i class="far fa-clock"></i> <span id="movierunTime"></span></li>                        
                    </ul>
                </div>
            </div>
            <div class="col-md-4">                
                <!-- <div class="movie_cast_detail">                    
                    <ul>
                        <li>
                            <span class="role">Director</span> 
                            <img src="assets/images/icons/user-icon.png" alt="Director" />
                            <span class="name">Person1</span> 
                        </li>
                        <li>
                            <span class="role">Cast & Crew</span> 
                            <img src="assets/images/icons/user-icon.png" alt="Director" />
                            <span class="name">Person2</span> 
                        </li>
                        <li>                            
                            <img class="mt-3" src="assets/images/icons/user-icon.png" alt="Director" />
                            <span class="name">Person3</span> 
                        </li>  
                        <li>                            
                            <img class="mt-3" src="assets/images/icons/user-icon.png" alt="Director" />
                            <span class="name">Person3</span> 
                        </li>                        
                    </ul>
                </div> -->
            </div>
        </div>
    </div>
</div>
<div class="main-booking-wrapper fixed-moviedetail-bar">
    <div class="container">
        <div class="row">
            <div class="col-md-7">
                <div class="datePicker_panel"></div>
            </div>
            <div class="col-md-5">
                <div class="moviesTiming_listingFilter"></div>
            </div>
        </div>
    </div>
</div>
<div class="showtime-movielist-panel default-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-warning alert-dismissible mt-1">
                    <button type="button" class="close" data-dismiss="alert">&times;</button>
                    <span><img src="assets/images/icons/movie-tickets.png" alt="food" /> Bulk booking available!</span>
                    <img src="assets/images/icons/fastfood.png" alt="food" /> Food and Beverage available
                </div>
                <div class="seatTiming-status text-left">
                    <ul>
                        <li class="available" style="color:#000;"><span class="fas fa-circle"></span> Available</li>
                        <li class="filling" style="color:#000;"><span class="fas fa-circle"></span> Fast Filling</li>
                        <li class="occupied" style="color:#000;"><span class="fas fa-circle"></span> Occupied</li>
                    </ul>
                </div>
            </div>
            <div class="col-md-12 ags-showtime-panel mt-1">               
                <div class="theater-list screens_show_div"></div>                
            </div>
        </div>
    </div>
</div>
<!-- <button class="btn btn-sm btn-danger" data-toggle="modal" data-target="#agstheater_termsrule">Click</button> -->
<div class="modal fade animated agstheater_termsrule" id="agstheater_termsrule" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title text-left">Terms & Conditions</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <ul>
            <li class="highlight">Ticket price inclusive of 3D glass charges.</li>
            <li>Tickets once purchased cannot be cancelled, exchanged or refunded.</li>
            <li>Tickets purchased online are not eligible for discounts, schemes or promotions of any kind.</li>
            <li>To collect tickets from the Box Office, it is mandatory for the cardholder to be present in person with the card used for the transaction, along with the booking confirmation (SMS/computer printout) to help minimize the risk of fraud.</li>
            <li>Online bookings on our site are carried out over a secure payment gateway.</li>
            <li>Tickets purchased online for a particular multiplex are valid for that multiplex only.</li>
            <li class="highlight">Children below the age of 18 cannot be admitted for movies certified `A`.</li>
            <li class="highlight">Please carry proof of age for movies certified `A`.</li>
            <li>Please purchase tickets for children 3 years and above.</li>
            <li>To counter unforeseen delays, please collect your tickets half an hour before show time.</li>
            <li>Outside food and beverages are not allowed inside the cinema premises.</li>
            <li>A convenience fee per ticket is levied on all tickets booked online.</li>
            <li>Ticket holders are required to abide by the policies laid down by the AGS Cinemas management.</li>
            <li>Smoking is strictly prohibited inside the theatre premises.</li>
            <li>People under the influence of Alcohol/Drugs will not be allowed inside the cinema premises.</li>
        </ul>
      </div>
      <div class="modal-footer">
        <button type="button" class="cancel btn btn-outline-danger btn-sm" data-dismiss="modal"><i class="fas fa-undo-alt"></i> Cancel</button>
	<button type="button" class="accept btn btn-primary btn-sm" id="acceptance_agsTermspremises" value="true"><i class="fas fa-check-circle"></i> Accept</button>
      </div>
    </div>
  </div>  
</div>
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

<?php include('footer.php'); ?>
<script type="text/javascript">
    var dynamvalue = '';
    $(document).ready(function() {
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);
        var movie_id = "<?php echo $_SESSION['movieId']; ?>";
        var jsondata;        
        // Get Movie and Show Times Details        
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/php/getallshow2json.php",
            data: {'movieId': movie_id },
            success: display_movie
        });       

    });

    $(window).scroll(function(){
        var sticky = $('.fixed-moviedetail-bar'), finalHeight, scroll = $(window).scrollTop();        
        var nevHead_height = $('.main__wrapper').height();
        var height_info = $('.showTime_details_info').height();
        finalHeight = nevHead_height + height_info;
        if (scroll >= finalHeight) sticky.addClass('fixed_sts_bar');
        else sticky.removeClass('fixed_sts_bar');
    });
    // Header and Footer Visibility jQuery
    $(function() {
        $('.main__wrapper').hide();
        $('.footer').hide();
        $('.seat__booking_confirm_panel').hide();
    }); 

    function toggleIcon(e) { $(e.target).prev('.panel-heading').find(".more-less").toggleClass('fa-chevron-circle-up'); }
    var session_datewise = sessionStorage.getItem("Dategetting");    
    function display_movie(data) {        
        jsondata = data;
        data.sort(function (x, y) {
            let a = new Date(x.showDatetime),
            b = new Date(y.showDatetime);
            return a - b;
        });

        var groupedPeople = groupBy(data, 'showDate');        
        var ii = 0;
        const ordered = {};
        Object.keys(groupedPeople).sort().forEach(function(key) {
            ordered[key] = groupedPeople[key];
        });
        Object.keys(groupedPeople).sort().forEach((key) => {
            var groupbydatas = groupedPeople[key]; 
	    var	ClsName = '';
            value = groupbydatas[0]; 
           
            if(value.days == "Today")
                ClsName = 'todaydateHighlight';
            else
               ClsName = ''; 

            if(ii == 0 && session_datewise==null) {               
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].days+'</span> </button>');
                show_screen(""+key+"",""+value.MovieId+"");
            } else if(session_datewise!=null) {
                if(key == session_datewise) {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+value.date+'<span>'+value.days+'</span> </button>');                    
                    show_screen(""+key+"",""+value.MovieId+"");
                } else {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+value.date+'<span>'+value.days+'</span> </button>');                    
                }
            } else {
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].days+'</span> </button>');                
            }           

            $.each(groupedPeople[key], function(i, value) {               
                $("#movieName").html(value.movieName);                
                $("#movieGenre").html(value.Genere);                  
                $("#movieCensor").html(value.Censor);
                $("#MovieRelesedDate").html(value.filmOpeningDate);
                var M_hours = Math.floor(value.Runtime / 60);          
                var M_minutes = value.Runtime % 60;
                $('#movierunTime').html(M_hours+ 'h '+M_minutes+ 'm');
                if(i == 0) {
                    $(".trailerimg").attr("src",value.trailerImageURL);                    
                    $(".video1_div").append('<iframe id="cartoonVideo" width="600" height="315" src="" frameborder="0" allowfullscreen></iframe>'); 
                    vid = document.getElementById("myVideo"); 
                    $(".trailer").hide();
                    setTimeout(function(){  $(".se-pre-con").fadeOut("slow");  }, 2000);   
                }      
            });

            ii++;
        });
	$('.todaydateHighlight').click(); 
    }

    function groupBy(objectArray, property) {
        return objectArray.reduce((acc, obj) => {
            const key = obj[property];
            if (!acc[key]) { acc[key] = []; }        
            acc[key].push(obj);
            return acc;
        }, {});
    }

    function show_screen(str,str1) {
        $('.boxs').removeClass('todaydateHighlight');                
        $('.'+str).addClass('todaydateHighlight');
        var groupedPeople = groupBy(jsondata, 'showDate');            
        Object.keys(groupedPeople).forEach((key) => {
            if(key == str){
                display_time(groupedPeople[key]);
            }
        });
    }

    function display_time(data){
        var select = $('.screens_show_div');
        $('.screens_show_div').empty();
        $.each(data, function (key, cat) {
            if (cat.hasOwnProperty("Cin_Loc")) {
                var group = cat.Cin_Loc;
                if(select.find("div[class='" + group + " screen_box']").length === 0) {
                    select.append("<div class='" + group + " screen_box' > <div class='rotate'><img src='assets/images/icons/film.png' alt='' /> <p class='screens'>"+cat.Cin_Loc+"</p></div></div>");           
                }
                if(cat.soundsysimg == '') {            
                    if(cat.checkcount == '#F285A2') {
                        var option = "<div class='show-timing dd' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div style='color:#ff5f5f;'  disabled='true'><p class='time_click'>"+cat.showtime+"</p></div>";
                    } else if(cat.red_col == 'red') {
                        var option = "<div class='show-timing ddd' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='movie_time_red' style='color:#33a054; opacity:0.3;' disabled='true'><p class='time_click'>"+cat.showtime+"</p></div>";
                    } else if(cat.checkcount == '#D4AF37') {
                        var option = "<div class='show-timing dds data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div data-midnight-"+data[key].SessionId +"='"+cat.showtime+"' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' style='color:"+cat.checkcount+"'><span class='time_click'>"+cat.showtime+"</span></div>";  
                    } else {
                        var option = "<div class='show-timing ds data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='showtimings' data-midnight-"+data[key].SessionId +"='"+cat.showtime+"' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' style='color:"+cat.checkcount+"'><span class='time_click'>"+cat.showtime+"</span></div>";
                    }            
                } else {            
                    if(cat.checkcount == '#F285A2') {              
                        var option = "<div class='show-timing occupied' style='cursor: not-allowed;'><div style='disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                        option +="</div></div>";
                    } else if(cat.red_col == 'red') {              
                        var option = "<div class='show-timing' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div style='color:#33a054; opacity:0.3;' disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                        option +="</div></div>";
                    } else if(cat.checkcount == '#D4AF37') {                
                        var option = "<div class='show-timing fast-filling data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div data-midnight-"+data[key].SessionId +"='"+cat.showtime+"' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";               
                        option +="</div></div>";
                    } else {               
                        var option = "<div class='show-timing data-midnight-"+data[key].SessionId +"' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='showtimings' data-midnight-"+data[key].SessionId +"='"+cat.showtime+"' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";             
                        option +="</div></div>";                        
                    }
                }       
                select.find("div[class='" + group + " screen_box']").append(option);      
            }       
        });
    }

    function session_value(ids, censor, cinid) {
        dynamvalue = 2;

	var time = $(".data-midnight-"+ids+" .time_click").text();
	var hours = Number(time.match(/^(\d+)/)[1]);
	var minutes = Number(time.match(/:(\d+)/)[1]);
	var AMPM = time.match(/\s(.*)$/)[1];
	if(AMPM == "PM" && hours<12) hours = hours+12;
	if(AMPM == "AM" && hours==12) hours = hours-12;
	var sHours = hours.toString();
	var sMinutes = minutes.toString();
	if(hours<10) sHours = "0" + sHours;
	if(minutes<10) sMinutes = "0" + sMinutes;

        if(sHours + ":" + sMinutes <= "06:00" && sHours + ":" + sMinutes > "00:00"){
            $('#ags_midnight_show').modal('show');         
            $('#acceptance_agsMidnightShow').on('click', function(){
                 var confirm = $(this).attr('value');
                if (confirm == 'true') {
                    $('#ags_midnight_show').modal('hide');
                    $('#agstheater_termsrule').modal('show');         
                    $('#acceptance_agsTermspremises').on('click', function(){
                        var confirm = $(this).attr('value');
                        if (confirm == 'true') {   
                            $('#agstheater_termsrule').modal('hide');   
                            if(censor == 'A') {
                                Swal.fire({      
                                  allowOutsideClick: false,
                                  title: '<p style="font-size:14px;color:#f00;">This movie is rated "A" and is for audiences above the age of 18.</p>',                
                                  imageUrl: "assets/images/logos/ags-logo-transparent.png",
                                  imageHeight: 60, 
                                  imageWidth: 80,                    
                                  showConfirmButton: false,
                                  timer:3000  
				  }).then((result) => {
                                        var name01 = ids;
                                        var tickvalue = dynamvalue;
                                        var datas = {'id':name01, 'movieticket':tickvalue, 'cinid':cinid };
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
                                var name01 = ids;
                                var tickvalue = dynamvalue;      
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

                }
            });
        }else{
            $('#agstheater_termsrule').modal('show');         
            $('#acceptance_agsTermspremises').on('click', function(){
                var confirm = $(this).attr('value');
                if (confirm == 'true') {   
                    $('#agstheater_termsrule').modal('hide');   
                    if(censor == 'A') {
                        Swal.fire({      
                         allowOutsideClick: false,
			 title: '<p style="font-size:14px;color:#f00;">This movie is rated "A" and is for audiences <br>above the age of 18.</p>',                
			 imageUrl: "assets/images/logos/ags-logo-transparent.png",
 			 imageHeight: 60, 
			 imageWidth: 80,                    
			 showConfirmButton: false,
			 timer:4000                        
			}).then((result) => {   
                                var name01 = ids;
                                var tickvalue = dynamvalue;
                                var datas = {'id':name01, 'movieticket':tickvalue, 'cinid':cinid };
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
                        var name01 = ids;
                        var tickvalue = dynamvalue;      
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
        }
    }    
    
</script>




