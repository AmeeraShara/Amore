<?php 

// function getBetweenDates($startDate, $endDate){
//     $rangArray = [];
//     $i =1;
//     $startDate = strtotime($startDate);
//     $endDate = strtotime($endDate." -".$i." day");
         
//     for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {                
//         $date = date('Y-m-d', $currentDate);
//         $rangArray[] = $date;
//     }
//     return $rangArray;
// }

// function dateNow(){
//     include('config.php');
//     $result = mysqli_query($conn, "SELECT `value` FROM settings WHERE setting='timezone'");
//     $row = mysqli_fetch_assoc($result);
//     $timezone = $row['value'];
//     $date_now = date("Y-m-d", time() + (60 * 60 * $timezone));
//     return $date_now;
// }

// function passwordHash($password){
//     $options = ['cost' => 12];
//     $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
//     return $hashed_password;
// }

// var_dump(getBetweenDates("2022-08-29","2023-03-01"));
?>