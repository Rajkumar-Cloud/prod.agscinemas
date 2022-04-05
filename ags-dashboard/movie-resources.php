<?php 
    $title = "AGS Cinemas Add Movies Cover and Poster Images";
    $description = "AGS Cinemas Add Movies Cover and Poster Images";
    $keywords = "AGS Cinemas Add Movies Cover and Poster Images";
    include('header.php');

?>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Update Movies Cover, Poster Images with Trailer Video URL</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Movie Resources</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->
        <div class="row">
		<div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Movie Posters and Cover Images Section</h5>
                        <div class="w-100">
                            <div class="mt-2 mb-0 alert alert-info alert-dismissible fade show" role="alert" style="display:none" id="alert_Success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-check-circle"></i> Selecetd movie poster & cover images with trailer link updated <strong>successfully!</strong>.
                            </div>
                            <div class="mt-2 mb-0 alert alert-danger alert-dismissible fade show" role="alert" style="display:none" id="alert_Error">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i> Failed to update images. <strong>please try again!</strong>.
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-captitalize" id="addmovieimages-tab" data-toggle="tab" href="#addmovie_posters" role="tab" aria-controls="add poster images" aria-selected="true"><span class="feather f-15 icon-user-plus"></span> Add Movie Images</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-captitalize" id="viewmoviesposter-tab" data-toggle="tab" href="#viewmoviesposter_actions" role="tab" aria-controls="view poster images" aria-selected="false"><span class="feather f-15 icon-eye"></span> View Movie Posters Details</a>
                            </li>
                        </ul>
						<div class="tab-content" id="myTabContent">
							<div class="tab-pane fade show active" id="addmovie_posters" role="tabpanel" aria-labelledby="addmovieimages-tab">
                                <form class="addMovieResources_form" id="addMovieResources_form" name="addMovieResources_form" method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" id="movie__hid_arr" name="movie__hid_arr" />
                                    <div class="row">
                                        <div class="col-md-12 mt-2">                                
                                            <div class="form-group" id="awaitingMovies" style="position: relative;">
                                                <label for="movie_id"><i class="fas fa-film"></i> Select Movie ID & Name <sup style="color:red;">*</sup></label>
                                                <select class="form-control" id="movieId_name" name="movieId_name">
                                                    <option value="">Select Movie Id</option>                                                                                                   
                                                </select>        
                                                <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                                <span class="error__message" id="error_movieId"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                
                                            <div class="form-group">
                                                <label for="poster image"><i class="fas fa-photo-video"></i> Upload Movie Poster Image <sup style="color:red;">*</sup></label>
                                                <input type="file" class="form-control" id="movie_poster_image" name="movie_poster_image" required />
                                                <span class="error__message" id="error_movieposter"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                
                                            <div class="form-group">
                                                <label for="cover image"><i class="fas fa-photo-video"></i> Upload Movie Cover Image <sup style="color:red;">*</sup></label>
                                                <input type="file" class="form-control" id="movie_cover_image" name="movie_cover_image" required />
                                                <span class="error__message" id="error_moviecover"></span>
                                            </div>
                                        </div>                                
                                        <div class="col-md-6 preview_posterSection" style="display:none;">
                                            <div class="form-group">
                                                <label for="Poster image" style="font-size:13px;display:block;" class="text-muted"><i class="fas fa-photo-video"></i> Movie Poster Preview Image</label>
                                                <img class="img-thumbnail" id="poster_imgPreview" src="" alt="poster image" />
                                            </div>
                                        </div>
                                        <div class="col-md-6 preview_coverSection" style="display:none;">
                                            <div class="form-group">
                                                <label for="Cover image" style="font-size:13px;display:block;" class="text-muted"><i class="fas fa-photo-video"></i> Movie Cover Preview Image</label>
                                                <img class="img-thumbnail" id="cover_imgPreview" src="" alt="cover image" />
                                            </div>
                                        </div>
                                        <div class="col-md-12">                                
                                            <div class="form-group">
                                                <label for="trailer link"><span class="feather icon-link"></span> Movie Trailer Embed YouTube Link<sup style="color:red;">*</sup></label>
                                                <input type="text" class="form-control" id="movie_trailer_link" name="movie_trailer_link" required />
                                                <small id="emailHelp" class="form-text text-muted">Youtube embed code video src link for valid format.</small>
                                                <span class="error__message" id="error_movietrailer"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader" /></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="moviePoster_submitbtn" name="moviePoster_submitbtn"><i class="feather mr-2 icon-check-circle"></i>Submit</button>
                                            <button type="reset" class="btn btn-sm btn-outline-warning"><i class="feather icon-delete"></i> Reset</button>
                                        </div>                                                                        
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="viewmoviesposter_actions" role="tabpanel" aria-labelledby="viewmoviesposter-tab">
                            <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div>
                                <div class="table-responsive">
                                    <table id="posterImagesrecords_tbl" class="table display dataTable table-condensed mb-2">
                                        <thead>
                                            <tr>                                                                  
                                                <th>S.No</th>
                                                <th>Movie ID</th>
                                                <th>Movie Name</th>
                                                <th>Who Posted</th>                                                
                                                <th>Poster Image</th>                                                 
                                                <th>Cover Image</th>                                                                                                                                       
                                                <th>Trailer URL</th>                                                          
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

