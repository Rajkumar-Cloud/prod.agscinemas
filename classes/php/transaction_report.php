<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Transaction Report</title>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">
	
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-md-12">
				<table id="trans_report_table" class="display nowrap table table-striped table-bordered" style="width:100%">
					<thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Vista ID</th>
                            <th>Transaction No</th>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Mobile</th>
                            <th>Movie Name</th>
                            <th>Movie Location</th>
                            <th>Screen</th>
                            <th>Show Date</th>
                            <th>Show Time</th>
                            <th>Seats</th>
                            <th>Movie Amount</th>
                            <th>Conv Fees</th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>Transaction Date</th>
                        </tr>
                    </thead>
				</table>
			</div>
		</div>
	</div>
</body>

<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.print.min.js"></script>


<script type="text/javascript">
	$(document).ready(function() {
	    
        var table = $('#trans_report_table').DataTable( {
                "dom": 'Bfrtip',
                "buttons": [
                            {
                                extend: 'excelHtml5',
                                title: 'Transaction Report',
                                messageTop: function () {
                                    let tday = new Date();
                                    let yday = new Date();
                                    yday.setDate(tday.getDate() - 1);
                                    today = tday.getDate()+'-'+tday.getMonth()+'-'+tday.getFullYear(); 
                                    yesterday = yday.getDate()+'-'+yday.getMonth()+'-'+yday.getFullYear(); 

                                    return 'Daily Report [ ' + yesterday +' - '+ today +' ]';
                                },
                                filename: function(){
                                    let tday = new Date();
                                    let yday = new Date();
                                    yday.setDate(tday.getDate() - 1);
                                    today = tday.getDate()+'-'+tday.getMonth()+'-'+tday.getFullYear(); 
                                    yesterday = yday.getDate()+'-'+yday.getMonth()+'-'+yday.getFullYear();

                                    return 'Daily_Report_' + yesterday +'_'+ today;
                                },
                            }
                        ],
                "processing": true,
                "serverSide": true,
                "searching": false,
                "paging":   false,
                "ordering": false,
                "info":     false,
                "order": [[1, 'asc']],
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                "ajax": {
                    cache: false,
                   "url": 'trans_report.php',
                   "type": 'GET'
                },
                "initComplete":function( settings, json){
                    // table.button( '.buttons-excel' ).trigger();
                },
                error: function() { 
                    $(".trans_report_table-error").html("");
                    $("#trans_report_table").append('<tbody class="trans_report_table-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                }
            });
	} );

</script>
</html>