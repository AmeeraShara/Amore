<?php 
    include_once('templates/header.php'); 

    function validateDate($date){ 
        // date must be in yyyy-dd-mm format
        $date = explode('-', $date);
        $year  = $date[0];
        $month = $date[1];
        $day   = $date[2];
        return checkdate($month, $day, $year);
    }

    $out = true;
    $implode_ids = '';
    $room_id = $room_name = $description =  $header_bg_image = $price = $bed = 
    $adults_db = $children_db = $view = $size = $booked_room_ids = array();
    $today = date("Y-m-d");

    // arrival date validation
    if($out){
        if((isset($_GET['arrival'])) && ($_GET['arrival'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['arrival'])) && (validateDate($_GET['arrival']))){
            $arrival = $_GET['arrival'];
        }else{
            $msg = 'Arrival date is required and need to be in yyyy-mm-dd date format';
            $out = false;
        }
    }

    // departure date validation
    if($out){
        if((isset($_GET['departure'])) && ($_GET['departure'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['departure'])) && (validateDate($_GET['departure']))){
            $departure = $_GET['departure'];
        }else{
            $msg = 'Departure date is required and need to be in yyyy-mm-dd date format';
            $out = false;
        }
    }

    // arrival date validation (date must need to be today or future day)
    if($out){
        if(!($arrival >= $today)){
            $out = false;
            $msg = 'Please select today or a future day as the arrival date';
        } 
    }

    // departure date validation (date must need to be a future day)
    if($out){
        if(!($departure > $arrival)){
            $out = false;
            $msg = 'Please select future day as the departure date';
        } 
    }

    // adults validation
    if($out){
        if((isset($_GET['adults'])) && ($_GET['adults'] != '') && (preg_match('/^\d+$/',$_GET['adults']))){
            $adults = $_GET['adults'];
        }else{
            $msg = 'Adult guest(s) count is required';
            $out = false;
        }
    }

    // children validation
    if($out){
        if((isset($_GET['children'])) && (preg_match('/^\d+$/',$_GET['children']))){
            $children = $_GET['children'];
        }else{
            $children = '';
        }
    }

    if($out){
        $query = "SELECT DISTINCT `room_id` FROM `room_booked_dates` WHERE  DATE(`date`) BETWEEN DATE('$arrival') AND DATE('$departure')";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $booked_room_ids[] = $row[0];
        }

        if(sizeof($booked_room_ids) > 0){
            $implode_ids = implode($booked_room_ids,",");
            $query1 = "SELECT  `id`,`name`,`description`,`header_bg_image`,`price`,`adults`,`children`,`bed`,`view`,`size` FROM `rooms` WHERE `id` NOT IN($implode_ids) AND `adults` >= '$adults' AND `children` >= '$children'";
        }else{
            $query1 = "SELECT  `id`,`name`,`description`,`header_bg_image`,`price`,`adults`,`children`,`bed`,`view`,`size` FROM `rooms` WHERE `adults` >= '$adults' AND `children` >= '$children'";
        }
        $result1 = mysqli_query($conn,$query1);
        while($row=mysqli_fetch_array($result1)){
            $room_id[] = $row[0];
            $room_name[] = $row[1];
            $description[] = $row[2];
            $header_bg_image[] = $row[3];
            $price[] = $row[4];
            $adults_db[] = $row[5];
            $children_db[] = $row[6];
            $bed[] = $row[7];
            $view[] = $row[8];
            $size[] = $row[9];
        }
    }
    // var_dump($room_name);
    // exit();
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
        #book{
            position: absolute;
            right: 0;
            margin-right: 15px;
        }
        .btn-room {
            line-height: 25px;
            font-size: 12px;
        }
        #room_image{
            width:50%;
            margin-bottom: 10px;
        }
    </style>
    <!-- BANNER -->
    <section class="banner-tems bg-room text-center">
        <div class="container">
            <div class="banner-content">
                <h2>Room Availibility</h2>
                <p>Please select the room you would like to reserve.</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <?php 
        if((isset($_GET['msg'])) && ($_GET['msg'] != '')){
            $msg = $_GET['msg'];
            echo '
            <section class="section-product-detail" style="'.$style.'">
                    <div class="container">
                        <div class="product-detail margin">
                            <div class="row text-center">
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                        <strong>Error: </strong>'.$msg.'
                                </div>
                            </div>
                        </div>
                    </div>
            </section>';
        }
    ?>

    <!-- ROOM DETAIL -->
    <?php if(sizeof($room_id) != 0){
            for($x=0; $x<sizeof($room_id); $x++){ 
                $max_people = 0;
                $max_people = $adults_db[$x] + $children_db[$x];
                if(sizeof($room_id) == $x+1) $style="padding-bottom:100px;"; else $style="padding-bottom: 15px;";
                print '
                <section class="section-product-detail" style="'.$style.'">
                    <div class="container">
                        <div class="product-detail margin">
                            <div class="row">
                                <div class="col-lg-12" style="overflow:hidden">
                                    <div id="book"><a href="room.php?id='.($room_id[$x]).'&adults='.$adults.'&children='.$children.'=&arrival='.$arrival.'&departure='.$departure.'&case=confirm" class="btn btn-room">BOOK NOW</a></div>
                                    <div class="product-detail_book">
                                        <div class="product-detail_total">
                                            <p class="price">
                                                <a href=""><span class="amout">'.$room_name[$x].'</span></a>
                                            </p>
                                            <p><span class="night">'.$price[$x].'$ Per night</span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <div class="row">
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">MAX PEOPLE : '.$max_people.'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">ADULTS : '.$adults_db[$x].'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">CHILDREN : '.$children_db[$x].'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">BED : '.$bed[$x].'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">VIEW : '.$view[$x].'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-4 col-xs-6 col-sm-4">
                                    <div class="room-main-info">
                                        <div class="product-detail_total">
                                            <p>
                                                <span class="room-main-info-text">SIZE : '.$size[$x].'</span>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>';

                        $room_details_category_id = $room_details_category_name = $room_details_category_text = array();
                        $query3 = "SELECT `id`,`name`,`room_avilability_text` FROM `room_detail_categories` WHERE `room_id`='$room_id[$x]' AND `status`='1'";
                        $result3 = mysqli_query($conn,$query3);
                        while($row=mysqli_fetch_array($result3)){
                            $room_details_category_id[] = $row[0];
                            $room_details_category_name[] = $row[1];
                            $room_details_category_text[] = $row[2];
                        }
                        print '
                        <div class="product-detail_tab" style="margin-top: 8px;">
                            <div class="row">'; 
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
                                    print '<h4 class="text-center">Room details are coming soon.</h4>';
                                }
                                print '
                            </div>
                        </div>
                    </div>
                </section>';
            }
        }
    ?>

<?php include_once('templates/footer.php'); ?>