<div id="watch_trailer_embed_Modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header" style="padding: 6px 14px;">        
                <h5 class="modal-title" id="movie__trailer_name" style="font-size: 14px;"></h5>    
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body" style="padding:0;">               
                <iframe width="100%" height="252" src="" name="iframe_trailer_url" id="iframe_trailer_url" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>        
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        $('#movieId_name').attr('disabled', true);
        $('#awaitingMovies').find('img').css('display','block'); 
        setTimeout(function() { 
            $.ajax({             
                type:'GET',
                url: "../classes/getMovies.php",                
                success: function(data) {  
                    $('#movieId_name').attr('disabled', false);
                    $('#awaitingMovies').find('img').css('display','none');               
                    var movie_json = JSON.parse(data);
                    var option_arr = '';
                    if(movie_json.length > 0) {
                        for(var i = 0; i < movie_json.length; i++) {
                            option_arr += '<option value="'+movie_json[i].movieId+'">'+movie_json[i].movieId+' - '+movie_json[i].movieName+'</option>';
                        }
                        $('#movieId_name').append(option_arr);
                    } else {                  
                        $('#movieId_name').append('<option value="">Not Found</option>');
                    }
                }
            });
        }, 1000);

        $("#movieId_name").change(function () {
            var movieName = $("#movieId_name option:selected").text();
            var getm_arr = movieName.split(' - ');
            $('#movie__hid_arr').val(getm_arr['1']);
        });

        $("#movie_poster_image").change(function () {
            var filename = $('#movie_poster_image').val().replace(/C:\\fakepath\\/i, '');
            var ext = $('#movie_poster_image').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg','webp']) == -1) {
                $("#error_movieposter").html('Poster image should be a valid image format');   
                $("#movie_poster_image").val('');
                $('.preview_posterSection').hide();
            } else {
                $("#error_movieposter").html('');
                $('.preview_posterSection').show();
                $('.previewposter_actions').remove();
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader(); 
                    reader.onload = function (event) {
                        $("#poster_imgPreview").attr("src", event.target.result);
                        let closeBtn = '<button type="button" class="btn btn-icon btn-outline-primary has-ripple" title="Delete Image" onclick="removePosterImage();" aria-label="Close"><span class="feather icon-trash-2"></span></button>';
                        $('.preview_posterSection .form-group').append('<div class="previewposter_actions">'+filename+''+closeBtn+'</div>');
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        
        $("#movie_cover_image").change(function () {
            var filename = $('#movie_cover_image').val().replace(/C:\\fakepath\\/i, '');
            var ext = $('#movie_cover_image').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['png','jpg','jpeg','webp']) == -1) {
                $("#error_moviecover").html('Cover image should be a valid image format');   
                $("#movie_cover_image").val('');
                $('.preview_coverSection').hide();
            } else {
                $("#error_moviecover").html('');
                $('.preview_coverSection').show();
                $('.previewcover_actions').remove();
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader(); 
                    reader.onload = function (event) {
                        $("#cover_imgPreview").attr("src", event.target.result);
                        let closeBtn = '<button type="button" class="btn btn-icon btn-outline-primary has-ripple" title="Delete Image" onclick="removeCoverImage();" aria-label="Close"><span class="feather icon-trash-2"></span></button>';
                        $('.preview_coverSection .form-group').append('<div class="previewcover_actions">'+filename+''+closeBtn+'</div>');
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        
        $("#moviePoster_submitbtn").on('click', function () {
            var movieId = $("#movieId_name").val();
            var poster_image = $('#movie_poster_image').val();                    
            var cover_image = $('#movie_cover_image').val();
            var trailer_link = $('#movie_trailer_link').val();
            var poster_ext = poster_image.split('.').pop().toLowerCase();            
            var cover_ext = cover_image.split('.').pop().toLowerCase();            
            var validate = 0;   
            if (movieId == "") {
                $("#error_movieId").html('Please select movie id and its name');
                validate = 1;
            } else {    
                $("#error_movieId").html('');             
            }            
            if (poster_image == "") {
                $("#error_movieposter").html('Please upload movie poster image');
                validate = 1;
            } else {    
                if($.inArray(poster_ext, ['png','jpg','jpeg','webp']) == -1) {
                    $("#error_movieposter").html('Poster image should be a valid image format');                    
                    validate = 1;
                } else {
                    $("#error_movieposter").html('');             
                }
            }
            if (cover_image == "") {
                $("#error_moviecover").html('Please upload movie cover image');
                validate = 1;
            } else {    
                if($.inArray(cover_ext, ['png','jpg','jpeg','webp']) == -1) {
                    $("#error_moviecover").html('Cover image should be a valid image format');                    
                    validate = 1;
                } else {
                    $("#error_moviecover").html('');             
                }
            }
            if (trailer_link == "") {
                // $("#error_movietrailer").html('Please enter youtube embed code video link valid format');
                // validate = 1;
            } else {               
                var ytId = ytVidId(trailer_link);
                if (ytId == false) {                            
                    $("#error_movietrailer").html('Enter valid Youtube embed video link code format');                    
                    $('#movie_trailer_link').val('');
                    validate = 1;
                } else  {
                    $("#error_movietrailer").html(''); 
                }                                        
            }
            if (validate == 1) {
                return false;
            } else {
                $('.processLoader').show();
                $('#moviePoster_submitbtn').attr('disabled', true);
                setTimeout(function() {
                    var movieData = $("#addMovieResources_form").serialize();
                    $.ajax({ 
                        url: "classes/movie_resource.php?movie_Posters", 
                        type: "POST", 
                        data: movieData,                        
                        success: function(data) {   
                            var data = JSON.parse(data);
                            if(data.message == "inserted") {
                                var formData = new FormData($('#addMovieResources_form')[0]);                            
                                $.ajax({                                    
                                    url: "classes/movie_resource.php?addMovieimgs&rowId="+data.dataId+"&movieId="+data.movieId,
                                    type: "POST",
                                    data:  formData,
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    success: function(response){
                                        var data = JSON.parse(response);
                                        if(data.message == "success") { 
                                            $('#alert_Success').fadeIn();
                                            $('#moviePoster_submitbtn').attr('disabled', false);
                                            $('#addMovieResources_form')[0].reset();
                                            setTimeout(function(){ location.reload(); }, 5000);
                                        } else {
                                            $('#alert_Error').fadeIn();
                                            $('#moviePoster_submitbtn').attr('disabled', false);
                                            $('#addMovieResources_form')[0].reset();
                                            setTimeout(function(){ location.reload(); }, 5000);
                                        }
                                    }                                	        
                                });
                            } else {
                                $('#alert_Error').fadeIn();
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
	
$('#posterImagesrecords_tbl').DataTable({
            "processing": true,
            "serverSide": true,                    
            "ajax": "../ags-dashboard/classes/movie_poster_list.php",
            "columns": [
                { "data": "0" },
                { "data": "1" },
                { "data": "2" },
                { "data": "3" },
                { "data": "4" },
                { "data": "5" },
                { "data": "6" },
                { "data": "7" }
                        
            ],
            "order": [[ 0, "asc" ]],   
            "columnDefs": [
                {
                    targets: 4,
                    render: function (data, type, row, meta) {                        
                        if (type === 'display') {
                            data = '<img class="img-responsive posterImageAnim_preview" src="'+data+'" title="'+row['8']+', size: '+row['9']+'" style="width:120px;height: 72px;object-fit: cover;" alt="Poster image" />';
                        }
                        return data;
                    }
                },
                {
                    targets: 5,
                    render: function (data, type, row, meta) {                        
                        if (type === 'display') {
                            data = '<img class="img-responsive coverImageAnim_preview" src="'+data+'" title="'+row['10']+', size: '+row['11']+'" style="width:50px;" alt="Cover image" />';
                        }
                        return data;
                    }
                },
                {
                    targets: 6,
                    render: function (data, type, row, meta) {                          
                        if (type === 'display') {                          
                            if(data == null || data.length === 0) {
                                data = '<span class="badge badge-light-danger">Not available</span>';
                            } else {
                                data = '<button title="Play this movie trailer" name="watch_trailer_embed" id="watch_trailer_embed" data-name="'+row['2']+'" data-url="'+data+'" onClick="watch_trailer_embed(this)"><span class="fab fa-youtube"></span></button>';                                
                            }                            
                        }
                        return data;
                    }
                },
                {
                    targets: 8,
                    "orderable": false,
                    className: 'text-center',
                    render: function (data, type, row, meta) {                          
                        if (type === 'display') {
                            data = '<button type="button" title="Delete poster" data-id="'+row['0']+'" data-poster="'+row['8']+'" data-cover="'+row['10']+'" onclick="deletePoster_images(this);" class="btn btn-sm btn-icon btn-outline-danger has-ripple" style="width:22px;height:22px;font-size: 10px;"><i class="feather icon-trash"></i><span class="ripple ripple-animate" style="height:30px; width:30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -2.21094px; left: -8.92188px;"></span></button>';
                        }
                        return data;
                    }
                }

            ]
        });
	
    });

    function removePosterImage() {        
        $("#movie_poster_image").val('');        
        $('.preview_posterSection').hide();
        $('.previewposter_actions').not(this).remove();
    }

    function removeCoverImage() {        
        $("#movie_cover_image").val('');        
        $('.preview_coverSection').hide();
        $('.previewcover_actions').not(this).remove();
    } 

    function ytVidId(url) {
        var type_url = /^(?:https?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:embed\/|v\?.+&v=))((\w|-){11})(?:\S+)?$/;
        return (url.match(type_url)) ? RegExp.$1 : false;
    }
    
    function watch_trailer_embed(e) {
        var this_btn = $(e);        
        $('#movie__trailer_name').html(this_btn.data('name')+" - Trailer");
        $('#iframe_trailer_url').attr("src", this_btn.data('url'));
        $("#watch_trailer_embed_Modal").modal("show");
    }

    function deletePoster_images(e) {
        var this_btn = $(e);
        var rowId = this_btn.data("id");
        var poster = this_btn.data("poster");
        var cover = this_btn.data("cover");
        if (confirm('Sure want to delete this poster?')) {
            setTimeout(function() { 
                $.ajax({ 
                    url: "classes/movie_resource.php?delete_PosterImages",
                    type: "POST", 
		    data: { rowId:rowId, posterImg:poster, coverImg:cover },                                             
                    success: function(response) {   
                        var data = JSON.parse(response);                            
                        if(data.status == "success") {
                            $.toast({
                                heading: 'Deleted!',
                                text: 'This poster images has been deleted successfully!',
                                showHideTransition: 'fade',
                                icon: 'success',
                                position: 'top-center',
                                stack: false,
                                hideAfter: 6000
                            });                              
                            $('#posterImagesrecords_tbl').DataTable().ajax.reload();
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
                            $('#posterImagesrecords_tbl').DataTable().ajax.reload();
                        }                             
                    },
                    complete: function (data) { }
                });
            }, 100);
        }
    }

</script>