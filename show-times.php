<?php 
    include ('header.php');
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
<section class="main-booking-wrapper showtime-bg">
    <div class="container">
        <div class="col-md-8 offset-md-2">            
            <form method="POST" class="showTiming_Theater_frm" name="showTiming_Theater_frm">
                <h5>Show timings for all available movies and locations </h5>
                <div class="col-md-12 p-m-3">
                    <div class="datePicker_panel"></div>
                </div>
                <div class="col-md-12 p-m-3">
                    <div class="showtimeFiltering">
                        <div class="row">                                                       
                            <div class="col-sm-6">
                                <div class="form-group">                                    
                                    <label for="movie" class="label-control"><img src="assets/images/icons/film.png" alt="icon" /> Select your movie</label>
                                    <select class="form-control" name="noof_seats" id="all_movies_name">
                                        <option value="">Select Movie</option>                                   
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="form-group">
                                    <label for="locations" class="label-control"><i class="fas fa-map-marker-alt"></i> Select location</label>
                                    <select class="form-control" name="theater_locations" id="theater_locations">
                                        <option value="">Select cinema location</option>    
                                    <?php if($cinemasarr_count != 0) {
                                            for($i = 0; $i < $cinemasarr_count; $i++) {
                                                $CinemaID = $cinemasarr[$i]['CinemaID'];
                                                $CinemaName = $cinemasarr[$i]['CinemaName'];
                                                echo "<option value='".$CinemaID."'>".$CinemaName."</option>";
                                            }
                                        } else {
                                            echo "<option value=''>No location found</option>";
                                        }
                                        ?>                                
                                    </select>
                                </div>
                            </div>                           
                        </div>
                    </div>
                </div>
                <div class="col-md-12 p-m-3">
                    <div class="seatTiming-status">
                        <ul>
                            <li class="available"><span class="fas fa-circle"></span> Available</li>
                            <li class="filling"><span class="fas fa-circle"></span> Fast Filling</li>
                            <li class="occupied"><span class="fas fa-circle"></span> Occupied</li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-12 p-m-3 ags-showtime-panel mt-1">               
                    <div class="theater-list screens_show_div scrollbar scrollbar-primary"></div>
                </div>                    
            </form>            
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<script type="text/javascript">
    var dynamvalue = '', jsondata = '';
    var session_datewise = sessionStorage.getItem("Dategetting");    
    $(document).ready(function() {
        $('.panel-group').on('hidden.bs.collapse', toggleIcon);
        $('.panel-group').on('shown.bs.collapse', toggleIcon);   
        var jsondata;
        $(".datePicker_panel").empty();
        // Get Movie and Show Times Details - Ajax Call
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "classes/getMovies.php",                     
            success: function(data) {
                var movieArr ='';
                $.each(data, function (key, value) {                                 
                    movieArr +='<option value="'+data[key].movieId+'">'+data[key].movieName+'</option>';
                });
                $("#all_movies_name").html(movieArr);
                var movie_ID = $('#all_movies_name').val();
                var Cin_id = $('#theater_locations').val();
                if (movie_ID != '') {
                    $.ajax({
                        type: "POST",
                        dataType: "json",
                        url: "classes/php/getallshow1json.php?getAllShowTime",
                        data: {'movieId': movie_ID, 'Cin_id': Cin_id },
                        success: display_movie
                    });
                }
            }
        });    

        $('#all_movies_name').on('change', function() {
            var movie_ID = $('#all_movies_name').val();
            var Cin_id = $('#theater_locations').val();
            $(".datePicker_panel").empty();
            $('.screens_show_div').empty();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/php/getallshow1json.php?getAllShowTime",
                data: {'movieId': movie_ID, 'Cin_id': Cin_id },
                success: display_movie
            });            
        });

        $('#theater_locations').on('change', function() {
            var movie_ID = $('#all_movies_name').val();
            var Cin_id = $('#theater_locations').val();
            $('.screens_show_div').empty();
            $(".datePicker_panel").empty();
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/php/getallshow1json.php?getLocationShowTime",
                data: {'movieId': movie_ID, 'Cin_id': Cin_id },
                success: display_movie
            });            
        });

        $('#all_movies_name').on('click', function() {
            var movie_ID = $(this).val();
            if(movie_ID == '') {
                Swal.fire({
                    title: 'Please wait untile fetching the data from server',
                    icon: 'warning',
                    showClass: {
                        popup: 'animated fadeInDown'
                    },
                    hideClass: {
                        popup: 'animated fadeOutUp'
                    },
                    showConfirmButton: false,
                    timer: 4500
                });
            }
        });
    });
    function toggleIcon(e) { $(e.target).prev('.panel-heading').find(".more-less").toggleClass('fa-chevron-circle-up'); }
    var session_datewise = sessionStorage.getItem("Dategetting");

    function groupBy(objectArray, property) {
        return objectArray.reduce((acc, obj) => {
            const key = obj[property];
            if (!acc[key]) { acc[key] = []; }        
            acc[key].push(obj);
            return acc;
        }, {});
    }


    function display_movie(data) {
        $(".datePicker_panel").empty();

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
            var ClsName = '';
            value = groupbydatas[0];            
            if(value.days == "Today")
                ClsName = 'todaydateHighlight';
	    else
               ClsName = ''; 
          
            if(ii == 0 && session_datewise==null) {               
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].days+'</span> </button>');
                // show_screen(""+key+"",""+value.MovieId+"");
            } else if(session_datewise!=null) {
                if(key == session_datewise) {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+value.date+'<span>'+value.days+'</span> </button>');                    
                    // show_screen(""+key+"",""+value.MovieId+"");
                } else {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+value.date+'<span>'+value.days+'</span> </button>');                    
                }
            } else {
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs '+ClsName+' '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].days+'</span> </button>');                
            }
        }); 
	$(".datePicker_panel button:first-child").trigger("onclick");
	$('.todaydateHighlight').click();      
    }

    function show_screen(str,str1) {
        $('.boxs').removeClass('btn-outline-success');
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
                    select.append("<div class='" + group + " screen_box' > <div class='rotate'><p class='screens'>"+cat.Cin_Loc+"</p></div></div>");           
                }
                if(cat.soundsysimg == '') {            
                    if(cat.checkcount == '#F285A2') {
                        var option = "<div class='show-timing dd' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div style='color:#ff5f5f;'  disabled='true'><p class='time_click'>"+cat.showtime+"</p></div>";
                    } else if(cat.red_col == 'red') {
                        var option = "<div class='show-timing dd' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='movie_time_red' style='color:#33a054; opacity:0.3;' disabled='true'><p class='time_click'>"+cat.showtime+"</p></div>";
                    } else if(cat.checkcount == '#D4AF37') {
                        var option = "<div class='show-timing dds' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' style='color:"+cat.checkcount+"'><span class='time_click'>"+cat.showtime+"</span></div>";  
                    } else {
                        var option = "<div class='show-timing ds' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='showtimings' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' style='color:"+cat.checkcount+"'><span class='time_click'>"+cat.showtime+"</span></div>";
                    }            
                } else {            
                    if(cat.checkcount == '#F285A2') {              
                        var option = "<div class='show-timing occupied' style='cursor: not-allowed;'><div style='disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                        option +="</div></div>";
                    } else if(cat.red_col == 'red') {              
                        var option = "<div class='show-timing' style='cursor: default;' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div style='color:#33a054; opacity:0.3;' disabled='true'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";
                        option +="</div></div>";
                    } else if(cat.checkcount == '#D4AF37') {                
                        var option = "<div class='show-timing fast-filling' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";               
                        option +="</div></div>";
                    } else {               
                        var option = "<div class='show-timing' data-toggle='tooltip' data-placement='bottom' title='Show time: "+cat.showtime+"'><div class='showtimings' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")'><span class='time_click'>"+cat.showtime+"</span><div class='soungimg'>";             
                        option +="</div></div>";                        
                    }
                }       
                select.find("div[class='" + group + " screen_box']").append(option);      
            }       
        });
    }

    function session_value(ids, censor, cinid) {
        dynamvalue = 2;
        if (dynamvalue != "") {
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
		    // if (result.isConfirmed) {  
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
		     // }                  
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
        } else {
            Swal.fire({
                title: 'Please select no of seat',
                icon:'warning',
                width: 400,
                padding: '0',
                background: '#fff url(assets/images/tree-bg.png)',
                timer: 3500,
                showClass: { popup: 'animated pulse' },
                hideClass: { popup: 'animated fadeOutUp' }
            });
            
        }
    }
setTimeout(function() { 
        var showPanelTrig = $(".datePicker_panel button").length; 
        if(showPanelTrig > 0) {
            $(".datePicker_panel button:first-child").trigger("onclick");
        }
    }, 5000);
    
</script>



