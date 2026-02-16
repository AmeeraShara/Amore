<?php include 'templates/admin/admin_header.php'; ?>

<?php include 'templates/admin/admin_menu.php'; ?>

    <div class="">
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper" style="margin-top: 100px;">
                        <h3>BOOKING VIEW</h3>
                    </div>
                </div>
            </div>
            <!--  -->
            <!--  -->
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-12">
                            <h4 style="margin: 10px;">#BOOKING ID</h4>
                        </div>
                        <div class="row w-100 p-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                    </thead>
                                    <tbody class="table">
                                        <tr>
                                            <td class="font-weight-bold">Guest First Name</td>
                                            <td><span id="first_name">Sahan</span></td>
                                            <td class="font-weight-bold">Guest Last Name</td>
                                            <td><span id="last_name">Pasindu</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Booked Room Name</td>
                                            <td><span id="room">Room Name</span></td>
                                            <td class="font-weight-bold">Room Number</td>
                                            <td><span id="room_number">102</span></td>
                                        </tr>
                                        <tr>
                                            <td class="font-weight-bold">Total Price</td>
                                            <td><span id="total_price">$129.00</span></td>
                                            <td class="font-weight-bold">Night Price</td>
                                            <td><span id="single_night_price">$20.00</span></td>
                                        </tr>
                                        <tr>
                                            <td>Guest Country</td>
                                            <td><span id="country">Sri Lanka</span></td>
                                            <td>City</td>
                                            <td><span id="city">City</span></td>
                                        </tr>
                                        <tr>
                                            <td>Arrival Date</td>
                                            <td><span id="arrival_date">2022-11-29</span></td>
                                            <td>Departure Date</td>
                                            <td><span id="departure_date">2022-12-2</span></td>
                                        </tr>
                                        <tr>
                                            <td>Adults</td>
                                            <td><span id="adults">4</span></td>
                                            <td>Children</td>
                                            <td><span id="children">0</span></td>
                                        </tr>
                                        <tr>
                                            <td>Email</td>
                                            <td><span id="email">sahanpasindu07@gmail.com</span></td>
                                            <td>Contact Number</td>
                                            <td><span id="contact_no">0711229266</span></td>
                                        </tr>
                                        <tr>
                                            <td>Address</td>
                                            <td><span id="address">Address</span></td>
                                            <td>Extra Note</td>
                                            <td><span id="extra"></span></td>
                                        </tr>
                                        <tr>
                                            <td colspan="3">Booked At</td>
                                            <td><span id="booked_at">2022-11-01</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php include 'templates/admin/admin_footer.php'; ?>