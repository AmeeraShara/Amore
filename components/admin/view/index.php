<?php include '../../templates/admin/admin_header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/admin/datatables.css" />
<link rel="stylesheet" href="css/fullcalendar@5.11.3.css">

<style>
    #fullcalendar a{
        color: #0e0e0d !important;
    }
    .fc .fc-daygrid-day-top {
        flex-direction: row;
    }
    .fc-dayGridMonth-button, .fc-listMonth-button{
        display:none !important;
    }
    .fc-bg-event .fc-event-title{
        margin: auto !important;
        margin-top: 3.5rem !important;
        color: white !important;
        font-weight: 900 !important;
        font-style: inherit !important;
        background-color: #ff0000;
        width: 25px !important;
        padding: 0 2px !important;
        border-radius: 15px !important;
        box-shadow: 1px 2px 14px rgb(0 0 0 / 99%) !important;
    }
    .modal { overflow-y: auto !important; }
    .fade {transition: opacity 0.1s; }
    tfoot input {
        width: 100%;
        padding: 3px;
        box-sizing: border-box;
    }
    .crm_customer_table_main_wrapper table.dataTable tbody th, .crm_customer_table_main_wrapper table.dataTable tbody td{
        padding-top:20px;
        padding-bottom:20px;
    }
    tbody tr:hover { cursor:pointer; }
