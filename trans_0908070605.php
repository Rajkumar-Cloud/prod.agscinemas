<!DOCTYPE html>
<html lang="en">
<head>
  <title>Transaction Details</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<body>

<div class="container">
  <h4>Booking Transaction Details</h4><hr />
  <div class="row">
    <div class="col-md-6" style="border-right: 2px dashed #ccc;">
      <div class="row">
        <div class="col-md-5">
            <label for="json file" class="form-label">Transaction ID(json transaction file name)</label>
        </div>
        <div class="col-md-7">
          <div class="form-group mb-2">
	      <input type="text" class="form-control" id="transactionFileId" maxlength="13" placeholder="Enter Transaction ID" />
          </div>
	  <button type="button" class="btn btn-primary btn-sm mb-2 getTransDetails" onclick="getTransDetails();">Submit</button>
          <button type="button" class="btn btn-danger btn-sm mb-2" onclick="clearTransactions();">Clear</button>
        </div>
      </div>
      <hr />
      <div class="table-responsive">
        <table class="table table-hover trans_table">
          <thead>
            <tr>
              <th>Field's</th>
              <th>Details</th>          
            </tr>
          </thead>
          <tbody id="trans_details_table"></tbody>
        </table>
      </div>
    </div>
    <div class="col-md-6">
	<div id="transaction__viewer">	
        <ul  class="nav nav-pills">
          <li class="active"><a href="#transactionJson" data-toggle="tab">Transaction JSON View for payU</a></li>
          <li class=""><a href="#VISTAtransaction" data-toggle="tab">Transaction Confirmation for VISTA</a></li>
	  <li class=""><a href="#SetSeatLog" data-toggle="tab">Set Seat Log</a></li>
        </ul>
        <div class="tab-content">
          <div class="tab-pane active" id="transactionJson">
            <label for="json file" class="form-label">Transaction JSON View for payU</label>
            <p id="json_view_payu" style="color: #a94442;font-size: 12px;line-height: 25px;"></p>
          </div>
          <div class="tab-pane" id="VISTAtransaction">
            <label for="json" class="form-label">Transaction Confirmation for VISTA (lngAuditNumber was VISTA ID)</label>  
            <p id="json_view_vista" style="color: #a94442;font-size: 12px;line-height: 25px;"></p>          
          </div>
	  <div class="tab-pane" id="SetSeatLog">
            <label for="json" class="form-label">Set-Seat API Response for User Selected Seat Confirmation Through AGS Website</label>  
            <p id="json_view_setseat" style="color: #a94442;font-size: 12px;line-height: 25px;"></p>          
          </div>
        </div>
      </div>
   </div>
</div>

<div class="modal" tabindex="-1" role="dialog" data-backdrop="static">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h3 class="modal-title">Verification Page</h3>
      </div>
      <div class="modal-body">
        <input type="text" class="form-control" id="verifyPage" placeholder="Enter the verification code" />
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-primary" onclick="verifyPage();">Verify</button>
      </div>
    </div>
  </div>
</div>


</body>
</html>
<style>
  table {
    border:1px solid #ddd;
    font-size: 12px;
  }
  table thead th {
    background-color: #000000bd;
    border-right: 1px solid #fff;
    color: #fff;
  }
  table tbody tr td:first-child {
    background-color: #ddd;
    color: #000;
    border-bottom: 1px solid #fff;
    font-weight: 600;
  }
  label {
    font-size: 14px;
  }
  #transaction__viewer ul li a {
    border-radius: 0;
    padding: 6px 7px;
    font-size: 12px;
    letter-spacing: .5px;
  }
  #transaction__viewer .tab-content {
    border: 1px solid #ddd;
    padding: 12px;
  }
</style>

