<?php 
 $title = "AGS Cinemas Mail send to old users";
 $description = "AGS Cinemas Mail send to old users";
 $keywords = "AGS Cinemas Mail send to old users";
 include('header.php'); 
?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Existing User Details Recovery through Email</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Old User Mail Trigering</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">			
        <div class="col-xl-12 col-md-12">
                <div class="card table-card mb-1">
                    <div class="card-header">
                        <h5>Existing User Mail Trigering</h5>
                        <div class="w-100">
                            <div class="alert alert-info alert-dismissible fade show mt-2 p-2" role="alert" style="display:none" id="alert_Success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding: 5px;">&times;</a>
                                <i class="fa fa-check-circle"></i> Mail alert has been send <strong>successfully!</strong>.
                            </div>
                        </div>
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
                    <div class="card-body mb-1">                    
                        <div class="table-responsive">
                            <table id="existingUsers_tbl" class="table display dataTable table-condensed mb-2">
                                <thead>
                                    <tr>                                                                               
                                        <th>S.No</th> 
                                        <th>User Id</th>
                                        <th>Username</th>
                                        <th>User Email</th>                                        
                                        <th>Mobile No</th>  
                                        <th>Created Date</th>                                      
                                        <th>Mail Status</th>                                        
                                        <th>Check All <br /><input type="checkbox" class='checkall' name="checkall_rowuser" id='checkall_rowuser' style="vertical-align: middle;">
                                        <button type="button" id='mailSendto_checkedrow' class="btn btn-sm btn-info" style="padding:0px 5px;font-size:12px;font-weight:200;">Send</button>
                                        </th>
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

<?php include('footer.php'); ?>
<script>
$(document).ready(function() {
    var data_table;
    setTimeout(function() {
        data_table = $('#existingUsers_tbl').DataTable({
            "processing": true,
            "serverSide": true,                    
            "ajax": "../ags-dashboard/classes/existingUsermail_triger.php",            
            "order": [[ 1, "asc" ]],
            "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
            }, 
            fixedHeader: {
               header: true,
               footer: true
            },
            "columnDefs": [
              {  
                 targets: 0,
                 "orderable":false,  
              }, 
              {
                targets: 6,
                className:'text-center',
                render: function (data_status, type, row, meta) {                  
                  if (type === 'display') {
                    if(data_status == 0 && row['8'] == 0) {                  
                      data_status = '<button type="button" data-id="'+row['1']+'" data-name="'+row['2']+'" data-email="'+row['3']+'" onclick="sendMail_triger(this);" style="border: 1px solid;letter-spacing: 1px;" class="badge badge-light-success">Send mail</button>';
                    }                
                  }
                  return data_status;
                }                
              },
              {
                targets: 7,
                'orderable': false,
                className:'text-center',
                render: function (data, type, row, meta) {                  
                    if (type === 'display') {                                        
                        data = '<input type="checkbox" class="usermail_Check" id="delcheck_'+row['1']+'" onclick="checkcheckbox(this);" data-id="'+row['1']+'" data-name="'+row['2']+'" value="'+row['3']+'" />';
                    }
                    return data;
                }
              }

            ]           
        });
    }, 100);

    $('input[type=checkbox][name=checkall_rowuser]').change(function() {        
        if($(this).is(':checked')){                        
            $('.usermail_Check').prop('checked', true);            
        }else{
            $('.usermail_Check').prop('checked', false);            
        }
    });

    $('#mailSendto_checkedrow').on('click', function() {
        var bulkSend_arr = [];        
        // Read all checked checkboxes
        $("input:checkbox[class=usermail_Check]:checked").each(function (key, val) {            
            bulkSend_arr[key] = {'id':$(this).data("id"),'name':$(this).data("name"),'email':$(this).val()};
        });       

        // Check checkbox checked or not
        if(bulkSend_arr.length > 0) {
            var confirmSend = confirm("Do you want to send bulk mail to existing customer?");
            if (confirmSend == true) {
                $.ajax({
                    url: "classes/userControl.php?bulkTrigring",
                    type: 'POST',
                    data: {bulkSend_arr: bulkSend_arr},
                    success: function(response) {
                        var data = JSON.parse(response);                        
                        if(data.status == "success") { 
                            $('#alert_Success').fadeIn();
                            setTimeout(function(){                     
                            $('#existingUsers_tbl').DataTable().ajax.reload();
                            $('#alert_Success').fadeOut();
                            }, 4000);              
                        } else {
                            setTimeout(function(){ $('#existingUsers_tbl').DataTable().ajax.reload(); }, 4000);              
                            alert("Send mail error!")       
                        }
                    }
                });
            } 
        }
        
    });


});
function sendMail_triger(e) {
    var this_btn = $(e);
    var userId = this_btn.data("id");
    var userName = this_btn.data("name");
    var email = this_btn.data("email");    
    this_btn.html("Sending.. <i class='fas fa-sync fa-spin'></i>").css({"cursor": "not-allowed", "opacity":".6","pointer-events":"none"});    
    this_btn.removeClass('badge-light-success');
    this_btn.addClass('badge-light-danger');
    this_btn.attr('disabled', true);
    $.ajax({ 
        url: "classes/userControl.php?mailTriger", 
        type: "POST", 
        data: {userId: userId, username: userName, email: email},        
        success: function(data) {   
            var data = JSON.parse(data);                        
            if(data.status == "success") { 
                $('#alert_Success').fadeIn();
                setTimeout(function(){                     
                    $('#existingUsers_tbl').DataTable().ajax.reload();
                    $('#alert_Success').fadeOut();
                }, 4000);              
            } else {
                setTimeout(function(){ $('#existingUsers_tbl').DataTable().ajax.reload(); }, 4000);              
                alert("Send mail error!")       
            }
        },
        complete: function (data) { } 
    });   
}

function checkcheckbox(e) {
    var e_this = $(e);
    var length_chk = $('.usermail_Check').length;
    var totalchecked = 0;
    $('.usermail_Check').each(function(){
        if($(this).is(':checked')){
            totalchecked+= 1;
        }
    }); 
    if(totalchecked == length_chk) {
        $("#checkall_rowuser").prop('checked', true);
    } else {
        $('#checkall_rowuser').prop('checked', false);
    }
}

</script>