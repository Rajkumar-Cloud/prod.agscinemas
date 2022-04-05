<?php 
     include ('header.php'); 

    if (!isset($_SESSION["movie_Name"])){
        header("Location:movies.php");
    }
    $movieId=$_SESSION['movieId'];
    $movie_Name=$_SESSION['movie_Name'];
    $movie_Language=$_SESSION['movie_Language'];
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
                                <li><?php echo $movie_Language ?> - <?php echo $movie_Genre ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="movie-data-list">                            
                            <ul> 
                                <li class="data-icon"><i class="fas fa-clock"></i></li>
                                <li>Run Time - <span><?php echo $movie_runTime; ?> Minutes</span></li>
                                <li class="spacing"></li>
                                <li class="data-icon"><i class="fas fa-star-half-alt"></i></li>
                                <li>Rating - <span><?php echo $movie_Censor; ?></span></li>
                                <li class="spacing"></li>
                                <!--<li class="data-icon"><i class="fas fa-user-clock"></i></li>-->
                                <!--<li>Time Left - <span id="waiting_time"></span></li>-->
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
                    <div class="col-md-3">
                        <div class="movie-data-list"> 
                        <div class="col-sm-12">
                            <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Collections</button>
                            <div id="dd7" class="wrapper-dropdown-7" tabindex="1">
                                <!-- <p class="ticketno">ALL</p><img src="assets/images/down.png" class="selectdir"> -->
                                <ul class="dropdown dropdown-menu tickdrop"> </ul>
                            </div>

                            <!-- <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Collections</button>
                            <ul id="dd7" class="wrapper-dropdown-7 dropdown-menu tickdrop">
                                                      
                            </ul> -->
                            
                        </div>                           
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div id="foodcostlist">
                        <div class="col-md-12 col-xs-12 col-sm-12 foodcost_0">
                            <div id="foodlist"></div>
                        </div>
                    </div>
                    <div class="col-md-12"><div class="divider-rows"></div></div>
                    <div class="col-md-12 mt-3 text-right">                                            
                            <button type="submit" class="btn btn-primary proceeds" onclick="proceed2()" id="paynow_btn"><i class="fas fa-shopping-cart"></i> Paynow</button>                 
                    </div>
                </div>
            </div>
        </div>          
    </div>
</section>

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
                    <button type="button" class=" btn btn-primary btn-sm btn-order" onclick="foodtime('before')">During Entry</button>
                    <button type="button" class=" btn btn-danger btn-sm btn-order1" style="float:right;" onclick="foodtime('after')">During Interval</button>
                </div>            
            </div>        
        </div>
      </div>
    </div>
<!-- ************** POPUP *************-->

<?php include('footer.php'); ?>
<script type="text/javascript">
    
    var timeleftsec='';
    var isWaiting = false;
    var isRunning = false;
    var seconds = 300;
    var countdownTimer;
    var finalCountdown = false;

    if (localStorage.getItem("seconds") !== null) 
    {
        seconds = localStorage.getItem("seconds");
    }  //seconds not change using getItem And setItem  

    function GameTimer() {
        if (isWaiting) {
            return;   
        }
        var minutes = Math.round((seconds - 30) / 60);
        var remainingSeconds = seconds % 60;
        if (remainingSeconds < 10) {
            remainingSeconds = "0" + remainingSeconds;
        }

        $('#waiting_time').html(minutes + ":" + remainingSeconds);

        timeleftsec = minutes * 60+ remainingSeconds;


        if (seconds == 0) {

            if (finalCountdown) {
                clearInterval(countdownTimer);

                $.ajax({
                    url: "classes/php/session_clear.php",
                }).done(function( data ) {

                    Swal.fire({
                        title: "",
                        text: "Your session has Expired",
                        type: "warning",
                        showCancelButton: false,
                        confirmButtonClass: "btn-danger",
                        confirmButtonText: "OK",
                        closeOnConfirm: false
                    }).then(function(){
                        sessionStorage.removeItem('Dategetting');
                        window.location = "movies.php";
                    });

                });

            } else {
                finalCountdown = true;
            }

        } else {             

        seconds--;
        }
        localStorage.setItem("seconds",seconds);

    }
    // countdownTimer = setInterval(GameTimer, 1000);

    var showid="<?php echo $_SESSION['movie_showid']; ?>";
    var cin_id="<?php echo $_SESSION['Cin_Id']; ?>";
    var p17="<?php  echo $_COOKIE['userid']; ?>";    
    var CinemaId = cin_id;
    var TempTransId = "<?php echo $_SESSION['transac_id']; ?>";

    $(document).ready(function() {

        var movie_seat="<?php echo $movie_seat ?>";
        var seatlengths="<?php echo $_SESSION['seatlength']; ?>";        
        var seatcatid="<?php echo $_SESSION['seat_cat_type_id']; ?>";      

        if(p17=='')
        {
            var datas={'seat':movie_seat,'showid':showid, foodOrder: '1'} 

            $.ajax({
                type: "POST",
                url: "classes/php/session_clear.php",
                data: datas
            }).done(function(data) {
                window.location='movies.php';
            });
        }

    });

    $(document).ready(function() {

        var cinemas_id = cin_id;        
        if (cinemas_id == '1')
        {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_tnagar.json",
                data: "",
                success: food_drop
            });
        }
        else if (cinemas_id == '2')
        {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_navalur.json",
                data: "",
                success: food_drop
            });
        }
        else if (cinemas_id == '3')
        {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_villivakkam.json",
                data: "",
                success: food_drop
            });
        }
        else
        {
            $.ajax({
                dataType: "json",
                url: "classes/foodjson/foodcat/foodtype_allapakkam.json",
                data: "",
                success: food_drop
            });
        }

    });

