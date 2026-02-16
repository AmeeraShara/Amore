<?php include_once('templates/header.php'); ?>

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
                        <li><a href="#"><span>1.</span> Choose Room</a></li>
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
                                <p>We have sent you an Email, by including all the details regarding your room booking With <?php echo getCompanyName(); ?></p>
                                <a href="#" class="btn btn-room">GO NEXT STEP</a>
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