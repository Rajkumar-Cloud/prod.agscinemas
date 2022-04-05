<?php 
$title = "AGS Cinemas Food and Beverages Items List";
$description = "AGS Cinemas Food and Beverages Items List";
$keywords = "AGS Cinemas Food and Beverages Items List";
include('header.php');
?>
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                         <h5 class="m-b-10">View Food and Beverages</h5>
                        </div>
                        <ul class="breadcrumb">
                            <?php 
                                if($_SESSION['userData']->user_role == 1 || $_SESSION['userData']->user_role == 7) 
                                    echo '<li class="breadcrumb-item"><a href="index.php"><i class="feather icon-home"></i></a></li>';
                                else
                                    echo '<li class="breadcrumb-item"><a href="dashboard.php"><i class="feather icon-home"></i></a></li>';
                            ?>
                            <li class="breadcrumb-item"><a href="javascript:void(0)">Food & Beverages</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">			
        <div class="col-xl-12 col-md-12">
                <div class="card table-card mb-1">
                    <div class="card-header">
                        <h5>Food & Beverages List</h5>
                        <div class="w-100">
                            <div class="alert alert-info alert-dismissible fade show" role="alert" style="margin: 6px 0 0px;padding:3px;display:none" id="alert_Success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close" style="padding: 3px;">&times;</a>
                                <i class="fa fa-check-circle"></i> Food item status updated <strong>successfully!</strong>.
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
                            <table id="agsFoodList_tbl" class="table display dataTable table-condensed mb-2">
                                <thead>
                                    <tr>        
                                        <th>S.No</th>                                                                        
                                        <th>Food Id</th> 
                                        <th>Food Name</th>
                                        <th>Food Price</th>
                                        <th>Offer Applied Price</th>
                                        <th>Offer(%)</th>  
                                        <th>Food Type</th> 
                                        <th>Created User</th>                                      
                                        <th>Food Image</th>
                                        <th>Status</th>           
                                        <th>Created Date</th>   
					<th>Action</th>                             
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
        data_table = $('#agsFoodList_tbl').DataTable({
            "processing": true,
            "serverSide": true,                    
            "ajax": "../ags-dashboard/classes/getFoodData.php",
            "order": [[ 1, "asc" ]],
            "fnRowCallback" : function( nRow, aData, iDisplayIndex, iDisplayIndexFull ) {
                $("td:first", nRow).html(iDisplayIndex +1);
                return nRow;
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
                targets: 8,
                render: function (imgData, type, row, meta) {                    
                  if (type === 'display') {
                    var tempUrl, url = window.location.protocol + "//" + window.location.host + "/assets/Food/";                                        
                    tempUrl = checkFileExist(url+imgData);
                    if(tempUrl == true) { foodImg = imgData; } else { foodImg = 'no-image-available.png'; }                                              
                    imgSet = '<img src="'+url+foodImg+'" class="img-responsive" title="Food Image" alt="Food Image" style="margin: 0 auto; border: 1px solid #26a8df57;width:142px;" />';                    
                  }
                  return imgSet;
                }
              },
              {
                targets: 9,
                render: function (data_status, type, row, meta) {
                  if (type === 'display') {
                    if(data_status == 1) {                      
                      data_status = '<button type="button" onclick="foodStatus_Update('+row['1']+', '+data_status+');" style="border: 1px solid;letter-spacing: 1px;color:#64a914;" class="badge badge-light-success">Active</button>';
                    } else {
                      data_status = '<button type="button" onclick="foodStatus_Update('+row['1']+', '+data_status+');" style="border: 1px solid;letter-spacing: 1px;color:#ff5252;" class="badge badge-light-danger">In Active</button>';
                    }                    
                  }
                  return data_status;
                }                
              },
	      {
                targets: 11,
                render: function (data_action, type, row, meta) {                                        
                  if (type === 'display') {                    
		    data_action = '<button type="button" title="Update item" data-id="'+row['1']+'" onclick="updateFood_Items(this);" class="btn btn-sm btn-icon btn-outline-primary has-ripple" style="width:22px;height:22px;font-size: 10px;"><i class="feather icon-edit"></i><span class="ripple ripple-animate" style="height:30px; width:30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -2.21094px; left: -8.92188px;"></span></button> | <button type="button" title="Delete item" data-id="'+row['1']+'" data-img="'+row['8']+'" onclick="deleteFood_Items(this);" class="btn btn-sm btn-icon btn-outline-danger has-ripple" style="width:22px;height:22px;font-size: 10px;"><i class="feather icon-trash"></i><span class="ripple ripple-animate" style="height:30px; width:30px; animation-duration: 0.7s; animation-timing-function: linear; background: rgb(255, 255, 255); opacity: 0.4; top: -2.21094px; left: -8.92188px;"></span></button>';
                  }
                  return data_action;
                }                
              }
            ]            
        });
    }, 100);
});

function checkFileExist(urlToFile) {    
    var xhr = new XMLHttpRequest();
    xhr.open('HEAD', urlToFile, false);
    xhr.send();
    if (xhr.status == "404") {
        return false;
    } else {
        return true;
    }
}
function foodStatus_Update(rowId, statusId) {   
    if(statusId == 0)
        statusId = 1;
    else
        statusId = 0; 

    $.ajax({ 
        url: "classes/foodItem.php?foodStatusUppdate", 
        type: "POST", 
        data: {rowId: rowId, statusId: statusId}, 
        beforeSend: function() { },
        success: function(response) { 
            var data = JSON.parse(response);
            if(data.message == "updated") { 
                $('#alert_Success').fadeIn();
                setTimeout(function(){ 
                    $('#alert_Success').fadeOut();
                    $('#agsFoodList_tbl').DataTable().ajax.reload();
                 }, 4000);                
            }
        }
    });
}

function deleteFood_Items(e) {
    var this_btn = $(e);
    var rowId = this_btn.data("id");
    var foodImg = this_btn.data("img");
    if (confirm('Sure want to delete this food item?')) {
        setTimeout(function() { 
            $.ajax({ 
                url: "classes/foodItem.php?delete_foodItems",
                type: "POST", 
                data: { rowId:rowId, foodImg:foodImg },                        
                success: function(response) {   
                    var data = JSON.parse(response);                            
                    if(data.status == "success") {
                        $.toast({
                            heading: 'Deleted!',
                            text: 'This food items has been deleted successfully!',
                            showHideTransition: 'fade',
                            icon: 'success',
                            position: 'top-center',
                            stack: false,
                            hideAfter: 6000
                        });                              
                        $('#agsFoodList_tbl').DataTable().ajax.reload();
                    } else {
                        $.toast({
                            heading: 'Error',
                            text: 'Failed to delete this record!',
                            showHideTransition: 'fade',
                            icon: 'error',
                            position: 'top-center',
                            stack: false,  
                            hideAfter: 4000                            
                        });
                        $('#agsFoodList_tbl').DataTable().ajax.reload();
                    }                             
                },
                complete: function (data) { }
            });
        }, 100);
    }
}
function updateFood_Items(e) {
    var this_btn = $(e);
    var rowId = this_btn.data("id");
    var encodeId = btoa(rowId);
    window.location.href = "edit-food-items.php?fid=" + encodeId; 
}

</script>