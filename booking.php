<?php
    include_once('templates/header.php');
    $out = false;
    $room_id = '';
    $msg = '';
    $image = 'images/headers/default-room-header.jpg';

    function validateDate($date){
        // date must be in yyyy-dd-mm format
        $date = explode('-', $date);
        $year  = $date[0];
        $month = $date[1];
        $day   = $date[2];
        return checkdate($month, $day, $year);
    }
    // validation
    if((isset($_GET['room_id'])) && ($_GET['room_id'] != '') && (preg_match('/^\d+$/',$_GET['room_id']))) $out = true;
    if($out){
        if((isset($_GET['arrival'])) && ($_GET['arrival'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['arrival'])) && (validateDate($_GET['arrival']))) $out=true; else $out=false;
    }
    if($out){
        if((isset($_GET['departure'])) && ($_GET['departure'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_GET['departure'])) && (validateDate($_GET['departure']))) $out=true; else $out=false;
    }
    if($out){
        if((isset($_GET['adults'])) && ($_GET['adults'] != '') && (preg_match('/^\d+$/',$_GET['adults']))) $out=true; else $out=false;
    }
    if($out){
        if(isset($_GET['children'])){
            if(($_GET['children'] != '') && (preg_match('/^\d+$/',$_GET['children']))) $out=true; else $out=false;
        }
    }
    if($out){
        $room_id = $_GET['room_id'];
        $arrival_date = $_GET['arrival'];
        $departure_date = $_GET['departure'];
        $adults = $_GET['adults'];
        $children = '';
        if((isset($_GET['children'])) && ($_GET['children'] != '')) $children = $_GET['children'];

        $today = date("Y-m-d");

        $id = $room_name = $description =  $header_bg_image = $price = $max_people = $adults_db = $children_db = '';
        $query = "SELECT `id`,`name`,`header_bg_image`,`price`,`adults`,`children` FROM `rooms` WHERE `id`='$room_id' AND `status`='1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_row($result)){
            $id = $row[0];
            $room_name = $row[1];
            if($row[2] != '') $header_bg_image = $row[2]; else $header_bg_image = $image;
            $price = $row[3];
            $max_people = $row[4] + $row[5];
            $adults_db = $row[4];
            $children_db = $row[5];
        }

        // redirect if room is not in db
        if($id == '') {
            header("Location: 404.php");
            exit();
        }

        // validate user inputs
        if((($arrival_date != '') && ($departure_date != '')) && (!($arrival_date < $departure_date ))){
            $out = false;
            $msg = 'Depature date cannot be before the arrival date or cannot be the same date of arrival';
        }
        if(($adults == '') || ($adults <= 0)){
            $out = false;
            $msg = 'Please select number of adult people';
        }
        if(($adults != '') && ($adults > $adults_db)){
            $out = false;
            $msg = 'Please select adult guests count only within our allowed range';
        }
        if(($children != '') && ($children > 0)){
            if(($children_db == 0) || ($children_db == '')){
                $out = false;
                $msg = 'Sorry, We are not allow book children to this room';
            }
            if($out){
                if(($children != '') && ($children > $children_db)){
                    $out = false;
                    $msg = 'Please select children count only within our allowed range';
                }
            }
        }
        if(($departure_date == '') || (!($departure_date >= $today))){
            $out = false;
            $msg = 'Please select today or a future day as the departure date';
        }
        if(($arrival_date == '') || (!($arrival_date >= $today))){
            $out = false;
            $msg = 'Please select today or a future day as the arrival date';
        }

        if(!$out){
            header("Location: room.php?id=".$room_id.'&arrival='.$arrival_date.'&departure='.$departure_date."&msg=".$msg);
            exit();
        }

        $country_id = $country_name = $phone_code = $country_code = array();
        $query = "SELECT `id`,`country_name`,`phone_code`, `country_code` FROM `countries` WHERE `status`='1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $country_id[] = $row[0];
            $country_name[] = $row[1];
            $phone_code[] = $row[2];
            $country_code[] = $row[3];
        }

        // $from_date = strtotime($arrival_date);
        // $to_date = strtotime($departure_date);
        // $day_diff = $to_date - $from_date;
        $total_nights = totalNightCount($arrival_date, $departure_date);

        $departure_date_text = date('D', strtotime($departure_date)).', '.$departure_date;
        $arrival_date_text = date('D', strtotime($arrival_date)).', '.$arrival_date;

        $currency = getCurrency();
        $total_guest = $adults + $children;
        $total_room_price = number_format($total_nights * $price, 2, ".", "");

        $back_link = 'room.php?id='.$room_id.'&arrival='.$arrival_date.'&departure='.$departure_date.'&adults='.$adults.'&children='.$children;

        $meal_plan_id = $meal_plan_name = $meal_plan_price = array();
        $query = "SELECT `id`,`name`,`price_per_head` FROM `room_booking_meal_plans` WHERE `status`='1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $meal_plan_id[] = $row[0];
            $meal_plan_name[] = $row[1];
            $meal_plan_price[] = $row[2];
        }
    }else{
        header("Location: 404.php");
        exit();
    }
