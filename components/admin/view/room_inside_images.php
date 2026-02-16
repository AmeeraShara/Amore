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
                        <h3>ROOMS INSIDE IMAGES</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ROOM SLIDER IMAGES</h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-center">ROOM NO</th>
                                            <th class="text-center">ROOM NAME</th>
                                            <th class="text-center">IMAGES</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-center">ROOM NO</th>
                                            <th class="text-center">ROOM NAME</th>
                                            <th class="text-center">IMAGES</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="table">
                                        <?php 
                                        for($i=0; $i<sizeof($room_id); $i++){
                                            print '<tr>
                                                <td>'.$room_no[$i].'</td>
                                                <td>'.$room_name[$i].'</td>
                                                <td>';
                                                    $query = "SELECT `image` FROM `room_images` WHERE `room_id`='$room_id[$i]'";
                                                    $result = mysqli_query($conn,$query);
                                                    $image_count = 1;
                                                    while($row=mysqli_fetch_array($result)){
                                                        print '<img src="'.$row[0].'" alt="image '.$image_count.'" class="img-preview">';
                                                        $image_count++;
                                                    }
                                                print '</td>
                                                <td class="text-center" id="td_'.$room_id[$i].'">
                                                    <button title="View Room" type="button" class="btn btn-warning" onclick="viewRoom('.$room_id[$i].');">
                                                        <span title="View Room" class="fa fa-eye" aria-hidden="true"></span>
                                                    </button>
                                                    <button title="Add Images" type="button" class="btn btn-success" onclick="addImages('.$room_id[$i].');">
                                                        <span title="Add Images" class="fa fa-plus" aria-hidden="true"></span>
                                                    </button>
                                                    <button title="Update Images" type="button" class="btn btn-primary" onclick="editImages('.$room_id[$i].');">
                                                        <span title="Update Images" class="fa fa-edit" aria-hidden="true"></span>
                                                    </button>
                                                    <button title="Delete Images" type="button" class="btn btn-danger" onclick="deleteImages('.$room_id[$i].');">
                                                            <span title="Delete Images" class="fa fa-trash" aria-hidden="true"></span>
                                                    </button>
                                                </td>
                                            </tr>';
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

    function Redirect() { 
        window.location='index.php?components=admin&action=room_inside_images'; 
    }

    function addImages(id){
        window.location='index.php?components=admin&action=room_inside_image_manage&id='+id;
    }

    function deleteImages(id){
        $("#td_"+id).hide();
        Swal.fire({
            title: 'Delete Room Images',
            text: "Are you sure you want to delete these all images? If you delete these images, you will permanetly delete these images. This action cannot be undo!",
            confirmButtonText: "Yes, I'm Sure",
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $.ajax({
                    url: 'index.php?components=admin&action=delete_room_inside_images',
                    type: 'POST',
                    data: {room_id:id},
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            $("#td_"+id).show();
                            toastr.error(obj.msg);
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect()', 2000);
                        }else{
                            $("#td_"+id).show();
                            toastr.info("Unknown Error! Try again");
                        }
                    }
                });
            }
        });
    }

    function viewRoom(id){
        window.open('room.php?id='+id);
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