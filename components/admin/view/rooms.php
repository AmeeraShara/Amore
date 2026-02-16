<?php include 'templates/admin/admin_header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/admin/toastr.min.css" />
<style>
    span{
        font-family: ubuntu;
    }
    .table td {vertical-align: middle;}
</style>
<?php include 'templates/admin/admin_menu.php'; ?>

    <div class="">
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper" style="margin-top: 100px;">
                        <h3>ROOMS</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ALL ROOMS</h4>
                        </div>
                        <div class="col-md-9 col-sm-12 text-md-right text-center">
                            <div>
                                <button title="Add New Room" type="button" class="btn btn-success" onclick="addRoom()">
                                    <i class="fa fa-plus" aria-hidden="true"><span> ADD NEW ROOM</span></i>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ROOM NO</th>
                                            <th class="text-center">ROOM NAME</th>
                                            <th class="text-center">ROOM PRICE</th>
                                            <th class="text-center">MAX PEOPLE</th>
                                            <th class="text-center">ADULTS</th>
                                            <th class="text-center">CHILDREN</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">#</th>
                                            <th class="text-center">ROOM NO</th>
                                            <th class="text-center">ROOM NAME</th>
                                            <th class="text-center">ROOM PRICE</th>
                                            <th class="text-center">MAX PEOPLE</th>
                                            <th class="text-center">ADULTS</th>
                                            <th class="text-center">CHILDREN</th>
                                            <th class="text-center">STATUS</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="table">
                                        <?php 
                                            for($i=0; $i<sizeof($room_id); $i++){
                                                echo '<tr>';
                                                    echo '<td class="text-center">'.$room_id[$i].'</td>';
                                                    echo '<td class="text-center">'.$room_no[$i].'</td>';
                                                    echo '<td class="text-left">'.$room_name[$i].'</td>';
                                                    echo '<td class="text-right">'.$room_price[$i].'</td>';
                                                    echo '<td class="text-right">'.$room_max_people[$i].'</td>';
                                                    echo '<td class="text-right">'.$room_adults[$i].'</td>';
                                                    echo '<td class="text-right">'.$room_children[$i].'</td>';
                                                    echo '<td class="text-center">'.$room_status[$i].'</td>';
                                                    echo '<td class="text-center">
                                                            <div class="text-center text-info">
                                                                <button title="View Room Details" type="button" class="btn btn-warning" id="view_btn'.$room_id[$i].'" onclick="viewRoom('.$room_id[$i].');">
                                                                    <span title="View Room Details" class="fa fa-eye" aria-hidden="true"></span>
                                                                </button>
                                                                <button title="Edit Room Details" type="button" class="btn btn-success" id="edit_btn'.$room_id[$i].'" onclick="editRoom('.$room_id[$i].');">
                                                                    <span title="Edit Room Details" class="fa fa-edit" aria-hidden="true"></span>
                                                                </button>
                                                                <button title="Delete Room" type="button" class="btn btn-danger" id="delete_btn'.$room_id[$i].'" onclick="deleteRoom('.$room_id[$i].');">
                                                                    <span title="Delete Room" class="fa fa-trash" aria-hidden="true"></span>
                                                                </button>
                                                            </div>
                                                        </td>';
                                                echo '</tr>';
                                            }
                                        ?>
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

    function addRoom(){
        window.location ='index.php?components=admin&action=room_add';
    }

    function viewRoom(id){
        window.open('room.php?id='+id);
    }

    function editRoom(id){
        window.location = 'index.php?components=admin&action=room_edit&id='+id;
    }

    function deleteRoom(id){
        Swal.fire({
            title: 'Delete Room',
            text: "Are you sure you want to delete this room? If you delete this room, you will permanetly delete room details. This is action cannot be undo!",
            confirmButtonText: 'Yes, I"m Sure',
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                document.getElementById('delete_btn'+id).style.display = 'none';
                document.getElementById('edit_btn'+id).style.display = 'none';
                document.getElementById('view_btn'+id).style.display = 'none';
                window.location ='index.php?components=admin&action=room_delete&room_id='+id;
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