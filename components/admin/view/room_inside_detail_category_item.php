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
                        <h3>ROOMS INSIDE DETAILS</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ROOM DETAILS CATEGORIES ITEMS</h4>
                        </div>
                        <div class="col-md-9 col-sm-12 text-md-right text-center">
                            <div>
                                <button title="Add Detail Category" type="button" class="btn btn-success" onclick="addDetailCategory()">
                                    <i class="fa fa-plus" aria-hidden="true"><span> NEW DETAIL CATEGORY</span></i>
                                </button>
                                <button title="Add Detail Category" type="button" class="btn btn-success" onclick="addDetailCategoryItem()">
                                    <i class="fa fa-plus" aria-hidden="true"><span> DETAIL CATEGORY ITEMS</span></i>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>ROOM NO</th>
                                            <th>ROOM NAME</th>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>ROOM NO</th>
                                            <th>ROOM NAME</th>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="table">
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
        window.location='index.php?components=admin&action=room_inside_details'; 
    } 

    function viewRoom(id){
        window.open('room.php?id='+id);
    }

    function addDetailCategoryItem(){

    }

    function addDetailCategory(){
        window.location ='index.php?components=admin&action=add_room_detail_category';
    }

    function editDetailCategory(id){
        window.location ='index.php?components=admin&action=edit_room_detail_category&id='+id;
    }

    function deleteDetailCategory(id){
        Swal.fire({
            title: 'Delete Room Detail Category',
            text: "Are you sure you want to delete this room detail category? If you delete this room detail category, you will permanetly delete room detail category and all other details related to this main category. This is action cannot be undo!",
            confirmButtonText: 'Yes, I"m Sure',
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $("#td_"+id).hide();
                var fd = new FormData();  
                fd.append('detail_category_id', id);  

                $.ajax({
                        url: 'index.php?components=admin&action=ajax_delete_room_details_category',
                        type: 'POST',
                        data: fd,
                        processData: false,
                        contentType: false,
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect()', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
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