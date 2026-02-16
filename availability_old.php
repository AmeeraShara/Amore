<?php 

    include_once('templates/header.php'); 
    if((isset($_GET['id'])) && ($_GET['id'] != '') && (preg_match('/^\d+$/',$_GET['id']))){
        $get_room_id = $_GET['id'];

        $room_id = $room_name = $description =  $header_bg_image = $price = $bed = $max_people = $view = $size = '';
        $adults = $children = array();
        $query = "SELECT `id`,`name`,`description`,`header_bg_image`,`price`,`max_people`,`adults`,`children`,`bed`,`view`,`size` FROM `rooms` WHERE `id`='$get_room_id' AND `status`='1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_row($result)){
            $room_id = $row[0];
            $room_name = $row[1];
            $description = $row[2];
            $header_bg_image = $row[3];
            $price = $row[4];
            $max_people = $row[5];
            $adults = $row[6];
            $children = $row[7];
            $bed = $row[8];
            $view = $row[9];
            $size = $row[10];
        }

        if($room_id == '') {
            header("Location: 404.php");
            exit();
        }

        $room_details_category_id = $room_details_category_name = $room_details_category_text = array();
        $query3 = "SELECT `id`,`name`,`text` FROM `room_detail_categories` WHERE `room_id`='$room_id' AND `status`='1'";
        $result3 = mysqli_query($conn,$query3);
        while($row=mysqli_fetch_array($result3)){
            $room_details_category_id[] = $row[0];
            $room_details_category_name[] = $row[1];
            $room_details_category_text[] = $row[2];
        }
    }else{
        header("Location: 404.php");
        exit();
    }
?>
    <style>
        .items-para{
            margin-left: 15px;
            margin-top: 5px;
        }
        .item-span{
            padding-right: 5px;
        }
        .room-main-info{
            margin-top: 15px;
            text-align:center;
        }
        .room-main-info-text{
            font-weight: 500;
        }
        .night{
            font-size:18px;
            font-weight:400;
        }
    </style>
    <!-- BANNER -->
    <section class="banner-tems bg-room text-center">
        <div class="container">
            <div class="banner-content">
                <h2>Room Availibility</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Optio voluptates amet ut.</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <!-- ROOM DETAIL -->
    <section class="section-product-detail">
        <div class="container">
            <!-- DETAIL -->
            <div class="product-detail margin">
                <?php 
                    if((isset($_GET['msg'])) && ($_GET['msg'] != '')){
                        $msg = $_GET['msg'];
                        echo '
                        <div class="row text-center">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Error: </strong>'.$msg.'
                            </div>
                        </div>';
                    }
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="product-detail_book">
                            <div class="product-detail_total">
                                <p class="price">
                                    <span class="amout"><?php echo $room_name; ?> <span class="night">  - <?php echo $price; ?>$ Per night</span></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END / DETAIL -->
            
            <div class="">
                <div class="row">
                    <!-- MAX -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">MAX PEOPLE : <?php echo $max_people; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- ADULTS -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">ADULTS : <?php echo $adults; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- CHILDREN -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">CHILDREN : <?php echo $children; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- BED -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">BED : <?php echo $bed; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- VIEW -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">VIEW : <?php echo $view; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <!-- SIZE -->
                    <div class="col-lg-4 col-xs-6 col-sm-4">
                        <div class="room-main-info">
                            <div class="product-detail_total">
                                <p>
                                    <span class="room-main-info-text">SIZE : <?php echo $size; ?></span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- TAB -->
            <div class="product-detail_tab" style="margin-top: 8px;">
                <div class="row">
                <?php 
                    if(sizeof($room_details_category_id) != 0){
                        print '
                            <div class="col-md-3">
                                <ul class="product-detail_tab-header">';
                                    for($i=0; $i<sizeof($room_details_category_id); $i++){
                                        if($i == 0) $active='active'; else $active ='';
                                        print '
                                            <li class="'.$active.'">
                                                <a href="#'.($room_details_category_id[$i]).'" data-toggle="tab">'.($room_details_category_name[$i]).'</a>
                                            </li>';
                                            if((sizeof($room_details_category_id)-1) == $i){
                                        print ' 
                                </ul>
                            </div>';}
                                if((sizeof($room_details_category_id)-1) == $i){
                                    print '
                                    <div class="col-md-9">
                                        <div class="product-detail_tab-content tab-content">';
                                        for($j=0; $j<sizeof($room_details_category_id); $j++){
                                            if($j == 0) $active='active'; else $active ='';
                                            $room_details_category_item_id = $room_details_category_item_text = array();
                                            print '
                                            <div class="tab-pane fade '.$active.' in" id="'.($room_details_category_id[$j]).'">
                                                <div class="product-detail_overview">';
                                                    print html_entity_decode(htmlspecialchars_decode($room_details_category_text[$j]));
                                                    print '<div class="row">';
                                                        $query = "SELECT `id` FROM `room_detail_category_items` WHERE `room_details_category_id`='$room_details_category_id[$j]' AND `status`='1'";
                                                        $result = mysqli_query($conn,$query);
                                                        while($row=mysqli_fetch_array($result)){
                                                            $room_details_category_item_id[] = $row[0];
                                                        }
                                                        for($k=0; $k<sizeof($room_details_category_item_id); $k++){
                                                            $room_details_category_item_detail_id = $room_details_category_item_detail_text = array();
                                                            $query = "SELECT `text` FROM `room_detail_category_item_details` WHERE `room_details_category_item_id`='$room_details_category_item_id[$k]' AND `status`='1'";
                                                            $result = mysqli_query($conn,$query);
                                                            while($row=mysqli_fetch_array($result)){
                                                                $room_details_category_item_detail_text[] = $row[0];
                                                            }
                                                            print '<p class="items-para">';
                                                            for($l=0; $l<sizeof($room_details_category_item_detail_text); $l++){
                                                                print '<i class="fa fa-check" aria-hidden="true" style="padding-right: 5px;"></i><span class="item-span">'.($room_details_category_item_detail_text[$l]).', </span>';
                                                            }
                                                            print '</p>';
                                                        }
                                                        print '
                                                    </div>
                                                </div>
                                            </div>';
                                        }
                                            print   
                                        '</div>
                                    </div>';
                                }
                            }
                    }else{
                        print '<h3 class="text-center">Room details are coming soon.</h3>';
                    }
                ?>
                </div>
            </div>
            <!-- END / TAB -->
        </div>
    </section>
    <!-- END / SHOP DETAIL -->

<?php include_once('templates/footer.php'); ?>