?>
    <link rel="stylesheet" type="text/css" href="css/home/toastr.min.css" />
    <style>
        .bg-room{ background: url('<?php echo $header_bg_image; ?>') no-repeat !important; }
        .error{ color: red; }
        .success-response{ color: green; font-weight: bold; }
        .meal_packages { cursor:help; font-weight: 100; color: #337ab7; }
        .swal2-popup {  font-size: 1.5rem !important; }
    </style>

    <!-- BANNER -->
    <section class="banner-tems bg-room text-center">
        <div class="container">
            <div class="banner-content">
                <h2>RESERVATION</h2>
                <p><?php echo $room_name; ?>, Booking Process</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <!-- RESERVATION -->
    <section class="section-reservation-page ">
        <div class="container">
            <div class="reservation-page">
                <!-- STEP -->
                <div class="reservation_step">
                    <ul>
                        <li><a href="<?php echo $back_link; ?>"><span>1.</span> Choose Room</a></li>
                        <li class="active"><a href="#"><span>2.</span> Make a Reservation</a></li>
                        <li><a href="#"><span>3.</span> Confirmation</a></li>
                    </ul>
                </div>
                <!-- END / STEP -->

                <div class="row">
                    <!-- SIDEBAR -->
                    <div class="col-md-4 col-lg-3">
                        <div class="reservation-sidebar">
                            <!-- RESERVATION DATE -->
                            <div class="reservation-date">
                                <!-- HEADING -->
                                <h2 class="reservation-heading">Dates</h2>
                                <!-- END / HEADING -->
                                <ul>
                                    <li>
                                        <span>Check-In</span>
                                        <span><?php echo $arrival_date_text; ?></span>
                                    </li>
                                    <li>
                                        <span>Check-Out</span>
                                        <span><?php echo $departure_date_text; ?></span>
                                    </li>
                                    <li>
                                        <span>Total Nights</span>
                                        <span><?php echo $total_nights; ?></span>
                                    </li>
                                    <li>
                                        <span>Total Adults</span>
                                        <span><?php echo $adults; ?></span>
                                    </li>
                                    <li>
                                        <span>Total Children</span>
                                        <span><?php echo $children; ?></span>
                                    </li>
                                    <li>
                                        <span>Total Guests</span>
                                        <span><?php print $total_guest; ?> People</span>
                                    </li>
                                </ul>
                            </div>
                            <!-- END / RESERVATION DATE -->
                            <!-- ROOM SELECT -->
                            <div class="reservation-room-selected selected-4 ">
                                <!-- HEADING -->
                                <h2 class="reservation-heading">Selected Room</h2>
                                <!-- END / HEADING -->

                                <!-- ITEM -->
                                <div class="reservation-room-seleted_item">
                                    <div class="reservation-room-seleted_name has-package">
                                        <h2><a href="room.php?id=<?php echo $id; ?>"><?php echo $room_name; ?></a></h2>
                                    </div>
                                    <span class="reservation-option">One Night Price = <?php echo number_format($price,2, ".", ""); ?><?php echo $currency; ?></span>
                                    <?php if(sizeof($meal_plan_id) != 0){ ?>
                                    <div class="reservation-room-seleted_package">
                                        <h6>Food Selections</h6>
                                        <ul>
                                            <?php
                                                for($i=0; $i<sizeof($meal_plan_id); $i++){
                                                    echo '
                                                        <li>
                                                            <span>'.$meal_plan_name[$i].' ('.$total_guest.' People, '.$total_nights.' Days)</span>
                                                            <span><input type="checkbox" class="checkbox" name="meal_plan" id="'.$meal_plan_id[$i].'" data-price="'.$meal_plan_price[$i].'"></span>
                                                        </li>
                                                    ';
                                                }
                                            ?>
                                            <li><span class="meal_packages" style="text-transform:none; font-weight: 400; float:none;" id="meal_packages">What are included in each package?</span></li>
                                        </ul>
                                    </div>
                                    <?php } ?>
                                    <div class="reservation-room-seleted_package">
                                        <h6>Space Price</h6>
                                        <ul>
                                            <li>
                                                <span>Service</span>
                                                <span>Free</span>
                                            </li>
                                            <li>
                                                <span>Tax</span>
                                                <span>Free</span>
                                            </li>
                                            <li>
                                                <span>Foods</span>
                                                <span style="float:right"><?php echo $currency; ?></span><span id="foods-price">0</span>
                                            </li>
                                        </ul>
                                    </div>
                                    <div class="reservation-room-seleted_total-room">
                                        TOTAL Room Price
                                        <span class="reservation-amout"><?php echo $total_room_price; ?><?php echo $currency; ?></span>
                                    </div>
                                </div>
                                <!-- END / ITEM -->

                                <!-- TOTAL -->
                                <div class="reservation-room-seleted_total ">
                                    <label>TOTAL</label>
                                    <span style="float:right" class="reservation-total"><?php echo $currency; ?></span><span class="reservation-total" id="final-price"><?php echo $total_room_price; ?></span>
                                </div>
                                <!-- END / TOTAL -->
                            </div>
                            <!-- END / ROOM SELECT -->
                        </div>
                    </div>
                    <!-- END / SIDEBAR -->

                    <!-- CONTENT -->
                    <div class="col-md-8 col-lg-9">
                        <div class="reservation_content">
                            <div class="reservation-billing-detail">
                                <h4>GUEST DETAILS</h4>
                                <label>Country <sup> *</sup></label>
                                <select class="awe-select" id="country">
                                    <option value="">Select Your Country</option>
                                    <?php
                                        for($i=0; $i<sizeof($country_id); $i++){
                                            echo '<option value="'.$country_id[$i].'">'.$country_name[$i].'</option>';
                                        }
                                    ?>
                                </select>
                                <span class="error" id="country_error"></span>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>First Name<sup> *</sup></label>
                                        <input type="text" class="input-text" id="first_name" pattern="[a-zA-Z]+">
                                        <span class="error" id="first_name_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Last Name<sup></sup></label>
                                        <input type="text" class="input-text" id="last_name" pattern="[a-zA-Z]+">
                                        <span class="error" id="last_name_error"></span>
                                    </div>
                                </div>
                                <label>Address<sup> *</sup></label>
                                <input type="text" class="input-text" placeholder="Street Address" id="address">
                                <span class="error" id="address_error"></span>
                                <br>
                                <label>City / Town<sup> *</sup></label>
                                <input type="text" class="input-text" placeholder="City or Town name" id="city">
                                <span class="error" id="city_error"></span>
                                <br>
                                <div class="row">
                                    <div class="col-sm-6">
                                        <label>Email Address<sup> *</sup></label>
                                        <input type="text" class="input-text" placeholder="Contact Email Address" id="email">
                                        <span class="error" id="email_error"></span>
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Mobile Number<sup> *</sup></label>
                                            <div class="row" style="display:inline-flex; margin: 0px; width:100%;">
                                                <div class="col-3">
                                                    <select class="awe-select" title="Code" data-live-search="true" data-width="fit" id="phone_code">
                                                        <option value="">Select Phone Code</option>
                                                        <?php
                                                            for($i=0; $i<sizeof($country_id); $i++){
                                                                echo '<option data-tokens="'.$country_name[$i]. ''.$phone_code[$i].'" value="'.$phone_code[$i].'">'.$phone_code[$i].'</option>';
                                                            }
                                                        ?>
                                                    </select>
                                                </div>
                                                <div class="col-9">
                                                    <input type="text" class="input-text" placeholder="Mobile Number" id="mobile" autocomplete="nope">
                                                </div>
                                            </div>
                                            <span class="error" id="mobile_error"></span>
                                    </div>
                                </div>
                                <label>Extra Notes</label>
                                <textarea class="input-textarea" placeholder="Any extra details" id="extra"></textarea>
                                <span class="error" id="extra_note_error" style="margin-bottom:10px;"></span>
                                <input type="checkbox" name="tos" id="tos" class="tos"> <span>By clicking here, I state that I have read and understood the <a href="policies.php" target="_blank">terms and conditions.</a></span>
                                <span class="error" id="tos_error"></span>
                                <br><br>
                                <small style="margin-top:20px;">Please make sure, you have entered accurate details. We are going to contact you using these details</small>
                                <br>
                                <small class="error" id="form_error" style="display:none"></small>
                                <br>
                                <button class="btn btn-room btn4" onclick="booking();" id="btn_booking">BOOK RESERVATION</button>
                                <small class="success-response" style="display:none;" id="response"></small>
                            </div>
                        </div>
                    </div>
                    <!-- END / CONTENT -->
                </div>
            </div>
        </div>
    </section>
    <!-- END / RESERVATION -->
    <div class="modal fade" id="data-modal" tabindex="-1" role="dialog"aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document" style="width: 60%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Meal Plans Details</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                            <th>Name</th>
                            <th>Included Meals</th>
                            <th>Price Per Person</th>
                        </thead>
                        <tbody class="table" id="meal_data">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php include_once('templates/footer.php'); ?>
<script src="js/home/toastr.min.js"></script>
<script src="js/home/sweetalert-2.11.js"></script>
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

    $('#meal_packages').on('click', function() {
        var html = '';
        $.ajax ({
            url: "bookingModel.php?action=ajax_get_meal_plans",
            type: "GET",
            success: function (response){
                const obj = JSON.parse(response);
                var data = obj.data;
                for (let i = 0; i < data.length; i++) {
                    var name = data[i][0];
                    var description = data[i][1];
                    var price_per_person = data[i][2];
                    html += '<tr><td class="text-left">'+name+'</td><td class="text-left">'+description+'</td><td class="text-right">'+price_per_person+'</td></tr>';
                }
                if(data.length > 0){
                    Swal.fire({
                        confirmButtonColor: "#8E7037",
                        width: "70%",
                        html: '<div class="table-responsive"><table class="table"><thead><th class="text-left" style="width:15%; font-size:14px">Name</th><th class="text-left" style="font-size:14px;">Included Meals</th><th class="text-left" style="width:20%; font-size:14px">Price Per Person (One Day)</th></thead><tbody class="table">'+html+'</tbody></table></div>',
                    });
                }
            },
            error:function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    });

    $('.checkbox').change(function() {
        var total_guest = <?php echo $total_guest; ?>;
        var total_nights = <?php echo $total_nights; ?>;
        var final_total = <?php echo $total_room_price; ?>;
        var food_total = 0;
        $('.checkbox:checked').each(function() {
            food_total += ((total_guest * $(this).data('price')) * total_nights);
        });
        $("#foods-price").text(parseFloat(food_total.toFixed(2)));
        $("#final-price").text(parseFloat((final_total + food_total).toFixed(2)));
    });

    function redirectPage(redirectUrl, arg, value) {
        var form = $('<form action="' + redirectUrl + '" method="post">' +
        '<input type="hidden" name="'+ arg +'" value="' + value + '"></input>' + '</form>');
        $('body').append(form);
        $(form).submit();
    }
    function validateEmail(mail) {
        var mailformat = /^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/;
        if(mail.match(mailformat))return true;
        else return false;
    }
    function onlyLettersAndSpaces(str) {
        return /^[A-Za-z\s]*$/.test(str);
    }
    function booking(){
        $out = true;
        $checkbox = $('.checkbox');
        var meal_plan_array_ids = [];
        meal_plan_array_ids = $.map($checkbox, function(el){
            if(el.checked) { return el.id };
        });
        var meal_plans = meal_plan_array_ids.join(', ');
        var country = document.getElementById('country').value;
        var first_name = document.getElementById('first_name').value;
        var last_name = document.getElementById('last_name').value;
        var address = document.getElementById('address').value;
        var city = document.getElementById('city').value;
        var email = document.getElementById('email').value;
        var mobile = document.getElementById('mobile').value;
        var phone_code = document.getElementById('phone_code').value;
        var extra_note = document.getElementById('extra').value;
        var tos = document.getElementById('tos');

        // =====  EMPTY FEILDS VALIDATION ==== //
        // country empty validation
        if(country == ''){
            $out = false;
            document.getElementById('country_error').innerHTML = 'Please select your country';
        }else{
            document.getElementById('country_error').innerHTML = '';
        }

        // first name empty validation
        if(first_name == ''){
            $out = false;
            document.getElementById('first_name_error').innerHTML =  'First name is mandatory to fill'
        }else{
            document.getElementById('first_name_error').innerHTML = '';
        }

        // address empty validation
        if(address == ''){
            $out = false;
            document.getElementById('address_error').innerHTML = 'Address is mandatory to fill';
        }else{
            document.getElementById('address_error').innerHTML = '';
        }

        // city empty validation
        if(city == ''){
            $out = false;
            document.getElementById('city_error').innerHTML = 'City is mandatory to fill';
        }else{
            document.getElementById('city_error').innerHTML = '';
        }

        // email empty validation
        if(email == ''){
            $out = false;
            document.getElementById('email_error').innerHTML = 'Email address is mandatory to fill';
        }else{
            document.getElementById('email_error').innerHTML = '';
        }

        // mobile empty validation
        if(mobile == ''){
            $out = false;
            document.getElementById('mobile_error').innerHTML = 'Mobile number is mandatory to fill';
        }else{
            document.getElementById('mobile_error').innerHTML = '';
        }

        // phone code empty validation
        if((mobile != '') && (phone_code == '')){
            $out = false;
            document.getElementById('mobile_error').innerHTML = 'Phone code is mandatory to select';
        }

        if (!tos.checked){
            $out = false;
            document.getElementById('tos_error').innerHTML = 'You must need to agree to term and conditions of the Hotel';
        }else{
            document.getElementById('tos_error').innerHTML = ''
        }

        //  ==== INDEPTH VALIDATIONS  ==== //
        // first names validation
        if(last_name != ''){
            if(!(onlyLettersAndSpaces(first_name))){
                $out = false;
                document.getElementById('first_name_error').innerHTML = 'First name must need to be in english and cannot contain any spcial characters or numbers!';
            }else if((first_name.length < 2)){
                $out = false;
                document.getElementById('first_name_error').innerHTML = 'First name field must need to be at least 2 characters long';
            }else if((first_name.length > 50)){
                $out = false;
                document.getElementById('first_name_error').innerHTML = 'First name field cannot be more than 50 characters long';
            }else{
                document.getElementById('first_name_error').innerHTML = '';
            }
        }

        // last name validation
        if(last_name != ''){
            if(!onlyLettersAndSpaces(last_name)){
                $out = false;
                document.getElementById('last_name_error').innerHTML = 'Last name must need to be in english and cannot contain any spcial characters or numbers!';
            }
            if ((last_name.length < 2)){
                $out = false;
                document.getElementById('last_name_error').innerHTML = 'Last name field must need to be at least 2 characters long';
            }
            if((last_name != '') && (last_name.length > 100)){
                $out = false;
                document.getElementById('last_name_error').innerHTML = 'Last name field cannot be more than 100 characters long';
            }
        }

        // email validation
        if(email != ''){
            if(!validateEmail(email)){
                $out = false;
                document.getElementById('email_error').innerHTML = 'Please enter valid email address';
            }
        }

        // address validation
        if(address != ''){
            if((address.length < 5)){
                $out = false;
                document.getElementById('address_error').innerHTML = 'Address field must need to be more than 5 characters long';
            }
            if((address.length > 150)){
                $out = false;
                document.getElementById('address_error').innerHTML = 'Address field cannot be more than 150 characters long';
            }
        }

        // city validation
        if(city != ''){
            if((city.length < 2)){
                $out = false;
                document.getElementById('city_error').innerHTML = 'City field must need to be at least more than 2 characters long';
            }
            if((city.length > 255)){
                $out = false;
                document.getElementById('city_error').innerHTML = 'City field cannot be more than 50 characters long';
            }
        }

        // mobile numb validation
        if(mobile != ''){
            if((mobile.length < 7)){
                $out = false;
                document.getElementById('mobile_error').innerHTML = 'Mobile number field must need to be at least more than 7 characters long';
            }
            if((mobile.length > 24)){
                $out = false;
                document.getElementById('mobile_error').innerHTML = 'Mobile number field City field cannot be more than 24 characters long';
            }
        }

        // extra not validation
        if(extra_note != ''){
            if((extra_note != '') && (extra_note.length > 255)){
                $out = false;
                document.getElementById('extra_note_error').innerHTML = 'Extra notes field cannot be more than 255 characters long';
            }
        }

        if($out){
            var room_id = "<?php echo $room_id; ?>";
            var arrival = "<?php echo $arrival_date; ?>";
            var departure = "<?php echo $departure_date; ?>";
            var adults = "<?php echo $adults; ?>";
            var children = "<?php echo $children; ?>";

            Swal.fire({
                title: 'Did you double check the details you have entered?',
                confirmButtonText: "Yes, I did. Book Now",
                icon: 'info',
                showCancelButton: true,
                confirmButtonColor: '#8E7037',
                iconColor: '#8E7037',
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('response').style.display = 'inline';
                    document.getElementById('response').innerHTML = 'Please wait. Your booking is processing..';
                    document.getElementById('form_error').innerHTML = '';
                    document.getElementById('form_error').style.display = 'none';
                    document.getElementById('btn_booking').style.display = 'none';
                    $.ajax({
                        type: "POST",
                        url: 'bookingModel.php?action=booking',
                        data: {
                            country: country,
                            first_name: first_name,
                            last_name: last_name,
                            email : email,
                            address : address,
                            city : city,
                            mobile : mobile,
                            phone_code : phone_code,
                            extra : extra_note,
                            room_id : room_id,
                            arrival : arrival,
                            departure : departure,
                            adults : adults,
                            children : children,
                            meal_plans : meal_plans,
                        },
                        success: function (response) {
                            const obj = JSON.parse(response);
                            if(obj.status == 'error'){
                                toastr.error(obj.msg);
                                document.getElementById('btn_booking').style.display = 'inline';
                                document.getElementById('response').style.display = 'none';
                                document.getElementById('response').innerHTML = '';
                                document.getElementById('form_error').style.display = 'inline';
                                document.getElementById('form_error').innerHTML = 'Please check form errors';
                            }else if(obj.status = 'success'){
                                toastr.success(obj.msg);
                                document.getElementById('form_error').style.display = 'none';
                                document.getElementById('form_error').innerHTML = '';
                                document.getElementById('response').style.display = 'inline';
                                document.getElementById('response').innerHTML = 'Your booking is successfully completed. We will redirect you to confrimation page.';
                                setTimeout(() => redirectPage("booking_confrimation.php", "booking_id", obj.booking_id), 3000);
                            }else{
                                document.getElementById('btn_booking').style.display = 'inline';
                                document.getElementById('response').innerHTML = '';
                                document.getElementById('response').style.display = 'none';
                                document.getElementById('form_error').innerHTML = '';
                                document.getElementById('form_error').style.display = 'none';
                                toastr.info("Unknown Error! Try again");
                            }
                        }
                    });
                }
            });
        }else{
            document.getElementById('form_error').style.display = 'inline';
            document.getElementById('form_error').innerHTML = 'Please check form errors';
        }
    }
</script>