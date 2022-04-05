<?php 
 $title = "Cinema Food Transaction Reports";
 $description = "AGS Cinemas Food Transaction List";
 $keywords = "AGS Cinemas Food Transaction List";
 $menu_name = "Cinema Food Transaction";
 $Sub_title = "Cinema Food Sales Report";
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
			<div class="card">
                            <div class="card-body pb-1">
                                <div class="row justify-content-between text-left">
                                    <div class="form-group col-sm-6 flex-column d-flex"><label class="form-control-label">From Date<span class="text-danger"> *</span></label><input type="date" id="startdate" class="form-control" name="startdate" placeholder="Select from date" /> </div>
                                    <div class="form-group col-sm-6 flex-column d-flex"> <label class="form-control-label">To Date<span class="text-danger"> *</span></label><input type="date" id="enddate" class="form-control" name="enddate" placeholder="Select To date" /> </div>
                                </div>
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table id="ags_food_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Invoice ID</th>
                                        <th>Transaction No</th>
                                        <th>Name</th>
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th>Seats</th>
                                        <th>Food Details</th>
                                        <th>Total Qty</th>
                                        <th>Price( <i class="fas fa-rupee-sign" aria-hidden="true"></i> )</th>
                                        <th>Delivery Mode</th>
                                        <th>Transaction Date</th>
                                        <th>Transaction Date</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Booking ID</th>
                                        <th>Invoice ID</th>
                                        <th>Transaction No</th>
                                        <th>Name</th>
                                        <th>Movie Name</th>
                                        <th>Movie Location</th>
                                        <th>Screen</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th></th>
                                        <th></th>
                                        <th id="totalFoodQty"></th>
                                        <th id="totalFoodPrice"></th>
                                        <th>Delivery Mode</th>
                                        <th>Transaction Date</th>
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

<?php include('footer.php'); ?>
<script>

'use strict';
$(document).ready(function() {
    var userRole = "<?php echo $_SESSION['userData']->user_role; ?>";
    var data_table = $('#ags_food_tbl').DataTable({                   
            "ajax": "classes/food_transaction.php",
            "ordering" : true,
            columnDefs: [ 
                { type: 'date', 'targets': [14] }, 
                { type: 'date', 'targets': [15], "visible": false, "searchable": true },
            ],
            "order": [[ 14, "asc" ]],
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
                { "data": "invoice_id" },
                { "data": "txnid" },
                { "data": "name" },
                { "data": "movie_name" },
                { "data": "movie_location" },
                { "data": "movie_screen"},
                { "data": "movie_date"},
                { "data": "movie_showtime"},
                { "data": "seat_no"},
                { "data": "food_details", defaultContent:"" , render: function(data, type, row, column){
                    if(data != null){
                        var html = '';
                        $.each(data, function(key, val){                            
                            html+='<p style="font-family: math;margin-bottom: 2px;"><label>Name :</label> <span style="color:chocolate;">'+val.foodName+'</span></p>';
                            html+='<p style="font-family: math;margin-bottom: 2px;"><label>Price :</label> <span style="color:chocolate;">'+val.foodPrice+'</span></p>';
                            html+='<p style="font-family: math;margin-bottom: 2px;"><label>Quantity :</label> <span style="color:chocolate;">'+val.foodQnty+'</span></p>';
                            html+='<p style="font-family: math;margin-bottom: 2px;"><label>Total Price :</label> <span style="color:#0753de;">'+val.totalFoodPrice+'</span></p>';
                            html+='<hr>';
                        });
                        return html;
                    }
                    }
                },
                { "data": "total_food_qty"},
                { "data": "total_food_price"},
                { "data": "delivery_mode"},
                { "data": "trans_dateTime"},
                { "data": "trans_date"},
            ],
            drawCallback: () => {
            //append tfoot and populate it with total cost
            $('#totalFoodPrice').html(`<b>Total:</b> ${$('#ags_food_tbl').DataTable().column(12, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            $('#totalFoodQty').html(`<b>Total:</b> ${$('#ags_food_tbl').DataTable().column(11, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
            },
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var ColIndex = column[0][0];
                    var title = $('#ags_food_tbl thead th').eq( ColIndex ).text();
                    if(ColIndex != 9 && ColIndex != 10 && ColIndex != 11 && ColIndex != 12){
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

        $('#ags_food_tbl tfoot th').each( function (i) {
            var title = $('#ags_food_tbl thead th').eq( $(this).index() ).text();
                var ColIndex = $(this).index();
                if(ColIndex != 9 && ColIndex != 10 && ColIndex != 11 && ColIndex != 12)
                    $(this).html( '<input type="text" placeholder="'+title+'" data-index="'+i+'" />' );
        } );

        //custom date range filter
        $.fn.DataTable.ext.search.push((settings, row) => (new Date(row[15].split('-').reverse()) >= new Date($('#startdate').val().split('-')) || $('#startdate').val() == '') && (new Date(row[15].split('-').reverse()) <= new Date($('#enddate').val().split('-')) || $('#enddate').val() == ''));
        //bind 'from' / 'to' inputs
        $('input[type="date"]').on('change', function(){
          if($(this).attr('id') == 'startdate') $('#enddate').attr('min', $(this).val());
          else if ($(this).attr('id') == 'enddate') $('#startdate').attr('max', $(this).val());
          data_table.draw();
        });
});


</script>

