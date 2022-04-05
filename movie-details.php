<?php 
    include ('header.php'); 
?>

<section class="movie-detail-pg">
    <div class="banner-wrapper posterimage" >
        <div class="container">
            <div class="row">
                <div class="col-md-3">
                    <a href="javascript:void(0)" class="movies_link">
                        <div class="movie-box">
                            <div class="m-background-holder">
                                <img src="" id="official_cover_images" class="img-fluid" alt="" />
                            </div>                            
                            <div class="movie-stream"><p>Releasing on <span id="movie_realeasing_date"></span></p></div>
                        </div>
                    </a>
                </div>
                <div class="col-md-9">
                    <div class="movie-ordering-box">
                        <!-- <p class="premier"><i class="fas fa-play-circle"></i> PREMIERE</p> -->
                        <h3 id="movieName"></h3>
                        <p class="option">
                            <a href="javascript:void(0)">2D</a>
                            <!-- <a href="javascript:void(0)">3D</a>
			    <a href="">4DX</a>,
                            <a href="">MX4D</a>,
                            <a href="">IMAX 2D</a>,
                            <a href="">IMAX 3D</a> -->
                        </p> <br />
                        <!-- <p class="option" id="movie-lang">
                            <a href="javascript:void(0)"></a>
                        </p> -->
                        <ul>
                            <li id="movie_hours_time"></li>
                            <li id="movie_type"><a href="javascript:void(0)"></a></li>
                            <!-- <li>• 13+</li> -->
                            <!-- <li></li> -->
                            <li id="movie_censor"></li>
                        </ul>
                        <button type="button" class="btn btn-sm btn-primary" id="bookTicket_movie" value="" onclick="bookMovie_ticket('<?php echo $_SESSION['movieId'];?>');"><i class="fas fa-ticket-alt"></i> Book Tickets</button>
                        <button type="button" class="btn btn-sm btn-danger trailerPopup"><i class="fas fa-play-circle"></i> Play Trailer</button>
                    </div>
                </div>                
                <div class="movie-share">                        
                    <div class="d-inline-block">                        
                        <button type="button" class="btn btn-sm btn-outline-primary dropdown-toggle" id="dropdownSocialShare" title="Share this movie" name="movie-share" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><i class="fas fa-share-alt"></i>&nbsp; Share</button>
                        <ul class="dropdown-menu">                            
                            <li><a href="https://twitter.com/intent/tweet?url=<?php echo $SERVER_NAME.$_SERVER['REQUEST_URI'].'?temp='.$_SESSION['movieId'];?>"&text="tweet;socialWindow(<?php echo $SERVER_NAME.$_SERVER['REQUEST_URI'].'?temp='.$_SESSION['movieId'];?>);" title="Twitter share"><i class="fab fa-twitter-square"></i></a> </li>
                            <li><a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo $SERVER_NAME.$_SERVER['REQUEST_URI'].'?temp='.$_SESSION['movieId'];?>socialWindow(<?php echo $SERVER_NAME.$_SERVER['REQUEST_URI'].'?temp='.$_SESSION['movieId'];?>);" title="Facebook share"><i class="fab fa-facebook-square"></i></a></li>
                            <li><a href="javascript:void(0)" id="copyToClipboard" data-id="<?php echo $SERVER_NAME.$_SERVER['REQUEST_URI'].'?temp='.$_SESSION['movieId'];?>" title="Copy Link"><i class="fas fa-link"></i></a></li>
                        </ul>
                    </div>
                </div>                
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="movie-desc">
                    <h4><i class="fas fa-tags"></i> About the movie </h4>
                    <p id="moviesDesc"></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include('footer.php'); ?>
