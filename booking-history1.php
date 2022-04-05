
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
                        <h4><img class="img-fluid" src="assets/images/icons/movie-tickets.png" alt="ticket" /> Your Booking history details</h4>
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
                                    <th>Transaction ID</th>
                                    <th>Booking Date</th>
                                    <!-- <th>Transaction ID</th>
                                    <th>Status</th>
                                    <th>Food Cost</th>
                                    <th>Ticket Cost</th>
                                    <th>Booked Date</th>
                                    <th>Show Date</th>
                                    <th>Action</th> -->
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
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
                      <label class="form-label"><i class="fas fa-film"></i> Film Name</label>
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
                            <div id="collapseOne" class="panel-collapse collapse in">
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
          <div class="col-sm-12">
            <button class="btn btn-sm btn-outline-danger" title="Download Ticket" onClick="download_ticket();"><i class="fas fa-cloud-download-alt"></i></button>
          </div>
      </div>
    </div>
  </div>
</div>

<?php include('footer.php'); ?>
<script type="text/javascript" src="assets/js/qrcode.js"></script>
<link rel="stylesheet" href="assets/plugins/DataTable/jquery.dataTables.min.css">
<script type="text/javascript" src="assets/plugins/DataTable/jquery.dataTables.min.js"></script>
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-alpha1/html2canvas.js"></script> -->
<script src="assets/js/html2canvas.js"></script>
<script type="text/javascript">    
    $(document).ready(function() {        
        var tic_tbl = $('#ticketHistory').DataTable({
            "processing": true,
            "serverSide": true,
            "paging":   true,
            "ajax": {
                type:"post",
                data: "",
                url:"classes/booking_history.php?userBookinghistory"
            }           
            // , error: function() { 
            //     $(".ticketHistory-error").html("");
            //     $("#ticketHistory").append('<tbody class="ticketHistory-error"><tr><th colspan="3">No booking history found.!</th></tr></tbody>');
            // }
        });
    });

    function download_ticket() {
        var container = document.getElementById("mivieTicket_model");
        html2canvas(container, { allowTaint: true }).then(function (canvas) {
            var link = document.createElement("a");
            document.body.appendChild(link);
            link.download = "ticket.jpg";
            link.href = canvas.toDataURL();
            link.target = '_blank';
            link.click();
        });
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
            $("#imageURL").attr('src', 'https://in.bmscdn.com/iedb/movies/images/mobile/thumbnail/xlarge/laabam-et00137405-25-08-2020-11-51-17.jpg');

            // $total_val = $raw.total_amt;
            $total_val = 1;
            ticketDetails = '<tr><td>Theatre Location: </td><td>'+ $raw.movie_location +'</td></tr>';
            ticketDetails += '<tr><td>Ticket No: </td><td>'+ $raw.ticket_num +'</td></tr>';
            ticketDetails += '<tr><td>Screen: </td><td>'+ $raw.movie_screen +'</td></tr>';
            ticketDetails += '<tr><td>Seat No: </td><td>'+ $raw.movie_seat.join(", ") +'</td></tr>';

            paymentDetails = '<li>Seat Cost: <span class="totalamount"><i class="fas fa-rupee-sign"></i>'+ $raw.movie_amt +'</span></li>';
            paymentDetails += '<li>Food Cost: <span class="foodvalue"><i class="fas fa-rupee-sign"></i>'+ $raw.foodvalue +'</span></li>';
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