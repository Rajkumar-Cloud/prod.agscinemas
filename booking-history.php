<?php 
    if (!isset($_COOKIE["userid"])){
        header("Location: index");
    }
    include ('header.php'); 
?>
<section class="booking-history-wrapper default-bg">
    <div class="container">
        <!-- <div class="col-md-10 offset-md-1">             -->
            <div class="row">
                <div class="col-md-8">
                    <div class="ticket-header">             
                        <h4><img class="img-fluid" src="assets/images/icons/movie-tickets.png" alt="ticket" /> Booking History</h4>
                    </div>
                </div>
                <div class="col-md-4 text-right">
                    <a href="movies.php" class="btn btn-sm btn-outline-primary"><i class="fab fa-wpforms"></i> Book Ticket</a>
                </div>
                <div class="col-md-12"><hr /> </div>
            </div>
            <div class="row">
                <div class="col-md-12 mt-3" >
                    <div class="table-responsive">
                        <table id="ticketHistory" class="display" style="width:100%">
                            <thead>
                                <tr>                                
                                    <th>S.No</th>
                                    <th>Name</th>
                                    <th>Movie Name</th>
                                    <th>Ticket ID</th>
                                    <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Food Cost</th>
                                    <th>Ticket Cost</th>
                                    <th>Booked Date</th>
                                    <th>Show Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>        
    <!-- </div> -->
</section>

<div class="modal fade animated mivieTicket_model" id="mivieTicket_model" data-backdrop="static" data-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm downloadTicket">
    <div class="modal-content">
      <div class="modal-header">
          <img class="img-fluid" src="assets/images/logos/ags-logo.jpg" alt="logo" />
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
              <div class="col-md-8 plm-0">
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
<script type="text/javascript" src="assets/js/qrcode.js"></script>
<link rel="stylesheet" href="assets/plugins/DataTable/jquery.dataTables.min.css">
<script type="text/javascript" src="assets/plugins/DataTable/jquery.dataTables.min.js"></script>
<script src="assets/js/html2canvas.js"></script>
<script type="text/javascript">    
    $(document).ready(function() {
        var p17="<?php  echo $_COOKIE['userid']; ?>";

        var table = $('#ticketHistory').DataTable( {
                        "processing": true,
                        "serverSide": true,
                        "searching": false,
                        "paging":   false,
                        "ordering": false,
                        "info":     false,
                        "order": [[1, 'asc']],
                        "ajax": {
                            cache: false,
                           "url": 'classes/php/booking_history_list.php',
                           "type": 'POST',
                           "data": {userid : p17, txnid: '', type: 'history'}
                        },
                        error: function() { 
                            $(".ticketHistory-error").html("");
                            $("#ticketHistory").append('<tbody class="ticketHistory-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
                        }
                    });
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

    function showtickets(txnid) {
        document.getElementById('qrcodesss').innerHTML = '';
        jQuery(".ticketDetails").html('');
        jQuery(".paymentDetails").html('');
        $(".movie_Name").html('');
        $(".movie_date").html('');
        $(".movie_showtime").html('');
        $("#imageURL").attr('src', '');
        var ticketDetails = '';
        var paymentDetails = '';
        var p17="<?php  echo $_COOKIE['userid']; ?>";
        var datas = {userid: p17, txnid: txnid, type: 'tickets' };
        $.ajax({
            type:"POST",
            url:"classes/php/booking_history_list.php",
            data:datas
        }).done(function(data) { 
            $raw = JSON.parse(data);
            $(".movie_Name").html($raw.movie_Name);
            $(".movie_date").html($raw.movie_date);
            $(".movie_showtime").html($raw.movie_showtime);
            $("#imageURL").attr('src', 'assets/images/movies/'+$raw.movieId+'_cover.jpg');
            $total_val = $raw.total_amt;
            // $total_val = 1;
            ticketDetails = '<tr><td>Theatre Location: </td><td>'+ $raw.movie_location +'</td></tr>';
            ticketDetails += '<tr><td>Ticket No: </td><td>'+ $raw.ticket_num +'</td></tr>';
            ticketDetails += '<tr><td>Screen: </td><td>'+ $raw.movie_screen +'</td></tr>';
            ticketDetails += '<tr><td>Seat No: </td><td>'+ $raw.movie_seat.join(", ") +'</td></tr>';

            paymentDetails = '<li>Seat Cost: <span class="totalamount"><i class="fas fa-rupee-sign"></i>'+ $raw.movie_amt +'</span></li>';
            if($raw.row !=0) {                
                paymentDetails +='<div class="panel-group" id="foodDetailAccordion"><div class="panel panel-default"><div class="panel-heading"><h5 class="panel-title"><a class="accordion-toggle" data-toggle="collapse" data-parent="#foodDetailAccordion" href="#foodDataCollapse"> Food Item Details <span class="fas fa-arrow-circle-down" style="float: right;"></span></a></h5></div>';
                paymentDetails +='<div id="foodDataCollapse" class="panel-collapse collapse in show"><div class="panel-body"><ul>';
                $.each($raw.foodData, function(index, item) {
                    paymentDetails += '<li><p>&#183;</p><div class="foodBill_description"><span>'+item.foodname+'(<sub>'+item.quantity+' - Nos</sub>)</span><span><i class="fas fa-rupee-sign"></i> '+item.foodprice+'</span></div></li>';
                });
                paymentDetails += '<li>Total Food Cost: <span class="foodvalue"><i class="fas fa-rupee-sign"></i>'+ $raw.foodvalue +'</span></li>';
                paymentDetails +='</ul></div></div></div></div>';
            }
            paymentDetails += '<li>Booking Cost: <span class="conv_fees"><i class="fas fa-rupee-sign"></i>'+ $raw.conv_fees +'</span></li>';
            paymentDetails += '<li>Total Amount: <span class="total_val"><i class="fas fa-rupee-sign"></i>'+ $total_val +'</span></li>';


            var tiknum = $raw.ticket_num;      
            var qrcode = new QRCode(document.getElementById('qrcodesss'),{width : 65,height : 65}); 
            qrcode.makeCode(tiknum); 

            jQuery(".ticketDetails").append(ticketDetails);
            jQuery(".paymentDetails").append(paymentDetails);


        });
    }
</script>