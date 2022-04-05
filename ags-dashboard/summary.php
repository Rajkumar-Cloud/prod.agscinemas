<?php 
 $title = "Summary Reports";
 $description = "AGS Cinemas Summary List";
 $keywords = "AGS Cinemas Summary List";
 $menu_name = "Summary";
 $Sub_title = "Summary Sales Report";
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
                            <!-- <label>from:</label><input type="date" id="startdate"></input>
                            <label>to:</label><input type="date" id="enddate"></input> -->
                            <table id="ags_summary_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>                                        
                                        <th>Cinema Name</th>
                                        <th>Movie Name</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th>Trans.Count</th>
                                        <th>Ticket Qty</th>
                                        <th>Movie Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Conv Fees( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Total Amount( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Cinema Name</th>
                                        <th>Movie Name</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th id="transCount"></th>
                                        <th id="TicketQty"></th>
                                        <th id="totalMovAmnt"></th>
                                        <th id="totalConvFee"></th>
                                        <th id="totalAmnt"></th>
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
    var data_table = $('#ags_summary_tbl').DataTable({                   
            "ajax": "classes/summary_report.php",
            "ordering" : true,
            "order": [[ 0, "asc" ]],
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
                { "data": "movie_location" },
                { "data": "movie_name" },
                { "data": "movie_date"},
                { "data": "movie_showtime"},
                { "data": "trans_count"},
                { "data": "ticket_qty"},
                { "data": "movie_amt"},
                { "data": "conv_fees"},
                { "data": "total_amt"},
            ],
            rowsGroup: [0,1,2,3,4],
            drawCallback: () => {
            //append tfoot and populate it with total cost
            $('#totalAmnt').html(`<b>Total:</b> ${$('#ags_summary_tbl').DataTable().column(8, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalConvFee').html(`<b>Total:</b> ${$('#ags_summary_tbl').DataTable().column(7, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalMovAmnt').html(`<b>Total:</b> ${$('#ags_summary_tbl').DataTable().column(6, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#TicketQty').html(`<b>Total:</b> ${$('#ags_summary_tbl').DataTable().column(5, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#transCount').html(`<b>Total:</b> ${$('#ags_summary_tbl').DataTable().column(4, {search:'applied'}).page.info().recordsDisplay}`);
            $('#ags_summary_tbl').DataTable().column(4).nodes().each(function(node, index, dt){
              $('#ags_summary_tbl').DataTable().cell(node).data($('#ags_summary_tbl').DataTable().column(4, {search:'applied'}).page.info().recordsDisplay);
            });
            },
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var ColIndex = column[0][0];
                    var title = $('#ags_summary_tbl thead th').eq( ColIndex ).text();
                    if(ColIndex != 4 && ColIndex != 5 && ColIndex != 6 && ColIndex != 7 && ColIndex != 8){
                        var select = $('<select id="'+title.split(' ').join('_')+'" style="width:auto" class="form-control"><option selected value="">'+title+'</option></select>')
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
            // data_table.column( 5 ).data().sum();                

        /*$( data_table.table().container() ).on( 'keyup', 'tfoot input', function () {
            data_table
                .column( $(this).data('index') )
                .search( this.value )
                .draw();
        } );*/
/*
        $('#ags_summary_tbl tfoot th').each( function (i) {
            var title = $('#ags_summary_tbl thead th').eq( $(this).index() ).text();
                var ColIndex = $(this).index();
                if(ColIndex != 4 && ColIndex != 5 && ColIndex != 6 && ColIndex != 7 && ColIndex != 8)
                    $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
        } );*/

        /*//custom date range filter
        $.fn.DataTable.ext.search.push((settings, row) => (new Date(row[17].split('-').reverse()) >= new Date($('#startdate').val().split('-')) || $('#startdate').val() == '') && (new Date(row[17].split('-').reverse()) <= new Date($('#enddate').val().split('-')) || $('#enddate').val() == ''));
        //bind 'from' / 'to' inputs
        $('input[type="date"]').on('change', function(){
          if($(this).attr('id') == 'startdate') $('#enddate').attr('min', $(this).val());
          else if ($(this).attr('id') == 'enddate') $('#startdate').attr('max', $(this).val());
          data_table.draw();
        });*/
});

</script>

