<?php 
    include ('header.php');
    $checkid = $_SESSION['movieId'];
?>   

<section class="main-booking-wrapper showtime-bg">
    <div class="container">
        <div class="col-md-10 offset-md-1">
            <div class="row">
                <form method="POST" class="showTiming_Theater_frm" name="showTiming_Theater_frm">
                    <div class="col-md-12">
                        <div class="datePicker_panel"> 
                            <!-- <button type="button" name="bookingDate" class="btn btn-outline-success mr-2">26 <span>THU</span> </button>
                            <button type="button" name="bookingDate" class="btn btn-outline-dark mr-2">27 <span>FRI</span> </button>
                            <button type="button" name="bookingDate" class="btn btn-outline-dark mr-2">28 <span>SAT</span> </button>
                            <button type="button" name="bookingDate" class="btn btn-outline-dark mr-2">29 <span>SUN</span> </button>
                            <button type="button" name="bookingDate" class="btn btn-outline-dark mr-2">30 <span>MON</span> </button>
                            <button type="button" name="bookingDate" class="btn btn-outline-primary mr-2">31 <span>TUE</span></button>
                            <button type="button" name="bookingDate" class="btn btn-outline-primary mr-2">01 <span>WED</span></button>
                            <button type="button" name="bookingDate" class="btn btn-outline-primary">02 <span>THU</span></button>                             -->
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="showtimeFiltering">
                            <div class="row">
                                <div class="col-sm-12">
                                    <label for="movie filtering" class="col-form-label"><img class="img-fluid" src="assets/images/icons/Theater.png" alt="" /> Select movie details</label>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="noof_seats" id="noof_total_seats">
                                        <option value="">Select Movie</option>
                                        <option value="bell bottom">Bell Bottom</option>
                                        <option value="The Conjuring Saathaan ennai Aattuvithathu">The Conjuring Saathaan ennai Aattuvithathu-Tamil-A</option>                            
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="noof_seats" id="noof_total_seats">
                                        <option value="">Select cinema location</option>
                                        <option value="Navallur">Navallur</option>
                                        <option value="Tnager">T.Nager</option>                            
                                        <option value="Villivakkam">Villivakkam</option>                            
                                        <option value="maduravoyal">Maduravoyal</option>                            
                                    </select>
                                </div>
                                <div class="col-sm-4">
                                    <select class="form-control" name="noof_seats" id="noof_total_seats">
                                        <option value="">Select Shows</option>
                                        <option value="Morning">Morning</option>                                                                  
                                        <option value="Noon">Noon</option>    
                                        <option value="Evening">Evening</option>    
                                        <option value="Night">Night</option>    
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="seatTiming-status">
                            <ul>
                                <li class="available"><span class="fas fa-circle"></span> Available</li>
                                <li class="filling"><span class="fas fa-circle"></span> Fast Filling</li>
                                <li class="occupied"><span class="fas fa-circle"></span> Occupied</li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12 ags-showtime-panel mt-1">               
                        <div class="theater-list"> 
                            <div class="panel-group" id="Movies_accordion" role="tablist" aria-multiselectable="true">
                                <!-- <div class="panel panel-default"></div> -->
                            </div>
                        </div>
                    </div>                    
                </form>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<script type="text/javascript">
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
    function toggleIcon(e) { $(e.target).prev('.panel-heading').find(".more-less").toggleClass('fa-chevron-circle-up'); }
    var session_datewise = sessionStorage.getItem("Dategetting");
    function display_movie(data) {        
        jsondata = data;
        var groupedPeople = groupBy(data, 'showDate');
        var ii = 0;

        const ordered = {};
        Object.keys(groupedPeople).sort().forEach(function(key) {
            ordered[key] = groupedPeople[key];
        });

        Object.keys(ordered).forEach((key) => {
            var groupbydatas = groupedPeople[key];
            value = groupbydatas[0];
            if(ii == 0 && session_datewise==null) {
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].month+'</span> </button>');
                show_screen(""+key+"",""+value.MovieId+"");
            } else if(session_datewise!=null) {
                if(key == session_datewise) {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs btn-outline-dark '+key+' mr-2">'+value.date+'<span>'+value.month+'</span> </button>');                    
                    show_screen(""+key+"",""+value.MovieId+"");
                } else {
                    $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+value.MovieId+'\');" name="bookingDate" class="btn boxs btn-outline-dark '+key+' mr-2">'+value.date+'<span>'+value.month+'</span> </button>');                    
                }
            } else {
                $(".datePicker_panel").append('<button type="button" onclick="show_screen(\''+key+'\',\''+groupbydatas[0].MovieId+'\');" name="bookingDate" class="btn boxs btn-outline-dark '+key+' mr-2">'+groupbydatas[0].date+'<span>'+groupbydatas[0].month+'</span> </button>');                
            }

            $.each(groupedPeople[key], function(i, value) {
                url = "//www.youtube.com/embed/"+value.trailerURL+"?autoplay=1";      
                var htmlText='<span class="under under_'+value.Censor+'">'+value.Censor+'</span>';
                $(".movie-name").html(value.movieName+' '+htmlText);
                $(".movie-lang").text(value.Language);
                $(".movie-types1").text(value.genre);
                $(".min").text(value.Runtime);
                $(".crew_detail").text(value.crew);
                $(".cast_detail").text(value.cast);
                $(".movie_desc").text(value.moviedescription);
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
        $('.boxs').removeClass('btn-outline-success');                
        $('.'+str).addClass('btn-outline-success');
        var groupedPeople = groupBy(jsondata, 'showDate');        
        Object.keys(groupedPeople).forEach((key) => {
            if(key == str){
                display_time(groupedPeople[key]);
            }
        });
    }

    function display_time(data) {        
        var select = $('#Movies_accordion');
        $('#Movies_accordion').empty();
        $.each(data, function (key, cat) {     
            if (cat.hasOwnProperty("Cin_Loc")) {
                var group = cat.Cin_Loc;
                if (select.find("div[class='" +group+ " panel']").length === 0) {                    
                    select.append("<div class='"+group+" panel'><div class='panel-heading' role='tab'><h4 class='panel-title'><a role='button' data-toggle='collapse' data-parent='#Movies_accordion' href='#movie"+key+"' aria-expanded='true' aria-controls='collapseOne'><i class='more-less fas fa-chevron-circle-down'></i> AGS - "+cat.Cin_Loc+"</a></h4></div></div>");
                }
                var optionDiv = "<div id='movie"+key+"' class='panel-collapse collapse' role='tabpanel' aria-labelledby=''><div class='show-availabilities'><ul>";
                if(cat.soundsysimg == '') {            
                    if(cat.checkcount == '#F285A2') {
                        optionDiv += "<li><a href='#' class='btn text-default' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";                        
                        optionDiv += "</ul></div></div>";
                    } else if(cat.red_col == 'red') {
                        optionDiv += "<li><a href='#' class='btn text-danger' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";                        
                        optionDiv += "</ul></div></div>";
                    } else if(cat.checkcount == '#D4AF37') {
                        optionDiv += "<li><a href='javascript:void(0)' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' class='btn text-warning' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";                        
                        optionDiv += "</ul></div></div>";
                    } else {
                        optionDiv += "<li><a href='javascript:void(0)' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' class='btn text-warning' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";
                        optionDiv += "</ul></div></div>";                        
                    }
                
                } else {                      
                    if(cat.checkcount == '#F285A2') {  
                        optionDiv += "<li><a href='#' class='btn text-danger' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"' disabled>"+cat.showtime+"</a></li>";
                        optionDiv += "</ul></div></div>";
                    } else if(cat.red_col == 'red') {     
                        optionDiv += "<li><a href='#' class='btn text-success' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";                                   
                        optionDiv += "</ul></div></div>";
                    } else if(cat.checkcount == '#D4AF37') {
                        optionDiv += "<li><a href='javascript:void(0)' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' class='btn text-warning' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";                        
                        optionDiv += "</ul></div></div>";
                    } else {
                        optionDiv += "<li><a href='javascript:void(0)' onclick='session_value(\""+data[key].SessionId +"\",\""+data[key].Censor +"\",\""+data[key].Cin_id +"\")' class='btn text-default' data-toggle='tooltip' data-placement='top' title='"+cat.showtime+"'>"+cat.showtime+"</a></li>";
                        optionDiv += "</ul></div></div>";                        
                    }
                }       
                 select.find("div[class='" + group + " panel']").append(optionDiv);      
                // select.append(option);                  
            }     
        });
    }



</script>




