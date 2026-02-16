<?php 
    include_once('templates/header.php'); 
    $out = true;
    $db_booking_id = '';

    // validation
    if((isset($_POST['booking_id'])) && ($_POST['booking_id'] != '')) $out = true; else $out = false;
    if($out){
        $booking_id = $_POST['booking_id'];
        $query = "SELECT `booking_code` FROM `rooms_booking` WHERE `booking_code`='$booking_id' AND `status`='1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_row($result)){
            $db_booking_id = $row[0];
        }
        if($db_booking_id == ''){
            header("Location: 404.php");
            exit();
        }
    }else{
        header("Location: 404.php");
        exit();
    }
?>

    <section class="banner-tems text-center">
        <div class="container">
            <div class="banner-content">
                <h2>RESERVATION</h2>
                <p>RESERVATION COMPLETED</p>
            </div>
        </div>
    </section>

    <!-- RESERVATION -->
    <section class="section-reservation-page">
        <div class="container">
            <div class="reservation-page">
                <!-- STEP -->
                <div class="reservation_step">
                    <ul>
                        <li><a href="rooms.php"><span>1.</span> Choose Room</a></li>
                        <li><a href="#"><span>2.</span> Make a Reservation</a></li>
                        <li class="active"><a href="#"><span>3.</span> Confirmation</a></li>
                    </ul>
                </div>
                <!-- END / STEP -->

                <div class="row">
                    <!-- CONTENT -->
                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="reservation_content">
                            <!-- RESERVATION ROOM -->
                            <div class="reservation-chosen-message bg-gray text-center">
                                <h4>Your booking is Completed</h4>
                                <h5 style="color:#3c763d; font-weight:600;">Booking ID : #<?php echo $db_booking_id; ?></h5> 
                                <p class="booking-confrimation-para">We have received your booking and would like to thank you for your trust in us. If your inquiry is urgent, please use the telephone number below to speak to one of our staff. Otherwise, we will contact you within 24 hours and confirm.</p>
                                <p class="booking-confrimation-para">with warm greetings <a href="home.php" title="<?php echo getCompanyName(); ?><"><?php echo getCompanyName(); ?></a></p>
                                <a href="home.php" class="btn btn-room">BACK TO HOME</a>
                            </div>
                        </div>
                        <!-- END / RESERVATION ROOM -->
                    </div>
                    <!-- END / CONTENT -->
                </div>
            </div>
        </div>
    </section>
    <!-- END / RESERVATION -->

<?php include_once('templates/footer.php'); ?>