function food_drop(data)
{
    var Arr = [];
    $.each( data, function( key, value ) {
        Arr.push(value);
    });
    var htmlText='';

    htmlText +='<li><a href="#"><p class="food-history">ALL</p></a></li>';

    for(var key in data)
    {

        if(key == 0){
            getvaluetype(data[key].foodType,data[key].cin_id);      
        }
        
        htmlText +='<li><a href="#"><p class="food-history">'+data[key].foodType+'</p></a></li>';

    }
    $(".tickdrop").html(htmlText);

    function DropDown(el) {
        this.dd = el;
        this.placeholder = this.dd.children('span');
        this.opts = this.dd.find('ul.dropdown > li');
        this.val = '';
        this.index = -1;
        this.initEvents();
    }
    DropDown.prototype = {
        initEvents : function() {
        var obj = this;
        obj.dd.on('click', function(event){

        $(this).toggleClass('active');
        if($(this).hasClass('active')){
        $(".selectdir").attr("src","assets/images/up.png");
        $(".tickdrop").show();
        $(".tickdrop").show();
        }
        else{
        $(".selectdir").attr("src","assets/images/img/down.png");
        $(".tickdrop").hide();
        }
        return false;

        });

        obj.opts.on('click',function(){

        var opt = $(this);
        obj.val = opt.text();

        obj.index = opt.index();
        obj.placeholder.text(obj.val);
        var sep=obj.val;
        var str = sep;
        if(str=='ALL')
        {
        $(".foodload").show();   
        }
        else
        {

        var sep1=sep+'_div';
        var str = sep;
        $(".foodload").hide();
        $("."+sep1).show();  
        }



        $(".ticketno").html(obj.val);
        });
        },
        getValue : function() {
        return this.val;
        },
        getIndex : function() {
        return this.index;
        }
    }

    $(function() {

        var dd = new DropDown($('#dd7'));

        $(document).click(function() {
        // all dropdowns
            $('.wrapper-dropdown-7').removeClass('active');
            if($("#dd7").hasClass('active')){
                $(".selectdir").attr("src","assets/images/up.png");
            }
            else{
                $(".selectdir").attr("src","assets/images/img/down.png");
            }
        });

    });
}

