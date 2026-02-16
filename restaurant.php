<?php 
    include_once('templates/header.php');

    $category_id = $category_name = $category_time = array();
    $query = "SELECT * FROM `restaurant_categories` WHERE `status`='1'";
    $result = mysqli_query($conn,$query);
    while($row=mysqli_fetch_array($result)){
        $category_id[] = $row[0];
        $category_name[] = $row[1];
        $category_time[] = $row[2];
    }

    $item_id = $item_name = $item_category_id = $item_description = $item_price = $item_discount = $item_image = array();
    $query1 = "SELECT * FROM `restaurant_menu_items` WHERE `status`='1'";
    $result1 = mysqli_query($conn,$query1);
    while($row=mysqli_fetch_array($result1)){
        $item_id[] = $row[0];
        $item_name[] = $row[1];
        $item_category_id[] = $row[2];
        $item_description[] = $row[3];
        $item_price[] = $row[4];
        $item_discount[] = $row[5];
        $item_image[] = $row[6];
    }
?>
    <!-- BANNER -->
    <section class="banner-tems text-center bg-restaurants">
        <div class="container">
            <div class="banner-content">
                <h2>Our Restaurant</h2>
                <p>Hotel Amore has an exotic restaurant. Our exotic restaurant offers a mixed breakfast menu where you can choose between Sri Lankan or English breakfast.</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <!-- MENUS -->
    <section class="body-restaurant-2">
        <div class="container">
            <div class="shape"><img src="images/resource/Shape-11.png" alt="#"></div>
            <ul class="nav nav-tabs text-uppercase">
                <?php 
                    if(sizeof($category_id) != 0){
                        for($i=0; $i<sizeof($category_id); $i++){
                            if($i == 0) $active='active'; else $active='';
                            print '<li class="'.$active.'">
                                <a data-toggle="tab" href=#'.($category_id[$i]).'>
                                    '.($category_name[$i]).'<span class="time">'.($category_time[$i]).'</span>
                                </a>
                            </li>';
                        }
                    }else{
                        print '<h1 class="center">Menu Categories are coming soon.</h1>';
                    }
                ?>
            </ul>
            <br/>
            <div class="tab-content">
                <?php
                    if((sizeof($item_id) != 0) && (sizeof($category_id) !=0)){
                        for($i=0; $i<sizeof($category_id); $i++){
                            if($i == 0) $active='active'; else $active='';
                            print '
                            <div id="'.($category_id[$i]).'" class="tab-pane fade in '.$active.'">
                                <div class="product">
                                    <div class="row">
                                        <div class=" col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                            <div class="restaurant_item">';
                                                for($j=0; $j<sizeof($item_id); $j++){
                                                    if(($category_id[$i]) == ($item_category_id[$j])){
                                                        if($item_discount[$j] > 0) $discount = $item_discount[$j]; else $discount = 0;
                                                        print '
                                                        <div class="wrap_item" style="padding-bottom:40px;">
                                                            <div class="img">
                                                                <a href="#"><img src="'.($item_image[$j]).'" alt="#"></a>';
                                                                if($discount > 0){
                                                                    print '<div class="sales">
                                                                        '.($discount).'%
                                                                    </div>';
                                                                }
                                                            print '</div>
                                                            <div class="text">
                                                                <h2><a href="#">'.($item_name[$j]).'</a></h2>
                                                                <p class="desc">'.($item_description[$j]).'</p>
                                                                <p class="price">
                                                                    <span class="amout">$'.($item_price[$j] - ($item_price[$j] * $discount) / 100).'</span>';
                                                                    if($discount > 0){
                                                                        print '<span class="del">$'.($item_price[$j]).'</span>';
                                                                    }
                                                                print '</p>
                                                            </div>
                                                        </div>';
                                                    }
                                                }
                                    print '</div>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                        }
                    }else{
                        print '<h3 class="center">Menu items are coming soon.</h3>';
                    }
                ?>
            </div>
            <!-- end-tab-content -->
        </div>
        <!-- /container -->
    </section>
    <!-- END / MENUS -->

    <!-- RESTAURANT-GALLERY-->
    <section class="gallery-our wrap-gallery-restaurant">
        <div class="container">
            <div class="gallery gallery-restaurant">
                <h2 class="h2-rooms">GALLERY Restaurant</h2>
                <ul class="nav nav-tabs text-uppercase">
                    <li class="active"><a data-toggle="tab" href="#all">ALL</a></li>
                    <li><a data-toggle="tab" href="#dinner">DINNER</a></li>
                    <li><a data-toggle="tab" href="#lunch">LUNCH</a></li>
                    <li><a data-toggle="tab" href="#diner">DINER</a></li>
                    <li><a data-toggle="tab" href="#drink">DRINK</a></li>
                </ul>
                <br/>
                <div class="tab-content">
                    <div id="all" class="tab-pane fade in active">
                        <div class="product ">
                            <div class="row">
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main ">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="dinner" class="tab-pane fade">
                        <div class="product ">
                            <div class="row">
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main " title>
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2.png" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="lunch" class="tab-pane fade">
                        <div class="product ">
                            <div class="row">
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main " title>
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="diner" class="tab-pane fade">
                        <div class="product ">
                            <div class="row">
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main " title>
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div id="drink" class="tab-pane fade">
                        <div class="product ">
                            <div class="row">
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main " title>
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox" href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-48.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="gallery_product col-lg-3 col-md-4 col-sm-6 col-xs-6 ">
                                    <div class="wrap-box">
                                        <div class="box-img">
                                            <img src="images/restaurant/Restaurants-49.jpg" class="img-responsive" alt="Product" title="images products">
                                        </div>
                                        <div class="gallery-box-main">
                                            <div class="gallery-icon">
                                                <a class="lightbox " href="images/restaurant/gallery-2-2.jpg" data-littlelightbox-group="gallery" title="Flying is life"><i class="ion-ios-plus-empty" aria-hidden="true" ></i> </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- end-tab-content -->
            </div>
            <!-- /gallery -->
        </div>
        <!-- /container -->
    </section>
    <!-- END / RESTAURANT GALLERY -->

<?php include_once('templates/footer.php'); ?>