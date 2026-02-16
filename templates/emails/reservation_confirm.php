<?php $message = '<!doctype html>
<html lang="en-US">
<head>
    <meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
    <title>ROOM RESERVATION CONFIRMATION</title>
    <meta name="description" content="ROOM RESERVATION CONFIRMATION">
</head>
<style>
    a:hover {
        text-decoration: underline !important;
    }
</style>

<body marginheight="0" topmargin="0" marginwidth="0" style="margin: 0px; background-color: #f2f3f8;" leftmargin="0">
    <table cellspacing="0" border="0" cellpadding="0" width="100%" bgcolor="#f2f3f8"
        style="@import url(https://fonts.googleapis.com/css?family=Rubik:300,400,500,700|Open+Sans:300,400,600,700); font-family: "Open Sans", sans-serif;">
        <tr>
            <td>
                <table style="background-color: #f2f3f8; max-width:670px; margin:0 auto;" width="100%" border="0"
                    align="center" cellpadding="0" cellspacing="0">
                    <tr>
                        <td style="height:80px;">&nbsp;</td>
                    </tr>
                    <!-- Logo -->
                    <tr>
                        <td style="text-align:center;">
                            <a href="'.getPrimaryUrl().'" title="logo" target="_blank">
                                <img width="200" src="'.getPrimaryUrl().'templates/emails/images/image-5.png" title="logo"
                                    alt="logo">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <!-- Email Content -->
                    <tr>
                        <td>
                            <table width="95%" border="0" align="center" cellpadding="0" cellspacing="0"
                                style="max-width:670px; background:#fff; border-radius:3px;-webkit-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);-moz-box-shadow:0 6px 18px 0 rgba(0,0,0,.06);box-shadow:0 6px 18px 0 rgba(0,0,0,.06);padding:0 40px;">
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                                <!-- Title -->
                                <tr>
                                    <td style="padding:0 15px; text-align:center;">
                                        <h1
                                            style="color:#1e1e2d; font-weight:400; margin:0;font-size:32px;font-family:"Rubik",sans-serif;line-height: 40px;">
                                            '.$email_inside_title.'
                                        </h1>
                                        <span style="display:inline-block; vertical-align:middle; margin:29px 0 26px; border-bottom:1px solid #cecece; 
                                        width:100px;"></span>
                                    </td>
                                </tr>
                                <!-- Details Table -->
                                <tr>
                                    <td>
                                        <table cellpadding="0" cellspacing="0"
                                            style="width: 100%; border: 1px solid #ededed">
                                            <tbody>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                        Reservation Number:
                                                    </td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                        #'.$booking_code.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                        Guest Name:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                        '.$first_name.' '.$last_name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                        Contact Number:
                                                    </td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                        '.$mobile_number.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed;border-right: 1px solid #ededed; width: 35%; font-weight:500; color:rgba(0,0,0,.64)">
                                                        Booked Room Name:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                        '.$room_name.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px;  border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Arrival Date:
                                                    </td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056;">
                                                        '.$arrival_date_text.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Departure Date:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$departure_date_text.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Number of Nights:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$total_nights.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Number of Adults:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$adults.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Number of Children:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$children.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Single Night Price:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$currency . $single_night_price_text.'
                                                    </td>
                                                </tr>
                                                '.$meal_plans_tr.'
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Total Price:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$currency . $total_room_price_text.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Booked Date:</td>
                                                    <td
                                                        style="padding: 10px; border-bottom: 1px solid #ededed; color: #455056; ">
                                                        '.$date_now.'
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td
                                                        style="padding: 10px; border-right: 1px solid #ededed; width: 35%;font-weight:500; color:rgba(0,0,0,.64)">
                                                        Conditions:</td>
                                                    <td style="padding: 10px; color: #455056;">'.$conditions.'</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                </tr>
                                <tr>
                                    <td style="height:40px;">&nbsp;</td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td style="height:20px;">&nbsp;</td>
                    </tr>
                    <tr>
                        <td style="text-align:center;">
                            <p style="font-size:14px; color:#455056bd; line-height:18px; margin:0 0 0;">&copy;
                                <strong>'.getPrimaryUrl().'</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>';
?>