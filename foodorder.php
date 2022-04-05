<?php 
     include ('header.php'); 

    if (!isset($_SESSION["movie_Name"])){
        header("Location:movies.php");
    }
    $movieId=$_SESSION['movieId'];
    $movie_Name=$_SESSION['movie_Name'];
    $movie_Language = $_SESSION['movie_Language'];
    $movie_Censor=$_SESSION['movie_Censor'];
    $movie_Genre=$_SESSION['movie_Genre'];
    $movie_runTime=$_SESSION['movie_runTime'];
    $movie_location=$_SESSION['movie_location'];
    $movie_showtime=$_SESSION['movie_showtime'];
    $movie_date=$_SESSION['movie_date'];
    $movie_screen=$_SESSION['movie_screen'];
    $totalamount=$_SESSION['totalamount'];
    $myArray0=$_SESSION['showmovie_seat'];
    $showmovie_seat = "";
    $n=0;
    foreach($myArray0 as $my_Array0) {
        if($n == 0) {
            $showmovie_seat .= $my_Array0; 
            $n=1;
        } else {
            $showmovie_seat .= ",".$my_Array0;  
        }
    }

    $myArray=$_SESSION['movie_seat'];
    $movie_seat = "";
    $m=0;
    foreach($myArray as $my_Array) {
        if($m == 0) {
            $movie_seat .= $my_Array; 
            $m=1;
        } else {
            $movie_seat .= ",".$my_Array;  
        }
    }
    $time_lefts=$_SESSION['timelefts'];

?>

<section class="payment-wrapper default-bg">
    <div class="container">        
        <div class="row row-pay-bg">
            <div class="col-md-12">
                <div class="title-head"><h4><i class="fas fa-ticket-alt"></i> Movie Payment Details</h4> </div>
            </div>
            <div class="col-md-12 mt-3">
                <div class="row">
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-ticket-alt"></i></li>
                                <li data-toggle="tooltip" title="<?php echo $movie_Name; ?>"><?php echo $movie_Name; ?></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-drum-steelpan"></i></li>
                                <li>Genre: <?php echo $movie_Genre ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-clock"></i></li>
                                <li>Run Time - <span><?php echo $hours = intdiv($movie_runTime, 60).'h '. ($movie_runTime % 60).'m'; ?></span></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-star-half-alt"></i></li>
                                <li>Rating - <span><?php echo $movie_Censor; ?></span></li>
                                <li class="spacing"></li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-compact-disc"></i></li>
                                <li class="block-flex"><p>Theatre</p> <span><?php echo $movie_location; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="fas fa-calendar-day"></i></li>
                                <li class="block-flex"><p>Date</p> <span><?php echo $movie_date; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="far fa-clock"></i></li>
                                <li class="block-flex"><p>Time</p> <span style="text-transform: uppercase;"><?php echo $movie_showtime; ?></span> </li>                              
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-film"></i></li>
                                <li class="block-flex"><p>Screen</p> <span><?php echo $movie_screen; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="fas fa-couch"></i></li>
                                <li class="block-flex"><p>Seat</p> <span><?php echo $showmovie_seat; ?></span> </li>
                                <li class="spacing"></li>
                                <li class="data-icon icon-flex"><i class="far fa-money-bill-alt"></i></li>
                                <li class="block-flex"><p>Ticket Cost</p> <span>Rs. <?php echo $totalamount; ?></span> </li>
                                <li class="spacing"></li><li class="spacing"></li>
                                <li class="data-icon icon-flex" style="color:green;"><i class="far fa-check-circle"></i></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon icon-flex"><i class="fas fa-hamburger"></i></li>
                                <li class="block-flex otherlist">Food and Beverages</li>                                
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="movie-data-list">                            
                            <ul>                                 
                                <li class="data-icon icon-flex"><i class="fas fa-rupee-sign"></i></li>
                                <li class="block-flex"><p>Food Cost</p> <span id="showamt">0</span> </li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-3 text-center">
                        
                    </div>                    
                </div>
            </div>
        </div>          
    </div>
</section>

