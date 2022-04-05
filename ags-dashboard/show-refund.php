<?php 
    $title = "AGS Cinemas Show Refund";
    $description = "AGS Cinemas Show Refund";
    $keywords = "AGS Cinemas Show Refund";
    $menu_name = "Show Refund";
    $Sub_title = "Show Refund";

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
                            <h5 class="m-b-10"><?php echo $title; ?></h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)"><?php echo $menu_name ?></a></li>
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
                        <h5><?php echo $Sub_title; ?></h5>
                        <div class="w-100">
                            <div class="mt-2 mb-0 alert alert-info alert-dismissible fade show" role="alert" style="display:none" id="alert_Success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-check-circle"></i> Selecetd movie show refund updated <strong>successfully!</strong>.
                            </div>
                            <div class="mt-2 mb-0 alert alert-danger alert-dismissible fade show" role="alert" style="display:none" id="alert_Error">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i> Failed to update movie show refund. <strong>please try again!</strong>.
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <ul class="nav nav-tabs mb-3" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active text-captitalize" id="addshowrefund-tab" data-toggle="tab" href="#addshowrefund" role="tab" aria-controls="add poster images" aria-selected="true"><span class="feather f-15 icon-user-plus"></span> Add Show Refund</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-captitalize" id="viewshowrefund-tab" data-toggle="tab" href="#viewshowrefund_actions" role="tab" aria-controls="view poster images" aria-selected="false"><span class="feather f-15 icon-eye"></span> View Show Refund</a>
                            </li>
                        </ul>
                        <div class="tab-content" id="myTabContent">
                            <div class="tab-pane fade show active" id="addshowrefund" role="tabpanel" aria-labelledby="addshowrefund-tab">
                                <form class="addMovieShowRefund_form" id="addMovieShowRefund_form" name="addMovieShowRefund_form" method="POST" action="" enctype="multipart/form-data">
                                    <input type="hidden" id="movie__hname_arr" name="movie__hname_arr" />
                                    <input type="hidden" id="movie__hsessionid_arr" name="movie__hsessionid_arr" />
                                    <div class="row">
                                        <div class="col-md-6 mt-2">                                
                                            <div class="form-group" id="awaitingMovies" style="position: relative;">
                                                <label for="movie_id"><i class="fas fa-film"></i> Select Movie ID & Name <sup style="color:red;">*</sup></label>
                                                <select class="form-control" id="movieId" name="movieId">
                                                    <option value="">Select Movie Id</option>                                                                                                   
                                                </select>        
                                                <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                                <span class="error__message" id="error_movieId"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">                                
                                            <div class="form-group" id="awaitingMovies" style="position: relative;">
                                                <label for="movie_showDateTime"><i class="fas fa-film"></i> Select Location <sup style="color:red;">*</sup></label>
                                                <select class="form-control" id="movie_location" name="movie_location">
                                                    <option value="">Select location</option>            
                                                    <option value="1">AGS TNAGAR</option>
                                                    <option value="2">AGS NAVALUR</option>
                                                    <option value="3">AGS VILLVAKKAM</option>                                       
                                                    <option value="4">AGS ALAPAKKAM</option>
                                                </select>        
                                                <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                                <span class="error__message error_movieLocation" id="error_movieLocation"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6 mt-2">                                
                                            <div class="form-group" id="awaitingMovies" style="position: relative;">
                                                <label for="movie_showDateTime"><i class="fas fa-film"></i> Select Show Date & Time <sup style="color:red;">*</sup></label>
                                                <select class="form-control" id="show_date_time" name="show_date_time">
                                                    <option value="">Select Show Date & Time</option>                                                                                                   
                                                </select>        
                                                <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                                <span class="error__message error_showDateTime" id="error_ShowDateTime"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">                                
                                            <div class="form-group">
                                                <label for="remark"><span class="feather icon-book"></span>Remark<sup style="color:red;">*</sup></label>
                                                <input type="text" class="form-control" id="movie_remark" name="movie_remark"  placeholder="Enter the remark" required />
                                                <!-- <small id="remark" class="form-text text-muted">Enter the remark.</small> -->
                                                <span class="error__message" id="error_movieremark"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader" /></div>
                                            <button type="button" class="btn btn-sm btn-outline-primary" id="movieShowRefund" name="movieShowRefund"><i class="feather mr-2 icon-check-circle"></i>Submit</button>
                                            <button type="reset" class="btn btn-sm btn-outline-warning"><i class="feather icon-delete"></i> Reset</button>
                                        </div>                                                                        
                                    </div>
                                </form>
                            </div>
                            <div class="tab-pane fade" id="viewshowrefund_actions" role="tabpanel" aria-labelledby="viewshowrefund-tab">
                                <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div>
                                <div class="table-responsive">
                                    <table id="showrefund_tbl" class="showrefund_tbl table display dataTable table-condensed mb-2" width="100%">
                                        <thead>
                                            <tr>
                                                <th>Movie ID</th>
                                                <th>Movie Name</th>
                                                <th>Location</th>
                                                <th>Show Date & Time</th>
                                                <th>Who Posted</th>                                                
                                                <th>Remark</th>                       
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

    'use strict';
    var data_table = $('#showrefund_tbl').DataTable({                   
        "ajax": "classes/show_refund.php?GetShowRefund",
        "ordering" : true,
        "paging": false,
        "order": [[ 0, "asc" ]],
        dom: 'Blfrtip',
        buttons: [
          'lengthMenu', 'copy', 'csv', 'excel',
            {
                extend : 'pdfHtml5',
                title : function() {
                    return "<?php echo $title; ?>";
                },
                orientation : 'landscape',
                pageSize : 'TABLOID',
                text : '<i class="fa fa-file-pdf-o">PDF</i>',
                titleAttr : 'PDF'
            },
            {
                extend : 'print',
                title : function() {
                    return "<?php echo $title; ?>";
                },
                orientation : 'landscape',
                pageSize : 'TABLOID',
                text : '<i class="fa fa-file-print-o">Print</i>',
                titleAttr : 'Print'
            }
        ],
        "oLanguage": {
            "sInfo": "Showing _START_ to _END_ of _TOTAL_ items."
        },
        "columns": [
            { "data": "movieId" },
            { "data": "movieName" },
            { "data": "location" },
            { "data": "showDateTime"},
            { "data": "whoPosted"},
            { "data": "remark"},
        ],               
    });

    $(document).ready(function() {

        $('#movieId').attr('disabled', true);
        $('#show_date_time').attr('disabled', true);
        $('#awaitingMovies').find('img').css('display','block'); 
        setTimeout(function() { 
            $.ajax({             
                type:'GET',
                url: "classes/show_refund.php?getMovieDetails",                
                success: function(data) {  
                    $('#movieId').attr('disabled', false);
                    $('#awaitingMovies').find('img').css('display','none');               
                    var movie_json = JSON.parse(data);
                    var option_arr = '';
                    if(movie_json.length > 0) {
                        for(var i = 0; i < movie_json.length; i++) {
                            option_arr += '<option value="'+movie_json[i].movie_id+'" data-sessionid="'+movie_json[i].movie_sessionId+'">'+movie_json[i].movie_id+' - '+movie_json[i].movie_name+'</option>';
                        }
                        $('#movieId').append(option_arr);
                    } else {                  
                        $('#movieId').append('<option value="">Not Found</option>');
                    }
                }
            });
        }, 1000);

        $("#movieId").change(function () {
            var movieName = $("#movieId option:selected").text();
            var getm_arr = movieName.split(' - ');
            $('#movie__hname_arr').val(getm_arr['1']);
        });

        setTimeout(function() { 
            $.ajax({             
                type:'GET',
                url: "classes/show_refund.php?getMovieShowDateTimeDetails",                
                success: function(data) {  
                    $('#show_date_time').attr('disabled', false);
                    $('#awaitingMovies').find('img').css('display','none');               
                    var movie_json = JSON.parse(data);
                    var option_arr = '';
                    if(movie_json.length > 0) {
                        for(var i = 0; i < movie_json.length; i++) {
                            option_arr += '<option value="'+movie_json[i].movie_showDateTime+'" data-sessionid="'+movie_json[i].movie_sessionId+'">'+movie_json[i].movie_showDateTime+'</option>';
                        }
                        $('#show_date_time').append(option_arr);
                    } else {                  
                        $('#show_date_time').append('<option value="">Not Found</option>');
                    }
                }
            });
        }, 1000);

        $("#show_date_time").change(function () {
            var SessionId = $("#show_date_time option:selected").data('sessionid');
            $('#movie__hsessionid_arr').val(SessionId);
        });


        
        $("#movieShowRefund").on('click', function () {
            var movieId = $("#movieId").val();
            var show_date_time = $("#show_date_time").val();
            var movie_location = $("#movie_location").val();
            var remark = $('#movie_remark').val();           
            var validate = 0;   
            if (movieId == "") {
                $("#error_movieId").html('Please select movie id and its name');
                validate = 1;
            } else {    
                $("#error_movieId").html('');             
            }
            if (show_date_time == "") {
                $(".error_showDateTime").html('Please select movie show date and time');
                validate = 1;
            } else {    
                $(".error_showDateTime").html('');             
            }            
            
            if (movie_location == "") {
                $(".error_movieLocation").html('Please select movie location');
                validate = 1;
            } else {    
                $(".error_movieLocation").html('');             
            } 
            if (remark == "") {
                $("#error_movieremark").html('Enter the remark');
                    validate = 1;
            } else {               
                $("#error_movieremark").html('');                                      
            }
            if (validate == 1) {
                return false;
            } else {
                $('.processLoader').show();
                $('#movieShowRefund').attr('disabled', true);
                setTimeout(function() {
                    var movieData = $("#addMovieShowRefund_form").serialize();
                    $.ajax({ 
                        url: "classes/show_refund.php?addMovieShowRefund", 
                        type: "POST", 
                        data: movieData,                        
                        success: function(data) {   
                            var data = JSON.parse(data);                                                      
                            if(data.message == "success") { 
                                $('#alert_Success').fadeIn();
                                $('#movieShowRefund').attr('disabled', false);
                                $('#addMovieShowRefund_form')[0].reset();
                                setTimeout(function(){ location.reload(); }, 5000);
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
    
    });

    

</script>