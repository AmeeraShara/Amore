<?php 
    function getUpcomingBookingDataAjax(){
        $data = array();
        $today = dateNow();
        $name_search_qry = $query = $from = $to = $query1 = $query_total_records = $number_filter_row = $recordsTotal = $booking_code_search_qry = '';
        include('config.php');

        $column = array("rb.`id`","rb.`booking_code`", "rb.`first_name`", "c.`country`", "r.`room_number`" , "r.`name`","rb.`arrival_date`","rb.`departure_date`","rb.`adults`","rb.`children`","rb.`email`","rb.`mobile`");
        
        $query_total_records = "SELECT `id` FROM `rooms_booking` WHERE  `status` = '1'";
        $recordsTotal = mysqli_num_rows(mysqli_query($conn,$query_total_records));  // total number of records count

        if(isset($_POST["search"]["value"]) && ($_POST["search"]["value"] != '')){ // search by email
            $value = $_POST["search"]["value"];
            $booking_code_search_qry = " AND (rb.`booking_code` LIKE '%".$value."%' OR CONCAT(rb.`first_name`, '', rb.`last_name`)  LIKE '%".$value."%')";
        }

        // $query = "SELECT rb.`id`,rb.`booking_code`,rb.`first_name`,rb.`last_name`,c.`country_name`,r.`room_number`,r.`name`,rb.`arrival_date`,rb.`departure_date`,rb.`adults`,rb.`children`,rb.`email`,rb.`mobile` FROM `rooms_booking` rb , `rooms` r , `countries` c  WHERE c.`id` = rb.`country` AND r.`id` = rb.`room_id` AND rb.`arrival_date` >= '$today' AND rb.`status`='1'  $booking_code_search_qry";
        $query = "SELECT
        rb.`id`,rb.`booking_code`,rb.`first_name`,rb.`last_name`,c.`country_name`,r.`room_number`,r.`name`,rb.`arrival_date`,rb.`departure_date`,rb.`adults`,rb.`children`,rb.`email`,rb.`mobile`, GROUP_CONCAT(mp.`name`) AS `meals`
        FROM `rooms` r
        LEFT JOIN `rooms_booking` rb ON r.`id` = rb.`room_id`
        LEFT JOIN `countries` c ON c.`id` = rb.`country`
        LEFT JOIN `room_booked_meal_plans` rbmp ON rbmp.`guest_id` = rb.`id`
        LEFT JOIN `room_booking_meal_plans` mp ON mp.`id` = rbmp.`booking_meal_plan_id`
        WHERE rb.`arrival_date` >= '$today' AND rb.`status`='1'
        GROUP BY rb.`id`  $booking_code_search_qry";

        if((isset($_POST["is_date_search"])) &&  ($_POST["is_date_search"] == "yes") && (isset($_POST["date_type"])) && ($_POST["date_type"] == 'arrival') && ($_POST["start_date"] != '') && ($_POST["end_date"] != '')){ // date filter
            $from = $_POST["start_date"];
            $to = $_POST["end_date"];
            $query .= " AND  DATE(rb.`arrival_date`) BETWEEN DATE('$from') AND DATE('$to') ";
        }

        if((isset($_POST["is_date_search"])) &&  ($_POST["is_date_search"] == "yes") && (isset($_POST["date_type"])) && ($_POST["date_type"] == 'departure') && ($_POST["start_date"] != '') && ($_POST["end_date"] != '')){ // date filter
            $from = $_POST["start_date"];
            $to = $_POST["end_date"];
            $query .= " AND  DATE(rb.`departure_date`) BETWEEN DATE('$from') AND DATE('$to') ";
        }

        if((isset($_POST['order'])) && ($_POST["order"] != '')){ // sorting
            $query .= ' ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
        }else{
            $query .= ' ORDER BY rb.`arrival_date` ASC ';
        }

        if($_POST['length'] != -1){ // page limit
            $query1 = ' LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
        }
        $query .= $query1;

        $result = mysqli_query($conn,$query);
        $number_filter_row = mysqli_num_rows($result);

        foreach($result as $row){
            $sub_array = array();
            $sub_array[] = $row['id'];
            $sub_array[] = $row['booking_code'];
            $sub_array[] = $row['first_name']." ".$row['last_name'];
            $sub_array[] = $row['country_name'];
            $sub_array[] = $row['arrival_date'];
            $sub_array[] = $row['departure_date'];
            $sub_array[] = $row['adults'];
            $sub_array[] = $row['children'];
            // $sub_array[] = $row['meals'];
            $values = explode(",", $row["meals"]);
            $design = '';
            if(sizeof($row["meals"]) > 0){
                foreach ($values as $value) {
                    $design .= '<p style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true" style="padding-right: 5px; color: green;"></i>'.$value.'</p>';
                }
            }
            $sub_array[] = $design;
            $sub_array[] = $row['email'];
            $sub_array[] = $row['mobile'];
            $data[] = $sub_array;
        }
        
        $output = array(
            "draw"		=>	intval($_POST["draw"]),
            "recordsTotal"	=>	$recordsTotal,
            "recordsFiltered"	=>	$number_filter_row,
            "data"		=>	$data
        );
        echo json_encode($output);
    }

    function getRecentBookingDataToCalendar(){
        $today = dateNow();
        $to = date("Y-m-d", strtotime("+3 months"));
        $from = date("Y-m-d", strtotime("-3 months"));
        $room_count = 0;
        $implode_room_ids = '';
        
        global $booked_count, $full_booked_date, $booked_portion, $booked_dates, $booking_id, $booking_code, $arrival_date, $departure_date, $room_name, $room_number, $room_color, $calendar_data;
        $booked_count = $full_booked_date = $booked_portion = $booked_dates = $room_ids = $booking_id = $booking_code = $arrival_date = $departure_date = $calendar_data = $room_name = $room_number = $room_color = array();
        include('config.php');

        // SELECT ACTIVE ROOM IDs
        $query = "SELECT `id` FROM `rooms` WHERE `status` = '1'";
        $result = mysqli_query($conn,$query);
        $room_count = mysqli_num_rows($result); // active room count
        while($row=mysqli_fetch_row($result)){
            $room_ids[] = $row[0];
        }

        // GET COUNT OF EACH DAY WHICH HAS ALL ROOM ID IN PARTICULAR DATE
        $datesAr = getBetweenDates($from, $to); // get all dates between start and end date as an array
        $implode_room_ids = implode($room_ids,","); // make room id string to query ("1,2,3")
        for($i=0; $i<sizeof($datesAr); $i++){ // loop through range of dates
            $date = $datesAr[$i];
            $booked_room_count = 0;

            $query = "SELECT `id` FROM `room_booked_dates` WHERE `room_id` IN($implode_room_ids) AND `date` = '$date'";
            $result = mysqli_query($conn,$query);
            $booked_room_count = mysqli_num_rows($result);

            $booked_dates[] = $date;
            $booked_count[] = $booked_room_count;
            $booked_portion[] = $booked_room_count .'/'. $room_count;
            if($room_count == $booked_room_count){ // a day has all booking
                $full_booked_date[] = 1;
            }else{
                $full_booked_date[] = 0;
            }
        }
        // var_dump($query);
        // exit;

        $query = "SELECT rb.`id`, rb.`booking_code`, rb.`arrival_date`, rb.`departure_date`, r.`name`, r.`room_number`, r.`color` FROM `rooms_booking` rb, `rooms` r WHERE rb.`room_id` = r.`id` AND rb.`status`='1' AND DATE(rb.`arrival_date`) BETWEEN DATE('$from') AND DATE('$to') ";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_row($result)){
            $booking_id[] = $row[0];
            $booking_code[] = $row[1];
            $arrival_date[] = $row[2];
            $departure_date[] = $row[3];
            $room_name[] = $row[4];
            $room_number[] = $row[5];
            $room_color[] = $row[6];
        }
    }

    function getBookingDataCalendarEventSelect(){
        $today = dateNow();
        $output = array();
        $currency = getCurrency();
        include('config.php');

        if((isset($_POST["id"])) &&  ($_POST["id"] != "")){ // date filter
            $id = $_POST["id"];
        }

        $query = "SELECT rb.`booking_code`, rb.`arrival_date`, rb.`departure_date`, rb.`adults`, rb.`children`, rb.`first_name`, 
        rb.`last_name`, rb.`total`, rb.`email`, rb.`mobile`, rb.`city`, rb.`address`, rb.`extra_note`, rb.`booked_at`, 
        rb.`single_night_price`, r.`name`, c.`country_name`, r.`room_number` 
        FROM `rooms_booking` rb, `rooms` r, `countries` c 
        WHERE rb.`room_id` = r.`id` AND c.`id` = rb.`country` AND rb.`status`='1' AND rb.`id`='$id'";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);

        $output = array(
            "booking_code" =>$row[0],
            "arrival_date" =>$row[1],
            "departure_date" => $row[2],
            "adults" => $row[3],
            "children" => $row[4],
            "first_name" => $row[5],
            "last_name" => $row[6],
            "total_price" => $currency . number_format($row[7] , 2, ".", ""),
            "email" => $row[8],
            "contact_no" => $row[9],
            "city" => $row[10],
            "address" => $row[11],
            "extra" => $row[12],
            "booked_at" => $row[13],
            "single_night_price" => $currency . number_format($row[14] , 2, ".", ""),
            "room" => $row[15],
            "country" => $row[16],
            "room_number" => $row[17],
        );
        echo json_encode($output);
    }

    function getRoomColors(){
        global $rm_color, $rm_name, $rm_number;
        $rm_color = $rm_name = $rm_number = array();
        include('config.php');

        $query = "SELECT `name`,`color`,`room_number` FROM `rooms`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $rm_name[] = $row[0];
            $rm_color[] = $row[1];
            $rm_number[] = $row[2];
        }
    }

    function getRoomsByDatesAjax(){
        $data = array();
        $date = $_POST['date'];
        $implode_room_ids = '';
        $guest_id = array();
        $currency = getCurrency();
        include('config.php');
        // get booked id's
        $query = "SELECT DISTINCT `guest_id` FROM `room_booked_dates` WHERE `date` = '$date'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $guest_id[] = $row[0];
        }
        // get booked data
        if(sizeof($guest_id) > 0){
            $implode_room_ids = implode($guest_id,","); 
            $query = "SELECT rb.`id`, rb.`booking_code`, rb.`first_name`, rb.`last_name`, r.`name`, r.`room_number` 
            FROM `rooms_booking` rb, `rooms` r
            WHERE rb.`room_id` = r.`id`  AND rb.`status`='1' AND rb.`id` IN($implode_room_ids)";
            $result = mysqli_query($conn,$query);
    
            foreach($result as $row){
                $sub_array = array();
                $sub_array[] = $row['id'];
                $sub_array[] = $row['booking_code'];
                $sub_array[] = $row['first_name'];
                $sub_array[] = $row['last_name'];
                $sub_array[] = $row['room_number'];
                $sub_array[] = $row['name'];
                $data[] = $sub_array;
            }
        }

        $output = array(
            "data"	=>	$data
        );

        echo json_encode($output);
    }

    function getRoomDataAjax(){
        $today = dateNow();
        $output = array();
        $currency = getCurrency();
        include('config.php');

        if((isset($_POST["id"])) &&  ($_POST["id"] != "")){ // date filter
            $id = $_POST["id"];
        }

        $query = "SELECT rb.`booking_code`, rb.`arrival_date`, rb.`departure_date`, rb.`adults`, rb.`children`, rb.`first_name`, 
        rb.`last_name`, rb.`total`, rb.`email`, rb.`mobile`, rb.`city`, rb.`address`, rb.`extra_note`, rb.`booked_at`, 
        rb.`single_night_price`, r.`name`, c.`country_name`, r.`room_number` 
        FROM `rooms_booking` rb, `rooms` r, `countries` c 
        WHERE rb.`room_id` = r.`id` AND c.`id` = rb.`country` AND rb.`status`='1' AND rb.`id`='$id'";
        $result = mysqli_query($conn,$query);
        $row=mysqli_fetch_row($result);

        $output = array(
            "booking_code" =>$row[0],
            "arrival_date" =>$row[1],
            "departure_date" => $row[2],
            "adults" => $row[3],
            "children" => $row[4],
            "first_name" => $row[5],
            "last_name" => $row[6],
            "total_price" => $currency . number_format($row[7] , 2, ".", ""),
            "email" => $row[8],
            "contact_no" => $row[9],
            "city" => $row[10],
            "address" => $row[11],
            "extra" => $row[12],
            "booked_at" => $row[13],
            "single_night_price" => $currency . number_format($row[14] , 2, ".", ""),
            "room" => $row[15],
            "country" => $row[16],
            "room_number" => $row[17],
        );
        echo json_encode($output);
    }

    function getAllRooms(){
        $currency = getCurrency();
        include('config.php');
        global $room_id, $room_no, $room_name, $room_price, $room_max_people, $room_adults, $room_children, $room_status;
        $room_id = $room_no = $room_name = $room_price = $room_max_people = $room_adults = $room_children = $room_status = array();

        $query = "SELECT `id`,`room_number`,`name`,`price`,`adults`,`children`,`status` FROM `rooms`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $room_id[] = $row[0];
            $room_no[] = $row[1];
            $room_name[] = $row[2];
            $room_price[] = $currency . number_format($row[3], 2, ".", "");
            $room_max_people[] = $row[4] + $row[5];
            $room_adults[] = $row[4];
            $room_children[] = $row[5];
            if($row[6] == 1) $room_status[] = "ACTIVE";  else  $room_status[] = "INACTIVE"; 
        }
    }

    function deleteRoom(){
        global $msg;
        $msg = $room_id = '';
        include('config.php');
        $out=true;
        $msg="Room deleted successfully!";

        // room id validation
        if($out){
            if((isset($_GET['room_id'])) && ($_GET['room_id'] != '') && (preg_match('/^\d+$/',$_GET['room_id']))){
                
                $room_id = $_GET['room_id'];
                $query = "SELECT `id` FROM `rooms` WHERE `id`='$room_id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_room_id = $row[0];
                
                if($db_room_id == ''){
                    $out=false;
                    $msg='Please re-check your select room.';
                }
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }
        // delete images of room
        if($out){
            $query = "SELECT `overview_image`,`header_bg_image`,`home_image` FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_array($result)){
                if($row[0] != ''){
                    if(!unlink($row[0])){
                        $out = false;
                        $msg = 'Room oveview image delete error';
                    } 
                }
               if($row[1] != ''){
                    if(!unlink($row[1])){
                        $out = false;
                        $msg = 'Room header background image delete error';
                    }
               }
               if($row[2] != ''){
                    if(!unlink($row[2])){
                        $out = false;
                        $msg = 'Room home image delete error';
                    }
                }
            }
        }

        // delete room
        if($out){
            // $query="DELETE FROM `rooms` WHERE `id` = '$room_id'";
            /* $query="DELETE FROM `rooms`, `room_detail_categories`,  `room_detail_category_items`,  `room_detail_category_item_details`
            USING `rooms`, `room_detail_categories`,  `room_detail_category_items`,  `room_detail_category_item_details`
            WHERE rooms.`id` = room_detail_categories.`room_id` AND room_detail_categories.`id` = room_detail_category_items.`room_details_category_id` AND room_detail_category_items.`id` = room_detail_category_item_details.`room_details_category_item_id` AND rooms.`id` = '$room_id'"; */
            $query = "DELETE rooms, room_detail_categories, room_detail_category_items, room_detail_category_item_details
            FROM rooms
            LEFT JOIN room_detail_categories ON rooms.`id` = room_detail_categories.`room_id`
            LEFT JOIN room_detail_category_items ON room_detail_categories.`id` = room_detail_category_items.`room_details_category_id` 
            LEFT JOIN room_detail_category_item_details ON room_detail_category_items.`id` = room_detail_category_item_details.`room_details_category_item_id`
            WHERE rooms.`id` = '$room_id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }
        }
        return $out;
    }

    function addRoomAjax(){
        $msg = $room_number = $room_name = $room_price = $room_adults = $room_children = $room_bed = $room_view = $room_size = 
        $room_subtitle = $room_overview_description = $room_description = $room_home_description = $room_overview_image = $room_header_bg_image = $room_home_image = '';
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room added successfully!";

        // room number validation
        if($out){
            if((isset($_POST['room_number'])) && ($_POST['room_number'] != '')){
                $room_number = $_POST['room_number'];
                $query = "SELECT COUNT(`room_number`) FROM `rooms` WHERE `room_number`='$room_number'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                if($row[0] > 0){
                    $out=false;
                    $msg='Room number already exist!';
                }
                if($out){
                    if(strlen($room_number) > 4){
                        $out = false;
                        $msg = 'Room number field cannot be more than 4 characters long';
                    }
                }
            }else{
                $out = false;
                $msg = 'Room number cannot be emtpy';
            }
        }

        // room name validation
        if($out){
            if((isset($_POST['room_name'])) && ($_POST['room_name'] != '')){
                $room_name = $_POST['room_name'];
                if(strlen($room_name) > 64){
                    $out = false;
                    $msg = 'Room size field cannot be more than 64 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room name cannot be emtpy';
            }
        }

        // room price validation
        if($out){
            if((isset($_POST['room_price'])) && ($_POST['room_price'] != '') && (filter_var($_POST['room_price'], FILTER_VALIDATE_FLOAT))){
                $room_price = $_POST['room_price'];
                if($room_price < 0){
                    $out = false;
                    $msg = 'Room price should be greather than 0 and positive number';
                }
            }else{
                $out = false;
                $msg = 'Room price cannot be emtpy and has to be a number';
            }
        }

        // room adluts limit validation
        if($out){
            if((isset($_POST['room_adults'])) && ($_POST['room_adults'] != '') && (preg_match('/^\d+$/',$_POST['room_adults']))){
                $room_adults = $_POST['room_adults'];
                if($room_adults < 0){
                    $out = false;
                    $msg = 'Room price should be greather than 0 and positive number';
                }
            }else{
                $out = false;
                $msg = 'Room adults limit cannot be emtpy and has to be a number';
            }
        }

        // room children limit validation
        if($out){
            if((isset($_POST['room_children'])) && ($_POST['room_children'] != '')){
                $room_children = $_POST['room_children'];
                if(!preg_match('/^\d+$/',$room_children)){
                    $out = false;
                    $msg = 'Room children limit cannot be emtpy and has to be a number';
                }
            }
        }

        // room room bed validation
        if($out){
            if((isset($_POST['room_bed'])) && ($_POST['room_bed'] != '')){
                $room_bed = $_POST['room_bed'];
                if(strlen($room_bed) > 50){
                    $out = false;
                    $msg = 'Room bed field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room bed cannot be emtpy and has to be a number';
            }
        }

        // room view validation
        if($out){
            if((isset($_POST['room_view'])) && ($_POST['room_view'] != '')){
                $room_view = $_POST['room_view'];
                if(strlen($room_view) > 50){
                    $out = false;
                    $msg = 'Room view field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room view cannot be emtpy and has to be a number';
            }
        }

        // room size validation
        if($out){
            if((isset($_POST['room_size'])) && ($_POST['room_size'] != '')){
                $room_size = $_POST['room_size'];
                if(strlen($room_size) > 50){
                    $out = false;
                    $msg = 'Room size field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room size cannot be emtpy and has to be a number';
            }
        }

        // room subtitle validation
        if($out){
            if((isset($_POST['room_subtitle'])) && ($_POST['room_subtitle'] != '')){
                $room_subtitle = $_POST['room_subtitle'];
                if(strlen($room_subtitle) > 64){
                    $out = false;
                    $msg = 'Room subtitle field cannot be more than 64 characters long';
                }
            }
        }

        // room overview description validation
        if($out){
            if((isset($_POST['room_overview_description'])) && ($_POST['room_overview_description'] != '')){
                $room_overview_description = $_POST['room_overview_description'];
            }
        }

        // room description validation
        if($out){
            if((isset($_POST['room_description'])) && ($_POST['room_description'] != '')){
                $room_description = $_POST['room_description'];
                if(strlen($room_description) > 255){
                    $out = false;
                    $msg = 'Room description field cannot be more than 255 characters long';
                }
            }
        }

        // room home description validation
        if($out){
            if((isset($_POST['room_home_description'])) && ($_POST['room_home_description'] != '')){
                $room_home_description = $_POST['room_home_description'];
                if(strlen($room_home_description) > 255){
                    $out = false;
                    $msg = 'Room home description field cannot be more than 255 characters long';
                }
            }
        }

        // room_overview_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_overview_image"])) {
                $target_dir = "images/rooms/";
                $target_file = $target_dir . basename($_FILES["room_overview_image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["room_overview_image"]["tmp_name"]);
                if($check == false) {
                    $msg = "Room overview image is not an image.";
                    $out = false;
                }

                // Check if file already exists
                if($out){
                    if (file_exists($target_file)) {
                        $msg = "Sorry, Room overview image file already exists. Upload new image or rename image file";
                        $out = false;
                    }
                }
                // Check file size
                if($out){
                    if ($_FILES["room_overview_image"]["size"] > 5000000) {
                        $msg = "Sorry, Room overview image file is too large. File must need to be within 5MB";
                        $out = false;
                    }
                }

                if($out){
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $msg =  "Sorry, for Room overview image only JPG, JPEG, PNG & GIF files are allowed.";
                        $out = false;
                    }
                }

                if($out){
                    if (!move_uploaded_file($_FILES["room_overview_image"]["tmp_name"], $target_file)) {
                        $msg =  "Sorry, there was an error uploading Room overview image file";
                        $out = false;
                    }else{
                        $room_overview_image = $target_dir . basename($_FILES["room_overview_image"]["name"]);
                    }
                }
            }
        }

        // room_header_bg_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_header_bg_image"])) {
                $target_dir = "images/headers/";
                $target_file = $target_dir . basename($_FILES["room_header_bg_image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["room_header_bg_image"]["tmp_name"]);
                if($check == false) {
                    $msg = "Room header background File is not an image.";
                    $out = false;
                }

                // Check if file already exists
                if($out){
                    if (file_exists($target_file)) {
                        $msg = "Sorry, Room header background file already exists. Upload new image or rename image file";
                        $out = false;
                    }
                }
                // Check file size
                if($out){
                    if ($_FILES["room_header_bg_image"]["size"] > 5000000) {
                        $msg = "Sorry, Room header background file is too large. File must need to be within 5MB";
                        $out = false;
                    }
                }

                if($out){
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $msg =  "Sorry, for Room header background only JPG, JPEG, PNG & GIF files are allowed.";
                        $out = false;
                    }
                }

                if($out){
                    if (!move_uploaded_file($_FILES["room_header_bg_image"]["tmp_name"], $target_file)) {
                        $msg =  "Sorry, there was an error uploading Room header background file";
                        $out = false;
                    }else{
                        $room_header_bg_image = $target_dir . basename($_FILES["room_header_bg_image"]["name"]);
                    }
                }
            }
        }

        // room_home_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_home_image"])) {
                $target_dir = "images/rooms/";
                $target_file = $target_dir . basename($_FILES["room_home_image"]["name"]);
                $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                $check = getimagesize($_FILES["room_home_image"]["tmp_name"]);
                if($check == false) {
                    $msg = "Room home image File is not an image.";
                    $out = false;
                }

                // Check if file already exists
                if($out){
                    if (file_exists($target_file)) {
                        $msg = "Sorry, room home image file already exists. Upload new image or rename image file";
                        $out = false;
                    }
                }
                // Check file size
                if($out){
                    if ($_FILES["room_home_image"]["size"] > 5000000) {
                        $msg = "Sorry, room home image file is too large. File must need to be within 5MB";
                        $out = false;
                    }
                }

                if($out){
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                    && $imageFileType != "gif" ) {
                        $msg =  "Sorry, for room home image only JPG, JPEG, PNG & GIF files are allowed.";
                        $out = false;
                    }
                }

                if($out){
                    if (!move_uploaded_file($_FILES["room_home_image"]["tmp_name"], $target_file)) {
                        $msg =  "Sorry, there was an error uploading room home image file";
                        $out = false;
                    }else{
                        $room_home_image = $target_dir . basename($_FILES["room_home_image"]["name"]);
                    }
                }
            }
        }

        // save data
        if($out){
            $query = "INSERT INTO `rooms` (`room_number`,`name`,`price`,`adults`,`children`,`bed`,`view`,`size`,`overview_subtitle`,`overview_decription`,`description`,`home_description`,`overview_image`,`header_bg_image`,`home_image`) 
            VALUES ('$room_number','$room_name','$room_price','$room_adults','$room_children','$room_bed','$room_view','$room_size','$room_subtitle','$room_overview_description','$room_description','$room_home_description','$room_overview_image', '$room_header_bg_image', '$room_home_image')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomDetails(){
        include('config.php');
        $out = true;
        global  $msg, $room_id, $room_number, $room_name, $room_price, $room_adults, $room_children, $room_bed, $room_view, $room_size, 
        $room_subtitle, $room_overview_description, $room_description, $room_home_description, $room_overview_image, $room_header_bg_image, 
        $room_home_image, $status, $currency;

        $msg = $room_number = $room_name = $room_price = $room_adults = $room_children = $room_bed = $room_view = $room_size = 
        $room_subtitle = $room_overview_description = $room_description = $room_home_description = $room_overview_image = $room_header_bg_image = 
        $room_home_image = $status = '';
        
        $currency = getCurrency();
        // id validation
        if((isset($_GET["id"])) &&  ($_GET["id"] != "")){
            $room_id = $_GET["id"];
            $query = "SELECT COUNT(`id`) FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            if(!($row[0] > 0)){
                $out=false;
                $msg='This room dose not exist in our system!';
                header('Location: index.php?components=admin&action=rooms&re=fail&message='.$msg);
            }
        }
        if($out){
            $query = "SELECT `id`,`room_number`,`name`,`price`,`adults`,`children`,`bed`,`view`,`size`,`overview_subtitle`,`overview_decription`,`description`,`home_description`,`status`,`overview_image`,`header_bg_image`,`home_image` FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $room_id = $row[0];
            $room_number = $row[1];
            $room_name = $row[2];
            $room_price = $row[3];
            $room_adults = $row[4];
            $room_children = $row[5];
            $room_bed = $row[6];
            $room_view = $row[7];
            $room_size = $row[8];
            $room_subtitle = $row[9];
            $room_overview_description = $row[10];
            $room_description = $row[11];
            $room_home_description = $row[12];
            $status = $row[13];
            $room_overview_image = $row[14];
            $room_header_bg_image = $row[15];
            $room_home_image = $row[16];
        }
    }

    function updateRoomAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room updated successfully!";
        $room_number = $room_name = $room_price = $room_adults = $room_children = $room_bed = $room_view = $room_size = 
        $room_subtitle = $room_overview_description = $room_description = $room_home_description = $room_overview_image = $room_header_bg_image = $room_home_image = '';
        $room_status = 0;

        // id validation
        if((isset($_POST["room_id"])) &&  ($_POST["room_id"] != "")){
            $room_id = $_POST["room_id"];
            $query = "SELECT COUNT(`id`) FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            if(!($row[0] > 0)){
                $out=false;
                $msg='This room dose not exist in our system!';
            }
        }

        // room number validation
        if($out){
            if((isset($_POST['room_number'])) && ($_POST['room_number'] != '')){
                $room_number = $_POST['room_number'];
                $query = "SELECT COUNT(`room_number`) FROM `rooms` WHERE `room_number`='$room_number'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                if($row[0] > 1){
                    $out=false;
                    $msg='Room number already exist!';
                }
                if($out){
                    if(strlen($room_number) > 4){
                        $out = false;
                        $msg = 'Room number field cannot be more than 4 characters long';
                    }
                }
            }else{
                $out = false;
                $msg = 'Room number cannot be emtpy';
            }
        }

        // room name validation
        if($out){
            if((isset($_POST['room_name'])) && ($_POST['room_name'] != '')){
                $room_name = $_POST['room_name'];
                if(strlen($room_name) > 64){
                    $out = false;
                    $msg = 'Room size field cannot be more than 64 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room name cannot be emtpy';
            }
        }

        // room price validation
        if($out){
            if((isset($_POST['room_price'])) && ($_POST['room_price'] != '') && (filter_var($_POST['room_price'], FILTER_VALIDATE_FLOAT))){
                $room_price = $_POST['room_price'];
                if($room_price < 0){
                    $out = false;
                    $msg = 'Room price should be greather than 0 and positive number';
                }
            }else{
                $out = false;
                $msg = 'Room price cannot be emtpy and has to be a number';
            }
        }

        // room adluts limit validation
        if($out){
            if((isset($_POST['room_adults'])) && ($_POST['room_adults'] != '') && (preg_match('/^\d+$/',$_POST['room_adults']))){
                $room_adults = $_POST['room_adults'];
                if($room_adults < 0){
                    $out = false;
                    $msg = 'Room price should be greather than 0 and positive number';
                }
            }else{
                $out = false;
                $msg = 'Room adults limit cannot be emtpy and has to be a number';
            }
        }

        // room children limit validation
        if($out){
            if((isset($_POST['room_children'])) && ($_POST['room_children'] != '')){
                $room_children = $_POST['room_children'];
                if(!preg_match('/^\d+$/',$room_children)){
                    $out = false;
                    $msg = 'Room children limit cannot be emtpy and has to be a number';
                }
            }
        }

        // room room bed validation
        if($out){
            if((isset($_POST['room_bed'])) && ($_POST['room_bed'] != '')){
                $room_bed = $_POST['room_bed'];
                if(strlen($room_bed) > 50){
                    $out = false;
                    $msg = 'Room bed field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room bed cannot be emtpy and has to be a number';
            }
        }

        // room view validation
        if($out){
            if((isset($_POST['room_view'])) && ($_POST['room_view'] != '')){
                $room_view = $_POST['room_view'];
                if(strlen($room_view) > 50){
                    $out = false;
                    $msg = 'Room view field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room view cannot be emtpy and has to be a number';
            }
        }

        // room size validation
        if($out){
            if((isset($_POST['room_size'])) && ($_POST['room_size'] != '')){
                $room_size = $_POST['room_size'];
                if(strlen($room_size) > 50){
                    $out = false;
                    $msg = 'Room size field cannot be more than 50 characters long';
                }
            }else{
                $out = false;
                $msg = 'Room size cannot be emtpy and has to be a number';
            }
        }

        // room subtitle validation
        if($out){
            if((isset($_POST['room_subtitle'])) && ($_POST['room_subtitle'] != '')){
                $room_subtitle = $_POST['room_subtitle'];
                if(strlen($room_subtitle) > 64){
                    $out = false;
                    $msg = 'Room subtitle field cannot be more than 64 characters long';
                }
            }
        }

        // room overview description validation
        if($out){
            if((isset($_POST['room_overview_description'])) && ($_POST['room_overview_description'] != '')){
                $room_overview_description = $_POST['room_overview_description'];
            }
        }

        // room description validation
        if($out){
            if((isset($_POST['room_description'])) && ($_POST['room_description'] != '')){
                $room_description = $_POST['room_description'];
                if(strlen($room_description) > 255){
                    $out = false;
                    $msg = 'Room description field cannot be more than 255 characters long';
                }
            }
        }

        // room home description validation
        if($out){
            if((isset($_POST['room_home_description'])) && ($_POST['room_home_description'] != '')){
                $room_home_description = $_POST['room_home_description'];
                if(strlen($room_home_description) > 255){
                    $out = false;
                    $msg = 'Room home description field cannot be more than 255 characters long';
                }
            }
        }

        // get db images
        if($out){
            $query = "SELECT `overview_image`,`header_bg_image`,`home_image` FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $room_overview_image = $row[0];
            $room_header_bg_image = $row[1];
            $room_home_image = $row[2];
        }

        // room_overview_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_overview_image"])) {
                if($_FILES["room_overview_image"]["tmp_name"] != ''){
                    $target_dir = "images/rooms/";
                    $target_file = $target_dir . basename($_FILES["room_overview_image"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["room_overview_image"]["tmp_name"]);
                    if($check == false) {
                        $msg = "Room overview image is not an image.";
                        $out = false;
                    }

                    // Check if file already exists
                    if($out){
                        if (file_exists($target_file)) {
                            $msg = "Sorry, Room overview image file already exists. Upload new image or rename image file";
                            $out = false;
                        }
                    }
                    // Check file size
                    if($out){
                        if ($_FILES["room_overview_image"]["size"] > 5000000) {
                            $msg = "Sorry, Room overview image file is too large. File must need to be within 5MB";
                            $out = false;
                        }
                    }

                    if($out){
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            $msg =  "Sorry, for Room overview image only JPG, JPEG, PNG & GIF files are allowed.";
                            $out = false;
                        }
                    }

                    // delete overview_image of room
                    if($out){
                        $query = "SELECT `overview_image` FROM `rooms` WHERE `id`='$room_id'";
                        $result = mysqli_query($conn,$query);
                        while($row=mysqli_fetch_array($result)){
                            if($row[0] != ''){
                                if(!unlink($row[0])){
                                    $out = false;
                                    $msg = 'Room home image delete error';
                                } 
                            }
                        }
                    }

                    if($out){
                        if (!move_uploaded_file($_FILES["room_overview_image"]["tmp_name"], $target_file)) {
                            $msg =  "Sorry, there was an error uploading Room overview image file";
                            $out = false;
                        }else{
                            $room_overview_image = $target_dir . basename($_FILES["room_overview_image"]["name"]);
                        }
                    }
                }
            }
        }

        // room_header_bg_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_header_bg_image"])) {
                if($_FILES["room_header_bg_image"]["tmp_name"] != ''){
                    $target_dir = "images/headers/";
                    $target_file = $target_dir . basename($_FILES["room_header_bg_image"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["room_header_bg_image"]["tmp_name"]);
                    if($check == false) {
                        $msg = "Room header background File is not an image.";
                        $out = false;
                    }

                    // Check if file already exists
                    if($out){
                        if (file_exists($target_file)) {
                            $msg = "Sorry, Room header background file already exists. Upload new image or rename image file";
                            $out = false;
                        }
                    }
                    // Check file size
                    if($out){
                        if ($_FILES["room_header_bg_image"]["size"] > 5000000) {
                            $msg = "Sorry, Room header background file is too large. File must need to be within 5MB";
                            $out = false;
                        }
                    }

                    if($out){
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            $msg =  "Sorry, for Room header background only JPG, JPEG, PNG & GIF files are allowed.";
                            $out = false;
                        }
                    }

                    // delete header_bg_image of room
                    if($out){
                        $query = "SELECT `header_bg_image` FROM `rooms` WHERE `id`='$room_id'";
                        $result = mysqli_query($conn,$query);
                        while($row=mysqli_fetch_array($result)){
                            if($row[0] != ''){
                                if(!unlink($row[0])){
                                    $out = false;
                                    $msg = 'Room header background image delete error';
                                } 
                            }
                        }
                    }

                    if($out){
                        if (!move_uploaded_file($_FILES["room_header_bg_image"]["tmp_name"], $target_file)) {
                            $msg =  "Sorry, there was an error uploading Room header background file";
                            $out = false;
                        }else{
                            $room_header_bg_image = $target_dir . basename($_FILES["room_header_bg_image"]["name"]);
                        }
                    }
                }
            }
        }

        // room_home_image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["room_home_image"])) {
                if($_FILES["room_home_image"]["tmp_name"] != ''){
                    $target_dir = "images/rooms/";
                    $target_file = $target_dir . basename($_FILES["room_home_image"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["room_home_image"]["tmp_name"]);
                    if($check == false) {
                        $msg = "Room home image File is not an image.";
                        $out = false;
                    }

                    // Check if file already exists
                    if($out){
                        if (file_exists($target_file)) {
                            $msg = "Sorry, room home image file already exists. Upload new image or rename image file";
                            $out = false;
                        }
                    }
                    // Check file size
                    if($out){
                        if ($_FILES["room_home_image"]["size"] > 5000000) {
                            $msg = "Sorry, room home image file is too large. File must need to be within 5MB";
                            $out = false;
                        }
                    }

                    if($out){
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            $msg =  "Sorry, for room home image only JPG, JPEG, PNG & GIF files are allowed.";
                            $out = false;
                        }
                    }

                    // delete home_image of room
                    if($out){
                        $query = "SELECT `home_image` FROM `rooms` WHERE `id`='$room_id'";
                        $result = mysqli_query($conn,$query);
                        while($row=mysqli_fetch_array($result)){
                            if($row[0] != ''){
                                if(!unlink($row[0])){
                                    $out = false;
                                    $msg = 'Room home image delete error';
                                } 
                            }
                        }
                    }

                    if($out){
                        if (!move_uploaded_file($_FILES["room_home_image"]["tmp_name"], $target_file)) {
                            $msg =  "Sorry, there was an error uploading room home image file";
                            $out = false;
                        }else{
                            $room_home_image = $target_dir . basename($_FILES["room_home_image"]["name"]);
                        }
                    }
                }
            }
        }

        // status validation
        if((isset($_POST["room_status"])) &&  ($_POST["room_status"] != "")){
            $room_status = $_POST["room_status"];
        }
        
        // update data
        if($out){
            $query = "UPDATE `rooms` SET `room_number` = '$room_number', `name` = '$room_name', `price` = '$room_price', `adults` = '$room_adults', `children` = '$room_children', `bed` = '$room_bed',
            `view` = '$room_view', `size` = '$room_size', `overview_subtitle` = '$room_subtitle', `overview_decription` = '$room_overview_description',`description` = '$room_description', `home_description` = '$room_home_description', `overview_image` = '$room_overview_image', `header_bg_image` = '$room_header_bg_image', `home_image` = '$room_home_image', `status` = '$room_status' WHERE `id` = '$room_id'";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomsImages(){
        include('config.php');
        global $room_id, $room_no, $room_name;
        $room_id = $room_no = $room_name = array();

        $query = "SELECT `id`, `room_number`,`name` FROM `rooms`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $room_id[] = $row[0];
            $room_no[] = $row[1];
            $room_name[] = $row[2]; 
        }
    }

    function deleteRoomInsideImagesAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $room_id='';
        $msg="Room images deleted successfully!";

        // room id validation
        if($out){
            if((isset($_POST['room_id'])) && ($_POST['room_id'] != '') && (preg_match('/^\d+$/',$_POST['room_id']))){
                $room_id = $_POST['room_id'];
                $query = "SELECT `id` FROM `rooms` WHERE `id`='$room_id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_room_id = $row[0];
                
                if($db_room_id == ''){
                    $out=false;
                    $msg='Please re-check your selected room.';
                }
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }
        // delete room inslide slider images from server
        if($out){
            $query = "SELECT `image` FROM `room_images` WHERE `room_id`='$room_id'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_array($result)){
                if($row[0] != ''){
                    if(!unlink($row[0])){
                        $out = false;
                        $msg = 'Room inslide image delete error';
                    } 
                }
            }
        }

        // delete room images from db
        if($out){
            $query="DELETE FROM `room_images` WHERE `room_id` = '$room_id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status='success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomImages(){
        include('config.php');
        $out = true;
        global  $room_id, $image_ids, $room_number, $room_name, $room_images;

        $room_images = $image_ids = array();
        
        // id validation
        if((isset($_GET["id"])) &&  ($_GET["id"] != "")){
            $room_id = $_GET["id"];
            $query = "SELECT `id`,`room_number`,`name` FROM `rooms` WHERE `id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $row=mysqli_fetch_row($result);
            $rows = mysqli_num_rows($result);
            $room_id = $row[0];
            $room_number = $row[1];
            $room_name = $row[2];
            if(!($rows > 0)){
                $out=false;
                $msg='This room dose not exist in our system!';
                header('Location: index.php?components=admin&action=room_inside_images&re=fail&message='.$msg);
            }
        }

        if($out){
            $query = "SELECT `id`,`image` FROM `room_images` WHERE `room_id`='$room_id'";
            $result = mysqli_query($conn,$query);
            $image_count = 1;
            while($row=mysqli_fetch_array($result)){
                $image_ids[] =$row[0];
                $room_images[] = $row[1];
            }
        }
    }

    function saveRoomInsideImageAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $room_id = $image =  $text =  '';
        $msg="Room inside slider image added successfully!";

        // room id validation
        if($out){
            if((isset($_POST['room_id'])) && ($_POST['room_id'] != '') && (preg_match('/^\d+$/',$_POST['room_id']))){
                $room_id = $_POST['room_id'];
                $query = "SELECT `id` FROM `rooms` WHERE `id`='$room_id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_room_id = $row[0];
                
                if($db_room_id == ''){
                    $out=false;
                    $msg='Please re-check your selected room.';
                }
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }

        // text validation
        if($out){
            if((isset($_POST['text'])) && ($_POST['text'] != '')){
                $text = $_POST['text'];
                if(strlen($text) > 255){
                    $out = false;
                    $msg = 'Text field cannot be more than 255 characters long';
                }
            }
        }

        // image image upload
        if($out){
            // Check if image file is a actual image or fake image
            if(isset($_FILES["image_file"])) {
                if($_FILES["image_file"]["tmp_name"] != ''){
                    $target_dir = "images/room/";
                    $target_file = $target_dir . basename($_FILES["image_file"]["name"]);
                    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

                    $check = getimagesize($_FILES["image_file"]["tmp_name"]);
                    if($check == false) {
                        $msg = "Room image file is not an image.";
                        $out = false;
                    }

                    // Check if file already exists
                    if($out){
                        if (file_exists($target_file)) {
                            $msg = "Sorry, image file already exists. Upload new image or rename image file";
                            $out = false;
                        }
                    }
                    // Check file size
                    if($out){
                        if ($_FILES["image_file"]["size"] > 5000000) {
                            $msg = "Sorry, image file is too large. File must need to be within 5MB";
                            $out = false;
                        }
                    }

                    if($out){
                        // Allow certain file formats
                        if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                        && $imageFileType != "gif" ) {
                            $msg =  "Sorry, image only JPG, JPEG, PNG & GIF files are allowed.";
                            $out = false;
                        }
                    }

                    if($out){
                        if (!move_uploaded_file($_FILES["image_file"]["tmp_name"], $target_file)) {
                            $msg =  "Sorry, there was an error uploading image file";
                            $out = false;
                        }else{
                            $image = $target_dir . basename($_FILES["image_file"]["name"]);
                        }
                    }
                }else{
                    $out = false;
                    $msg = "Please select an image to upload";
                }
            }else{
                $out = false;
                $msg = "Please select an image to upload";
            }
        }

        // save db
        if($out){
            $query = "INSERT INTO `room_images` (`room_id`,`image`,`text`) 
            VALUES ('$room_id','$image','$text')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function deleteRoomInsideImageAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $image_id='';
        $msg="Room inslide slider image deleted successfully!";

        // room id validation
        if($out){
            if((isset($_POST['image_id'])) && ($_POST['image_id'] != '') && (preg_match('/^\d+$/',$_POST['image_id']))){
                $image_id = $_POST['image_id'];
                $query = "SELECT `id`,`image` FROM `room_images` WHERE `id`='$image_id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_room_id = $row[0];
                $db_image = $row[1];
                if($db_room_id == ''){
                    $out=false;
                    $msg='Please re-check your selected image.';
                }
            }else{
                $out = false;
                $msg = 'Image cannot be emtpy';
            }
        }

        // delete room inslide slider image from server
        if($out){
            if(!unlink($db_image)){
                $out = false;
                $msg = 'Room inslide image delete error';
            }     
        }

        // delete room images from db
        if($out){
            $query="DELETE FROM `room_images` WHERE `id` = '$image_id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status='success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomsDetailCategories(){
        include('config.php');
        global  $room_id, $room_no, $room_name, $detail_category_id, $detail_category, $detail_category_text, $detail_category_status;
        $room_id = $room_no = $room_name = $detail_category_id = $detail_category = $detail_category_text = $detail_category_status = array();

        $query = "SELECT rd.`id`, rd.`room_id`, r.`room_number`, r.`name`, rd.`name`, rd.`text`, rd.`status` FROM `room_detail_categories` rd, `rooms` r WHERE r.`id` = rd.`room_id`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $detail_category_id[] =$row[0];
            $room_id[] = $row[1];
            $room_no[] = $row[2];
            $room_name[] = $row[3];
            $detail_category[] = $row[4];
            $detail_category_text[] = $row[5];
            if($row[6] == 1) $detail_category_status[] = "ACTIVE";  else  $detail_category_status[] = "INACTIVE"; 
        }
    }

    function getRoomNumbers(){
        include('config.php');
        global  $room_id, $room_no, $room_name;
        $room_id = $room_no = $room_name = array();

        $query = "SELECT `id`, `room_number`,`name` FROM `rooms`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $room_id[] =$row[0];
            $room_no[] = $row[1];
            $room_name[] = $row[2];
        }
    }

    function addRoomDetailCategoryAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $room_id = $name =  $text =  $text2 = '';
        $msg="Room detail category added successfully!";

        // room id validation
        if($out){
            if((isset($_POST['room_id'])) && ($_POST['room_id'] != '') && (preg_match('/^\d+$/',$_POST['room_id']))){
                $room_id = $_POST['room_id'];
                $query = "SELECT `id` FROM `rooms` WHERE `id`='$room_id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_room_id = $row[0];
                if($db_room_id == ''){
                    $out=false;
                    $msg='Please re-check your selected room.';
                }
            }else{
                $out = false;
                $msg = 'Room cannot be emtpy';
            }
        }

        // detail category name validation
        if($out){
            if((isset($_POST['name'])) && ($_POST['name'] != '')){
                $name = $_POST['name'];
                if(strlen($name) > 32){
                    $out = false;
                    $msg = 'Detail category name cannot be more than 32 characters long';
                }
            }else{
                $out = false;
                $msg = 'Detail category name cannot be emtpy';
            }
        }

        // detail category text validation
        if($out){
            if((isset($_POST['text'])) && ($_POST['text'] != '')){
                $text = $_POST['text'];
            }else{
                $out = false;
                $msg = 'Detail category text cannot be emtpy';
            }
        }

        // detail category text validation
        if($out){
            if((isset($_POST['text2'])) && ($_POST['text2'] != '')){
                $text2 = $_POST['text2'];
            }else{
                $out = false;
                $msg = 'Detail category text for room availability cannot be emtpy';
            }
        }

        // save data
        if($out){
            $query = "INSERT INTO `room_detail_categories` (`room_id`,`name`,`text`,`room_avilability_text`) VALUES ('$room_id','$name','$text','$text2')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomDetailCategory(){
        include('config.php');
        $out = true;
        $id = '';
        global  $msg, $room_no, $room_name, $detail_category_id, $detail_category, $detail_category_text, $detail_category_room_avilability_text, $detail_category_status;

         // id validation
         if((isset($_GET["id"])) &&  ($_GET["id"] != "")){
            $id = $_GET["id"];
            $query = "SELECT `id` FROM `room_detail_categories` WHERE `id`='$id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category dose not exist in our system!';
                header('Location: index.php?components=admin&action=room_inside_details&re=fail&message='.$msg);
            }
        }

        if($out){
            $query = "SELECT rd.`id`, r.`room_number`, r.`name`, rd.`name`, rd.`text`, rd.`room_avilability_text`, rd.`status` FROM `room_detail_categories` rd, `rooms` r WHERE r.`id` = rd.`room_id` AND rd.`id` = '$id'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_row($result)){
                $detail_category_id =$row[0];
                $room_no = $row[1];
                $room_name = $row[2];
                $detail_category = $row[3];
                $detail_category_text = $row[4];
                $detail_category_room_avilability_text = $row[5];
                $detail_category_status = $row[6];
            }
        }
    }

    function updateRoomDetailCategoryAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room detail category updated successfully!";
        $detail_category_id = $name = $text = $text2 = $status = '';

        // id validation
        if((isset($_POST["detail_category_id"])) &&  ($_POST["detail_category_id"] != "")){
            $detail_category_id = $_POST["detail_category_id"];
            $query = "SELECT `id` FROM `room_detail_categories` WHERE `id`='$detail_category_id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category dose not exist in our system!';
            }
        }

        // detail category name validation
        if($out){
            if((isset($_POST['name'])) && ($_POST['name'] != '')){
                $name = $_POST['name'];
                if(strlen($name) > 32){
                    $out = false;
                    $msg = 'Detail category name cannot be more than 32 characters long';
                }
            }else{
                $out = false;
                $msg = 'Detail category name cannot be emtpy';
            }
        }

        // detail category text validation
        if($out){
            if((isset($_POST['text'])) && ($_POST['text'] != '')){
                $text = $_POST['text'];
            }else{
                $out = false;
                $msg = 'Detail category text cannot be emtpy';
            }
        }

        // detail category text validation
        if($out){
            if((isset($_POST['text2'])) && ($_POST['text2'] != '')){
                $text2 = $_POST['text2'];
            }else{
                $out = false;
                $msg = 'Detail category text for room availability cannot be emtpy';
            }
        }

        // status validation
        if((isset($_POST["status"])) &&  ($_POST["status"] != "")){
            $status = $_POST["status"];
        }

        // update data
        if($out){
            $query = "UPDATE `room_detail_categories` SET `name` = '$name', `text` = '$text', `room_avilability_text` = '$text2', `status` = '$status' WHERE `id` = '$detail_category_id'";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function deleteRoomDetailCategoryAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $detail_category_id = '';
        $room_detail_category_items_ids = array();
        $msg="Room detail category deleted successfully!";


        // id validation detail_category_id
        if((isset($_POST["detail_category_id"])) &&  ($_POST["detail_category_id"] != "")){
            $detail_category_id = $_POST["detail_category_id"];
            $query = "SELECT `id` FROM `room_detail_categories` WHERE `id`='$detail_category_id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category dose not exist in our system!';
            }
        }

        if($out){
            //$query="DELETE FROM `room_detail_category_item_details` WHERE `room_details_category_id` = '$detail_category_id'";
            $query="DELETE room_detail_categories, room_detail_category_items, room_detail_category_item_details
            FROM room_detail_categories
            LEFT JOIN room_detail_category_items ON room_detail_categories.`id` = room_detail_category_items.`room_details_category_id` 
            LEFT JOIN room_detail_category_item_details ON room_detail_category_items.`id` = room_detail_category_item_details.`room_details_category_item_id`
            WHERE room_detail_categories.`id` = '$detail_category_id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status = 'success';
            }

            // if($out){
            //     $query="DELETE FROM `room_detail_category_items` WHERE `room_details_category_id` = '$detail_category_id'";
            //     $result=mysqli_query($conn,$query);
            //     if(!$result){
            //         $out = false;
            //         $msg = 'Something went to wrong. Please try again.';
            //     }
            // }

            // if($out){
            //     $query="DELETE FROM `room_detail_categories` WHERE `id` = '$detail_category_id'";
            //     $result=mysqli_query($conn,$query);
            //     if(!$result){
            //         $out = false;
            //         $msg = 'Something went to wrong. Please try again.';
            //     }else{
            //         $status = 'success';
            //     }
            // }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function deleteRoomDetailCategoryItemAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $room_detail_category_item_id = '';
        $msg="Room detail category item deleted successfully!";


        // id validation
        if((isset($_POST["room_detail_category_item_id"])) &&  ($_POST["room_detail_category_item_id"] != "")){
            $room_detail_category_item_id = $_POST["room_detail_category_item_id"];
            $query = "SELECT `id` FROM `room_detail_category_items` WHERE `id`='$room_detail_category_item_id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category item dose not exist in our system!';
            }
        }else{
            $out=false;
            $msg='Detail category item cannot be empty!';
        }

        if($out){
            //$query="DELETE FROM `room_detail_category_item_details` WHERE `room_details_category_item_id` = '$room_detail_category_item_id'";
            /* $query="DELETE FROM `room_detail_category_items`, `room_detail_category_item_details`
            USING `room_detail_category_items`,  `room_detail_category_item_details`
            WHERE room_detail_category_items.`id` = room_detail_category_item_details.`room_details_category_item_id` AND room_detail_category_items.`id` = '$room_detail_category_item_id'"; */
            $query="DELETE room_detail_category_items, room_detail_category_item_details
            FROM room_detail_category_items 
            LEFT JOIN room_detail_category_item_details ON room_detail_category_items.`id` = room_detail_category_item_details.`room_details_category_item_id`
            WHERE room_detail_category_items.`id` = '$room_detail_category_item_id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status = 'success';
            }

            // if($out){
            //     $query="DELETE FROM `room_detail_category_items` WHERE `id` = '$room_detail_category_item_id'";
            //     $result=mysqli_query($conn,$query);
            //     if(!$result){
            //         $out = false;
            //         $msg = 'Something went to wrong. Please try again.';
            //     }else{
            //         $status = 'success';
            //     }
            // }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomDetailCategoriesItems(){
        include('config.php');
        $id = '';
        global  $id, $room_detail_category_item_id, $room_detail_category_item_text, $room_detail_category;
        $room_detail_category_item_id = $room_detail_category_item_text = $room_detail_category = array();

        if((isset($_GET["id"])) &&  ($_GET["id"] != "")){
            $id = $_GET["id"];
        }

        $query = "SELECT rdci.`id`, rdci.`text`, rdc.`name` FROM `room_detail_category_items` rdci, `room_detail_categories` rdc WHERE rdc.`id`=rdci.`room_details_category_id` AND rdc.`id`='$id'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $room_detail_category_item_id[] =$row[0];
            $room_detail_category_item_text[] = $row[1];
            $room_detail_category[] = $row[2];
        }
    }

    function addRoomDetailCategoryItemAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room detail category item added successfully!";
        $id = $name = '';

         // id validation
         if((isset($_POST["room_detail_category_id"])) &&  ($_POST["room_detail_category_id"] != "")){
            $id = $_POST["room_detail_category_id"];
            $query = "SELECT `id` FROM `room_detail_categories` WHERE `id`='$id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category dose not exist in our system!';
            }
        }

        // text validation
        if($out){
            if((isset($_POST["room_detail_category_item_name"])) &&  ($_POST["room_detail_category_item_name"] != "")){
                $name = $_POST["room_detail_category_item_name"];
                if(strlen($name) > 20){
                    $out = false;
                    $msg = 'Room detail category item name cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Detail category item name cannot be emtpy';
            }
        }

        // save 
        if($out){
            $query = "INSERT INTO `room_detail_category_items` (`room_details_category_id`,`text`) VALUES ('$id','$name')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomDetailsCategoryItemsSubItems(){
        include('config.php');
        $id = '';
        global  $room_detail_category_item_id_1, $room_detail_category_item_text_1, $room_detail_category_1, $room_detail_category_item_details_text;
        $room_detail_category_item_id_1 = $room_detail_category_item_text_1 = $room_detail_category_1 = $room_detail_category_item_details_text = array();

        if((isset($_GET["id"])) &&  ($_GET["id"] != "")){
            $id = $_GET["id"];
        }

        $query = "SELECT rdcid.`id`, rdci.`text`, rdc.`name`, rdcid.`text` FROM `room_detail_category_items` rdci, `room_detail_categories` rdc, `room_detail_category_item_details` rdcid WHERE rdc.`id`=rdci.`room_details_category_id` AND rdci.`id` = rdcid.`room_details_category_item_id` AND rdc.`id`='$id' AND rdcid.`status` = '1'";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $room_detail_category_item_id_1[] =$row[0];
            $room_detail_category_item_text_1[] = $row[1];
            $room_detail_category_1[] = $row[2];
            $room_detail_category_item_details_text[] = $row[3];
        }
    }

    function addRoomDetailCategoryItemSubItemAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room detail category item sub item added successfully!";
        $room_detail_category =  $room_detail_category_item_id = $text = '';

        //  category id validation
        //  if((isset($_POST["room_detail_category_id"])) &&  ($_POST["room_detail_category_id"] != "")){
        //     $room_detail_category = $_POST["room_detail_category_id"];
        //     $query = "SELECT `id` FROM `room_detail_categories` WHERE `id`='$room_detail_category'";
        //     $result = mysqli_query($conn,$query);
        //     $rows = mysqli_num_rows($result);
        //     if(!($rows > 0)){
        //         $out=false;
        //         $msg='This detail category dose not exist in our system!';
        //     }
        // }else{
        //     $out = false;
        //     $msg='Detail category cannot be empty!';
        // }

        // category item id validation
        if((isset($_POST["room_detail_category_item_id"])) &&  ($_POST["room_detail_category_item_id"] != "")){
            $room_detail_category_item_id = $_POST["room_detail_category_item_id"];
            $query = "SELECT `id` FROM `room_detail_category_items` WHERE `id`='$room_detail_category_item_id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category item dose not exist in our system!';
            }
        }else{
            $out = false;
            $msg='Detail category item cannot be empty!';
        }

        // text validation
        if($out){
            if((isset($_POST["room_detail_category_item_sub_item_text"])) &&  ($_POST["room_detail_category_item_sub_item_text"] != "")){
                $text = $_POST["room_detail_category_item_sub_item_text"];
                if(strlen($text) > 20){
                    $out = false;
                    $msg = 'Room detail category item sub item text cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Detail category item sub item text cannot be emtpy';
            }
        }

        // save 
        if($out){
            //$query = "INSERT INTO `room_detail_category_item_details` (`room_details_category_id`,`room_details_category_item_id`,`text`) VALUES ('$room_detail_category','$room_detail_category_item_id','$text')";
            $query = "INSERT INTO `room_detail_category_item_details` (`room_details_category_item_id`,`text`) VALUES ('$room_detail_category_item_id','$text')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function deleteRoomDetailCategoryItemSubItemAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $room_details_category_item_sub_item = '';
        $msg="Room detail category item sub item deleted successfully!";


        // id validation
        if((isset($_POST["room_details_category_item_sub_item"])) &&  ($_POST["room_details_category_item_sub_item"] != "")){
            $room_details_category_item_sub_item = $_POST["room_details_category_item_sub_item"];
            $query = "SELECT `id` FROM `room_detail_category_item_details` WHERE `id`='$room_details_category_item_sub_item'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This detail category item sub item dose not exist in our system!';
            }
        }else{
            $out=false;
            $msg='Detail category item sub item cannot be empty!';
        }

        if($out){
            $query="DELETE FROM `room_detail_category_item_details` WHERE `id` = '$room_details_category_item_sub_item'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomBookingMealPalns(){
        global $id, $name, $description, $price, $status;
        $id = $name = $description = $price = $status = array();
        include('config.php');

        $query = "SELECT `id`,`name`,`description`,`price_per_head`,`status` FROM `room_booking_meal_plans`";
        $result = mysqli_query($conn,$query);
        while($row=mysqli_fetch_array($result)){
            $id[] = $row[0];
            $name[] = $row[1];
            $description[] = $row[2];
            $price[] = $row[3];
            if($row[4] == 1){ $status[] = 'ACTIVE'; } else { $status[] = 'INACTIVE'; }
        }
    }

    function addRoomBookingMealPlanAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room booking meal plan added successfully!";
        $name = $price = $description;

        // name validation
        if($out){
            if((isset($_POST["name"])) &&  ($_POST["name"] != "")){
                $name = $_POST["name"];
                if(strlen($name) > 20){
                    $out = false;
                    $msg = 'Name text cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Name cannot be emtpy';
            }
        }

        // description validation
        if($out){
            if((isset($_POST["description"])) &&  ($_POST["description"] != "")){
                $description = $_POST["description"];
                if(strlen($description) > 255){
                    $out = false;
                    $msg = 'Description text cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Description cannot be emtpy';
            }
        }

        // price validation
        if($out){
            if((isset($_POST["price"])) &&  ($_POST["price"] != "") && (filter_var($_POST["price"], FILTER_VALIDATE_FLOAT))){
                $price = $_POST["price"];
            }else{
                $out=false;
                $msg='Price cannot be emtpy and has to be a number';
            }
        }

        // save
        if($out){
            $query = "INSERT INTO `room_booking_meal_plans` (`name`,`description`,`price_per_head`) 
            VALUES ('$name','$description','$price')";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function getRoomBookingMealPlan(){
        global $msg, $id, $name, $description, $price, $meal_plan_status;
        include('config.php');
        $out = true;

        // id validation
        if($out){
            if((isset($_GET['id'])) && ($_GET['id'] != '') && (preg_match('/^\d+$/',$_GET['id']))){
                $id = $_GET['id'];
                $query = "SELECT `id` FROM `room_booking_meal_plans` WHERE `id`='$id'";
                $result = mysqli_query($conn,$query);
                $row=mysqli_fetch_row($result);
                $db_id = $row[0];
                if($db_id == ''){
                    $out=false;
                    $msg='Please re-check your selected meal plan.';
                }
            }else{
                $out = false;
                $msg = 'Meal plan cannot be emtpy';
            }
        }

        if($out){
            $query = "SELECT `id`,`name`,`description`,`price_per_head`,`status` FROM `room_booking_meal_plans` WHERE `id`='$id'";
            $result = mysqli_query($conn,$query);
            while($row=mysqli_fetch_row($result)){
                $id = $row[0];
                $name = $row[1];
                $description = $row[2];
                $price = $row[3];
                $meal_plan_status = $row[4];
            }
        }
    }

    function updateRoomBookingMealPlanAjax(){
        include('config.php');
        $out=true;
        $status='error';
        $msg="Room booking meal plan updated successfully!";
        $id = $name = $description = $price = $meal_plan_status = '';

        // id validation
        if((isset($_POST["id"])) &&  ($_POST["id"] != "")){
            $id = $_POST["id"];
            $query = "SELECT `id` FROM `room_booking_meal_plans` WHERE `id`='$id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This meal plan dose not exist in our system!';
            }
        }

        // name validation
        if($out){
            if((isset($_POST["name"])) &&  ($_POST["name"] != "")){
                $name = $_POST["name"];
                if(strlen($name) > 20){
                    $out = false;
                    $msg = 'Name text cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Name cannot be emtpy';
            }
        }

        // description validation
        if($out){
            if((isset($_POST["description"])) &&  ($_POST["description"] != "")){
                $description = $_POST["description"];
                if(strlen($description) > 255){
                    $out = false;
                    $msg = 'Description text cannot be more than 20 characters long';
                }
            }else{
                $out=false;
                $msg='Description cannot be emtpy';
            }
        }

        // price validation
        if($out){
            if((isset($_POST["price"])) &&  ($_POST["price"] != "") && (filter_var($_POST["price"], FILTER_VALIDATE_FLOAT))){
                $price = $_POST["price"];
            }else{
                $out=false;
                $msg='Price cannot be emtpy and has to be a number';
            }
        }

        // status validation
        if((isset($_POST["meal_plan_status"])) &&  ($_POST["meal_plan_status"] != "")){
            $meal_plan_status = $_POST["meal_plan_status"];
        }

        // update data
        if($out){
            $query = "UPDATE `room_booking_meal_plans` SET `name` = '$name', `description` = '$description', `price_per_head` = '$price', `status` = '$meal_plan_status' WHERE `id` = '$id'";
            $result = mysqli_query($conn,$query);
            if(!$result){
                $out=false;
                $msg='Opps.. Something went to wrong. Please try again';  
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }

    function deleteRoomBookingMealPlanAjax(){
        include('config.php');
        $out=true;
        $status = 'error';
        $id = '';
        $msg="Room booking meal plan deleted successfully!";

        // id validation
        if((isset($_POST["id"])) &&  ($_POST["id"] != "")){
            $id = $_POST["id"];
            $query = "SELECT `id` FROM `room_booking_meal_plans` WHERE `id`='$id'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if(!($rows > 0)){
                $out=false;
                $msg='This room booking meal plan dose not exist in our system!';
            }
        }else{
            $out=false;
            $msg='Meal plan cannot be empty!';
        }

        if($out){
            $query="DELETE FROM `room_booking_meal_plans` WHERE `id` = '$id'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $out = false;
                $msg = 'Something went to wrong. Please try again.';
            }else{
                $status = 'success';
            }
        }

        $output = array(
            "status" => $status,
            "msg" =>	$msg,
        );
        echo json_encode($output);
    }
?>