<div class="foodwrapper__container">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="foodmenu_title">
                    <h5>AGS reserved foods and beverages items</h5>
                    <p>Prebook your food beverages & save more.</p>
                </div>
            </div>
            <div class="col-md-12 text-center">
                <ul class="nav nav-tabs" id="foodmenuTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="all-tab" data-toggle="tab" href="#Allfooditem" role="tab" aria-controls="home" aria-selected="true">All</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link" id="agsFoodmenu-tab" data-toggle="tab" href="#mainfoodItem" role="tab" aria-controls="Food Item" aria-selected="false">Food</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link" id="agsBeveragemenu-tab" data-toggle="tab" href="#beveragesItem" role="tab" aria-controls="Beverage Item" aria-selected="false">Beverage</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="agsPopCornmenu-tab" data-toggle="tab" href="#popCornItem" role="tab" aria-controls="PopCorn Item" aria-selected="false">PopCorn</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="agsSnacksmenu-tab" data-toggle="tab" href="#snacksItem" role="tab" aria-controls="Snacks Item" aria-selected="false">Snacks</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="agsDessertsmenu-tab" data-toggle="tab" href="#dessertsItem" role="tab" aria-controls="Desserts Item" aria-selected="false">Desserts</a>
                    </li>
                </ul>
                <div class="tab-content majorfood_content">
                    <div class="tab-pane fade show active" id="Allfooditem" role="tabpanel" aria-labelledby="all-tab">
                        <div class="row" id="all_food_item_tab"></div>
                    </div>
                    <div class="tab-pane fade" id="mainfoodItem" role="tabpanel" aria-labelledby="food item">
                        <div class="row" id="food_item_tab"></div>
                    </div>
                    <div class="tab-pane fade" id="beveragesItem" role="tabpanel" aria-labelledby="Beverage item">
                        <div class="row" id="beverages_item_tab"></div>
                    </div>
                    <div class="tab-pane fade" id="popCornItem" role="tabpanel" aria-labelledby="PopCorn item">
                        <div class="row" id="popCorn_item_tab"></div>
                    </div>
                    <div class="tab-pane fade" id="snacksItem" role="tabpanel" aria-labelledby="Snacks item">
                        <div class="row" id="snacks_item_tab"></div>
                    </div>
                    <div class="tab-pane fade" id="dessertsItem" role="tabpanel" aria-labelledby="Desserts item">
                        <div class="row" id="desserts_item_tab"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 mt-4 proceeding-payement-part text-center">     
                <hr />
                <p><span class="fas fa-info-circle"></span> proceeding, I express my consent to complete this transaction.</p>                                       
                <button type="submit" class="btn btn-sm btn-outline-danger proceeds" onclick="proceed2()" id="paynow_btn"><i class="fas fa-comment-dollar"></i> Proceed to pay</button>                 
            </div>
        </div>
    </div>
</div>


<!-- ************** POPUP *************-->
<div class="modal fade" id="myModal17" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Drinks / Beverage Order - Confirmation</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body modal-body_order text-center">
            <img src="assets/images/img/snacks.png" class="order_snacks">
            <h5 class="modal_order" id="exampleModalLabel">When would you like your order to be delivered ?</h5>
        </div>
        <div class="modal-footer ">
            <div class="col-md-12">
                <button type="button" class=" btn btn-outline-primary btn-sm" onclick="foodtime('before')">During Entry</button>
                <button type="button" class=" btn btn-outline-danger btn-sm" style="float:right;" onclick="foodtime('after')">During Interval</button>
            </div>            
        </div>        
    </div>
    </div>
</div>
<!-- ************** POPUP *************-->

