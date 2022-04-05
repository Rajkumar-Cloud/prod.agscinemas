<?php 
 $title = "AGS Cinemas All Registered Users List";
 $description = "AGS Cinemas All Registered Users List";
 $keywords = "AGS Cinemas All Registered Users List";
 include('header.php'); 
?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">AGS Cinemas All User's</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">User's</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">			
        <div class="col-xl-12 col-md-12">
		<div class="card table-card mb-1">
                    <div class="card-header">
                        <h5>Users</h5>
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
                            <table id="agsallUsers_tbl" class="table display dataTable table-condensed mb-1">
                                <thead>
                                    <tr>                  
                                        <th>S.No</th>                                                              
                                        <th>User Id</th> 
                                        <th>Username</th>
                                        <th>Profile Picture</th>
                                        <th>Email</th>
                                        <th>Mobile No</th>  
                                        <th>Logged Device</th>  
                                        <th>Created Date</th>                                      
                                        <th>Status</th>                                        
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

'use strict';
$(document).ready(function() {
    var data_table;
    setTimeout(function() {
        data_table = $('#agsallUsers_tbl').DataTable({
            "processing": true,
            "serverSide": true,                    
            "ajax": "classes/agsUsers.php",
            "order": [[ 1, "asc" ]],
	    "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
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
            "columnDefs": [
              {  
                 targets: 0,
                 "orderable":false,  
              }, 
              {
                targets: 3,
                render: function (data_img, type, row, meta) {
                  if (type === 'display') {
                    if(data_img == 'undefined' || data_img == null || data_img == '') {                      
                      data_img = '<img src="assets/images/user/user-icon.png" class="img-responsive" title="Profile Image" alt="user profile picture" style="margin: 0 auto;border: 1px solid #9999993d;border-radius:50%;width:28px;" />';
                    } else {
                      data_img = '<img src="assets/images/user/'+data_img+'" class="img-responsive" title="Profile Image" alt="profile pic" style="margin: 0 auto;border: 1px solid #26a8df57; border-radius:50%; width:28px;" />';
                    }
                  }
                  return data_img;
                }
              },
              {
                targets: 4,
                render: function (data_mail, type, row, meta) {
                  if (type === 'display') {
                    data_mail = '<a title="Report this user" href="mailto:'+data_mail+'" target="_self">'+data_mail+'</a>';
                  }
                  return data_mail;
                }
              },
              {
                targets: 5,
                render: function (data_mob, type, row, meta) {
                  if (type === 'display') {                    
                    data_mob = '<a title="Call this user" href="tel:+91'+data_mob+'" target="_self" style="color:#6f7484;">'+data_mob+'</a>';                   
                  }
                  return data_mob;
                }
              },
              {
                targets: 8,
                render: function (data_status, type, row, meta) {
                  if (type === 'display') {
                    if(data_status == 1) {                      
                      data_status = '<span class="badge badge-light-success">Active</span>';
                    } else {
                      data_status = '<span class="badge badge-light-danger">In Active</span>';
                    }                    
                  }
                  return data_status;
                }                
              }
                       
            ]                  
        });
    }, 100);
});

</script>
<style type="text/stylesheet">

</style>
