<?php 
$title = "AGS Cinemas Add Food and Beverages Item Form";
$description = "AGS Cinemas Add Food and Beverages Item Form";
$keywords = "AGS Cinemas Add Food and Beverages Item Form";
include('header.php'); 
?>

<!-- [ Main Content ] start -->
<div class="pcoded-main-container">
    <div class="pcoded-content">
        <!-- [ breadcrumb ] start -->
        <div class="page-header">
            <div class="page-block">
                <div class="row align-items-center">
                    <div class="col-md-12">
                        <div class="page-header-title">
                            <h5 class="m-b-10">Add Food and Beverages</h5>
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
        <!-- [ breadcrumb ] end -->
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <h5>Add Food & Beverages Menu</h5>
                    </div>
                    <div class="card-body">
                        <h5>Add Food Items Here</h5>
                        <div class="w-100">
                            <div class="alert alert-info alert-dismissible fade show" role="alert" style="display:none" id="alert_Success">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-check-circle"></i> Entered food item inserted <strong>successfully!</strong>.
                            </div>
                            <div class="alert alert-danger alert-dismissible fade show" role="alert" style="display:none" id="alert_Error">
                                <a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a>
                                <i class="fa fa-exclamation-circle"></i> Failed to update entered food item. <strong>please try again!</strong>.
                            </div>
                        </div>
                        <hr>
                        <form class="addFooditem_form" id="addFooditem_form" name="addFooditem_form" method="POST" action="" enctype="multipart/form-data">
                            <div class="row">
                                <div class="col-md-6">                                
                                    <div class="form-group">
                                        <label for="foodname">Food Name</label>
                                        <input type="text" class="form-control" id="foodItems_name" name="foodItems_name" placeholder="Enter the food name" />
                                        <!-- <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small> -->
                                        <span class="error__message" id="error_foodname"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Food Price">Food Price</label>
                                        <input type="number" class="form-control numberonly" maxlength="4" id="food_price" name="food_price" placeholder="Enter food amount" />
                                        <span class="error__message" id="error_foodprice"></span>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label for="Food Price">Food Offer Applied Price</label>
                                        <input type="number" class="form-control numberonly" maxlength="4" id="food_offerApply_price" name="food_offerApply_price" placeholder="" readonly />
                                        <span class="error__message" id="error_foodofferprice"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="food offer">Food offer apply?</label>
                                        <input type="range" min="0" max="50" step="0" class="form-control-range" onchange="update__offerItem(this.value);" id="foodOffer_apply" name="foodOffer_apply" value="0" />
                                        <small id="offerPercentage_lbl" class="form-text text-muted"></small>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="exampleFormControlSelect1">Food Type</label>
                                        <select class="form-control" id="ags_foodType" name="ags_foodType">
                                            <option value="">Select food type</option>
                                            <option value="Desserts">Desserts</option>
                                            <option value="PopCorn">Pop Corn</option>
                                            <option value="Snacks">Snacks</option>
                                            <option value="Beverages">Beverages</option>            
                                        </select>
                                        <span class="error__message" id="error_foodtype"></span>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="upload image" for="Upload image">Select food image</label>
                                        <div class="input-group cust-file-button">                                            
                                            <div class="custom-file">                    
                                                <input type="file" class="custom-file-input" name="fooditem_image" id="fooditem_image" accept="image/*" value="" />
                                                <label class="custom-file-label" for="choose file">Choose file</label>
                                            </div>                    
                                        </div>
                                        <span class="error__message" id="error_foodimage"></span>
                                    </div>
                                </div>    
                                <div class="col-md-6 preview_foodImg" style="display: none;">
                                    <div class="form-group">
                                        <img class="img-thumbnail" id="food_imgPreview" src="" alt="food image" />
                                    </div>
                                </div>                                    
                                <div class="col-md-12">
                                    <div class="processLoader"><img class="img-fluid" src="assets/images/loading.gif" alt="loader"></div>
                                    <button type="button" class="btn btn-sm btn-outline-primary" id="foodItem_submitbtn" name="foodItem_submitbtn"><i class="feather mr-2 icon-check-circle"></i>Submit</button>
                                    <button type="reset" class="btn btn-sm btn-outline-warning"><i class="feather icon-delete"></i> Reset</button>
                                </div>                                                                        
                            </div>
                        </form>
                    </div>
                </div>
            </div>                
        </div>
    </div>
</div>