</style>
<?php include '../../templates/admin/admin_menu.php'; ?>

    <div class="">
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper" style="margin-top: 100px;">
                        <h3>HOME</h3>
                    </div>
                </div>

                <!-- Calendar start -->
                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="view_profile_wrapper float_left">
                        <div class="row">
                            <div id="fullcalendar" style="width:100%;"></div>
                        </div>
                    </div>
                </div>
                <!-- Calendar end -->

                <!-- Upcomming Room Booking Details start -->
                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="view_profile_wrapper float_left">
                        <div class="row">
                            <div class="col-md-10">
                                <h4 style="margin: 10px;">Upcomming Room Booking Details</h4>
                            </div>
                            <div class="col-md-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Page</span>
                                    </div>
                                    <select name="pagelist" id="pagelist" class="form-control text-center font-weight-bold"></select>
                                    <div class="input-group-append">
                                        <span class="input-group-text">of&nbsp;<span id="totalpages"></span></span>
                                    </div>
                                </div>
						    </div>
                            <div class="col-12">
                                <div class="row justify-content-end m-2 pb-2">
                                    <div class="col-md-2 col-sm-12 text-center">
                                        <input type="date" name="arrival_start_date" id="arrival_start_date" class="form-control" value="<?php echo dateNow(); ?>"/>
                                    </div>
                                    <div class="col-md-2 col-sm-12 text-center">
                                        <input type="date" name="arrival_end_date" id="arrival_end_date" class="form-control" value="<?php echo sevenDaysAfter(); ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-12 text-center mb-3">
                                        <input type="button" name="arrival_search_by_date" id="arrival_search_by_date" value="Arival Filter" class="btn btn-info" />
                                    </div>
                                    <div class="col-md-2 col-sm-12 text-center">
                                        <input type="date" name="departure_start_date" id="departure_start_date" class="form-control" value="<?php echo dateNow(); ?>"/>
                                    </div>
                                    <div class="col-md-2">
                                        <input type="date" name="departure_end_date" id="departure_end_date" class="form-control" value="<?php echo sevenDaysAfter(); ?>"/>
                                    </div>
                                    <div class="col-md-1 col-sm-12 text-center mb-3">
                                        <input type="button" name="departure_search_by_date" id="departure_search_by_date" value="Departure Filter" class="btn btn-info" />
                                    </div>
                                </div>
                            </div>
                            <div class="crm_customer_table_main_wrapper float_left">
                                <div class="crm_ct_search_wrapper">
                                    <div class="crm_ct_search_bottom_cont_Wrapper">
                                    </div>
                                </div>
                                <div class="table-responsive">
                                    <table id="upcoming_booking_data_table" class="packages table datatables hover cs-table crm_customer_table_inner_Wrapper">
                                        <thead>
                                            <tr>
                                                <th class="text-center">Booking ID</th>
                                                <th class="text-center">Booking Code</th>
                                                <th class="text-center">Guest Name</th>
                                                <th class="text-center">Country</th>
                                                <th class="text-center">Arrival Date</th>
                                                <th class="text-center">Departure Date</th>
                                                <th class="text-center">Adults</th>
                                                <th class="text-center">Children</th>
                                                <th class="text-center">Meals</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Contact No</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th class="text-center">Booking ID</th>
                                                <th class="text-center">Booking Code</th>
                                                <th class="text-center">Guest Name</th>
                                                <th class="text-center">Country</th>
                                                <th class="text-center">Arrival Date</th>
                                                <th class="text-center">Departure Date</th>
                                                <th class="text-center">Adults</th>
                                                <th class="text-center">Children</th>
                                                <th class="text-center">Meals</th>
                                                <th class="text-center">Email</th>
                                                <th class="text-center">Contact No</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- Upcomming Room Booking Details end -->
            </div>
        </div>
    </div>
    <!--  -->
    <div class="modal fade" id="booking-short-data-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">BOOKING IN <span id="booking_date_title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>BK CODE</th>
                                    <th>GUEST NAME</th>
                                    <th>RM NUMBER</th>
                                    <th>RM NAME</th>
                                </tr>
                            </thead>
                            <tbody id="booking-short-data">

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="data-modal" tabindex="-1" role="dialog" aria-labelledby="" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">BOOKING #<span id="title"></span></h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table">
                        <thead>
                        </thead>
                        <tbody class="table">
                            <tr>
                                <td style="width:10rem;">Guest First Name</td>
                                <td><span id="first_name"></span></td>
                            </tr>
                            <tr>
                                <td>Guest Last Name</td>
                                <td><span id="last_name"></span></td>
                            </tr>
                            <tr>
                                <td>Booked Room Name</td>
                                <td><span id="room"></span></td>
                            </tr>
                            <tr>
                                <td>Room Number</td>
                                <td><span id="room_number"></span></td>
                            </tr>
                            <tr>
                                <td>Total Price</td>
                                <td><span id="total_price"></span></td>
                            </tr>
                            <tr>
                                <td>Night Price</td>
                                <td><span id="single_night_price"></span></td>
                            </tr>
                            <tr>
                                <td>Guest Country</td>
                                <td><span id="country"></span></td>
                            </tr>
                            <tr>
                                <td>Arrival Date</td>
                                <td><span id="arrival_date"></span></td>
                            </tr>
                            <tr>
                                <td>Departure Date</td>
                                <td><span id="departure_date"></span></td>
                            </tr>
                            <tr>
                                <td>Adults</td>
                                <td><span id="adults"></span></td>
                            </tr>
                            <tr>
                                <td>Children</td>
                                <td><span id="children"></span></td>
                            </tr>
                            <tr>
                                <td>Meal Plans</td>
                                <td><span id="meail_plans"></span></td>
                            </tr>
                            <tr>
                                <td>Email</td>
                                <td><span id="email"></span></td>
                            </tr>
                            <tr>
                                <td>Contact Number</td>
                                <td><span id="contact_no"></span></td>
                            </tr>
                            <tr>
                                <td>City</td>
                                <td><span id="city"></span></td>
                            </tr>
                            <tr>
                                <td>Address</td>
                                <td><span id="address"></span></td>
                            </tr>
                            <tr>
                                <td>Extra Note</td>
                                <td><span id="extra"></span></td>
                            </tr>
                            <tr>
                                <td>Booked At</td>
                                <td><span id="booked_at"></span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>

<?php include 'templates/admin/admin_footer.php'; ?>

