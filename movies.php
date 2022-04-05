<?php 
    include ('header.php'); 
    // include ('imageconfig.php');
    $profilepic = isset($_COOKIE['profilepic']);
    if($profilepic == '') {
        $profilepic = "dummyimg.png";  
    } else {
        $profilepic = $_COOKIE['profilepic'];
    }
?>
<!--
    <svg viewbox="0 0 0 0" width="0" height="0" style="display:block;position:relative;left:0px;top:0px;">
        <defs>
            <filter id="jssor_1_flt_1" x="-50%" y="-50%" width="200%" height="200%">
                <feGaussianBlur stddeviation="4"></feGaussianBlur>
            </filter>
            <radialGradient id="jssor_1_grd_2">
                <stop offset="0" stop-color="#fff"></stop>
                <stop offset="1" stop-color="#000"></stop>
            </radialGradient>
            <mask id="jssor_1_msk_3">
                <path fill="url(#jssor_1_grd_2)" d="M600,0L600,400L0,400L0,0Z" x="0" y="0" style="position:absolute;overflow:visible;"></path>
            </mask>
        </defs>
    </svg>
    <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:1600px;height:560px;overflow:hidden;visibility:hidden;">
        <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
            <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="assets/images/spin.svg" />
        </div>
        <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:1600px;height:560px;overflow:hidden;">
            <div style="background-color:#d3890e;">
                <img data-u="image" style="opacity:0.8;" data-src="assets/images/ags-home1.jpg" />                
            </div>
            <div>
                <img data-u="image" data-src="assets/images/banner-food.jpg" />                
            </div>
            <div style="background-color:#000000;">
                <img data-u="image" style="opacity:0.8;" data-src="assets/images/banner-staff-vacin.jpg" />                
            </div>            
           
        </div><a data-scale="0" href="https://www.jssor.com" style="display:none;position:absolute;">slider html</a>
        <div data-u="navigator" class="jssorb132" style="position:absolute;bottom:24px;right:16px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
            <div data-u="prototype" class="i" style="width:12px;height:12px;">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                </svg>
            </div>
        </div>
        <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
            </svg>
        </div>
        <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
            <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
            </svg>
        </div>
    </div> -->
    <div class="movies-wrapper">
        <section class="section-wrapper newmovie-collections">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="newvission-head">
                            <h3>Movies Library</h3>
                        </div>
                    </div>
                </div>
                <div class="row" id="newMovies_Listing">
                    
                </div>
                <div class="row">            
                    <div class="col-md-12">
                        <!-- <div class="viewmore-btn"><a  onclick="viewmore();" class="btn btn-sm btn-default">View more <i class="fas fa-angle-double-right"></i></a></div> -->
                    </div>
                </div>
            </div>
        </section>
    </div>

    <?php include('footer.php'); ?>
    <script type="text/javascript">
    $(document).ready(function() {        
        $.ajax({
            type: "GET",
            dataType: "json",
            url: "classes/getMovies.php",                     
            success: function(data) {
                var movieArr ='', imgID, tempID, coverImgPath;
                if(window.location.host == 'localhost')
                    var url = window.location.protocol + "//" + window.location.host + "/assets/images/movies/";
                else
                    var url = window.location.protocol + "//" + window.location.host + "/assets/images/movies/";
                data.sort().reverse();
                $.each(data, function (key, value) { 
                    if(key < 12) {
                        imgID = data[key].coverimage;
                        tempID = checkFileExist(url+imgID);
                        if(tempID == true) {
                            coverImgPath = data[key].coverimage;
                        } else {
                            coverImgPath = 'nocover.jpg';
                        }                      
                        movieArr +='<div class="col-md-3 movieDivId" id="movieDivId_'+key+'" data-id="'+key+'" data-toggle="tooltip" data-placement="top" title="'+data[key].movieName+'" onclick="view_movie_details(\''+data[key].movieId+'\')"><div class="movies_link"><div class="movie-box"><div class="m-background-holder">'+
                        '<img class="img-fluid" src="assets/images/movies/'+coverImgPath+'" alt="movie cover image" /></div><div class="movie-censor censor_'+data[key].Censor+'">'+data[key].Censor+'</div>'+
                        '<div class="movie-desc"><p class="movie-name">'+data[key].movieName+'</p><p class="lang">'+data[key].Language+'</p></div></div></div></div>';
                    }                    
                }); 
                if(data.length < 12){
                    <!-- $('.viewmore-btn').find('a').html('<i class="fas fa-ban text-danger"></i> No more movies').css('pointer-events','none').addClass('text-danger'); -->
                }               
                $("#newMovies_Listing").html(movieArr);
            }, error: function (error) {
                $("#newMovies_Listing").html('<div class="col-md-12"><div class="text-center notAvailable_newMovies p-3"><img class="img-fluid" src="assets/images/movies/not-found-movie.png" alt="" /></div></div>');
            }
        });    
    });    function checkFileExist(urlToFile) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlToFile, false);
        xhr.send();
        if (xhr.status == "404") {
            return false;
        } else {
            return true;
        }
    }

    function view_movie_details(str) {
        var datas = {'movieId':str };
        $.ajax({
            type:"POST",
            url:"classes/php/movie_session.php",
            data:datas
        }).done(function(data) {            
            sessionStorage.removeItem('Dategetting');
            window.location = "movie-details.php";
        });
    }
    </script>