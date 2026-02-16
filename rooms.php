<?php 
    include_once('templates/header.php'); 

    $room_id = $room_name = $room_overview_subtitle = $room_overview_decription = $room_overview_image = array();
    $query = "SELECT `id`,`name`,`overview_subtitle`,`overview_decription`,`overview_image` FROM `rooms` WHERE `status`='1'";
    $result = mysqli_query($conn,$query);
    while($row=mysqli_fetch_array($result)){
        $room_id[] = $row[0];
        $room_name[] = $row[1];
        $room_overview_subtitle[] = $row[2];
        $room_overview_decription[] = $row[3];
        $room_overview_image[] = $row[4];
    }
?>
    <!-- BANNER -->
    <section class="banner-tems text-center bg-rooms">
        <div class="container">
            <div class="banner-content">
                <h2>ROOMS & RATES</h2>
                <p>Our living spaces are about more than just air conditioning, gorgeous furnishings, and modern conveniences.</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <!-- ROOMS -->
    <section class="body-room-2">
        <div class="container">
            <?php 
                if(sizeof($room_id) != 0){
                    for($i=0; $i<sizeof($room_id); $i++){
                        $classes_01 = $classes_02 = ''; 
                        $image_class = 'img';
                        if($i % 2 != 0){
                            $classes_01 = 'col-lg-push-4 col-md-push-4';
                            $classes_02 = 'col-lg-pull-8 col-md-pull-8';
                            $image_class = 'img1';
                        }
                        $image = '';
                        if($room_overview_image[$i] != '')
                            $image = '<img src="'.($room_overview_image[$i]).'"  alt="'.($room_name[$i]).'" title="'.($room_name[$i]).'">';
                        else 
                            $image = '<img src="images/rooms/room-overview-default-image.jpg" alt="Default room image" title="Default room image">';
                        print '
                        <div class="wrap-room2">
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 '.($classes_01).'">
                                    <div class="'.($image_class).'">
                                        <a href="room.php?id='.($room_id[$i]).'">'.$image.'</a>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 '.($classes_02).'">
                                    <div class="text">
                                        <h2 class="h2-rooms">'.($room_name[$i]).'</h2>
                                        <h5 class="h5-room">'.($room_overview_subtitle[$i]).'</h5>
                                        <p>'.($room_overview_decription[$i]).'</p>
                                        <a href="room.php?id='.($room_id[$i]).'&case=book_now" class="view-dateails btn btn-room">VIEW DETAILS</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        ';
                    }
                }else{
                    print '<h3 class="text-center">Rooms details are coming soon.</h3>';
                }
            ?>
        </div>
    </section>
    <!-- END / ROOMS -->

<?php include_once('templates/footer.php'); ?>