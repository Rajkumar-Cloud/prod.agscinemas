<?php
// function getFullHost()
// {
//     $protocole = $_SERVER['REQUEST_SCHEME'].'://';
//     $host = $_SERVER['HTTP_HOST'] . '/';
//     $project = explode('/', $_SERVER['REQUEST_URI'])[1];
//     return $protocole . $host . $project;
// }
// $SERVER_NAME = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]";   
// $project = explode('/', $_SERVER['REQUEST_URI'])[1];
include('header.php'); ?>
<div class="w-100 header-ags-loc-cont">
    <img class="img-fluid" src="assets/images/loc_alapakkam_new3.jpg" alt="alapakkam" />
    <p>AGS Maduravoyal is our flagship property with state-of-the-art interiors and the best quality 4K projection, designed to give life to the reel to real experience. The property has 5 massive screens with varied capacities to accommodate the different audiences of the huge plethora of movies we exhibit. The property is fully-equipped with a spacious car park and ample space for two wheelers. The multiplex is located centrally, with easy access. We pride ourselves of making and maintaining the best stand-alone multiplexes in the city and take great delight in bringing to people an affordable and good quality cinema viewing experience.</p>
</div>
<div class="container">
    <div class="row ags-seperate-info">
        <div class="col-md-12">
            <div class="location-title text-center p-3 mb-2">
                <h4>AGS Alapakkam </h4>
            </div>
        </div>
        <div class="col-md-7">
            <div class="map-container pb-4">            
                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3886.6109186641106!2d80.16269321384455!3d13.060420116459186!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a5261df6dc09b8d%3A0x82e8a7ab8e13d749!2sAGS%20Cinemas%20Maduravoyal!5e0!3m2!1sen!2sin!4v1635326159978!5m2!1sen!2sin" width="100%" height="320px" style="border:0;" allowfullscreen="" loading="lazy"></iframe>
            </div>
        </div>
        <div class="col-md-5">
            <div class="ags-loc-addr">
                <h5><img src="assets/images/icons/map-placeholder.png" alt="placeholder" width="20px" /> Location Details</h5>
                <p>AGS Cinemas,<br /> No. 3/47, Alapakkam Main Road, <br> Maduravoyal, <br>Chennai 600095 </p>
            </div>
        </div>
    </div>
</div>
<?php include('footer.php'); ?>