<?php include('footer.php'); ?>
<script>
    $(document).ready(function() {
        $("#fooditem_image").change(function () {
            var filename = $('input[type=file]').val().replace(/C:\\fakepath\\/i, '');
            var ext = $('#fooditem_image').val().split('.').pop().toLowerCase();
            if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                $("#error_foodimage").html('Please upload valid formats');                  
            } else {
                $("#error_foodimage").html('');
                $('.preview_foodImg').show();
                $('.previewImg_actions').remove();
                const file = this.files[0];
                if (file) {
                    let reader = new FileReader(); 
                    reader.onload = function (event) {
                        $("#food_imgPreview").attr("src", event.target.result);
                        let closeBtn = '<button type="button" class="btn btn-icon btn-outline-primary has-ripple" title="Delete Image" onclick="removePrevImage()" aria-label="Close"><span class="feather icon-trash-2"></span></button>';
                        $('.preview_foodImg .form-group').append('<div class="previewImg_actions">'+filename+''+closeBtn+'</div>');
                    };
                    reader.readAsDataURL(file);
                }
            }
        });    

        $("#foodOffer_apply").on('change', function () {
            var offerPercent = $(this).val();
            var foodprice = $('#food_price').val();
            var offer_applied_price = $("#food_offerApply_price").val();            
        });

        const calculateSale = (listPrice, discount) => {
            listPrice = parseFloat(listPrice);
            discount  = parseFloat(discount);
            return (listPrice - ( listPrice * discount / 100 )).toFixed(2); // Sale price
        }
        const calculateDiscount = (listPrice, salePrice) => {
            listPrice = parseFloat(listPrice);
            salePrice = parseFloat(salePrice);
            return 100 - (salePrice * 100 / listPrice); // Discount percentage
        }

        const $list = $('input[name="food_price"]'),
              $disc = $('input[name="foodOffer_apply"]'), 
              $sale = $('input[name="food_offerApply_price"]');

        $list.add($disc).on('input', () => { 
            let sale = $list.val();             
            if ($disc.val().length) {
                sale = calculateSale($list.val(), $disc.val());
            }
            $sale.val( sale );
        });

        $sale.on('input', () => {      // Sale input events
            let disc = 0;                // Default to 0%
            if ($sale.val().length) {  // if value is entered- calculate the discount
                disc = calculateDiscount($list.val(), $sale.val());
            }
            $disc.val( disc );
        });
        $list.trigger('input');
        $("#foodItem_submitbtn").on('click', function () {
            var foodItems_name = $("#foodItems_name").val();
            var food_price = $('#food_price').val();                    
            var ags_foodType = $('#ags_foodType').val();
            var fooditem_image = $('#fooditem_image').val();
            var foodOffer_apply = $('#foodOffer_apply').val();
            var ext = $('#fooditem_image').val().split('.').pop().toLowerCase();            
            var validate = 0;   
            if (foodItems_name == "") {
                $("#error_foodname").html('Please enter food name');
                validate = 1;
            } else {    
                $("#error_foodname").html('');             
            }
            if (food_price == "") {
                $("#error_foodprice").html('Please enter food cost');
                validate = 1;
            } else {    
                $("#error_foodprice").html('');             
            }
            if (ags_foodType == "") {
                $("#error_foodtype").html('Please select food type');
                validate = 1;
            } else {    
                $("#error_foodtype").html('');             
            }
            if (fooditem_image == "") {
                $("#error_foodimage").html('Please upload food image');
                validate = 1;
            } else {    
                if($.inArray(ext, ['gif','png','jpg','jpeg']) == -1) {
                    $("#error_foodimage").html('Please upload valid formats');                    
                    validate = 1;
                } else {
                    $("#error_foodimage").html('');             
                }
            }
            if (validate == 1) {
                return false;
            } else {
                $('.processLoader').show();
                $('#foodItem_submitbtn').attr('disabled', true);
                setTimeout(function() {
                    var foodData = $("#addFooditem_form").serialize();
                    $.ajax({ 
                        url: "classes/foodItem.php?addFoodItem", 
                        type: "POST", 
                        data: foodData, 
                        beforeSend: function() {
                            $('.processLoader').show();
                            $('#foodItem_submitbtn').attr('disabled', true);
                        },
                        success: function(data) {   
                            var data = JSON.parse(data);                        
                            if(data.message == "inserted") {
                                var formData = new FormData($('#addFooditem_form')[0]);                            
                                $.ajax({
                                    url: "classes/foodItem.php?addFoodimage&rowId="+data.dataId, 
                                    type: "POST",
                                    data:  formData,
                                    contentType: false,
                                    cache: false,
                                    processData:false,
                                    success: function(response){
                                        var data = JSON.parse(response);
                                        if(data.message == "success") { 
                                            $('#alert_Success').fadeIn();
                                            $('#foodItem_submitbtn').attr('disabled', false);
                                            $('#addFooditem_form')[0].reset();
                                            setTimeout(function(){ window.location.href = "view-food-items.php"; }, 8000);
                                        }
                                    }                                	        
                                });
                            } else {
                                $('#alert_Error').fadeIn();
                            }
                        },
                        complete: function (data) {                                         
                            $('.processLoader').hide();
                        },
                        error: function(data) {

                        } 
                    });
                }, 3000);
            }
        });

        $('.numberonly').keypress(function (e) {        
            var charCode = (e.which) ? e.which : event.keyCode    
            if (String.fromCharCode(charCode).match(/[^0-9]/g))    
                return false;                        
        });
    });

    function update__offerItem(val) {
        $('#offerPercentage_lbl').html('Offer applied level : <b class="badge badge-light-danger p-1">'+val+'%</b>'); 
    }
    function removePrevImage() {        
        $("#fooditem_image").val('');        
        $('.preview_foodImg').hide();
        $('.previewImg_actions').not(this).remove();
    }
    
</script>