<script src="js/admin/toastr.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="js/admin/sweetalert-2.11.js"></script>
<script src="js/fullcalendar@5.11.3.js"></script>
<script type="text/javascript">
    $(document).ready(function(){
        var calendarEl = document.getElementById("fullcalendar");
        var partiallyFilledColor = '<?php echo getPartiallyFilledColor(); ?>';
        var fullFilledColor = '<?php echo getFullFilledColor(); ?>';
        var dataTable;
        var calendar = new FullCalendar.Calendar(calendarEl, {
            showNonCurrentDates: false,
            headerToolbar: {
                left: "prev,next today",
                center: "title",
                right: "dayGridMonth,listMonth"
            },
            height: '700px',
            navLinks: true, // can click day/week names to navigate views
            selectable: true,
            selectMirror: true,
            editable: false,
            allDaySlot: false,
            dayMaxEvents: true, // allow "more" link when too many events
            events: [
            <?php
                for ($i=0; $i <count($booked_dates); $i++) {
                    if($booked_count[$i] > 0){
            ?>
                {
                    title : '<?php echo $booked_portion[$i]; ?>',
                    display : 'background',
                    start: '<?php echo $booked_dates[$i]; ?>',
                    end: '<?php echo $booked_dates[$i]; ?>',
                    <?php if($full_booked_date[$i] == 1){ ?>
                        color: fullFilledColor,
                    <?php } else { ?>
                        color: partiallyFilledColor,
                    <?php } ?>
                },
            <?php }} ?>
            ],
            dateClick: function (info) {
                var date = info.dateStr;
                $('#booking-short-data').html("<span>");
                $.ajax ({
                    url:"index.php?components=admin&action=ajax_get_rooms_by_dates",
                    method:"POST",
                    data:{
                        date:date,
                    },
                    success: function (response){
                        const obj = JSON.parse(response);
                        var data = obj.data;
                        for (let i = 0; i < data.length; i++) {
                            var id = data[i][0];
                            var code = data[i][1];
                            var name = data[i][2] + " " + data[i][3];
                            var room_number = data[i][4];
                            var room_name = data[i][5];
                            html = '<tr onclick=getMoreDataForBooking('+id+')><td>'+code+'</td><td style="width:10rem;">'+name+'</td><td style="width:5rem;">'+room_number+'</td><td style="width:5rem;">'+room_name+'</td></tr>';
                            $('#booking-short-data').append(html);
                        }
                        if(data.length > 0){
                            $("#booking_date_title").text(date);
                            $("#booking-short-data-modal").modal('show');
                        }
                    },
                    error:function (xhr, ajaxOptions, thrownError) {
                        alert(xhr.status);
                        alert(thrownError);
                    }
                });
            },
        });

        calendar.render();

        load_data('no');

        function load_data(is_date_search='', date_type='', start_date='', end_date='',start, length){
            dataTable = $('#upcoming_booking_data_table').DataTable({
                language: {
                        searchPlaceholder: "Search Code/Name"
                },
                columnDefs: [
                    {target: 0, visible: false},
                    {targets: [1,2,3,8],className: 'text-left'},
                    {targets: [0,5,6],className: 'text-right'},
                    {targets: [4,5],className: 'text-center'},
                    {orderable: false, targets: 2},
                    {orderable: false, targets: 3},
                    {orderable: false, targets: 8},
                    {orderable: false, targets: 9},
                    {orderable: false, targets: 10},
                ],
                "fnCreatedRow": function( nRow, aData, iDataIndex ) {
                    $(nRow).attr('id', aData[0]);
                },
                "processing" : true,
                "serverSide" : true,
                "order" : [],
                "retrieve": true,
                "ajax" : {
                    url:"index.php?components=admin&action=ajax_upcoming_booking_data",
                    method:"POST",
                    data:{
                        start:start,
                        length:length,
                        is_date_search:is_date_search,
                        date_type:date_type,
                        start_date:start_date,
                        end_date:end_date,
                    },
                    error: function (xhr, err) {
                        alert("readyState: " + xhr.readyState + "\nstatus: " + xhr.status);
                        alert("responseText: " + xhr.responseText);
                    }
                },
                "drawCallback" : function(settings){
                    var page_info = dataTable.page.info();
                    $('#totalpages').text(page_info.pages);
                    var html = '';
                    var start = 0;
                    var length = page_info.length;
                    for(var count = 1; count <= page_info.pages; count++){
                        var page_number = count - 1;
                        html += '<option value="'+page_number+'" data-start="'+start+'" data-length="'+length+'">'+count+'</option>';
                        start = start + page_info.length;
                    }
                    $('#pagelist').html(html);
                    $('#pagelist').val(page_info.page);
                },
                "initComplete": function() {
                },
            });
	    }

        load_data();

        $('#pagelist').change(function(){
            var start = $('#pagelist').find(':selected').data('start');
            var length = $('#pagelist').find(':selected').data('length');
            load_data(start, length);
            var page_number = parseInt($('#pagelist').val());
            var upcoming_booking_data_table = $('#upcoming_booking_data_table').dataTable();
            upcoming_booking_data_table.fnPageChange(page_number);
        });

        $('#arrival_search_by_date').click(function(){
            var start_date = $('#arrival_start_date').val();
            var end_date = $('#arrival_end_date').val();
            $('#upcoming_booking_data_table').DataTable().destroy();
            load_data('yes','arrival', start_date, end_date);
        });

        $('#departure_search_by_date').click(function(){
            var start_date = $('#departure_start_date').val();
            var end_date = $('#departure_end_date').val();
            $('#upcoming_booking_data_table').DataTable().destroy();
            load_data('yes','departure', start_date, end_date);
        });

        $.fn.dataTable.ext.errMode = function(obj,param,err){
            var tableId = obj.sTableId;
            console.log('Handling DataTable issue of Table '+tableId);
        };

        $('#upcoming_booking_data_table tbody').on('click', 'tr', function () {
            var data = dataTable.row(this).data();
            getMoreDataForBooking(data[0]);
        });
    });

    function getMoreDataForBooking(id){
        $("#booking-short-data-modal").modal('hide');
        $.ajax ({
            url:"index.php?components=admin&action=ajax_get_room_data",
            method:"POST",
            data:{
                id:id,
            },
            success: function (response){
                obj = JSON.parse(response);
                var meals = '';
                $("#title").text(obj.booking_code);
                $("#first_name").text(obj.first_name);
                $("#last_name").text(obj.last_name);
                $("#country").text(obj.country);
                $("#total_price").text(obj.total_price);
                $("#adults").text(obj.adults);
                $("#children").text(obj.children);
                $("#contact_no").text(obj.contact_no);
                $("#email").text(obj.email);
                $("#room").text(obj.room);
                $("#room_number").text(obj.room_number);
                $("#arrival_date").text(obj.arrival_date);
                $("#departure_date").text(obj.departure_date);
                $("#city").text(obj.city);
                $("#address").text(obj.address);
                $("#extra").text(obj.extra);
                $("#booked_at").text(obj.booked_at);
                $("#single_night_price").text(obj.single_night_price);
                // console.log(obj.meal_plans);
                if(obj.meal_plans != null){
                    var arr = obj.meal_plans.split(",");
                    for (var i = 0; i < arr.length; i++) {
                    meals += '<p style="padding-right: 5px;"><i class="fa fa-check" aria-hidden="true" style="padding-right: 5px; color: green;"></i>'+arr[i]+'</p>';
                    }
                }
                $("#meail_plans").html(meals);
                $("#data-modal").modal('show');
            },
            error:function (xhr, ajaxOptions, thrownError) {
                alert(xhr.status);
                alert(thrownError);
            }
        });
    }
</script>