<?php include('footer.php'); ?>
<script type="text/javascript">        
    var showid ="<?php echo $_SESSION['movie_showid']; ?>";
    var cin_id ="<?php echo $_SESSION['Cin_Id']; ?>";
    var p17 = "<?php  echo $_COOKIE['userid']; ?>";    
    var CinemaId = cin_id;
    var TempTransId = "<?php echo $_SESSION['transac_id']; ?>";

    $(document).ready(function() {
        var movie_seat="<?php echo $movie_seat ?>";
        var seatlengths="<?php echo $_SESSION['seatlength']; ?>";        
        var seatcatid="<?php echo $_SESSION['seat_cat_type_id']; ?>";     
        if(p17=='') {
            var datas = {'seat':movie_seat,'showid':showid, foodOrder: '1'} 
            $.ajax({
                type: "POST",
                url: "classes/php/session_clear.php",
                data: datas
            }).done(function(data) {
                window.location = 'movies.php';
            });
        }
    });

    $(document).ready(function() {
        var cinemas_id = cin_id;        
        if (cinemas_id == '1') {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_tnagar.json",
                data: "",
                success: food_drop
            });
        } else if (cinemas_id == '2') {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_navalur.json",
                data: "",
                success: food_drop
            });
        } else if (cinemas_id == '3') {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_villivakkam.json",
                data: "",
                success: food_drop
            });
        } else {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_allapakkam.json",
                data: "",
                success: food_drop
            });
        }
    });

    function food_drop(data) {

        var Arr = [];
        $.each( data, function( key, value ) {  Arr.push(value);  });
        var htmlText='';
        htmlText += '<li><a href="#">ALL</a></li>';
        for(var key in data) {
            if(key == 0) {
                getvaluetype(data[key].foodType,data[key].cin_id);      
            }        
            htmlText += '<li><a href="#">'+data[key].foodType+'</a></li>';
        }
        $(".tickdrop").html(htmlText);
        DropDown.prototype = {
            initEvents : function() {
                var obj = this;
                obj.opts.on('click',function() {
                    var opt = $(this);
                    obj.val = opt.text();
                    obj.index = opt.index();
                    obj.placeholder.text(obj.val);
                    var sep = obj.val;
                    var str = sep;
                    if(str == 'ALL') {
                        $(".foodload").show();   
                    } else {
                        var sep1=sep+'_div';
                        var str = sep;
                        $(".foodload").hide();
                        $("."+sep1).show();  
                    }
                    $(".ticketno").html(obj.val);
                });
            },
            getValue : function() { return this.val; },
            getIndex : function() { return this.index; }
        }
    }

    function DropDown(el) {
        this.dd = el;
        this.placeholder = this.dd.children('span');
        this.opts = this.dd.find('ul.dropdown > li');
        this.val = '';
        this.index = -1;
        this.initEvents();
    }

    function getvaluetype(foodType, id) {
        
        if(id == '1') {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/foodjson/foodlist/showfood_tnagar.json",
                data: ""
            }).done(function( data ) {         
                food_list(data);    
            }); 
        } else if (id == '2') {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/foodjson/foodlist/showfood_navalur.json",
                data: ""
            }).done(function( data ) { 
                food_list(data);    
            });
        } else if (id == '3') {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/foodjson/foodlist/showfood_villivakkam.json",
                data: ""
            }).done(function( data ) {
                food_list(data);    
            });
        } else {
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/foodjson/foodlist/showfood_allapakkam.json",
                data: ""
            }).done(function( data ) {        
                food_list(data);    
            });
        }
    }

    var foodvalue = 0;       
            
    function food_list(data) {    
        var Arr = [];
        $.each( data, function( key, value ) { Arr.push(value); });
        var htmlText='';   
        var foodText='';   
        var beveragesText=''; 
        var dessertsText=''; 
        var popCornText=''; 
        var snacksText=''; 
        var foodFalse = [];
        var beveragesFalse = [];
        var dessertsFalse = []; 
        var popCornFalse = []; 
        var snacksFalse = [];
        for (var key in Arr) {
            // console.log(Arr[key].foodType);
            if(Arr[key].foodType == 'Foods' && Arr[key].foodType != 'Beverages' && Arr[key].foodType != 'PopCorn' && Arr[key].foodType != 'Snacks' && Arr[key].foodType != 'Desserts')
                foodFalse.push(Arr[key].foodType == 'Foods');

            if(Arr[key].foodType != 'Foods' && Arr[key].foodType == 'Beverages' && Arr[key].foodType != 'PopCorn' && Arr[key].foodType != 'Snacks' && Arr[key].foodType != 'Desserts')
                beveragesFalse.push(Arr[key].foodType == 'Beverages');

            if(Arr[key].foodType != 'Foods' && Arr[key].foodType != 'Beverages' && Arr[key].foodType == 'PopCorn' && Arr[key].foodType != 'Snacks' && Arr[key].foodType != 'Desserts')
                popCornFalse.push(Arr[key].foodType == 'PopCorn');

            if(Arr[key].foodType != 'Foods' && Arr[key].foodType != 'Beverages' && Arr[key].foodType != 'PopCorn' && Arr[key].foodType == 'Snacks' && Arr[key].foodType != 'Desserts')
                snacksFalse.push(Arr[key].foodType == 'Snacks');

            if(Arr[key].foodType != 'Foods' && Arr[key].foodType != 'Beverages' && Arr[key].foodType != 'PopCorn' && Arr[key].foodType != 'Snacks' && Arr[key].foodType == 'Desserts')
                dessertsFalse.push(Arr[key].foodType == 'Desserts');

            if(Arr[key].foodType == 'Foods'){
                var foodDiscount = data[key].discount;  
                foodText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
                foodText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
                if(foodDiscount == 'yes') {

                } else {
                    var food_pricees=data[key].foodPrice;
                    foodText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
                }
                foodText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
                foodText += '</div></div></div>';
            }

            if(Arr[key].foodType == 'Beverages'){
                var beveragesDiscount = data[key].discount;  
                beveragesText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
                beveragesText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
                if(beveragesDiscount == 'yes') {

                } else {
                    var food_pricees=data[key].foodPrice;
                    beveragesText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
                }
                beveragesText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
                beveragesText += '</div></div></div>';
            }

            if(Arr[key].foodType == 'PopCorn'){
                
                var popCornDiscount = data[key].discount;  
                popCornText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
                popCornText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
                if(popCornDiscount == 'yes') {

                } else {
                    var food_pricees=data[key].foodPrice;
                    popCornText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
                }
                popCornText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
                popCornText += '</div></div></div>';
            }

            if(Arr[key].foodType == 'Snacks'){

                var snacksDiscount = data[key].discount;  
                snacksText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
                snacksText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
                if(snacksDiscount == 'yes') {

                } else {
                    var food_pricees=data[key].foodPrice;
                    snacksText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
                }
                snacksText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
                snacksText += '</div></div></div>';
            }
            
            if(Arr[key].foodType == 'Desserts'){
                var dessertsDiscount = data[key].discount;  
                dessertsText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
                dessertsText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
                if(dessertsDiscount == 'yes') {

                } else {
                    var food_pricees=data[key].foodPrice;
                    dessertsText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
                }
                dessertsText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
                dessertsText += '</div></div></div>';
            }

            var discount = data[key].discount;  
            htmlText +='<div class="col-md-3"><div class="foodbox_list"><div class="foodmain__img">';
            htmlText +='<img class="img-fluid" src="<?php echo $foodimg?>/'+data[key].foodImage+'" title="'+data[key].foodName+'" alt="food and beverage" /></div>';
            if(discount == 'yes') {

            } else {
                var food_pricees=data[key].foodPrice;
                htmlText += '<div class="pricebox"><p title="Rupees: '+data[key].foodPrice+'"><i class="fas fa-rupee-sign"></i>' +data[key].foodPrice+'</p><span class="veg" title="Pure vegetarian"></span></div>';  
            }
            htmlText += '<div class="foodaddon_process"><marquee scrolldelay="100" behavior="scroll" scrollamount="2" direction="left">' +data[key].foodName+'</marquee><div class="addamount_process"><button type="button" class="action_btn remove_quantity" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')" title="Remove item"><i class="fas fa-minus"></i></button><div class="disp_amt"><input type="text" class="food_amt" data-typeid="'+data[key].id+'" id="count_'+data[key].id+'" value="0" disabled="" readyonly /></div><button type="button" class="action_btn add_quantity" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')" title="Add item"><i class="fas fa-plus"></i></button></div>';
            htmlText += '</div></div></div>';
        }

        if(foodFalse.length == 0){
            foodText +='<div class="no-food-available"><p>This category food not available right now..<span></span></p><img class="img-fluid" src="assets/images/icons/not-allowed.png" alt="not found" /></div>';
        }

        if(beveragesFalse.length == 0){
            beveragesText +='<div class="no-food-available"><p>Beverage item not available right now..<span></span></p><img class="img-fluid" src="assets/images/icons/not-allowed.png" alt="not found" /></div>';
        }

        if(popCornFalse.length == 0){
            popCornText +='<div class="no-food-available"><p>Beverage item not available right now..<span></span></p><img class="img-fluid" src="assets/images/icons/not-allowed.png" alt="not found" /></div>';
        }

        if(snacksFalse.length == 0){
            snacksText +='<div class="no-food-available"><p>Beverage item not available right now..<span></span></p><img class="img-fluid" src="assets/images/icons/not-allowed.png" alt="not found" /></div>';
        }

        if(dessertsFalse.length == 0){
            dessertsText +='<div class="no-food-available"><p>Beverage item not available right now..<span></span></p><img class="img-fluid" src="assets/images/icons/not-allowed.png" alt="not found" /></div>';
        }
        $("#all_food_item_tab").append(htmlText);
        $("#food_item_tab").append(foodText);
        $("#beverages_item_tab").append(beveragesText);
        $("#popCorn_item_tab").append(popCornText);
        $("#snacks_item_tab").append(snacksText);
        $("#desserts_item_tab").append(dessertsText);
    }

    var plus = 0; 
    function incrementValue(str,str1,strid) {
        var value = parseInt(document.getElementById(str).value, 10);
        value = isNaN(value) ? 0 : value;
        if(value < 10) {
            value++;
           // $('[id="'+str+'"]').val(value);    
	    document.getElementById(str).value = value;  
            plus = Number(plus)+Number(str1);
            $('#showamt').text(plus);
        }
    }

    function decrementValue(str,str1,strid) {
        var value = parseInt(document.getElementById(str).value, 10);
        value = isNaN(value) ? 0 : value;
        if(value > 0) {
            value--;
            // $('[id="'+str+'"]').val(value);
            document.getElementById(str).value = value;
            plus = Number(plus)-Number(str1);
            $('#showamt').text(plus);
        }
    }

    function proceed2() {
        var movie_seat="<?php echo $movie_seat ?>";
        var showmovie_seat="<?php echo $showmovie_seat ?>";
        var val = new Array();
        var val1 = new Array();
        $(".food_amt").each(function(i) {
            if($(this).val() > 0){
                val.push($(this).attr('data-typeid'));
                val1.push($(this).val());
            }
        });

        if(val1 == '') {
            if(val1.length == 0)
                val1 = '';
            if(val.length == 0)
                val = '';

            var valuess = plus;
            var minsec = timeleftsec;
            var datas = {'amtvalues':valuess,'food_id':val,'count_num':val1,'timelefts':minsec,'movie_seat':movie_seat,'showmovie_seat':showmovie_seat,'cinemaid':cin_id};

            $.ajax({
                type: "POST",
                url: "classes/php/session_food.php",
                data: datas
            }).done(function(data) {
                var continuetransdatas = {'CinemaId':CinemaId,'TempTransId':TempTransId};
                $.ajax({
                    type: "POST",
                    dataType: "json",
                    url: "classes/php/continuetrans.php",
                    data: continuetransdatas,
                }).done(function(data) {                
                    var status1=data[0].result1;
                    if(status1 == "success"){
                        window.onbeforeunload = null;
                        localStorage.removeItem("seconds");
                        window.location = 'moviespayment.php';
                    } else {
			
                    }
                }); 
            });
        } else {
            $('#myModal17').modal("show");
        }
    }

    var dynam_foodval = '';

    function foodtime(str17) {
        // debugger;
        var movie_seat = "<?php echo $movie_seat ?>";
        var showmovie_seat = "<?php echo $showmovie_seat ?>";
        var val = new Array();
        var val1 = new Array();
        $(".food_amt").each(function(i) {
            if($(this).val() > 0){
                val.push($(this).attr('data-typeid'));
                val1.push($(this).val());
            }
        });
        dynam_foodval = str17;
        var valuess=plus;
        var minsec=timeleftsec;
        var datas = {'amtvalues':valuess,'food_id':val,'count_num':val1,'timelefts':minsec,'dynam_foodval':dynam_foodval,'movie_seat':movie_seat,'showmovie_seat':showmovie_seat,'cinemaid':cin_id};
        $.ajax({
            type: "POST",
            url: "classes/php/session_food.php",
            data: datas
        }).done(function(data) {
            var continuetransdatas={'CinemaId':CinemaId,'TempTransId':TempTransId}
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/php/continuetrans.php",
                data: continuetransdatas
            }).done(function(data) {
                var status1 = data[0].result1;
                if(status1 == "success") {
                    window.onbeforeunload = null;
                    localStorage.removeItem("seconds");
                    window.location = 'moviespayment.php';
                } else {

                }
            }); 
        });
    }
</script>