<script type="text/javascript">
    $(document).ready(function() {        
        var movie_code = "<?php echo $_SESSION['movieId']; ?>"; 
        // $("#bookTicket_movie").val('<?php echo $_SESSION['movieId']; ?>');      
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/php/getmovie_detail.php",            
            data: {movieId: movie_code},
            success: function(data) {
         	var imgID, posterImg, tempID, post_tempID, coverImgPath, posterImgPath;
                var url = window.location.protocol + "//" + window.location.host + "/assets/images/movies/";
                if(data.length != 0) {
		    imgID = data[0].coverimage;                    
                    posterImg = data[0].posterimage;
                    tempID = checkFileExist(url+imgID);
                    post_tempID = checkFileExist(url+posterImg);
                    if(tempID == true || post_tempID == true) {
                        coverImgPath = data[0].coverimage;
                        posterImgPath = data[0].posterimage;
                    } else {
                        coverImgPath = 'nocover.jpg';
                        posterImgPath = 'nocover.jpg';
                    }

                    $(".posterimage").css("background-image", 'linear-gradient(90deg, rgb(34, 34, 34) 24.97%, rgb(34, 34, 34) 38.3%, rgba(34, 34, 34, 0.04) 97.47%, rgb(34, 34, 34) 100%), url(assets/images/movies/'+ posterImgPath + ')');
                    $("#official_cover_images").attr('src', 'assets/images/movies/'+coverImgPath);
                    $(".trailerPopup").attr('onclick', 'movie_trailer("'+data[0].trailerURL+'")');
                    $('#movieName').html(data[0].FilmTitle);                   
                    if (data[0].FilmTitle.indexOf('Tamil') > -1 || data[0].FilmTitle.indexOf('TAMIL') > -1 || data[0].FilmTitle.indexOf('tamil') > -1) {
                        // $('#movie-lang').find('a').html("Tamil");
                    } else if (data[0].FilmTitle.indexOf('English') > -1 || data[0].FilmTitle.indexOf('ENGLISH') > -1 || data[0].FilmTitle.indexOf('english') > -1) {
                        // $('#movie-lang').find('a').html("English");
                    } else if (data[0].FilmTitle.indexOf('Hindi') > -1 || data[0].FilmTitle.indexOf('HINDI') > -1 || data[0].FilmTitle.indexOf('hindi') > -1) {
                        // $('#movie-lang').find('a').html("Hindi");
                    } else {
                        $('#movie-lang').css("display","none");
                    }
                    $('#movie-lang').find('a').html();
                    $('#movie_type').find('a').html('• ' +data[0].Genere);  
                    var t = data[0].FilmOpeningDate;                    
                    var newDate = new Date(t);
                    $('#movie_realeasing_date').html(newDate.toDateString());
                    var M_hours = Math.floor(data[0].Duration / 60);          
                    var M_minutes = data[0].Duration % 60;
                    $('#movie_hours_time').html('• '+M_hours+ 'h '+M_minutes+ 'm');
		    $('#movie_censor').html(data[0].Censor);
                    $('#moviesDesc').html(data[0].DescriptionLong);
                } else {
                    window.location.href = "movies.php";
                }                
            }
        });
        $("#copyToClipboard").click(function(e) {
            e.preventDefault();
            var content = $(this);    
            var copyText = content.data('id');
            document.addEventListener('copy', function(e) {
                e.clipboardData.setData('text/plain', copyText);
                e.preventDefault();
            }, true);
            document.execCommand('copy');
            Swal.fire({                
                icon: 'success',
                title: 'Clipboard url has been copied',
                showConfirmButton: false,
                timer: 2000
            })        
        });
    });

    function checkFileExist(urlToFile) {
        var xhr = new XMLHttpRequest();
        xhr.open('HEAD', urlToFile, false);
        xhr.send();
        if (xhr.status == "404") {
            return false;
        } else {
            return true;
        }
    }

    function bookMovie_ticket(id) {
        var datas = {'movieId':id };
        $.ajax({
            type:"POST",
            url:"classes/php/movie_session.php",
            data:datas
        }).done(function(data) {            
            sessionStorage.removeItem('Dategetting');
            window.location = "movies-time.php";
        });
    }
</script>