function getvaluetype(foodType,id)
{

    var foodType=foodType;
    var id=id;


    if(id == '1')
    {
        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/foodjson/foodlist/showfood_tnagar.json",
            data: ""
        }).done(function( data ) {
            console.log(data);
            food_list(data);    
        });   

    }
    else if (id == '2')
    {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/foodjson/foodlist/showfood_navalur.json",
            data: ""
        }).done(function( data ) {
            food_list(data);    
        });

    }
    else if (id == '3')
    {

        $.ajax({
            type: "POST",
            dataType: "json",
            url: "classes/foodjson/foodlist/showfood_villivakkam.json",
            data: ""
        }).done(function( data ) {
            food_list(data);    
        });
    }
    else{

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

var foodvalue=0;      
        
        
function food_list(data)
{
    console.log(data);
    var Arr = [];
    $.each( data, function( key, value ) {
        Arr.push(value);
    });
   var htmlText='';
   
   htmlText +='<div class="foodload '+data[Object.keys(data)[0]].foodType+'_div">';

    for (var key in Arr)
        {
            var discount=data[key].discount;//new
            
      htmlText +='<div class="col-md-4 food_cost_001"><div class="food_cost_01">';      
      htmlText +='<div class="food_images"><div class="foo_img"><img src="<?php echo $foodimg?>/' +data[key].foodImage+'" class="food_bevarages"></div>';  
      
      if(discount=='yes')
      {
          htmlText +='<h1 class="ribbon"><strong class="ribbon-content">' +data[key].discountpercent+' Off</strong> </h1>';
          
          var food_pricees=data[key].sellingprice;
         htmlText +='<p class="total_cost_amount"><img src="assets/images/img/rupee.png" class="addfood10"><span class="cost_amount_total">' +data[key].sellingprice+'</span></p>';
         htmlText +='<strike class="total_cost_amount_new"><img src="assets/images/img/rupee.png" class="addfood10"><span class="cost_amount_total">' +data[key].foodPrice+'</span></strike>';
      }
      else
      {
           var food_pricees=data[key].foodPrice;
        htmlText +='<p class="total_cost_amount"><img src="assets/images/img/rupee.png" class="addfood10"><span class="cost_amount_total">' +data[key].foodPrice+'</span></p>';  
      }
      

      
      htmlText +='<div class="row food_name">';      
      htmlText +='<div class="col-md-8 col-sm-8 col-xs-8 food_name0">';  htmlText +='<marquee class="food_name_list" scrolldelay="400" behavior="scroll" direction="left">' +data[key].foodName+'</marquee></div>';     
      
      htmlText +='<div class="col-md-4 col-sm-4 col-xs-4 food_name01">';    
      htmlText +='<div class="col-md-12 col-xs-12 col-ms-12 media"><div class="col-md-4 col-xs-4 col-sm-4 calculate">';
        htmlText +='<img src="assets/images/img/minus.png" class="addfood1" onclick="decrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+food_pricees+'\')"></div>';
        htmlText +='<div class="col-md-4 col-xs-4 col-sm-4 calculate0" style="text-align: center;">';
        htmlText +='<input data-typeid="'+data[key].id+'" class="food_amt" id="count_'+data[key].id+'" value="0" disabled="" type="text"></div>';
        htmlText +='<div class="col-md-4 col-xs-4 col-sm-4 calculate">';
        htmlText +='<img src="assets/images/img/plus.png" class="addfood" onclick="incrementValue(\'count_'+data[key].id+'\',\''+food_pricees+'\',\''+data[key].id+'\')"></div></div>';
      
      htmlText +='</div></div></div></div></div>';      
            
       }
      htmlText +='</div>';
    $("#foodlist").append(htmlText);
    
}


var plus=0; 

function incrementValue(str,str1,strid)
{   
/*if(document.getElementById('shownumber1').value < 10){*/
    var value = parseInt(document.getElementById(str).value, 10);
    value = isNaN(value) ? 0 : value;
    if(value<10)
    {
        value++;
        document.getElementById(str).value = value;      
       
        plus=Number(plus)+Number(str1);
       
  // document.getElementById("showamt").value = plus;
     $('#showamt').text(plus);
        
   }
}

function decrementValue(str,str1,strid)
{
 

    var value = parseInt(document.getElementById(str).value, 10);
    value = isNaN(value) ? 0 : value;
    if(value>0)
    {
        value--;
        document.getElementById(str).value=value;
        plus=Number(plus)-Number(str1);
        $('#showamt').text(plus);
    }
    
}

function proceed2()
{
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
    if(val1=='')
    {

        var valuess=plus;
        var minsec=timeleftsec;
        var datas={'amtvalues':valuess,'food_id':val,'count_num':val1,'timelefts':minsec,'movie_seat':movie_seat,'showmovie_seat':showmovie_seat,'cinemaid':cin_id}  
        $.ajax({
            type: "POST",
            url: "classes/php/session_food.php",
            data: datas
        }).done(function(data) {
            var continuetransdatas={'CinemaId':CinemaId,'TempTransId':TempTransId}
            console.log(continuetransdatas);
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "classes/php/continuetrans.php",
                data: continuetransdatas,
            }).done(function(data) {
                console.log(data);
                var status1=data[0].result1;

                if(status1 == "success"){
                    window.onbeforeunload = null;
                    localStorage.removeItem("seconds");
                    window.location = 'moviespayment.php';
                }
                else{

                }
            }); 
        });

    }
    else
    {
        $('#myModal17').modal("show");
    }
}

var dynam_foodval='';

function foodtime(str17)
{
    // debugger;
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

    dynam_foodval=str17;

    var valuess=plus;
    var minsec=timeleftsec;

    var datas={'amtvalues':valuess,'food_id':val,'count_num':val1,'timelefts':minsec,'dynam_foodval':dynam_foodval,'movie_seat':movie_seat,'showmovie_seat':showmovie_seat,'cinemaid':cin_id}  
    console.log(datas);
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
            var status1=data[0].result1;
            if(status1 == "success"){
                window.onbeforeunload = null;
                localStorage.removeItem("seconds");
                window.location = 'moviespayment.php';
            }
            else{

            }
        }); 

    }); 



}



</script>