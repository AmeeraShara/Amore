<body>

    <!-- preloader Start -->
    <div id="preloader">
        <div id="status">
            <center><img src="images/loader.gif" width="width: 80%;" height="80%" id="preloader_image" alt="loader"></center>
        </div>
    </div>
    <div class="cursor"></div>
    <!-- preloader End -->

    <!-- Top Scroll Start -->
    <a href="javascript:" id="return-to-top"> <i class="fas fa-angle-double-up"></i></a>
    <!-- Top Scroll End -->
    
    <!-- cp navi wrapper Start -->
    <nav class="cd-dropdown d-block d-sm-block d-md-block d-lg-none d-xl-none">
        <h2><a href="index.php"><?php echo getCompanyName(); ?></a></h2>
        <a href="#0" class="cd-close">Close</a>
        <ul class="cd-dropdown-content">
            <li><a href="index.php?components=admin&action=index" class="<?php if($_REQUEST['action'] =='index') echo 'active' ?>"> home </a></li>
            <li class="has-children">
                <a href="#" class="<?php if($_REQUEST['action'] =='rooms' || $_REQUEST['action'] =='room_add' || $_REQUEST['action']== 'room_edit' || $_REQUEST['action'] == 'room_inside_images' || $_REQUEST['action'] == 'room_inside_image_manage' || $_REQUEST['action'] ==  'room_inside_details' || $_REQUEST['action'] ==  'add_room_detail_category' || $_REQUEST['action'] == 'edit_room_detail_category') echo 'active' ?>">rooms</a>
                <ul class="cd-secondary-dropdown icon_menu is-hidden">
                    <li class="go-back"><a href="#0">Menu</a></li>
                    <li><a href="index.php?components=admin&action=rooms" class="<?php if($_REQUEST['action'] =='rooms' || $_REQUEST['action'] == 'room_edit') echo 'active' ?>">rooms</a></li>
                    <li><a href="index.php?components=admin&action=room_inside_images" class="<?php if($_REQUEST['action'] =='room_inside_images' || $_REQUEST['action'] == 'room_inside_image_manage') echo 'active' ?>">room inside images</a></li>
                    <li><a href="index.php?components=admin&action=room_inside_details" class="<?php if($_REQUEST['action'] =='room_inside_details' || $_REQUEST['action'] ==  'add_room_detail_category' || $_REQUEST['action'] == 'edit_room_detail_category') echo 'active' ?>">room inside details</a></li>
                </ul>
            </li> 
            <li><a href="index.php?components=admin&action=room_booking_meal_plans" class="<?php if($_REQUEST['action'] =='room_booking_meal_plans' || $_REQUEST['action'] == 'edit_room_booking_meal_plan') echo 'active' ?>"> room booking meal plans </a></li>
            <li><a href="index.php?components=admin&action=logout"> logout </a></li>
        </ul>
        <!-- .cd-dropdown-content -->
    </nav>
    <div class="cp_navi_main_wrapper inner_header_wrapper float_left">
        <div class="container-fluid">
            <div class="cp_logo_wrapper">
                <a href="index.php">
                    <img src="images/logos/footer-logo.png" alt="logo" width="width: 80px;" height="60px;">
                </a>
            </div>
            <!-- mobile menu area start -->
            <header class="mobail_menu d-block d-sm-block d-md-block d-lg-none d-xl-none">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="cd-dropdown-wrapper">
                                <a class="house_toggle inner_toggle" href="#0">
                                    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                        version="1.1" id="Capa_1" x="0px" y="0px" viewBox="0 0 31.177 31.177"
                                        style="enable-background:new 0 0 31.177 31.177;" xml:space="preserve"
                                        width="25px" height="25px">
                                        <g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,1.775H0.946c-0.489,0-0.887-0.398-0.887-0.888S0.457,0,0.946,0H30.23    c0.49,0,0.888,0.398,0.888,0.888S30.72,1.775,30.23,1.775z"
                                                    fill="#f46b45" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,9.126H12.069c-0.49,0-0.888-0.398-0.888-0.888c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,8.729,30.72,9.126,30.23,9.126z"
                                                    fill="#f46b45" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,16.477H0.946c-0.489,0-0.887-0.398-0.887-0.888c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,16.079,30.72,16.477,30.23,16.477z"
                                                    fill="#f46b45" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,23.826H12.069c-0.49,0-0.888-0.396-0.888-0.887c0-0.49,0.398-0.888,0.888-0.888H30.23    c0.49,0,0.888,0.397,0.888,0.888C31.118,23.43,30.72,23.826,30.23,23.826z"
                                                    fill="#f46b45" />
                                            </g>
                                            <g>
                                                <path class="menubar"
                                                    d="M30.23,31.177H0.946c-0.489,0-0.887-0.396-0.887-0.887c0-0.49,0.398-0.888,0.887-0.888H30.23    c0.49,0,0.888,0.398,0.888,0.888C31.118,30.78,30.72,31.177,30.23,31.177z"
                                                    fill="#f46b45" />
                                            </g>
                                        </g>
                                    </svg>
                                </a>
                                <!-- .cd-dropdown -->
                            </div>
                        </div>
                    </div>
                </div>
                <!-- .cd-dropdown-wrapper -->
            </header>

            <div class="top_header_right_wrapper">
                <div class="header_btn">
                    <ul>
                        <li>
                            <a href="index.php?components=admin&action=logout"> logout </a>
                        </li>
                    </ul>
                </div>
            </div>

            <div class="cp_navigation_wrapper main_top_wrapper">
                <!-- mainmenu start -->
                <div class="mainmenu d-xl-block d-lg-block d-md-none d-sm-none d-none">
                    <ul class="main_nav_ul">
                        <li><a href="index.php?components=admin&action=index" class="gc_main_navigation <?php if($_REQUEST['action'] =='index') echo 'active' ?>">home</a></li>
                        <li class="has-mega gc_main_navigation">
                            <a href="#" class="gc_main_navigation active_class 
                                <?php if($_REQUEST['action'] =='rooms' || $_REQUEST['action'] =='room_add' || $_REQUEST['action'] =='room_edit' || $_REQUEST['action'] == 'room_inside_images' || $_REQUEST['action'] == 'room_inside_image_manage' || $_REQUEST['action'] ==  'room_inside_details' || $_REQUEST['action'] ==  'add_room_detail_category' || $_REQUEST['action'] == 'edit_room_detail_category') echo 'active' ?>"
                            >rooms <i class="fas fa-caret-down"></i>
                            </a>
                            <ul class="navi_2_dropdown">
                                <li class="parent">
                                    <a href="index.php?components=admin&action=rooms" class="<?php if($_REQUEST['action'] == 'rooms' || $_REQUEST['action'] == 'room_edit') echo 'active' ?>"><i class="fas fa-caret-right"></i>rooms</a>
                                </li>
                                <li class="parent">
                                    <a href="index.php?components=admin&action=room_inside_images" class="<?php if($_REQUEST['action'] =='room_inside_images' || $_REQUEST['action'] == 'room_inside_image_manage') echo 'active' ?>"><i class="fas fa-caret-right"></i>room inside images</a>
                                </li>								
                                <li class="parent">
                                    <a href="index.php?components=admin&action=room_inside_details" class="<?php if($_REQUEST['action'] =='room_inside_details' || $_REQUEST['action'] ==  'add_room_detail_category' || $_REQUEST['action'] == 'edit_room_detail_category') echo 'active' ?>"><i class="fas fa-caret-right"></i>room inside details</a>
                                </li>								
                            </ul>
                        </li>
                        <li><a href="index.php?components=admin&action=room_booking_meal_plans" class="gc_main_navigation <?php if($_REQUEST['action'] == 'room_booking_meal_plans' || $_REQUEST['action'] == 'edit_room_booking_meal_plan') echo 'active' ?>"> room booking meal plans </a></li>
                    </ul>
                </div>
                <!-- mainmenu end -->
            </div>
        </div>
    </div>