<?php
include_once('templates/header.php');
$get_room_id = $full_booked_color = '';
$case = 'Book Now';
if ((isset($_GET['id'])) && ($_GET['id'] != '') && (preg_match('/^\d+$/', $_GET['id']))) {
    $get_room_id = $_GET['id'];
    if ((isset($_GET['case'])) && ($_GET['case'] != '')) {
        if ($_GET['case'] == 'confirm')
            $case = 'Confirm';
    }

    $room_id = $room_name = $description = $header_bg_image = $price = $max_people = '';
    $adults = $children = array();
    $query = "SELECT `id`,`name`,`description`,`header_bg_image`,`price`,`adults`,`children` FROM `rooms` WHERE `id`='$get_room_id' AND `status`='1'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_row($result);
    $room_id = $row[0];
    $room_name = $row[1];
    $description = $row[2];
    if ($row[3] == '') {
        $header_bg_image = 'images/headers/default-room-header.jpg';
    } else {
        '/' . $header_bg_image = $row[3];
    }
    $price = $row[4];
    $adults = $row[5];
    $children = $row[6];
    $max_people = $row[5] + $row[6];
    $adults_capacity = (int) $row[5];
    $children_capacity = (int) $row[6];


    if ($room_id == '') {
        header("Location: 404.php");
        exit();
    }

    $room_images = $image_text = array();
    $query1 = "SELECT `image`,`text` FROM `room_images` WHERE `room_id`='$room_id' AND `status`='1'";
    $result1 = mysqli_query($conn, $query1);
    while ($row = mysqli_fetch_array($result1)) {
        $room_images[] = $row[0];
        $image_text[] = $row[1];
    }

    $recommend_room_id = $recommend_room_name = $recommend_room_max_people = $recommend_room_bed = $recommend_room_view = $recommend_room_image = array();
    $query2 = "SELECT `id`,`name`,`bed`,`view`,`overview_image`,`adults`,`children` FROM `rooms` WHERE `id`!='$room_id' AND `status`='1'";
    $result2 = mysqli_query($conn, $query2);
    while ($row = mysqli_fetch_array($result2)) {
        $recommend_room_id[] = $row[0];
        $recommend_room_name[] = $row[1];
        $recommend_room_bed[] = $row[2];
        $recommend_room_view[] = $row[3];
        $recommend_room_image[] = $row[4];
        $recommend_room_max_people[] = $row[5] + $row[6];
    }

    $room_details_category_id = $room_details_category_name = $room_details_category_text = array();
    $query3 = "SELECT `id`,`name`,`text` FROM `room_detail_categories` WHERE `room_id`='$room_id' AND `status`='1'";
    $result3 = mysqli_query($conn, $query3);
    while ($row = mysqli_fetch_array($result3)) {
        $room_details_category_id[] = $row[0];
        $room_details_category_name[] = $row[1];
        $room_details_category_text[] = $row[2];
    }

    // Calendar
    $booked_dates = array();
    $booked;
    $today = dateNow();
    $to = date("Y-m-d", strtotime("+3 months"));
    $from = $today;
    $datesAr = getBetweenDates($from, $to);
    $full_booked_color = getFullFilledColor();

    for ($i = 0; $i < sizeof($datesAr); $i++) {
        $date = $datesAr[$i];
        $booked = 0;
        $query = "SELECT `id` FROM `room_booked_dates` WHERE `room_id` = '$room_id' AND `date` = '$date'";
        $result = mysqli_query($conn, $query);
        $booked = mysqli_num_rows($result);
        if ($booked > 0) {
            $booked_dates[] = $date;
        }
    }
} else {
    header("Location: 404.php");
    exit();
}

