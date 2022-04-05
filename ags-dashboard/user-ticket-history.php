<?php 
 $title = "Cinema Users Ticket History";
 $description = "AGS Cinemas Users Ticket History List";
 $keywords = "AGS Cinemas Users Ticket History List";
 $menu_name = "Cinema Users Ticket History";
 $Sub_title = "Cinema Users Ticket History";
 include('header.php'); 
?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
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
        <div class="row">			
        <div class="col-xl-12 col-md-12">
		<div class="card table-card mb-1">
                    <div class="card-header">
                        <h5><?php echo $Sub_title; ?></h5>
                        <div class="card-header-right">
                            <div class="btn-group card-option">
                                <button type="button" class="btn dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="feather icon-more-horizontal"></i>
                                </button>
                                <ul class="list-unstyled card-option dropdown-menu dropdown-menu-right">
                                    <li class="dropdown-item full-card"><a href="javascript:void(0)"><span><i class="feather icon-maximize"></i> maximize</span><span style="display:none"><i class="feather icon-minimize"></i> Restore</span></a></li>
                                    <li class="dropdown-item minimize-card"><a href="javascript:void(0)"><span><i class="feather icon-minus"></i> collapse</span><span style="display:none"><i class="feather icon-plus"></i> expand</span></a></li>
                                    <li class="dropdown-item reload-card"><a href="javascript:void(0)"><i class="feather icon-refresh-cw"></i> reload</a></li>                                    
                                </ul>
                            </div>
                        </div>
                    </div>  
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ags_user_ticket_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>
                                        <!-- <th></th> -->
                                        <!-- <th>S.No</th> -->
                                        <th>Name</th>
                                        <th>Email ID</th>
                                        <th>Mobile</th>
                                        <th>Movie Name</th>
                                        <th>Location</th>
                                        <th>Ticket Qty</th>
                                        <th>Source</th>
                                        <!-- <th>Ticket ID</th> -->
                                        <!-- <th>Transaction ID</th> -->
                                        <!-- <th>Status</th> -->
                                        <!-- <th>Ticket Cost</th> -->
                                        <!-- <th>Booked Date</th> -->
                                        <!-- <th>Show Date</th> -->
                                        <!-- <th>Show Time</th> -->
                                        <!-- <th>Action</th> -->
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

<div class="modal fade animated mivieTicket_model" id="mivieTicket_model" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm downloadTicket">
    <div class="modal-content">
      <div class="modal-header">
          <img class="img-fluid" src="../assets/images/logos/ags-logo.jpg" alt="logo" />
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><i class="fas fa-times"></i></button>
      </div>
      <div class="modal-body">
          <div class="row">
              <div class="col-md-12">
                  <div class="ticket-data-list">
                      <label class="form-label" style='display:inline;'><i class="fas fa-film"></i> Movie Name:</label>
                      <p class="movie_Name"></p>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-data-list">
                      <label class="form-label"><i class="fas fa-calendar-day"></i> Date</label>
                      <p class="movie_date"></p>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-data-list">
                      <label class="form-label"><i class="fas fa-clock"></i> Time</label>
                      <p class="movie_showtime"></p>
                  </div>
              </div>
          </div>
          <div class="row">
              <div class="col-md-4 pr-1">
                  <div class="ticket-data-list">
                        <img id="imageURL" src="" class="img-fluid" alt="movie poster" />
                  </div>
              </div>
              <div class="col-md-8 pl-0">
                  <div class="ticket-data-list">
                      <table class="table table-border">
                          <tbody class="ticketDetails">
                                              
                          </tbody>                         
                       </table>
                  </div>
              </div>              
          </div>
          <div class="row">
                <div class="col-md-12">
                    <div class="panel-group" id="paymentreceiptaccordion">
                        <div class="panel panel-default">
                            <div class="panel-heading">
                                <h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#paymentreceiptaccordion" href="#collapseOne"> View payment details <span class="fas fa-arrow-circle-down" style="float: right;"></span></a></h5>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in show">
                                <div class="panel-body">
                                    <ul class="paymentDetails">
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
              <div class="col-md-5">
                  <div class="ticket-qrbarcode">
                        <div id="qrcodesss"></div>
                  </div>
              </div>
              <div class="col-md-6">
                  <div class="ticket-qrbarmessage">
                        <p>Scan your QR Code <br />for more details</p>
                  </div>
              </div>
          </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
<script>

