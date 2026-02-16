<?php
include_once('templates/header.php');
$room_id = $room_name = $room_home_description = $room_home_image = $room_max_peope = $room_view =
    $room_size = $room_bed = $room_price = array();
$query = "SELECT `id`,`name`,`home_description`,`home_image`,`bed`,`size`,`view`,`price`,`adults`,`children` FROM `rooms` WHERE `status`='1'";
$result = mysqli_query($conn, $query);
while ($row = mysqli_fetch_array($result)) {
    $room_id[] = $row[0];
    $room_name[] = $row[1];
    $room_home_description[] = $row[2];
    $room_home_image[] = $row[3];
    $room_max_peope[] = $row[8] + $row[9];
    $room_bed[] = $row[4];
    $room_size[] = $row[5];
    $room_view[] = $row[6];
    $room_price[] = $row[7];
}
?>
<link rel="stylesheet" type="text/css" href="css/home/toastr.min.css" />

<?php include_once('templates/slider.php'); ?>

<!-- OUR-ROOMS -->
<section class="rooms rooms-v2 rooms-v4">
    <div class="container">
        <h2 class="title-room text-shadow-3x">Our Rooms</h2>
        <div class="outline"></div>
        <p class="rooms-p">Our Beautiful Bedrooms are more than just a place to lay your head down. They are also meant
            to serve as your home away from home. View our cozy accommodations and roomy suites.</p>
        <div class="wrap-rooms">
            <div class="row">
                <div id="rooms" class="owl-carousel owl-theme">
                    <div class="item">
                        <?php
                        if (sizeof($room_id) != 0) {
                            for ($i = 0; $i < sizeof($room_id); $i++) {
                                $image = '';
                                if ($room_home_image[$i] != '')
                                    $image = '<img src="' . ($room_home_image[$i]) . '" class="img-responsive" alt="' . ($room_name[$i]) . '" title="' . ($room_name[$i]) . '">';
                                else
                                    $image = '<img src="images/rooms/room.jpg" class="img-responsive" alt="Default room image" title="Default room image">';
                                print '
                                    <div class="col-lg-4 col-md-4 col-sm-6 col-xs-6 ">
                                        <div class="wrap-box wrap-box-v4">
                                            <div class="box-img">' . $image . '</div>
                                            <div class="rooms-content">
                                                <h4 class="sky-h4">' . ($room_name[$i]) . '</h4>
                                                <p class="price">$' . ($room_price[$i]) . ' / Per Night</p>
                                            </div>
                                            <div class="content">
                                                <div class="wrap-content">
                                                    <div class="rooms-content1">
                                                        <h4 class="sky-h4">' . ($room_name[$i]) . '</h4>
                                                        <p class="price">$' . ($room_price[$i]) . ' / Per Night</p>
                                                    </div>
                                                    <p>' . ($room_home_description[$i]) . '</p>
                                                    <div class="bottom-room">
                                                        <ul>
                                                            <li><img src="images/home/v2-icon.png" class="img-responsive" alt="Image">' . ($room_max_peope[$i]) . ' Person(s)</li>
                                                            <li><img src="images/home/v2-icon-1.png" class="img-responsive" alt="Image">' . ($room_size[$i]) . '</li>
                                                            <li><img src="images/home/v2-icon-2.png" class="img-responsive" alt="Image">' . ($room_view[$i]) . '</li>
                                                            <li><img src="images/home/v2-icon-3.png" class="img-responsive" alt="Image">' . ($room_bed[$i]) . '</li>
                                                        </ul>
                                                    </div>
                                                    <a href="room.php?id=' . ($room_id[$i]) . '&case=book_now" class="btn btn-room">VIEW DETAIL</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    ';
                            }
                        } else {
                            print '<h3 class="text-center">Rooms details are coming soon.</h3>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- /container -->
</section>
<!-- END / ROOMS -->

<!-- ABOUT-US -->
<section class="about about-v2 about-v4">
    <div class="container">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-10 col-md-offset-1 col-lg-10 col-lg-offset-1">
                <div class="about-centent text-center">
                    <h2 class="about-title text-center">About Us</h2>
                    <div class="line-v2"></div>
                    <p class="about-p" style="text-align: justify;">Hotel Amore is Located at Balapitiya, a beautiful
                        city down south Sri Lanka and a mere 3-hour drive from Colombo.
                        Hotel Amore is a prime spot for creating unforgettable experiences.
                    </p>
                    <p class="about-p1" style="text-align: justify;">Inside, our Hotel provides you with exquisite and
                        equally comfortable room choices that promise to make you feel at home. Outside, the Balapitiya
                        beach is within walking distance, and the anticipation of boat rides in the heart of the
                        wetlands of Madu River will give you the time of your life.
                        To satiate your appetite after all the sightseeing, Hotel Amore invites you to our exotic
                        restaurant with a menu so tantalizing and varied it is bound to suit every taste bud of yours.
                    </p>
                    <p class="about-p1" style="text-align: justify;"></p>
                </div>
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <img src="images/about-us/about.jpg" class="img-responsive img-v4" alt="Image">
            </div>
            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                <img src="images/about-us/about-1.jpg" class="img-responsive " alt="Image">
            </div>
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <img src="images/about-us/about-2.jpg" class="img-responsive img-v4" alt="Image">
            </div>
        </div>
    </div>
</section>
<!-- END / ABOUT-US -->

<!-- SLIDER -->
<section class="section-slider text-center section-slider-v3">
    <div class="container">
        <div id="index122" class="owl-carousel  owl-theme">
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/double-bed.png" class="img-responsive" alt="Double Bed Room"
                            style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Master Bedrooms</h6>
                </div>
            </div>
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/disco-ball.png" class="img-responsive" alt="Disco Ball"
                            style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Party Room</h6>
                </div>
            </div>
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/buffet-breakfast.png" class="img-responsive" alt="Buffet Breakfast"
                            style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Restaurent</h6>
                </div>
            </div>
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/taxi.png" class="img-responsive" alt="Taxi" style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Transports</h6>
                </div>
            </div>
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/snorkel.png" class="img-responsive" alt="Snorkel" style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Beach Sports</h6>
                </div>
            </div>
            <div class="item">
                <div class="wrap-best wrap-best-v3 text-uppercase">
                    <div class="icon-best">
                        <img src="images/home/holiday.png" class="img-responsive" alt="Beach Relaxing"
                            style="width: 50px;">
                    </div>
                    <h6 class="sky-h6">Near by Beach</h6>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END / SLIDER -->

<!--OUR-EVENTS-->
<section class="events" style="margin-bottom:85px;">
    <div class="container">
        <h2 class="events-title text-shadow-3x">Our Packages</h2>
        <div class="line"></div>
        <div id="events-v2" class="owl-carousel owl-theme">
            <div class="item ">
                <div class="events-item">
                    <div class="events-img"><img src="images/packages/package.jpg" class="img-responsive" alt="Image">
                    </div>
                    <div class="events-content">
                        <a href="#" title="">
                            <p class="sky-p">WEDDING PACKAGES</p>
                            <h3 class="sky-h3">Wedding Day</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="events-item">
                    <div class="events-img"><img src="images/packages/package.jpg" class="img-responsive" alt="Image">
                    </div>
                    <div class="events-content">
                        <a href="#" title="">
                            <p class="sky-p">TOUR PACKAGES</p>
                            <h3 class="sky-h3"> Tour | Sightseeing</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="events-item">
                    <div class="events-img"><img src="images/packages/package.jpg" class="img-responsive" alt="Image">
                    </div>
                    <div class="events-content">
                        <a href="#" title="">
                            <p class="sky-p">BEACH SPORT PACKAGES</p>
                            <h3 class="sky-h3"> Surfing | Diving</h3>
                        </a>
                    </div>
                </div>
            </div>
            <div class="item">
                <div class="events-item">
                    <div class="events-img"><img src="images/packages/package.jpg" class="img-responsive" alt="Image">
                    </div>
                    <div class="events-content">
                        <a href="#" title="">
                            <p class="sky-p">KIDS ACTIVITY PACKAGES</p>
                            <h3 class="sky-h3"> Surfing | Diving</h3>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- END / OUR EVENTS -->

<!-- MAP -->
<section class="section-map">
    <iframe id="map"
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7826495338822!2d80.03852911506368!3d6.292271595445915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae181cebc603721%3A0xfb00e78076c39c45!2sAmore!5e0!3m2!1sen!2slk!4v1666582653866!5m2!1sen!2slk"
        allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</section>
<!-- END / MAP -->

<?php include_once('templates/footer.php'); ?>
<script src="js/home/toastr.min.js"></script>

<script>
    toastr.options = {
        "closeButton": false,
        "debug": false,
        "newestOnTop": false,
        "progressBar": false,
        "positionClass": "toast-bottom-right",
        "preventDuplicates": false,
        "onclick": null,
        "showDuration": "1000",
        "hideDuration": "1000",
        "timeOut": "10000",
        "extendedTimeOut": "1000",
        "showEasing": "swing",
        "hideEasing": "linear",
        "showMethod": "fadeIn",
        "hideMethod": "fadeOut"
    }
    var adults = '';
    var children = '';
    $('#adults').on('click', 'li', function () {
        adults = $(this).text();
    });
    $('#children').on('click', 'li', function () {
        children = $(this).text();
    });
    function checkAvailability() {
        var arrival = document.getElementById('arrival').value;
        var departure = document.getElementById('departure').value;
        $.ajax({
            type: "POST",
            url: 'bookingModel.php?action=home_page_room_availability',
            data: {
                arrival: arrival,
                departure: departure,
                adults: adults,
                children: children
            },
            success: function (response) {
                const obj = JSON.parse(response);
                console.log(obj);
                if (obj.status == 'error') {
                    toastr.error(obj.msg);
                } else if (obj.status == 'success') {
                    window.location.href = "availability.php?arrival=" + arrival + "&departure=" + departure + "&adults=" + adults + "&children=" + children + "&id=1";
                } else if (obj.status == 'info') {
                    toastr.info(obj.msg);
                } else {
                    toastr.info("Unknown Error! Try again");
                }
            }
        });
    }
</script>