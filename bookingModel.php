<?php
    function randomStrings($length_of_string) {
        $str_result = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
        return substr(str_shuffle($str_result), 0, $length_of_string);
    }

    function generateOrderCode(){
        include('config.php');
        $new_code = randomStrings(10);
        $query = "SELECT COUNT(`id`) FROM `rooms_booking` WHERE `booking_code`='$new_code'";
        $row=mysqli_fetch_row(mysqli_query($conn,$query));
        $count = $row[0];
        if($count == 0){
            return $new_code;
        }else{
            generateOrderCode();
        }
    }

    function validateDate($date){
        // date must be in yyyy-dd-mm format
        $date = explode('-', $date);
        $year  = $date[0];
        $month = $date[1];
        $day   = $date[2];
        return checkdate($month, $day, $year);
    }

    function validatePhoneNumber($phone){
        // Allow +, - and . in phone number
        $filtered_phone_number = filter_var($phone, FILTER_SANITIZE_NUMBER_INT);
        // Remove "-" from number
        $phone_to_check = str_replace("-", "", $filtered_phone_number);
        // Check the lenght of number
        if(strlen($phone_to_check) < 7 || strlen($phone_to_check) > 24){
            return false;
        }else{
            return true;
        }
    }

    function phoneCodeValidationFromDB($phone_code){
        include('config.php');
        $query = "SELECT COUNT(`id`) FROM `countries` WHERE `phone_code`='$phone_code' AND  `status`='1'";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);
        if($row[0] > 0){
            return true;
        }else{
            return false;
        }
    }

    function checkAvailabilityBeforeBookingOld($arrival, $departure, $room_id){
        include('config.php');
        $query = "SELECT COUNT(`id`) FROM `rooms_booking` WHERE `room_id`='$room_id' AND `status`='1' AND
        (`arrival_date` <= '$arrival' AND `departure_date` > '$arrival') OR
        (`arrival_date` < '$departure' AND `departure_date` > '$arrival') OR
        (`arrival_date` >= '$arrival' AND `departure_date` < '$arrival')";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);
        return $row[0];
    }

    function checkAvailabilityBeforeBooking($arrival, $departure, $room_id){
        include('config.php');
        $query = "SELECT COUNT(`id`) FROM `room_booked_dates` WHERE `room_id`='$room_id' AND  DATE(`date`) BETWEEN DATE('$arrival') AND DATE('$departure')";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);
        return $row[0];
    }

    if((isset($_GET['action'])) && ($_GET['action'] == 'booking')){
        $out = true;
        $status = 'error';
        $meal_plans_ar = $datesAr = array();
        include('config.php');
        include('templates/common.php');
        $msg = '';
        $today = date("Y-m-d");
        $adults = $children = $adults_db = $children_db = $meal_plan_price = 0;
        $first_name = $last_name = $email  = $address  = $city  = $mobile = $phone_code  = $extra  =  $room_id = $code =
        $db_room_id = $room_name = $room_number = $price = $country_id = $arrival = $departure = '';

        // room id validation
        if($out){
            if((isset($_POST['room_id'])) && ($_POST['room_id'] != '') && (preg_match('/^\d+$/',$_POST['room_id']))){
                $room_id = $_POST['room_id'];
                $query = "SELECT `id`,`name`,`price`,`adults`,`children`,`room_number` FROM `rooms` WHERE `id`='$room_id' AND `status`='1'";
                $result = mysqli_query($conn,$query);
                while($row=mysqli_fetch_row($result)){
                    $db_room_id = $row[0];
                    $room_name = $row[1];
                    $price = $row[2];
                    $adults_db = $row[3];
                    $children_db = $row[4];
                    $room_number = $row[5];
                }
                if(($out) && ($db_room_id == '')){
                    $out=false;
                    $msg='Please re-check your select room.';
                }
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }

        // arrival date validation
        if($out){
            if((isset($_POST['arrival'])) && ($_POST['arrival'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['arrival'])) && (validateDate($_POST['arrival']))){
                $arrival = $_POST['arrival'];
            }else{
                $msg = 'Arrival date is required and need to be in yyyy-mm-dd date format';
                $out = false;
            }
        }

        // departure date validation
        if($out){
            if((isset($_POST['departure'])) && ($_POST['departure'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['departure'])) && (validateDate($_POST['departure']))){
                $departure = $_POST['departure'];
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

        // departure date validation (date must need to be future day)
        if($out){
            if(!($departure > $arrival)){
                $out = false;
                $msg = 'Please select future day as the departure date';
            } 
        }

        // room availability check
        if($out){
            $value = checkAvailabilityBeforeBooking($arrival, $departure, $db_room_id);
            if($value > 0){
                $out = false;
                $msg = "Sorry, This room is already booked within your selected date range";
            }
        }

        // adults validation
        if($out){
            if((isset($_POST['adults'])) && ($_POST['adults'] != '') && (preg_match('/^\d+$/',$_POST['adults']))){
                $adults = $_POST['adults'];
                if(($adults > $adults_db) || ($adults <= 0)){
                    $msg = 'Adult guest(s) count is invalid';
                    $out = false;
                }
            }else{
                $msg = 'Adult guest(s) count is required and need to be a intiger value';
                $out = false;
            }
        }

        // children validation
        if($out){
            if((isset($_POST['children'])) && (preg_match('/^\d+$/',$_POST['children']))){
                $children = $_POST['children'];
                if($children > 0 && ($children_db == 0) || ($children_db == '')){
                    $out = false;
                    $msg = 'Sorry, We are not allow book children to this room';
                }
                if($out){
                    if(($children != '') && ($children > $children_db)){
                        $out = false;
                        $msg = 'Please select children count only within our allowed range';
                    }
                }
            }else{
                $children = '';
            }
        }

        // country validation
        if($out){
            if((isset($_POST['country'])) && ($_POST['country'] != '')){
                $country_id = $_POST['country'];
                if(!preg_match('/^\d+$/',$_POST['country'])){
                    $out = false;
                    $msg = 'Double check your country';
                }
                if($out){
                    $query = "SELECT `id` FROM `countries` WHERE `status` = '1' AND `id`= '$country_id'";
                    $row=mysqli_fetch_row(mysqli_query($conn,$query));
                    if(!$row){
                        $out = false;
                        $msg = 'Double check your country';
                    }
                }
            }else{
                $msg = 'Country is required';
                $out = false;
            }
        }

        // first name validation
        if($out){
            if((isset($_POST['first_name'])) && ($_POST['first_name'] != '')){
                $first_name = ucwords(trim($_POST['first_name']));
                if(strlen($first_name) > 50){
                    $out = false;
                    $msg = 'First name field cannot be more than 50 characters long';
                }
                if(strlen($first_name) < 2){
                    $out = false;
                    $msg = 'First name field must need to be at least 2 characters long';
                }
                if(!preg_match('/^[a-zA-Z ]*$/i', $first_name)){
                    $out = false;
                    $msg = 'First name must need to be in english and cannot contain any spcial characters or numbers!';
                }
            }else{
                $out = false;
                $msg = 'First name cannot be emtpy';
            }
        }

        // last name validation
        if($out){
            if((isset($_POST['last_name'])) && ($_POST['last_name'] != '')){
                $last_name = ucwords(trim($_POST['last_name']));
                if(strlen($last_name) > 50){
                    $out = false;
                    $msg = 'Last name field cannot be more than 50 characters long';
                }
                if(strlen($last_name) < 2){
                    $out = false;
                    $msg = 'Last name field must need to be at least 2 characters long';
                }
                if(!preg_match('/^[a-zA-Z ]*$/i', $last_name)){
                    $out = false;
                    $msg = 'Last name must need to be in english and cannot contain any spcial characters or numbers!';
                }
            }
        }

        // email validation
        if($out){
            if((isset($_POST['email'])) && (filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))){
                $email = trim($_POST['email']);
            }else{
                $out = false;
                $msg = 'Email is required and need to be a valid email';
            }
        }

        // mobile number validation
        if($out){
            if((isset($_POST['mobile'])) && ($_POST['mobile'] != '') && (validatePhoneNumber($_POST['mobile']))){
                $mobile = trim($_POST['mobile']);
            }else{
                $out = false;
                $msg = 'Mobile number is required and not contains any english letters, min length 7 max 24';
            }
        }

        // phone code validation
        if($out){
            if((isset($_POST['phone_code'])) && ($_POST['phone_code'] != '')){
                $phone_code = trim($_POST['phone_code']);
                if(!(phoneCodeValidationFromDB($phone_code))){
                    $out = false;
                    $msg = 'Phone code is invalid';
                }
            }else{
                $out = false;
                $msg = 'Phone code is required';
            }
        }

        // address validation
        if($out){
            if((isset($_POST['address'])) && ($_POST['address'] != '')){
                $address = trim($_POST['address']);
                if(strlen($address) > 150){
                    $out = false;
                    $msg = 'Address field cannot be more than 150 characters long';
                }
                if(strlen($address) < 5){
                    $out = false;
                    $msg = 'Address field must need to be more than 5 characters long';
                }
            }else{
                $out = false;
                $msg = 'Address cannot be emtpy';
            }
        }

        // city validation
        if($out){
            if((isset($_POST['city'])) && ($_POST['city'] != '')){
                $city = trim($_POST['city']);
                if(strlen($city) >50){
                    $out = false;
                    $msg = 'City field cannot be more than 50 characters long';
                }
                if(strlen($city) < 2){
                    $out = false;
                    $msg = 'City field must need to be more than 2 characters long';
                }
            }else{
                $out = false;
                $msg = 'City cannot be emtpy';
            }
        }

        // extra validation
        if($out){
            if((isset($_POST['extra'])) && ($_POST['extra'] != '')){
                $extra = trim($_POST['extra']);
                if(strlen($extra) >255){
                    $out = false;
                    $msg = 'Extra notes cannot be more than 255 characters long';
                }
            }
        }

        // meal plans validation
        if($out){
            if((isset($_POST['meal_plans'])) && ($_POST['meal_plans'] != '')){
                $meal_plans_ar = explode(', ', $_POST['meal_plans']);
                $meal_plans = $_POST['meal_plans'];
                $query = "SELECT COUNT(`id`) FROM `room_booking_meal_plans` WHERE `id` IN($meal_plans) AND `status` = '1'";
                $row = mysqli_fetch_row(mysqli_query($conn,$query));
                if(!($row[0] > 0)){
                    $out = false;
                    $msg = 'Please check your meal plans';
                }
            }
        }

        // all data valid
        if($out){
            $time_now=timeNow();
            $date_now=dateNow();
            $total_nights = totalNightCount($arrival, $departure);

            // food prices
            for($i=0; $i<sizeof($meal_plans_ar); $i++){
                $meal_plan_id = $meal_plans_ar[$i];
                $query = "SELECT `price_per_head` FROM `room_booking_meal_plans` WHERE `id`='$meal_plan_id'";
                $row = mysqli_fetch_row(mysqli_query($conn,$query));
                $meal_price = $row[0];
                $meal_plan_price += ($meal_price * ($adults + $children)) * $total_nights;
            }

            $total_room_price = number_format((totalNightCount($arrival, $departure) * $price) + $meal_plan_price, 2, ".", "");
            $booking_code = generateOrderCode();
            $currency = getCurrency();
            $mobile_number = $phone_code.$mobile;

            // insert primary data
            $query = "INSERT INTO `rooms_booking` (`room_id`,`booking_code`,`adults`,`children`,`arrival_date`,`departure_date`,`single_night_price`,`total`,`first_name`,`last_name`,`address`,`city`,`country`,`email`,`mobile`,`extra_note`,`booked_at`) 
            VALUE ('$db_room_id','$booking_code','$adults','$children','$arrival','$departure','$price','$total_room_price','$first_name','$last_name','$address','$city','$country_id','$email','$mobile_number','$extra','$time_now');";
            $result = mysqli_query($conn,$query);
            $last_id = mysqli_insert_id($conn);
            if(!$result){
                $out = false;
                $msg = 'Opps.. Something went to wrong. Please try again';
            }else{
                $query = "SELECT `booking_code` FROM `rooms_booking` WHERE `id`='$last_id'";
                $row = mysqli_fetch_row(mysqli_query($conn,$query));
                $code = $row[0];
            }
            // insert booked dates
            if($out){
                $datesAr = getBetweenDates($arrival, $departure);
                for($i=0; $i<sizeof($datesAr); $i++){
                    $date = $datesAr[$i];
                    $query = "INSERT INTO `room_booked_dates` (`guest_id`,`room_id`,`date`) VALUE ('$last_id','$db_room_id','$date');";
                    $result = mysqli_query($conn,$query);
                }
            }

            // insert meal plans
            if($out){
                $meal_plan_price = 0;
                for($i=0; $i<sizeof($meal_plans_ar); $i++){
                    $meal_plan_id = $meal_plans_ar[$i];
                    $query = "SELECT `price_per_head` FROM `room_booking_meal_plans` WHERE `id`='$meal_plan_id'";
                    $row = mysqli_fetch_row(mysqli_query($conn,$query));
                    $price_per_head = $row[0];

                    $meal_plan_price = ($price_per_head * ($adults + $children)) * $total_nights;

                    $query = "INSERT INTO `room_booked_meal_plans` (`guest_id`,`booking_meal_plan_id`,`price`) VALUE ('$last_id','$meal_plan_id','$meal_plan_price');";
                    $result = mysqli_query($conn,$query);
                }
            }

            // email send
            if($out){
                $query = "SELECT `country_name` FROM `countries` WHERE `id` = '$country_id'";
                $row = mysqli_fetch_row(mysqli_query($conn,$query));
                $country_name = $row[0];

                $from_date = strtotime($arrival);
                $to_date = strtotime($departure);
                $day_diff = $to_date - $from_date;
                $total_nights = floor($day_diff/(60*60*24));

                $arrival_date_text = date('D', strtotime($arrival)).', '.$arrival;
                $departure_date_text = date('D', strtotime($departure)).', '.$departure;
                $total_room_price_text = number_format($total_room_price, 2, ".", "");
                $single_night_price_text = number_format($price, 2, ".", "");
                $email_inside_title = 'ROOM RESERVATION CONFIRMATION';
                $conditions = $meal_plans_tr = '';
                $meal_plan_name_ar = $meal_plan_price_ar = array();

                // meal plans
                $query = "SELECT rmp.`name`, rbmp.`price` FROM `room_booked_meal_plans` rbmp, `room_booking_meal_plans` rmp WHERE rmp.`id` = rbmp.`booking_meal_plan_id` AND `guest_id` = '$last_id'";
                $result = mysqli_query($conn,$query);
                while($row=mysqli_fetch_row($result)){
                    $meal_plans_tr .= '<tr>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                            '.ucfirst($row[0]).'
                        </td>
                        <td
                            style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                            '.$currency . number_format($row[1], 2, ".", "").'
                        </td>
                    </tr>';
                }

                // TO GUEST EMAIL
                include  'templates/emails/reservation_confirm.php';
                $subject = getCompanyName().' Room Booking Confirmation';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $headers .= "From: ".getFromEmail()."\r\n";
                $sent=mail($email,$subject,$message,$headers);
                if(!$sent){
                    $msg='Email Could Not be Sent.<br/> Please contact support: '.getSupportEmail();
                    $out=false;
                }

                // TO HOTEL EMAIL
                include  'templates/emails/reservation_confrim_hotel.php';
                $subject = getCompanyName().' New Booking Received';
                $headers = "MIME-Version: 1.0" . "\r\n";
                $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                $headers .= "From: ".getFromEmail()."\r\n";
                $sent=mail(getToEmail(),$subject,$message_hotel,$headers);
                if(!$sent){
                    $msg='Email Could Not be Sent.<br/> Please contact support: '.getSupportEmail();
                    $out=false;
                }
            }
            if($out){
                $status = "success";
                $msg = "Your room booking is successful.";
            }
        }

        $output = array(
            "status" => $status,
            "booking_id" => $code,
            "msg" =>	$msg
        );
        echo json_encode($output);
    }

    if((isset($_GET['action'])) && ($_GET['action'] == 'check_booking_availability')){
        $out = true;
        $msg = '';
        $status = 'error';
        $today = date("Y-m-d");

        if($out){
            if((isset($_POST['room_id'])) && ($_POST['room_id'] != '') && (preg_match('/^\d+$/',$_POST['room_id']))){
                $room_id = $_POST['room_id'];
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }
        // arrival date validation
        if($out){
            if((isset($_POST['arrival'])) && ($_POST['arrival'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['arrival'])) && (validateDate($_POST['arrival']))){
                $arrival = $_POST['arrival'];
            }else{
                $msg = 'Arrival date is required and need to be in yyyy-mm-dd date format';
                $out = false;
            }
        }

        // departure date validation
        if($out){
            if((isset($_POST['departure'])) && ($_POST['departure'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['departure'])) && (validateDate($_POST['departure']))){
                $departure = $_POST['departure'];
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

        // departure date validation (date must need to be today or future day)
        if($out){
            if(!($departure > $arrival)){
                $out = false;
                $msg = 'Please select future day as the departure date';
            } 
        }

        // room availability check
        if($out){
            $value = checkAvailabilityBeforeBooking($arrival, $departure, $room_id);
            if($value > 0){
                $out = false;
                $msg = "Sorry, This room is already booked within your selected date range";
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg
        );
        echo json_encode($output);
    }

    if((isset($_GET['action'])) && ($_GET['action'] == 'home_page_room_availability')){
        $status = 'error';
        $out = true;
        $count = 0;
        $msg = $data = $adults = $children = $arrival = $departure = '';
        $booked_room_ids = $room_name = $room_id = array();
        $today = date("Y-m-d");
        include('config.php');

        // arrival date validation
        if($out){
            if((isset($_POST['arrival'])) && ($_POST['arrival'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['arrival'])) && (validateDate($_POST['arrival']))){
                $arrival = $_POST['arrival'];
            }else{
                $msg = 'Arrival date is required and need to be in yyyy-mm-dd date format';
                $out = false;
            }
        }

        // departure date validation
        if($out){
            if((isset($_POST['departure'])) && ($_POST['departure'] != '') && (preg_match("/^([0-9]{4})-([0-9]{2})-([0-9]{2})$/", $_POST['departure'])) && (validateDate($_POST['departure']))){
                $departure = $_POST['departure'];
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
            if((isset($_POST['adults'])) && ($_POST['adults'] != '') && (preg_match('/^\d+$/',$_POST['adults']))){
                $adults = $_POST['adults'];
            }else{
                $msg = 'Adult guest(s) count is required';
                $out = false;
            }
        }

        // children validation
        if($out){
            if((isset($_POST['children'])) && (preg_match('/^\d+$/',$_POST['children']))){
                $children = $_POST['children'];
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
                $query = "SELECT COUNT(`id`) FROM `rooms` WHERE `id` NOT IN($implode_ids) AND `adults` >= '$adults' && `children` >= '$children'";
            }else{
                $query = "SELECT COUNT(`id`) FROM `rooms` WHERE `adults` >= '$adults' && `children` >= '$children'";
            }
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $count = $row[0];

            if($count == 0){
                $status = 'info';
                $msg = 'Sorry! There is no room available for this data inputs.';
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg
        );
        echo json_encode($output);
    }

    if((isset($_GET['action'])) && ($_GET['action'] == 'ajax_get_meal_plans')){
        include('config.php');
        include('templates/common.php');
        $data = [];
        $currency = getCurrency();
        
        $query = "SELECT `name`, `description`, `price_per_head` FROM `room_booking_meal_plans` WHERE `status`='1'";
        $result = mysqli_query($conn,$query);
        foreach($result as $row){
            $sub_array = array();
            $sub_array[] = $row['name'];
            $sub_array[] = $row['description'];
            $sub_array[] = $currency . number_format($row['price_per_head'], 2, ".", "");
            $data[] = $sub_array;
        }
        $output = array(
            "data"	=>	$data
        );
        echo json_encode($output);
    }
?>