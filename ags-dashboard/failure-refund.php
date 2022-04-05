<?php 
    $title = "AGS Cinemas Failure Refund";
    $description = "AGS Cinemas Failure Refund";
    $keywords = "AGS Cinemas Failure Refund";
    $menu_name = "Failure Refund";
    $Sub_title = "Failure Refund";

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
                    
                        <form class="addMovieFailureRefund_form" id="addMovieFailureRefund_form" name="addMovieFailureRefund_form" method="POST" action="" enctype="multipart/form-data">
                            <input type="hidden" id="movie__hname_arr" name="movie__hname_arr" />
                            <input type="hidden" id="movie__hsessionid_arr" name="movie__hsessionid_arr" />
                            <div class="row">
                                <div class="col-md-4 mt-2">                                
                                    <div class="form-group" id="awaitingMovies" style="position: relative;">
                                        <label for="movie_id"><i class="fas fa-film"></i> Select Movie ID & Name <sup style="color:red;">*</sup></label>
                                        <select class="form-control" id="movieId" name="movieId">
                                            <option value="">Select Movie Id</option>                                                                                                   
                                        </select>        
                                        <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                        <span class="error__message" id="error_movieId"></span>
                                    </div>
                                </div>
                                <div class="col-md-4 mt-2">                                
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
                                <div class="col-md-4 mt-2">                                
                                    <div class="form-group" id="awaitingMovies" style="position: relative;">
                                        <label for="movie_showDateTime"><i class="fas fa-film"></i> Select Show Date & Time <sup style="color:red;">*</sup></label>
                                        <select class="form-control" id="show_date_time" name="show_date_time">
                                            <option value="">Select Show Date & Time</option>                                                                                                   
                                        </select>        
                                        <img class="img-fluid" src="assets/images/loading-text.gif" style="position: absolute;top:2.5rem;left:20%;display:none;" alt="loader" />                        
                                        <span class="error__message error_showDateTime" id="error_ShowDateTime"></span>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader" /></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="movieFailureRefund" name="movieFailureRefund"><i class="feather mr-2 icon-check-circle"></i>Submit</button>
                                    <button id="reset" type="reset" class="btn btn-sm btn-outline-warning reset"><i class="feather icon-delete"></i> Reset</button>
                                </div>                                                                        
                            </div>
                        </form>
                                               
                    </div>
                </div>
            </div>
        </div>
        <div class="row">           
            <div class="col-xl-12 col-md-12">
                <div class="card table-card mb-1">
                    <div class="card-body">
                        <div class="card mt-2">
                            <div class="card-body pb-1">
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"><label class="form-control-label">From Date<span class="text-danger"> *</span></label><input type="date" id="startdate" class="form-control" name="startdate" placeholder="Select from date" /> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label">To Date<span class="text-danger"> *</span></label><input type="date" id="enddate" class="form-control" name="enddate" placeholder="Select To date" /> </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="ags_failure_refund_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>VISTA ID</th>
                                        <th>Transaction No</th>
                                        <th>Name</th>
                                        <!-- <th>Email</th>
                                        <th>Mobile</th> -->
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th>Seats</th>
                                        <th>Ticket Qty</th>
                                        <th>Movie Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Conv Fees( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Total Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Status</th>
                                        <th>Status Discription</th>
                                        <th>Transaction Date</th>
                                        <th>Action</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>VISTA ID</th>
                                        <th>Transaction No</th>
                                        <th>Name</th>
                                        <!-- <th>Email</th>
                                        <th>Mobile</th> -->
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th></th>
                                        <th></th>
                                        <th id="totalMovAmnt"></th>
                                        <th id="totalConvFee"></th>
                                        <th id="totalAmnt"></th>
                                        <th>Status</th>
                                        <th></th>
                                        <th>Transaction Date</th>
                                        <th></th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </tfoot>
                            </table>                            
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
            var SessionId = $("#movieId option:selected").data('sessionid');
            var getm_arr = movieName.split(' - ');
            $('#movie__hname_arr').val(getm_arr['1']);
            $('#movie__hsessionid_arr').val(SessionId);
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



        
        $("#movieFailureRefund").on('click', function () {
            var movieId = $("#movieId").val();
            var show_date_time = $("#show_date_time").val();           
            var movie_location = $("#movie_location").val();           
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
            
            
            if (validate == 1) {
                return false;
            } else {
                setTimeout(function() {
                    var userRole = "<?php echo $_SESSION['userData']->user_role; ?>";
                    var data_table = $('#ags_failure_refund_tbl').DataTable({   
                        destroy: true,                
                        "ajax": {
                            "url": "classes/failure_refund.php?MovieFailureRefund", 
                            "type": "POST", 
                            "data": function(d){
                                    d.form = $("#addMovieFailureRefund_form").serializeArray();
                                  },
                        },
                        "ordering" : true,
                        columnDefs: [ 
                            { type: 'date', 'targets': [16] }, 
                            { type: 'date', 'targets': [17], "visible": userRole == 1 || userRole == 6 || userRole == 7 }, 
                            { type: 'date', 'targets': [18], "visible": false, "searchable": true } 
                        ],
                        "order": [[ 16, "asc" ]],
                        "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                            if(aData.trans_status == 'success')
                                $(nRow).find('td:eq(14)').addClass('text-success');
                            if(aData.trans_status == 'failure')
                                $(nRow).find('td:eq(14)').addClass('text-danger');
                            if(aData.trans_status == 'pending')
                                $(nRow).find('td:eq(14)').addClass('text-warning');
                            // $("td:first", nRow).html(iDisplayIndex +1);
                            // return nRow;
                        },
                        fixedHeader: {
                            header: false,
                            footer: false
                        },
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
                        "columns": [
                            { "data": "booking_id" },
                            { "data": "vista_id" },
                            { "data": "txnid" },
                            { "data": "name" },
                            /*{ "data": "email" },
                            { "data": "mobile" },*/
                            { "data": "movie_name" },
                            { "data": "movie_location" },
                            { "data": "movie_screen"},
                            { "data": "movie_date"},
                            { "data": "movie_showtime"},
                            { "data": "seat_no"},
                            { "data": "ticket_qty"},
                            { "data": "movie_amt"},
                            { "data": "conv_fees"},
                            { "data": "total_amt"},
                            { "data": "trans_status"},
                            { "data": "unmappedstatus"},
                            { "data": "trans_dateTime"},
                            { "data": "action"},
                            { "data": "trans_date"},
                        ],
                        drawCallback: () => {
                        //append tfoot and populate it with total cost
                        $('#totalAmnt').html(`<b>Total:</b> ${$('#ags_failure_refund_tbl').DataTable().column(13, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
                        $('#totalConvFee').html(`<b>Total:</b> ${$('#ags_failure_refund_tbl').DataTable().column(12, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
                        $('#totalMovAmnt').html(`<b>Total:</b> ${$('#ags_failure_refund_tbl').DataTable().column(11, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
                        },
                        initComplete: function () {
                            
                            this.api().columns().every( function () {
                                var column = this;
                                var ColIndex = column[0][0];
                                var title = $('#ags_failure_refund_tbl thead th').eq( ColIndex ).text();
                                if(ColIndex != 9 && ColIndex != 10 && ColIndex != 11 && ColIndex != 12 && ColIndex != 13 && ColIndex != 15 && ColIndex != 17){
                                    var select = $('<select class="form-control"><option selected value="">'+title+'</option></select>')
                                        .appendTo( $(column.footer()).empty() )
                                        .on( 'change', function () {
                                            var val = $.fn.dataTable.util.escapeRegex(
                                                $(this).val()
                                            );
                     
                                            column
                                                .search( val ? '^'+val+'$' : '', true, false )
                                                .draw();
                                        } );
                     
                                    column.data().unique().sort().each( function ( d, j ) {
                                        if(d != null)
                                            select.append( '<option value="'+d+'">'+d+'</option>' )
                                    } );
                                }
                            } );
                        }                
                    });

                    $('#ags_failure_refund_tbl tfoot th').each( function (i) {
                        var title = $('#ags_failure_refund_tbl thead th').eq( $(this).index() ).text();
                            var ColIndex = $(this).index();
                            if(ColIndex != 9 && ColIndex != 10 && ColIndex != 11 && ColIndex != 12 && ColIndex != 13 && ColIndex != 15 && ColIndex != 17)
                                $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
                    } );

                    //custom date range filter
                    $.fn.DataTable.ext.search.push((settings, row) => (new Date(row[18].split('-').reverse()) >= new Date($('#startdate').val().split('-')) || $('#startdate').val() == '') && (new Date(row[18].split('-').reverse()) <= new Date($('#enddate').val().split('-')) || $('#enddate').val() == ''));
                    //bind 'from' / 'to' inputs
                    $('input[type="date"]').on('change', function(){
                      if($(this).attr('id') == 'startdate') $('#enddate').attr('min', $(this).val());
                      else if ($(this).attr('id') == 'enddate') $('#startdate').attr('max', $(this).val());
                      data_table.draw();
                    });            
                }, 3000);
            }
           $(".reset").click();
        });
    
    });




$(document).ready(function() {
    
});

function addRecordRefund(trans_id){
    $.ajax({ 
        url: "classes/refund_report.php?AddRefund",
        type: "POST", 
        data: { trans_id: trans_id },                        
        success: function(response) {   
            var data = JSON.parse(response);                       
            if(data.status == "success") {
                $.toast({
                    heading: 'Success',
                    text: 'This user has been refund successfully',
                    showHideTransition: 'fade',
                    icon: 'success',
                    position: 'top-center',
                    stack: false,
                    hideAfter: 4000
                });
                setTimeout(function(){ 
                    $('#ags_failure_refund_tbl').DataTable().ajax.reload();
                 }, 4000);          
            }else {
                $.toast({
                    heading: 'Error',
                    text: 'Failed to update refund',
                    showHideTransition: 'fade',
                    icon: 'error',
                    position: 'top-center',
                    stack: false,
                    hideAfter: 4000                                  
                });
                setTimeout(function(){ 
                    $('#ags_failure_refund_tbl').DataTable().ajax.reload();
                 }, 4000);
            }                                
        },
        complete: function (data) {                                         
            
        },
        error: function(data) {

        } 
    });
}

    

</script>