<?php 
 $title = "Cinema Show Transaction Reports";
 $description = "AGS Cinemas Show Transaction List";
 $keywords = "AGS Cinemas Show Transaction List";
 $menu_name = "Cinema Show Transaction";
 $Sub_title = "Cinema Show Sales Report";
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
                            <li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>
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
                            <!-- <label>from:</label><input type="date" id="startdate"></input>
                            <label>to:</label><input type="date" id="enddate"></input> -->
                            <table id="ags_cinema_show_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>
                                        <!-- <th>Booking ID</th>
                                        <th>VISTA ID</th>
                                        <th>Transaction No</th>
                                        <th>Name</th> -->
                                        <!-- <th>Email</th>
                                        <th>Mobile</th> -->
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <!-- <th>Seats</th> -->
                                        <!-- <th>Trans. Count</th> -->
                                        <th>Ticket Qty</th>
                                        <th>Movie Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Conv Fees( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Total Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <!-- <th>Status</th> -->
                                        <!-- <th>Status Discription</th> -->
                                        <!-- <th>Transaction Date</th> -->
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <!-- <th>Booking ID</th> -->
                                        <!-- <th>VISTA ID</th> -->
                                        <!-- <th>Transaction No</th> -->
                                        <!-- <th>Name</th> -->
                                        <!-- <th>Email</th>
                                        <th>Mobile</th> -->
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <!-- <th></th> -->
                                        <!-- <th></th> -->
                                        <th id="totalTicket"></th>
                                        <th id="totalMovAmnt"></th>
                                        <th id="totalConvFee"></th>
                                        <th id="totalAmnt"></th>
                                        <!-- <th>Status</th> -->
                                        <!-- <th></th> -->
                                        <!-- <th>Transaction Date</th> -->
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

<?php include('footer.php'); ?>
<script>

'use strict';
$(document).ready(function() {
    var data_table = $('#ags_cinema_show_tbl').DataTable({                  
            "ajax": "classes/cinema_show_transaction.php",
            "ordering" : true,
            columnDefs: [ { type: 'date', 'targets': [3] } ],
            "order": [[ 3, "asc" ]],
            "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                if(aData.trans_status == 'success')
                    $(nRow).find('td:eq(14)').addClass('text-success');
                if(aData.trans_status == 'failure')
                    $(nRow).find('td:eq(14)').addClass('text-danger');
                if(aData.trans_status == 'pending')
                    $(nRow).find('td:eq(14)').addClass('text-warning');
                /*$("td:first", nRow).html(iDisplayIndex +1);
                return nRow;*/
            },
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
                // { "data": "booking_id" },
                // { "data": "vista_id" },
                // { "data": "txnid" },
                // { "data": "name" },
                /*{ "data": "email" },
                { "data": "mobile" },*/
                { "data": "movie_name" },
                { "data": "movie_location" },
                { "data": "movie_screen"},
                { "data": "movie_date"},
                { "data": "movie_showtime"},
                // { "data": "seat_no"},
                { "data": "ticket_qty"},
                { "data": "movie_amt"},
                { "data": "conv_fees"},
                { "data": "total_amt"},
                // { "data": "trans_status"},
                // { "data": "unmappedstatus"},
                // { "data": "trans_date"},
            ],
            drawCallback: () => {
            //append tfoot and populate it with total cost
            // $('#totalTicket').html(`<b>Total:</b> ${$('#ags_cinema_show_tbl').DataTable().column(5, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalAmnt').html(`<b>Total:</b> ${$('#ags_cinema_show_tbl').DataTable().column(6, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalConvFee').html(`<b>Total:</b> ${$('#ags_cinema_show_tbl').DataTable().column(7, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalMovAmnt').html(`<b>Total:</b> ${$('#ags_cinema_show_tbl').DataTable().column(8, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            },
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var ColIndex = column[0][0];
                    var title = $('#ags_cinema_show_tbl thead th').eq( ColIndex ).text();
                    if(ColIndex != 8 && ColIndex != 7 && ColIndex != 6 && ColIndex != 5) {
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

        /*$( data_table.table().container() ).on( 'keyup', 'tfoot input', function () {
            data_table
                .column( $(this).data('index') )
                .search( this.value )
                .draw();
        } );*/

        $('#ags_cinema_show_tbl tfoot th').each( function (i) {
            var title = $('#ags_cinema_show_tbl thead th').eq( $(this).index() ).text();
                var ColIndex = $(this).index();
                if(ColIndex != 8 && ColIndex != 7 && ColIndex != 6 && ColIndex != 5)
                    $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
        } );

        /*//custom date range filter
        $.fn.DataTable.ext.search.push((settings, row) => (new Date(row[16].split('-').reverse()) >= new Date($('#startdate').val().split('-')) || $('#startdate').val() == '') && (new Date(row[16].split('-').reverse()) <= new Date($('#enddate').val().split('-')) || $('#enddate').val() == ''));
        //bind 'from' / 'to' inputs
        $('input[type="date"]').on('change', function(){
          if($(this).attr('id') == 'startdate') $('#enddate').attr('min', $(this).val());
          else if ($(this).attr('id') == 'enddate') $('#startdate').attr('max', $(this).val());
          data_table.draw();
        });*/
});

</script>

