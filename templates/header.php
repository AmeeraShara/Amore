<!-- <noscript>
    <style>
        body *{ 
            display: none !important;
        }
        h3{
            padding: 100px 0px;
            display: block !important;
            margin: auto auto;
            text-align: center;
            color:red !important;
        }
    </style>
    <h3>JavaScript is not enabled, please check your browser settings.</h3>
</noscript> -->

<?php include('common.php');  ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?php echo getCompanyName(); ?> <?php echo getPageTitle(); ?></title>
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- GOOGLE FONT -->
    <link href="https://fonts.googleapis.com/css?family=Playfair+Display:400,700,900" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Montserrat:100,200,300,400,500,600,700,800,900" rel="stylesheet">
    <!-- CSS LIBRARY -->
    <link rel="stylesheet" type="text/css" href="css/home/font-awesome.css">
    <link rel="stylesheet" type="text/css" href="css/home/ionicons.min.css">
    <link rel="stylesheet" type="text/css" href="css/home/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css" href="css/home/gallery.css">
    <link rel="stylesheet" type="text/css" href="css/home/vit-gallery.css">
    <link rel="shortcut icon" type="text/css" href="images/favicon.png" />
    <link rel="stylesheet" type="text/css" href="css/home/bootstrap-select.min.css">
    <link rel="stylesheet" type="text/css" href="css/home/bootstrap-datepicker.css" />
    <!-- MAIN STYLE -->
    <link rel="stylesheet" href="css/home/styles.css">
    
    <!-- LOAD JQUERY -->
    <script type="text/javascript" src="js/home/jquery-1.12.4.min.js"></script>
    <script type="text/javascript" src="js/home/owl.carousel.min.js"></script>
    <script type="text/javascript" src="js/home/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/home/vit-gallery.js"></script>
    <script type="text/javascript" src="js/home/jquery.countTo.js"></script>
    <script type="text/javascript" src="js/home/jquery.appear.min.js"></script>
    <script type="text/javascript" src="js/home/isotope.pkgd.min.js"></script>
    <script type="text/javascript" src="js/home/bootstrap-select.js"></script>
    <script type="text/javascript" src="js/home/jquery.littlelightbox.js"></script>
    <script type="text/javascript" src="js/home/bootstrap-datepicker.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBDyCxHyc8z9gMA5IlipXpt0c33Ajzqix4"></script>
    <!-- Custom jQuery -->
    <script type="text/javascript" src="js/home/amore.js"></script>
    <style>
        @media (max-width: 480px){
            .footer-sky .footer-mid .padding-footer-mid {
                padding: 15px 0px 10px 0px;
            }
        }
    </style>
</head>

<body>

    <!-- HEADER -->
    <header class="header-sky">
        <div class="container">
            <!--HEADER-TOP-->
            <div class="header-top">
                <div class="header-top-left">
                    <span style="text-shadow: -2px 3px 7px rgba(0,0,0,0.9);"><i class="ion-ios-location-outline"></i> <?php echo getAddress(); ?></span>
                    <span style="text-shadow: -2px 3px 7px rgba(0,0,0,0.9);"><i class="fa fa-phone" aria-hidden="true"></i> <?php echo getContactMobileNumber(); ?></span>
                </div>
                <div class="header-top-right">
                </div>
            </div>
            <!-- END/HEADER-TOP -->
        </div>
        <!-- MENU-HEADER -->
        <div class="menu-header">
            <nav class="navbar navbar-fixed-top">
                <div class="container">
                    <div class="navbar-header ">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar "></span>
                            <span class="icon-bar "></span>
                            <span class="icon-bar "></span>
                        </button>
                        <a class="navbar-brand" href="index.php" title="Hotel Amore Logo"><img src="images/logos/white-logo.png" alt="Hotel Amore Logo"></a>
                    </div>
                    <div class="collapse navbar-collapse">
                        <ul class="nav navbar-nav navbar-right">
                            <li <?php if((getScriptName() == "home.php") || getScriptName() == "") echo 'class="active"'; else '' ?>><a href="home.php" title="Home">Home</a></li>
                            <li <?php if(getScriptName() == "rooms.php" || getScriptName() == "room.php") echo 'class="active"'; else '' ?>><a href="rooms.php" title="Rooms">Rooms</a></li>
                            <li <?php if(getScriptName() == "restaurant.php") echo 'class="active"'; else '' ?>><a href="restaurant.php" title="Restaurant">Restaurant</a></li>
                            <li <?php if(getScriptName() == "near_by_places.php") echo 'class="active"'; else '' ?>><a href="near_by_places.php" title="Near by Places">Near by Places</a></li>
                            <li <?php if(getScriptName() == "contact.php") echo 'class="active"'; else '' ?>><a href="contact.php" title="Contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
        </div>
        <!-- END / MENU-HEADER -->
    </header>
    <!-- END-HEADER -->