'use strict';
$(document).ready(function() {
    var data_table = $('#ags_user_ticket_tbl').DataTable({
            "ajax": {
               "url": 'classes/user_booking_history.php',
               "type": 'POST',
               "data": {txnid: '', type: 'history'}
            },
            "ordering" : true,
            // columnDefs: [ { type: 'date', 'targets': [16] } ],
            "order": [[ 0, "asc" ]],
            /*"fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            },*/
            fixedHeader: {
                header: true,
                footer: true
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
                // { "data": "s_no" },
                /*{
                    "className":      'dt-control',
                    "orderable":      false,
                    "data":           null,
                    "defaultContent": ''
                },*/
                { "name":"name", "data": "name", orderable: true },
                { "name":"email", "data": "email", orderable: true },
                { "name":"mobile", "data": "mobile", orderable: true },
                { "data": "movie_name", orderable: true },
                { "data": "movie_location", orderable: true },
                { "data": "ticket_qty", orderable: true },
                { "data": "source", orderable: true },
                // { "data": "booking_id" },
                // { "data": "txnid" },
                // { "data": "status"},
                // { "data": "total_amt"},
                // { "data": "booking_date" },
                // { "data": "movie_date"},
                // { "data": "movie_showtime"},
                // { "data": "action"},
            ],
            rowsGroup: [
              'name:name',
              'email:name',
              'mobile:name',
              3,4
            ]/*,
            drawCallback: () => {
            //append tfoot and populate it with total cost
            $('#totalAmnt').html(`<b>Total:</b> ${$('#ags_user_ticket_tbl').DataTable().column(13, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalConvFee').html(`<b>Total:</b> ${$('#ags_user_ticket_tbl').DataTable().column(12, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalMovAmnt').html(`<b>Total:</b> ${$('#ags_user_ticket_tbl').DataTable().column(11, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            }*//*,
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var select = $('<select><option value=""></option></select>')
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
                        select.append( '<option value="'+d+'">'+d+'</option>' )
                    } );
                } );
            }*/                
        });

        /*$( data_table.table().container() ).on( 'keyup', 'tfoot input', function () {
            data_table
                .column( $(this).data('index') )
                .search( this.value )
                .draw();
        } );

        $('#ags_user_ticket_tbl tfoot th').each( function (i) {
            var title = $('#ags_user_ticket_tbl thead th').eq( $(this).index() ).text();
                var ColIndex = $(this).index();
                if(ColIndex != 9 && ColIndex != 10 && ColIndex != 11 && ColIndex != 12 && ColIndex != 13 && ColIndex != 15)
                    $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
        } );

        //custom date range filter
        $.fn.DataTable.ext.search.push((settings, row) => (new Date(row[16].split('-').reverse()) >= new Date($('#startdate').val().split('-')) || $('#startdate').val() == '') && (new Date(row[16].split('-').reverse()) <= new Date($('#enddate').val().split('-')) || $('#enddate').val() == ''));
        //bind 'from' / 'to' inputs
        $('input[type="date"]').on('change', function(){
          if($(this).attr('id') == 'startdate') $('#enddate').attr('min', $(this).val());
          else if ($(this).attr('id') == 'enddate') $('#startdate').attr('max', $(this).val());
          data_table.draw();
        });*/

        $('#ags_user_ticket_tbl tbody').on('click', 'td.dt-control', function () {
            var tr = $(this).closest('tr');
            var row = data_table.row( tr );

            if ( row.child.isShown() ) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            }
            else {
                // Open this row
                row.child( format(row.data()) ).show();
                tr.addClass('shown');
            }
        } );

        function format ( d ) {
            // `d` is the original data object for the row
            return '<table id="ags_user_ticket_tbl" class="table display dataTable table-condensed mb-1">'+
                '<thead><tr>'+
                    '<th>Source</th></thead><tbody><tr>'+
                    '<td>'+d.source+'</td>'+
                '</tr></tbody>'+
            '</table>';
        }
});
function download_ticket(txnid) {
    showtickets(txnid);
    // $("#mivieTicket_model").modal('show');
    // $("#mivieTicket_model").css('display', 'block');
    html2canvas($('.downloadTicket'), {
        onrendered: function (canvas) {
            var a = document.createElement('a');
            a.href = canvas.toDataURL("image/jpeg").replace("image/jpeg", "image/octet-stream");
            a.download = txnid+'.jpg';
            a.click();
        }
    })/*.then((canvas) => {
       $("#mivieTicket_model").modal('hide');
    $("#mivieTicket_model").css('display', 'none');
    })*/;
}


function showtickets(userId, txnid) {
    document.getElementById('qrcodesss').innerHTML = '';
    jQuery(".ticketDetails").html('');
    jQuery(".paymentDetails").html('');
    $(".movie_Name").html('');
    $(".movie_date").html('');
    $(".movie_showtime").html('');
    $("#imageURL").attr('src', '');
    var ticketDetails = '';
    var paymentDetails = '';
    var userId = userId;
    var datas = {userId: userId, txnid: txnid, type: 'tickets' };
    $.ajax({
        type:"POST",
        url:"classes/user_booking_history.php",
        data:datas
    }).done(function(data) { 
        var raw = JSON.parse(data);
        $(".movie_Name").html(raw.movie_name);
        $(".movie_date").html(raw.movie_date);
        $(".movie_showtime").html(raw.movie_showtime);
        $("#imageURL").attr('src', '../assets/images/movies/'+raw.movieId+'_cover.jpg');
        var total_val = raw.total_amt;
        // var total_val = 1;
        ticketDetails = '<tr><td>Theatre Location: </td><td>'+ raw.movie_location +'</td></tr>';
        ticketDetails += '<tr><td>Ticket No: </td><td>'+ raw.ticket_num +'</td></tr>';
        ticketDetails += '<tr><td>Screen: </td><td>'+ raw.movie_screen +'</td></tr>';
        ticketDetails += '<tr><td>Seat No: </td><td>'+ raw.movie_seat.join(", ") +'</td></tr>';

        paymentDetails = '<li>Seat Cost: <span class="totalamount"><i class="fas fa-rupee-sign"></i>'+ raw.movie_amt +'</span></li>';
        // paymentDetails += '<li>Food Cost: <span class="foodvalue"><i class="fas fa-rupee-sign"></i>'+ raw.foodvalue +'</span></li>';
        paymentDetails += '<li>Booking Cost: <span class="conv_fees"><i class="fas fa-rupee-sign"></i>'+ raw.conv_fees +'</span></li>';
        paymentDetails += '<li>Total Amount: <span class="total_val"><i class="fas fa-rupee-sign"></i>'+ total_val +'</span></li>';

        var tiknum = raw.ticket_num;      
        var qrcode = new QRCode(document.getElementById('qrcodesss'),{width : 65,height : 65}); 
        qrcode.makeCode(tiknum); 

        jQuery(".ticketDetails").append(ticketDetails);
        jQuery(".paymentDetails").append(paymentDetails);


    });
}


</script>

