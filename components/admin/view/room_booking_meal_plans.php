<?php include 'templates/admin/admin_header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/admin/toastr.min.css" />
<style>
    span{font-family: ubuntu;}
    .required-span{color:red}
    .table td {vertical-align: middle;}
    .img-preview{padding-top: 10px;padding-bottom: 10px;width: 100px;height: 100px;margin-right: 5px;}
</style>
<?php include 'templates/admin/admin_menu.php'; ?>

    <div class="">
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper" style="margin-top: 100px;">
                        <h3>ROOMS BOOKING MEAL PLANS</h3>
                    </div>
                </div>
            </div>
            <?php if($_GET['action'] == 'room_booking_meal_plans'){ ?>
                <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">MEAL PALNS</h4>
                        </div>
                        <div class="col-md-6 col-sm-12 text-md-right text-center">
                            <div>
                                <button title="Add Detail Category" type="button" class="btn btn-success" onclick="addMealPlanBtn()">
                                    <i class="fa fa-plus" aria-hidden="true"><span> ADD MEAL PLAN</span></i>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th width="50%;">DESCRIPTION</th>
                                            <th>PRICE PER HEAD</th>
                                            <th>STATUS</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php 
                                        for($i=0; $i<sizeof($id); $i++){
                                            print '<tr>
                                                <td>'.($i+1).'</td>
                                                <td>'.$name[$i].'</td>
                                                <td>'.$description[$i].'</td>
                                                <td>'.$price[$i].'</td>
                                                <td>'.$status[$i].'</td>
                                                <td id="td_'.$id[$i].'">
                                                    <div class="text-center">
                                                        <button title="Edit Meal Plan" type="button" class="btn btn-success" id="edit_btn'.$id[$i].'" onclick="viewEditMealPlan('.$id[$i].');">
                                                            <span title="Edit Meal Plan" class="fa fa-edit" aria-hidden="true"></span>
                                                        </button>
                                                        <button title="Delete Meal Plan" type="button" class="btn btn-danger" id="delete_btn'.$id[$i].'" onclick="deleteMealPlan('.$id[$i].');">
                                                            <span title="Delete Meal Plan" class="fa fa-trash" aria-hidden="true"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>';
                                        }
                                    ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>#</th>
                                            <th>NAME</th>
                                            <th width="50%;">DESCRIPTION</th>
                                            <th>PRICE PER HEAD</th>
                                            <th>STATUS</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
            <?php 
                if($_GET['action'] == 'edit_room_booking_meal_plan')
                    include('edit_room_booking_meal_plan.php');
                if($_GET['action'] == 'room_booking_meal_plans')
                    include('add_room_booking_meal_plan.php');
            ?>
        </div>
    </div>

<?php include 'templates/admin/admin_footer.php'; ?>
<script src="js/admin/sweetalert-2.11.js"></script>
<script src="js/admin/toastr.min.js"></script>
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
    function Redirect() { 
        window.location='index.php?components=admin&action=room_booking_meal_plans'; 
    } 

    function back(){
        window.location='index.php?components=admin&action=room_booking_meal_plans';
    }

    function addMealPlanBtn(){
        window.location='#add_meal_plans'; 
    }

    function addMealPlan(){
        Swal.fire({
            title: 'Add Booking Meal Plan',
            text: "Did you double check all the values?",
            confirmButtonText: 'Yes, Go ahead!',
            icon: 'info',
            showCancelButton: true,
            preConfirm: () => {
                $("#btn_add").hide();
                var fd = new FormData();  
                fd.append('name', $('#meal_plan_name').val());  
                fd.append('description', $('#meal_plan_includes').val());  
                fd.append('price', $('#price').val());  
                $.ajax({
                    url: 'index.php?components=admin&action=ajax_add_room_booking_meal_plan',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                            $("#btn_add").hide();
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect()', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                            $("#btn_add").hide();
                        }
                    }
                });
            }
        });
    }

    function updateMealPlan(){
        Swal.fire({
            title: 'Update Booking Meal Plan',
            text: "Did you double check all the values?",
            confirmButtonText: 'Yes, Go ahead!',
            icon: 'info',
            showCancelButton: true,
            preConfirm: () => {
                $("#btn_update").hide();
                var fd = new FormData();  
                var meal_plan_status = '';
                if ($('#meal_plan_status').is(":checked")) meal_plan_status = 1; else meal_plan_status = 0;
                fd.append('id',  <?php if(($_GET['action'] == 'edit_room_booking_meal_plan') && (isset($id))) echo $id; ?>);  
                fd.append('name', $('#meal_plan_name').val());  
                fd.append('description', $('#meal_plan_includes').val());  
                fd.append('price', $('#price').val());  
                fd.append('meal_plan_status', meal_plan_status);  
                $.ajax({
                    url: 'index.php?components=admin&action=ajax_update_room_booking_meal_plan',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                            $("#btn_update").hide();
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect()', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                            $("#btn_update").hide();
                        }
                    }
                });
            }
        });
    }

    function addDetailCategory(){
        window.location ='index.php?components=admin&action=add_room_detail_category';
    }

    function viewEditMealPlan(id){
        window.location ='index.php?components=admin&action=edit_room_booking_meal_plan&id='+id;
    }

    function deleteMealPlan(id){
        Swal.fire({
            title: 'Delete Booking Meal Plan',
            text: "Are you sure you want to delete this room booking meal plan? This is action cannot be undo!",
            confirmButtonText: "Yes, I'm Sure",
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $("#td_"+id).hide();
                var fd = new FormData();  
                fd.append('id', id);
                $.ajax({
                    url: 'index.php?components=admin&action=ajax_delete_room_booking_meal_plan',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                            $("#td_"+id).show();
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect()', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                            $("#td_"+id).show();
                        }
                    }
                });
            }
        });
    }

    <?php if(isset($_REQUEST['message'])){ ?>
        <?php if(isset($_REQUEST['re']) && ($_REQUEST['re'] == 'fail')){ ?>
            toastr.error("<?php echo $_REQUEST['message']; ?>");
        <?php } ?>
        <?php if(isset($_REQUEST['re']) && ($_REQUEST['re'] == 'success')){ ?>
            toastr.success("<?php echo $_REQUEST['message']; ?>", 'Success!');
        <?php } ?>
    <?php } ?>
</script>