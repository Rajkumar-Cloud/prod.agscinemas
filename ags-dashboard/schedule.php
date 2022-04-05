<?php
 $title = "Schedule Reports";
 $description = "AGS Cinemas Schedule List";
 $keywords = "AGS Cinemas Schedule List";
 $menu_name = "Schedule";
 $Sub_title = "Schedule Sales Report";
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
                            <table id="ags_schedule_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>                                        
                                        <th>Movie Name</th>
                                        <th>Screen Name</th>
                                        <th>Movie Name</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th>Show End Time</th>
                                    </tr>
                                </thead>
                                <tbody></tbody>
                                <tfoot>
                                    <tr>
                                        <th>Movie Name</th>
                                        <th>Screen Name</th>
                                        <th>Movie Name</th>
                                        <th>Show Date</th>
                                        <th>Show Time</th>
                                        <th>Show End Time</th>
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
    var locationId = <?php echo $_SESSION['userData']->locationId; ?>;
    var data_table = $('#ags_schedule_tbl').DataTable({                   
            "ajax": {
               "url": 'classes/schedule_report.php',
               "type": 'POST',
               "data": {locationId: locationId}
            },
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
                    // orientation : 'landscape',
                    pageSize : 'LEGAL',
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
                { "data": "movie_screen" },
                { "data": "movie_name" },
                { "data": "movie_date"},
                { "data": "movie_showtime"},
                { "data": "movie_showEndtime"},
            ],
            rowsGroup: [0,1,2,3],
            initComplete: function () {
                this.api().columns().every( function () {
                    var column = this;
                    var ColIndex = column[0][0];
                    var title = $('#ags_schedule_tbl thead th').eq( ColIndex ).text();
                    var width = title.length;
                    console.log(width);
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
                } );
            }
        });
});

</script>

