<?php
include('config.php');

function getPrimaryUrl()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='primary_url'");
    $row = mysqli_fetch_assoc($result);
    return $row['value'];
}
function getScriptName()
{
    $filename = baseName($_SERVER['REQUEST_URI']);
    $ipos = strpos($filename, "?");
    if (!($ipos === false))
        $filename = substr($filename, 0, $ipos);
    return $filename;
}

function getPageTitle()
{
    $pageLink = getScriptName();
    $pageTitle = '';
    switch ($pageLink) {
        case "":
            $pageTitle = ' - Home';
            break;
        case "home.php":
            $pageTitle = ' - Home';
            break;
        case "rooms.php":
            $pageTitle = ' - Rooms';
            break;
        case "room.php":
            $pageTitle = ' - Room';
            break;
        case "contact.php":
            $pageTitle = ' - Contact';
            break;
        case "near_by_places.php":
            $pageTitle = ' - Near by Places';
            break;
        case "restaurant.php":
            $pageTitle = ' - Restaurant';
            break;
        case "booking.php":
            $pageTitle = ' - Room Booking';
            break;
        case "booking_confrimation.php":
            $pageTitle = ' - Room Booking Completed';
            break;
        case "availability.php":
            $pageTitle = ' - Room Availability';
            break;
        case "policies.php":
            $pageTitle = ' - Hotel Policies';
            break;
        default:
            $pageTitle = "";
    }
    return $pageTitle;
}

function getCompanyName()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='company_name'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getSupportEmail()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='support_email'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getFromEmail()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='from_email'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getToEmail()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='to_email'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getContactMobileNumber()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='mobile_number'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getAddress()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM settings WHERE `setting`='address'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getFBLink()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='fb'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getTwitterLink()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='twitter'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getLinkedInLink()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='linkedin'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function dateNow()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM settings WHERE `setting`='timezone'");
    $row = mysqli_fetch_assoc($result);
    $timezone = $row['value'];
    $date_now = date("Y-m-d", time() + (60 * 60 * $timezone));
    return $date_now;
}

function timeNow()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='timezone'");
    $row = mysqli_fetch_assoc($result);
    $timezone = $row['value'];
    $time_now = date("Y-m-d H:i:s", time() + (60 * 60 * $timezone));
    return $time_now;
}

function sevenDaysAfter()
{
    $seven_days_before = date("Y-m-d", strtotime("+7 days"));
    return $seven_days_before;
}

function sixMonthsAfter()
{
    $six_month_after = date("Y-m-d", strtotime("+6 months"));
    return $six_month_after;
}

function sixMonthsBefore()
{
    $six_month_before = date("Y-m-d", strtotime("-6 months"));
    return $six_month_before;
}

function getCurrency()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='currency'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getPartiallyFilledColor()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='partially_filled_color'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function getFullFilledColor()
{
    include('config.php');
    $result = mysqli_query($conn2, "SELECT `value` FROM `settings` WHERE `setting`='full_filled_color'");
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        return $row['value'];
    }
    return null; // Return null if no result is found
}

function totalNightCount($arrival_date, $departure_date)
{
    $from_date = strtotime($arrival_date);
    $to_date = strtotime($departure_date);
    $day_diff = $to_date - $from_date;
    return floor($day_diff / (60 * 60 * 24));
}

function getBetweenDates($startDate, $endDate)
{
    $rangArray = [];
    $i = 1;
    $startDate = strtotime($startDate);
    $endDate = strtotime($endDate . " -" . $i . " day");

    for ($currentDate = $startDate; $currentDate <= $endDate; $currentDate += (86400)) {
        $date = date('Y-m-d', $currentDate);
        $rangArray[] = $date;
    }
    return $rangArray;
}
?>