<script type="text/javascript">

  $('.modal').modal('show');

  $("#transactionFileId").keypress(function (e) {
    if (e.which != 8 && e.which != 0 && (e.which < 48 || e.which > 57)) { return false; }
  });
  $("#transactionFileId").on('click', function () {
    $('.getTransDetails').prop('disabled', false);
  });

  function verifyPage(){
    var vcode = $("#verifyPage").val();
    if(vcode == 'W@g$1924.'){
      $('.modal').modal('hide');
    }else{
      alert('Please enter the valid verification code!..');
    }
  }

  $('#transactionFileId').keyup(function (e) {    
      if (e.which == 13) { getTransDetails(); }    
  });

  $(".trans_table").hide();
  function getTransDetails(){    
    var trans_id = $("#transactionFileId").val();
   if( trans_id.length >= 11) {
    $("#trans_details_table").empty();
    $("#json_view_payu").html('');
    $("#json_view_vista").html('');
    var trans_id = $("#transactionFileId").val();
    var datas = {'trans_id': trans_id}
    $.ajax({
        dataType:"json",
        type: "POST",
        url: "classes/php/get_trans_details.php",
        data: datas
    }).done(function(data) {
	$('.getTransDetails').prop('disabled', true);
      if(data.trans_data.length == 0){
        $(".trans_table").hide();
        alert('Given transaction Id not valid!..');
      }else{
        $(".trans_table").show(); 
        $("#transactionFileId").val('');
        var json_pretty_payu = data.json_pretty_payu;

        if(json_pretty_payu == 'null')
          json_pretty_payu = '<p style="color:red;">Sorry log not found.</p>';
        else
          json_pretty_payu = json_pretty_payu;

        var json_view_payu = '<pre>'+json_pretty_payu+'</pre>';
        $("#json_view_payu").html(json_view_payu);

        var json_pretty_vista = data.json_pretty_vista;

        if(json_pretty_vista == 'null')
          json_pretty_vista = '<p style="color:red;margin:0;font-weight:bold;">Sorry log not found.</p>';
        else
          json_pretty_vista = json_pretty_vista;

        var json_view_vista = '<pre>'+json_pretty_vista+'</pre>';
        $("#json_view_vista").html(json_view_vista);

	var setSeat_pretty_data = data.setSeat_data;
          if(setSeat_pretty_data == 'null')
            setSeat_pretty_data = '<p style="color:red;margin:0;font-weight:bold;">Sorry log not found.</p>';
          else 
            setSeat_pretty_data = setSeat_pretty_data;

            setSeat_pretty_data = '<pre>'+setSeat_pretty_data+'</pre>';
          $("#json_view_setseat").html(setSeat_pretty_data);

        var htmlText = '<tr><td>Transaction Id</td><td>'+data.trans_data.txnid+'</td></tr>';
            htmlText += '<tr><td>Name</td><td>'+data.trans_data.firstname+'</td></tr>';
            htmlText += '<tr><td>mihpay Id</td><td>'+data.trans_data.mihpayid+'</td></tr>';
            htmlText += '<tr><td>Amount</td><td>'+data.trans_data.transaction_amount+'</td></tr>';
            htmlText += '<tr><td>Production Info</td><td>'+data.trans_data.productinfo+'</td></tr>';
            htmlText += '<tr><td>Movie Location</td><td>'+data.trans_data.movie_location+'</td></tr>';
            htmlText += '<tr><td>Movie Name</td><td>'+data.trans_data.movie_Name+'</td></tr>';
            htmlText += '<tr><td>Movie Screen</td><td>'+data.trans_data.movie_screen+'</td></tr>';
            htmlText += '<tr><td>Movie Date</td><td>'+data.trans_data.movie_date+'</td></tr>';
            htmlText += '<tr><td>Movie Showtime</td><td>'+data.trans_data.movie_showtime+'</td></tr>';
            htmlText += '<tr><td>Payment Reason</td><td>'+data.trans_data.field9+'</td></tr>';
            htmlText += '<tr><td>Error code</td><td>'+data.trans_data.error_code+'</td></tr>';
            htmlText += '<tr><td>Payment Source</td><td>'+data.trans_data.payment_source+'</td></tr>';
            htmlText += '<tr><td>Card Type</td><td>'+data.trans_data.card_type+'</td></tr>';
            htmlText += '<tr><td>Error Message</td><td>'+data.trans_data.error_Message+'</td></tr>';
            htmlText += '<tr><td>Amount Debit</td><td>'+data.trans_data.net_amount_debit+'</td></tr>';
            htmlText += '<tr><td>Status</td><td>'+data.trans_data.status+'</td></tr>';
        $("#trans_details_table").append(htmlText);
      }
     });
    } else {
      alert("Please enter valid Transaction-id");
    }
  }
  function clearTransactions() {
    $("#transactionFileId").val('');
    $('.getTransDetails').prop('disabled', false);
  }

</script>