?>
<link rel="stylesheet" href="css/fullcalendar@5.11.3.css">
<link rel="stylesheet" type="text/css" href="css/home/toastr.min.css" />
<style>
    .bg-room {
        background: url('<?php echo $header_bg_image; ?>') no-repeat center center !important;
        background-size: cover !important;
    }

    .error {
        color: red;
        padding: 3px;
    }

    #fullcalendar a {
        color: #0e0e0d !important;
    }

    .fc .fc-daygrid-day-top {
        flex-direction: row;
    }

    .fc-dayGridMonth-button,
    .fc-listMonth-button {
        display: none !important;
    }

    .legend {
        list-style: none;
    }

    .legend li {
        float: left;
    }

    .legend span {
        border: none;
        float: left;
        width: 12px;
        height: 12px;
        margin: 6px;
    }
</style>


<!-- BANNER -->
<section class="banner-tems bg-room text-center">
    <div class="container">
        <div class="banner-content">
            <h2><?php echo ($room_name); ?></h2>
            <p><?php echo ($description); ?></p>
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
            if ((isset($_GET['msg'])) && ($_GET['msg'] != '')) {
                $msg = $_GET['msg'];
                echo '
                        <div class="row text-center">
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                                    <strong>Error: </strong>' . $msg . '
                            </div>
                        </div>';
            }
            ?>
            <div class="row">
                <div class="col-lg-9">
                    <!-- LAGER IMAGE -->
                    <div class="wrapper">
                        <div class="gallery3">
                            <?php
                            if (isset($room_images)) {
                                for ($i = 0; $i < sizeof($room_images); $i++) {
                                    print '
                                            <div class="gallery__img-block">
                                                <span class="">
                                                    ' . $image_text[$i] . '
                                                </span>
                                                <img src="' . ($room_images[$i]) . '" alt="' . ($room_images[$i]) . '" class="">
                                            </div>
                                        ';
                                }
                            }
                            ?>
                            <div class="gallery__controls">
                            </div>
                        </div>
                    </div>
                    <!-- END / LAGER IMAGE -->
                </div>
                <div class="col-lg-3">
                    <!-- FORM BOOK -->
                    <div class="product-detail_book">
                        <div class="product-detail_total">
                            <h6>STARTING ROOM FROM</h6>
                            <p class="price">
                                <span class="amout">$<?php if (isset($price))
                                    echo $price; ?></span> /day
                            </p>
                        </div>
                        <div class="product-detail_form">
                            <div class="sidebar">
                                <!-- WIDGET CHECK AVAILABILITY -->
                                <div class="widget widget_check_availability">
                                    <div class="check_availability">
                                        <div class="check_availability-field">
                                            <label>Arrive</label>
                                            <div class="input-group date" data-date-format="yyyy-mm-dd"
                                                id="datepicker1">
                                                <input class="form-control wrap-box" type="text"
                                                    placeholder="Arrival Date" id="arrival_date" value="<?php if ((isset($_GET['arrival'])) && ($_GET['arrival'] != ''))
                                                        echo $_GET['arrival']; ?>">
                                                <span class="input-group-addon"><i class="fa fa-calendar"
                                                        aria-hidden="true"></i></span>
                                                <p class="error" id="arrival_date_para" style="display:none"></p>
                                            </div>
                                        </div>
                                        <div class="check_availability-field">
                                            <label>Departure</label>
                                            <div id="datepicker2" class="input-group date"
                                                data-date-format="yyyy-mm-dd">
                                                <input class="form-control wrap-box" type="text"
                                                    placeholder="Departure Date" id="departure_date" value="<?php if ((isset($_GET['departure'])) && ($_GET['departure'] != ''))
                                                        echo $_GET['departure']; ?>">
                                                <span class="input-group-addon"><i class="fa fa-calendar"
                                                        aria-hidden="true"></i></span>
                                                <p class="error" id="departure_date_para" style="display:none"></p>
                                            </div>
                                        </div>
                                        <div class="check_availability-field">
                                            <label>Adult (s)</label>
                                            <select class="awe-select" id="adults">
                                                <?php
                                                $count = '';
                                                if ((isset($_GET['adults'])) && ($_GET['adults'] != '')) {
                                                    $count = $_GET['adults'];
                                                }
                                                if (isset($adults_capacity)) {
                                                    for ($i = 0; $i <= $adults_capacity; $i++) {
                                                        if ($i == $count) {
                                                            print '<option selected>' . ($i) . '</option>';
                                                        } else {
                                                            print '<option>' . ($i) . '</option>';
                                                        }
                                                    }
                                                }
                                                ?>
                                            </select>
                                            <p class="error" id="adults_para" style="display:none"></p>
                                        </div>
                                        <?php
                                        if (isset($children_capacity)) {
                                            if ($children_capacity > 0) { ?>
                                                <div class="check_availability-field">
                                                    <label>Children</label>
                                                    <select class="awe-select" id="children">
                                                        <?php
                                                        $count = '';
                                                        if ((isset($_GET['children'])) && ($_GET['children'] != '')) {
                                                            $count = $_GET['children'];
                                                        }
                                                        for ($i = 0; $i <= $children_capacity; $i++) {
                                                            if ($i == $count) {
                                                                print '<option selected>' . ($i) . '</option>';
                                                            } else {
                                                                print '<option>' . ($i) . '</option>';
                                                            }
                                                        }
                                                        ?>
                                                    </select>
                                                    <p class="error" id="children_para" style="display:none"></p>
                                                </div>
                                            <?php }
                                        } ?>
                                    </div>
                                </div>
                                <!-- END / WIDGET CHECK AVAILABILITY -->
                            </div>
                            <button class="btn btn-room btn-product" id="btn_booking" onclick="booking();"><?php if (isset($case))
                                echo $case; ?></button>
                        </div>
                    </div>
                    <!-- END / FORM BOOK -->
                </div>
            </div>
        </div>
        <!-- END / DETAIL -->

        <!-- TAB -->
        <div class="product-detail_tab">
            <div class="row">
                <?php
                if (isset($room_details_category_id)) {
                    if (sizeof($room_details_category_id) != 0) {
                        print '
                            <div class="col-md-3">
                                <ul class="product-detail_tab-header">';
                        for ($i = 0; $i < sizeof($room_details_category_id); $i++) {
                            if ($i == 0)
                                $active = 'active';
                            else
                                $active = '';
                            print '
                                            <li class="' . $active . '">
                                                <a href="#' . ($room_details_category_id[$i]) . '" data-toggle="tab">' . ($room_details_category_name[$i]) . '</a>
                                            </li>';
                            if ((sizeof($room_details_category_id) - 1) == $i) {
                                print '
                                </ul>
                            </div>';
                            }
                            if ((sizeof($room_details_category_id) - 1) == $i) {
                                print '
                                    <div class="col-md-9">
                                        <div class="product-detail_tab-content tab-content">';

                                for ($j = 0; $j < sizeof($room_details_category_id); $j++) {
                                    if ($j == 0)
                                        $active = 'active';
                                    else
                                        $active = '';
                                    $room_details_category_item_id = $room_details_category_item_text = array();

                                    print '
                                            <div class="tab-pane fade ' . $active . ' in" id="' . ($room_details_category_id[$j]) . '">
                                                <div class="product-detail_overview">';
                                    print html_entity_decode(htmlspecialchars_decode($room_details_category_text[$j]));
                                    print '<div class="row">';
                                    $query = "SELECT `id`,`text` FROM `room_detail_category_items` WHERE `room_details_category_id`='$room_details_category_id[$j]' AND `status`='1'";
                                    $result = mysqli_query($conn, $query);
                                    while ($row = mysqli_fetch_array($result)) {
                                        $room_details_category_item_id[] = $row[0];
                                        $room_details_category_item_text[] = $row[1];
                                    }
                                    for ($k = 0; $k < sizeof($room_details_category_item_id); $k++) {
                                        $room_details_category_item_detail_id = $room_details_category_item_detail_text = array();
                                        print '
                                                                <div class="col-xs-6 col-lg-4">
                                                                    <h6>' . ($room_details_category_item_text[$k]) . '</h6>
                                                                    <ul>
                                                                    ';
                                        $query = "SELECT `text` FROM `room_detail_category_item_details` WHERE `room_details_category_item_id`='$room_details_category_item_id[$k]' AND `status`='1'";
                                        $result = mysqli_query($conn, $query);
                                        while ($row = mysqli_fetch_array($result)) {
                                            $room_details_category_item_detail_text[] = $row[0];
                                        }
                                        for ($l = 0; $l < sizeof($room_details_category_item_detail_text); $l++) {
                                            print '
                                                                        <li>' . ($room_details_category_item_detail_text[$l]) . '</li>
                                                                    ';
                                        }
                                        print '
                                                                    </ul>
                                                                </div>';
                                        if ((($k + 1) % 3) == 0) {
                                            print '<div class="row"></div>';
                                        }
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
                    } else {
                        print '<h3 class="text-center">Room details are coming soon.</h3>';
                    }
                }
                ?>
            </div>
        </div>
        <!-- END / TAB -->

        <div class="row" style="margin-top:6rem; margin-bottom:6rem;">
            <div class="row" style="margin-bottom:2rem;">
                <div class="col-12">
                    <h3 style="margin-left:10px;">Room Reservation Calendar</h3>
                </div>
            </div>
            <div class="col-12">
                <div id="fullcalendar" style="width:100%;"></div>
            </div>
            <div class="row">
                <ul class="legend">
                    <li><span style="background-color: <?php if (isset($full_booked_color))
                        echo $full_booked_color; ?>"></span>
                        ROOM BOOKED</li>
                </ul>
            </div>
        </div>

        <!-- ANOTHER ACCOMMODATION -->
        <div class="product-detail">
            <h2 class="product-detail_title">Another accommodations</h2>
            <div class="product-detail_content">
                <div class="row">
                    <?php
                    if (isset($recommend_room_id)) {
                        if (sizeof($recommend_room_id) != 0) {
                            for ($i = 0; $i < sizeof($recommend_room_id); $i++) {
                                $image = '';
                                if ($recommend_room_image[$i] != '')
                                    $image = '<img src="' . ($recommend_room_image[$i]) . '" class="img-responsive" alt="' . ($recommend_room_image[$i]) . '" title="' . ($recommend_room_image[$i]) . '">';
                                else
                                    $image = '<img src="images/rooms/room-overview-default-image.jpg" alt="Default room image" title="Default room image">';
                                print '
                                    <div class="col-sm-6 col-md-3 col-lg-3">
                                        <div class="product-detail_item">
                                            <div class="img">
                                                <a href="room.php?id=' . ($recommend_room_id[$i]) . '">' . $image . '</a>
                                            </div>
                                            <div class="text">
                                                <h2><a href="#">' . ($recommend_room_name[$i]) . '</a></h2>
                                                <ul>
                                                    <li><i class="fa fa-child" aria-hidden="true"></i> Max: ' . ($recommend_room_max_people[$i]) . ' Person(s)</li>
                                                    <li><i class="fa fa-bed" aria-hidden="true"></i> Bed: ' . ($recommend_room_bed[$i]) . '</li>
                                                    <li><i class="fa fa-eye" aria-hidden="true"></i> View: ' . ($recommend_room_view[$i]) . '</li>
                                                </ul>
                                                <a href="room.php?id=' . ($recommend_room_id[$i]) . '" class="btn btn-room">VIEW DETAIL</a>
                                            </div>
                                        </div>
                                    </div>
                                ';
                            }
                        } else {
                            print '<h2 class="text-center mt-4">Other room pages coming soon.</h2>';
                        }
                    }
                    ?>
                </div>

            </div>
        </div>
        <!-- END / ANOTHER ACCOMMODATION -->
    </div>
</section>
<!-- END / SHOP DETAIL -->


<?php
include_once('templates/footer.php');
?>
<script src="js/fullcalendar@5.11.3.js"></script>
<script src="js/home/toastr.min.js"></script>
<script>
    $(document).ready(function () {
        var calendarEl = document.getElementById("fullcalendar");
        var fullFilledColor = '<?php echo $full_booked_color; ?>';
        var calendar = new FullCalendar.Calendar(calendarEl, {
            showNonCurrentDates: false,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,listMonth"
            },
            height: '500px',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            editable: false,
            allDaySlot: false,
            dayMaxEvents: true, // allow "more" link when too many events
            events: [
                <?php for ($i = 0; $i < count($booked_dates); $i++) { ?>
                ,                                                                                    {
                        display: 'background',
                        start: '<?php echo $booked_dates[$i]; ?>',
                        end: '<?php echo $booked_dates[$i]; ?>',
                        color: fullFilledColor,
                    },
                <?php } ?>
            ],
        });

        calendar.render();
    });
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
    function checkAvailabilityBeforeBooking(arrival, departure, room_id) {
        $out = false;
        $.ajax({
            type: "POST",
            async: false,
            url: 'bookingModel.php?action=check_booking_availability',
            data: {
                room_id: room_id,
                arrival: arrival,
                departure: departure
            },
            success: function (response) {
                const obj = JSON.parse(response);
                if (obj.status == 'error') {
                    toastr.error(obj.msg);
                } else if (obj.status = 'success') {
                    $out = true;
                } else {
                    toastr.error("Unknown error!");
                }
            }
        });
        return $out
    }

    function booking() {
        $out = true;
        var btn = document.getElementById('btn_booking');
        var arrival_date = document.getElementById('arrival_date').value;
        var departure_date = document.getElementById('departure_date').value;
        var adults = document.getElementById('adults').value;
        var children = document.getElementById('children').value;
        var room_id = <?php print $_GET['id']; ?>

        const today = new Date();
        const day = `0${today.getDate()}`.slice(-2);
        var date = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + day;

        // arrival_date validation
        if ((arrival_date == '') || (!(arrival_date >= date))) {
            $out = false;
            document.getElementById('arrival_date_para').style.display = 'inline-block';
            document.getElementById('arrival_date_para').innerHTML = 'Please select today or a future day';
        } else {
            document.getElementById('arrival_date_para').innerHTML = '';
            document.getElementById('arrival_date_para').style.display = 'none';
        }
        // departure_date validation
        if ((departure_date == '') || (!(departure_date >= date))) {
            $out = false;
            document.getElementById('departure_date_para').style.display = 'inline-block';
            document.getElementById('departure_date_para').innerHTML = 'Please select today or a future day';
        } else {
            document.getElementById('departure_date_para').innerHTML = '';
            document.getElementById('departure_date_para').style.display = 'none';
        }
        // arrival departure different validation
        if (((arrival_date != '') && (departure_date != '')) && (!(arrival_date <= departure_date))) {
            document.getElementById('departure_date_para').style.display = 'inline-block';
            $out = false;
            document.getElementById('departure_date_para').innerHTML = 'Departure date cannot be before the arrival date';
        }
        // adults validation
        if (($out) && (adults == '') || (adults <= 0)) {
            $out = false;
            document.getElementById('adults_para').style.display = 'inline-block';
            document.getElementById('adults_para').innerHTML = 'Please select the amount of adult guests';
        } else {
            document.getElementById('adults_para').innerHTML = '';
            document.getElementById('adults_para').style.display = 'none';
        }

        if ($out) {
            btn.style.display = 'none';
            if (checkAvailabilityBeforeBooking(arrival_date, departure_date, room_id)) {
                window.location.href = "booking.php?room_id=" + room_id + "&arrival=" + arrival_date + "&departure=" + departure_date + "&adults=" + adults + "&children=" + children;
            } else {
                btn.style.display = 'inline-block';
            }
        }
    }
</script>