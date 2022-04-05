<?php include('header.php'); ?>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">AGS Dashboard Analytics</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->      
        <div class="row homeIndexedTables">
            <div class="col-sm-12">
                <div class="card overflow-hidden mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-chart-line"></i> Sales(Excl. Return)</h5>                        
                        <button type="button" title="Reload Data" onclick="salesExclRetn_fn(this);" class="btn btn-sm btn-icon btn-outline-primary has-ripple" style="float:right;width:22px;height:22px;font-size: 10px;"><i class="fa fa-sync"></i><span class="ripple ripple-animate" style="height: 30px; width: 30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -4.85938px; left: -4.03906px;"></span></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="agsSalesexclReturn_tbl" class="table hover display mb-1">
                                <thead>
                                    <tr>        
                                        <th>Outlet Name</th>                
                                        <th>This Day</th>
                                        <th>Prev Day</th>
                                        <th>This Week<br><small>(Sun - Sat)</small></th>
                                        <th>Prev Week<br><small>(Sun - Sat)</small></th>
                                        <th>This<br>Month</th> 
                                        <th>Prev<br>Month</th>                                      
                                        <th>This Fin<br>Yr</th>
                                        <th>Prev Fin<br>Yr</th>           
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Total</th>
                                        <th id="thisDay"></th>
                                        <th id="prevDay"></th>
                                        <th id="thisWeek"></th>
                                        <th id="prevWeek"></th>
                                        <th id="thisMnth"></th>
                                        <th id="prevMnth"></th>
                                        <th id="thisYr"></th>
                                        <th id="prevYr"></th>
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>                            
                </div>
            </div>
            <div class="col-sm-12">
                <div class="card overflow-hidden mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-shopping-bag"></i> Purchase Receivable <small style="color: #343a40;font-weight: bold;text-shadow: 0px 0px 1px #0000003b;background-color: #ff0;font-size: 10px;">(Food Details)</small></h5>
                        <button type="button" title="Reload Data" onclick="purchaseReceive_fn(this);" class="btn btn-sm btn-icon btn-outline-primary has-ripple" style="float:right;width:22px;height:22px;font-size: 10px;"><i class="fa fa-sync"></i><span class="ripple ripple-animate" style="height: 30px; width: 30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -4.85938px; left: -4.03906px;"></span></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="agsPurchaserec_tbl" class="table hover display mb-1">
                                <thead>
                                    <tr>        
                                        <th>Outlet Name</th>                    
                                        <th>This Day</th>
                                        <th>Prev Day</th>
                                        <th>This Week<br><small>(Sun - Sat)</small></th>
                                        <th>Prev Week<br><small>(Sun - Sat)</small></th> 
                                        <th>This<br>Month</th> 
                                        <th>Prev<br>Month</th>                                      
                                        <th>This Fin<br>Yr</th>
                                        <th>Prev Fin<br>Yr</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                    
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Total</th>
                                        <th id="purchaseThisDay"></th>
                                        <th id="purchasePrevDay"></th>
                                        <th id="purchaseThisWeek"></th>
                                        <th id="purchasePrevWeek"></th>
                                        <th id="purchaseThisMnth"></th>
                                        <th id="purchasePrevMnth"></th>
                                        <th id="purchaseThisYr"></th>
                                        <th id="purchasePrevYr"></th>                                       
                                    </tr>
                                </tfoot>
                            </table>                            
                        </div>
                    </div>                            
                </div>
            </div>

            <div class="col-sm-12">
                <div class="card overflow-hidden mb-3">
                    <div class="card-header">
                        <h5><i class="fas fa-exchange-alt"></i> Sales Return <small style="color:#ff5252;font-weight: bold;text-shadow: 0px 0px 1px #0000003b;background-color: #ff0;font-size: 10px;">(Refund)</small></h5>
                        <button type="button" title="Reload Data" onclick="salesReturn_fn(this);" class="btn btn-sm btn-icon btn-outline-primary has-ripple" style="float:right;width:22px;height:22px;font-size: 10px;"><i class="fa fa-sync"></i><span class="ripple ripple-animate" style="height: 30px; width: 30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -4.85938px; left: -4.03906px;"></span></button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="agsSalesReturn_tbl" class="table hover display mb-1">
                            <thead>
                                    <tr>        
                                        <th>Outlet Name</th>                    
                                        <th>This Day</th>
                                        <th>Prev Day</th>
                                        <th>This Week<br><small>(Sun - Sat)</small></th>
                                        <th>Prev Week<br><small>(Sun - Sat)</small></th> 
                                        <th>This<br>Month</th> 
                                        <th>Prev<br>Month</th>                                      
                                        <th>This Fin<br>Yr</th>
                                        <th>Prev Fin<br>Yr</th>                            
                                    </tr>
                                </thead>
                                <tbody>
                                                               
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th class="text-center">Total</th>
                                        <th id="refundThisDay"></th>
                                        <th id="refundPrevDay"></th>
                                        <th id="refundThisWeek"></th>
                                        <th id="refundPrevWeek"></th>
                                        <th id="refundThisMnth"></th>
                                        <th id="refundPrevMnth"></th>
                                        <th id="refundThisYr"></th>
                                        <th id="refundPrevYr"></th>                                       
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
$(document).ready(function() {    

    var data_table_Salesexcl = $('#agsSalesexclReturn_tbl').DataTable({  
        "ajax": "classes/dashboard.php?Salesexcl",
        "ordering" : true,
        "order": [[ 0, "asc" ]],
        dom: 'Blfrtip',
        buttons: [
          'lengthMenu', 'copy', 'csv', 'excel',
            {
                extend : 'pdfHtml5',
                title : function() {
                    return "Sales(Excl. Return)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-pdf-o">PDF</i>',
                titleAttr : 'PDF',
                footer: true,
            },
            {
                extend : 'print',
                title : function() {
                    return "Sales(Excl. Return)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-print-o">Print</i>',
                titleAttr : 'print',
                footer: true,
            }
        ],
        "columns": [
            
            { "data": "location", className: "text-right" },
            { "data": "today", className: "text-right" },
            { "data": "yesterday", className: "text-right" },
            { "data": "this_week", className: "text-right" },
            { "data": "last_week", className: "text-right" },
            { "data": "this_month", className: "text-right" },
            { "data": "last_month", className: "text-right" },
            { "data": "this_year", className: "text-right" },
            { "data": "last_year", className: "text-right" }

        ],
        drawCallback: () => {
        //append tfoot and populate it with total cost
        $('#thisDay').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(1, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#prevDay').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(2, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#thisWeek').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(3, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#prevWeek').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(4, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#thisMnth').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(5, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#prevMnth').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(6, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#thisYr').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(7, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#prevYr').html(`${$('#agsSalesexclReturn_tbl').DataTable().column(8, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        }               
    });

    var data_table_SalesReturn = $('#agsSalesReturn_tbl').DataTable({                   
        "ajax": "classes/dashboard.php?SalesReturn",
        "ordering" : true,
        "order": [[ 0, "asc" ]],
        dom: 'Blfrtip',
        buttons: [
          'lengthMenu', 'copy', 'csv', 'excel',
            {
                extend : 'pdfHtml5',
                title : function() {
                    return "Sales Return (Refund)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-pdf-o">PDF</i>',
                titleAttr : 'PDF',
                footer: true,
            },
            {
                extend : 'print',
                title : function() {
                    return "Sales Return (Refund)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-print-o">Print</i>',
                titleAttr : 'print',
                footer: true,
            }
        ],
        "columns": [
            
            { "data": "location", className: "text-right" },
            { "data": "today", className: "text-right" },
            { "data": "yesterday", className: "text-right" },
            { "data": "this_week", className: "text-right" },
            { "data": "last_week", className: "text-right" },
            { "data": "this_month", className: "text-right" },
            { "data": "last_month", className: "text-right" },
            { "data": "this_year", className: "text-right" },
            { "data": "last_year", className: "text-right" }

        ],
        drawCallback: () => {
        //append tfoot and populate it with total cost
        $('#refundThisDay').html(`${$('#agsSalesReturn_tbl').DataTable().column(1, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundPrevDay').html(`${$('#agsSalesReturn_tbl').DataTable().column(2, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundThisWeek').html(`${$('#agsSalesReturn_tbl').DataTable().column(3, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundPrevWeek').html(`${$('#agsSalesReturn_tbl').DataTable().column(4, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundThisMnth').html(`${$('#agsSalesReturn_tbl').DataTable().column(5, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundPrevMnth').html(`${$('#agsSalesReturn_tbl').DataTable().column(6, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundThisYr').html(`${$('#agsSalesReturn_tbl').DataTable().column(7, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#refundPrevYr').html(`${$('#agsSalesReturn_tbl').DataTable().column(8, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        }               
    });

    var data_table_Purchase = $('#agsPurchaserec_tbl').DataTable({                   
        "ajax": "classes/dashboard.php?Purchase",
        "ordering" : true,
        "order": [[ 0, "asc" ]],
        dom: 'Blfrtip',
        buttons: [
          'lengthMenu', 'copy', 'csv', 'excel', 
            {
                extend : 'pdfHtml5',
                title : function() {
                    return "Purchase Receivable (Food Details)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-pdf-o">PDF</i>',
                titleAttr : 'PDF',
                footer: true,
            },
            {
                extend : 'print',
                title : function() {
                    return "Purchase Receivable (Food Details)";
                },
                orientation : 'landscape',
                pageSize : 'A4',
                text : '<i class="fa fa-file-print-o">Print</i>',
                titleAttr : 'print',
                footer: true,
            }
        ],
        "columns": [
            
            { "data": "location", className: "text-right" },
            { "data": "today", className: "text-right" },
            { "data": "yesterday", className: "text-right" },
            { "data": "this_week", className: "text-right" },
            { "data": "last_week", className: "text-right" },
            { "data": "this_month", className: "text-right" },
            { "data": "last_month", className: "text-right" },
            { "data": "this_year", className: "text-right" },
            { "data": "last_year", className: "text-right" }

        ],
        drawCallback: () => {
        //append tfoot and populate it with total cost
        $('#purchaseThisDay').html(`${$('#agsPurchaserec_tbl').DataTable().column(1, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchasePrevDay').html(`${$('#agsPurchaserec_tbl').DataTable().column(2, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchaseThisWeek').html(`${$('#agsPurchaserec_tbl').DataTable().column(3, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchasePrevWeek').html(`${$('#agsPurchaserec_tbl').DataTable().column(4, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchaseThisMnth').html(`${$('#agsPurchaserec_tbl').DataTable().column(5, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchasePrevMnth').html(`${$('#agsPurchaserec_tbl').DataTable().column(6, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchaseThisYr').html(`${$('#agsPurchaserec_tbl').DataTable().column(7, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        $('#purchasePrevYr').html(`${$('#agsPurchaserec_tbl').DataTable().column(8, {search:'applied'}).data().toArray().reduce((sum, item) => sum+=item, 0)}`);
        }               
    });
});
</script>