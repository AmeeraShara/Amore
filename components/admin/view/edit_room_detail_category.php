<?php include 'templates/admin/admin_header.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.14.3/dist/umd/popper.min.js"></script>
<link rel="stylesheet" type="text/css" href="css/admin/toastr.min.css" />
<link rel="stylesheet" type="text/css" href="css/admin/summernote.min.css" />
<style>
    span{font-family: ubuntu;}
    .required-span{color:red}
    .table td {vertical-align: middle;}
    .img-preview{padding-top: 10px; width: 130px; height:100px;}
</style>
<?php include 'templates/admin/admin_menu.php'; ?>

    <div class="">
        <div class="view_profile_wrapper_top float_left">
            <div class="row">
                <div class="col-md-12 col-lg-12 col-sm-12 col-12">
                    <div class="sv_heading_wraper" style="margin-top: 100px;">
                        <h3>ROOM DETAILS CATEGORY</h3>
                    </div>
                </div>
            </div>
            <!-- EDIT DETAILS CATEGORY -->
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">EDIT DETAILS CATEGORY : - Room No: <?php if(isset($room_no)) echo $room_no; ?></h4>
                        </div>
                        <div class="col-md-6 col-sm-12 text-md-right text-center">
                            <div>
                                <button title="Back to Rooms Detail Categories" type="button" class="btn btn-success" onclick="back()">
                                    <i class="fa fa-arrow-left" aria-hidden="true"><span> BACK</span></i>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="room_id">Room Number <span class="required-span">*</span></label>
                                        <select class="form-control" name="room_id" id="room_id">
                                            <option selected value="<?php if(isset($room_id)) echo $room_id; ?>"><?php if(isset($room_no) && isset($room_name)) echo $room_no . '-' . $room_name; ?></option> }
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="detail_category_name">Detail Category Name <span class="required-span">*</span></label>
                                        <input type="text" class="form-control" name="detail_category_name" id="detail_category_name" value="<?php if(isset($detail_category)) echo $detail_category; ?>"  placeholder="Enter Detail Category Name">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="detail_category_text">Detail Category Description <span class="required-span">*</span></label>
                                        <textarea id="summernote" class="mt-5" name="content"><?php if(isset($detail_category_text)) echo $detail_category_text; ?></textarea>
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="detail_category_text">Detail Category Description for Room Availability Page <span class="required-span">*</span></label>
                                        <textarea id="summernote_2" class="mt-5" name="content"><?php if(isset($detail_category_room_avilability_text)) echo $detail_category_room_avilability_text; ?></textarea>
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-12">
                                        <div class="">
                                            <label for="detail_category_status" class="mr-2 font-weight-bold text-primary">Detail Category Active Status</label>
                                            <input type="checkbox" name="detail_category_status" id="detail_category_status" <?php if(isset($detail_category_status)) if($detail_category_status==1) print 'checked="checked"'; ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <input type="button" value="UPDATE" class="btn btn-lg btn-success" id="btn_add" onclick="updateCategory()">
                                        <small id="response" class="text-success" style="display:none"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- EDIT DETAILS CATEGORY END -->

            <!-- ROOM DETAILS CATEGORY ITEMS -->
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ROOM DETAILS CATEGORY ITEMS - Room No: <?php if(isset($room_no)) echo $room_no; ?></h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table">
                                    <?php 
                                        for($i=0; $i<sizeof($room_detail_category_item_id); $i++){
                                            print '<tr>
                                                <td>'.$room_detail_category[$i].'</td>
                                                <td>'.$room_detail_category_item_text[$i].'</td>
                                                <td id="td_'.$room_detail_category_item_id[$i].'">
                                                    <div class="text-center">
                                                        <button title="Delete Room Detail Category" type="button" class="btn btn-danger" id="delete_btn'.$room_detail_category_item_id[$i].'" onclick="deleteDetailCategory('.$room_detail_category_item_id[$i].');">
                                                            <span title="Delete Room Detail Category" class="fa fa-trash" aria-hidden="true"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5 p-md-5">
                            <div class="form-group col-md-5 col-sm-12">
                                <label for="">Room Detail Category</label>
                                <input type="text" value="<?php if(isset($detail_category)) echo $detail_category; ?>"  class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-5 col-sm-12">
                                <label for="room_detail_category_item_name">Room Detail Category Item Name</label>
                                <input type="text" class="form-control" name="room_detail_category_item_name" id="room_detail_category_item_name" placeholder="Enter Room Detail Category Item name">
                            </div>
                            <div class="form-group col-md-2 col-sm-12 text-md-right text-center my-auto">
                                    <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add_detail_category_item" onclick="saveDetailCategoryItem()">
                                    <small id="detail_category_item_response" class="text-success" style="display:none"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROOM DETAILS CATEGORY ITEMS END -->

            <!-- ROOM DETAILS CATEGORY ITEMS SUB ITEMS -->
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-12 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ROOM DETAILS CATEGORY ITEMS SUB ITEMS - Room No: <?php if(isset($room_no)) echo $room_no; ?></h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th>DETAIL CATEGORY ITEM SUB ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table">
                                        <?php
                                        for($i=0; $i<sizeof($room_detail_category_item_id_1); $i++){
                                            print '<tr>
                                                <td>'.$room_detail_category_1[$i].'</td>
                                                <td>'.$room_detail_category_item_text_1[$i].'</td>
                                                <td>'.$room_detail_category_item_details_text[$i].'</td>
                                                <td id="td1_'.$room_detail_category_item_id_1[$i].'">
                                                    <div class="text-center">
                                                        <button title="Delete Room Detail Category Item Sub Item" type="button" class="btn btn-danger" id="delete_btn'.$room_detail_category_item_id_1[$i].'" onclick="deleteDetailCategoryItemSubItem('.$room_detail_category_item_id_1[$i].');">
                                                            <span title="Delete Room Detail Category Item Sub Item" class="fa fa-trash" aria-hidden="true"></span>
                                                        </button>
                                                    </div>
                                                </td>
                                            </tr>';
                                        }
                                        ?>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th>DETAIL CATEGORY</th>
                                            <th>DETAIL CATEGORY ITEM</th>
                                            <th>DETAIL CATEGORY ITEM SUB ITEM</th>
                                            <th class="text-center">ACTIONS</th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5 p-md-5">
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="">Room Detail Category</label>
                                <input type="text" value="<?php if(isset($detail_category)) echo $detail_category; ?>"  class="form-control" readonly>
                            </div>
                            <div class="form-group col-md-3 col-sm-12">
                                <label for="room_id">Room Detail Category Item <span class="required-span">*</span></label>
                                <select class="form-control" name="room_detail_category_item_id" id="room_detail_category_item_id">
                                    <option selected value="">Select Room Detail Category Item</option>
                                    <?php 
                                        for($i=0; $i<sizeof($room_detail_category_item_id); $i++){
                                            print '<option value="'.$room_detail_category_item_id[$i].'">'.$room_detail_category_item_text[$i].'</option>';
                                        }
                                    ?>
                                </select>
                            </div>
                            <div class="form-group col-md-4 col-sm-12">
                                <label for="room_detail_category_item_sub_item_text">Room Detail Category Item Sub Item Text</label>
                                <input type="text" class="form-control" name="room_detail_category_item_sub_item_text" id="room_detail_category_item_sub_item_text" placeholder="Enter Room Detail Category Item Sub Item Text">
                            </div>
                            <div class="form-group col-md-2 col-sm-12 text-md-right text-center my-auto">
                                    <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add_detail_category_item_sub_item" onclick="saveDetailCategoryItemSubItem()">
                                    <small id="detail_category_item_sub_item_response" class="text-success" style="display:none"></small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ROOM DETAILS CATEGORY ITEMS SUB ITEMS END -->
        </div>
    </div>

<?php include 'templates/admin/admin_footer.php'; ?>
<script src="js/admin/sweetalert-2.11.js"></script>
<script src="js/admin/toastr.min.js"></script>
<script src="js/admin/summernote.min.js"></script>

<script>
    // summernote
    $(document).ready(function() {
        $('#summernote').summernote({
            fontNames: ['Poppins'],
            addDefaultFonts: true,
            placeholder: 'Enter Detail Category Description Text',
            tabsize: 2,
            height: 300,
        });
        $('#summernote').summernote('fontName', 'Poppins');
        $('#summernote_2').summernote({
            fontNames: ['Poppins'],
            addDefaultFonts: true,
            placeholder: 'Enter Detail Category Description Text for Room Availibity Page',
            tabsize: 2,
            height: 300,
        });
        $('#summernote_2').summernote('fontName', 'Poppins');
    });

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

    function back(){
        window.location='index.php?components=admin&action=room_inside_details';
    }

    function Redirect(id) { 
        if(id != '') window.location='index.php?components=admin&action=edit_room_detail_category&id='+id; 
        else window.location='index.php?components=admin&action=room_inside_details'; 
    }

    function updateCategory(){
        document.getElementById('btn_add').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait ...';
        var detail_category_status;
        var detail_category_id = <?php if(isset($detail_category_id)) echo $detail_category_id; ?>;
        var name = $('#detail_category_name').val();
        var text = $('#summernote').summernote('code');
        var text2 = $('#summernote_2').summernote('code');
        if ($('#detail_category_status').is(":checked")) detail_category_status = 1; else detail_category_status = 0;

        var fd = new FormData();  
        fd.append('detail_category_id', detail_category_id);  
        fd.append('name', name);  
        fd.append('text', text);    
        fd.append('status', detail_category_status);    
        fd.append('text2', text2);

        $.ajax({
            url: 'index.php?components=admin&action=ajax_update_room_detail_category',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                document.getElementById('response').style.display = 'none';
                document.getElementById('response').innerHTML = '';
                const obj = JSON.parse(response);
                if(obj.status == 'error'){
                    toastr.error(obj.msg);
                    document.getElementById('btn_add').style.display = 'inline';
                }else if(obj.status = 'success'){
                    toastr.success(obj.msg);
                    setTimeout('Redirect('+detail_category_id+')', 3000);
                }else{
                    document.getElementById('btn_add').style.display = 'inline';
                    toastr.info("Unknown Error! Try again");
                }
          }
       });
    }

    function saveDetailCategoryItem(){
        document.getElementById('btn_add_detail_category_item').style.display = 'none';
        document.getElementById('detail_category_item_response').style.display = 'inline';
        document.getElementById('detail_category_item_response').innerHTML = 'Please wait ...';
        var room_detail_category_id = <?php if(isset($id)) echo $id; ?>;
        var room_detail_category_item_name = $('#room_detail_category_item_name').val();
        var fd = new FormData();  
        fd.append('room_detail_category_id', room_detail_category_id);  
        fd.append('room_detail_category_item_name', room_detail_category_item_name);

        $.ajax({
            url: 'index.php?components=admin&action=ajax_add_room_detail_category_item',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                document.getElementById('detail_category_item_response').style.display = 'none';
                document.getElementById('detail_category_item_response').innerHTML = '';
                const obj = JSON.parse(response);
                if(obj.status == 'error'){
                    toastr.error(obj.msg);
                    document.getElementById('btn_add_detail_category_item').style.display = 'inline';
                }else if(obj.status = 'success'){
                    toastr.success(obj.msg);
                    setTimeout('Redirect('+room_detail_category_id+')', 2000);
                }else{
                    document.getElementById('btn_add_detail_category_item').style.display = 'inline';
                    toastr.info("Unknown Error! Try again");
                }
          }
       });
    }

    function saveDetailCategoryItemSubItem(){
        document.getElementById('btn_add_detail_category_item_sub_item').style.display = 'none';
        document.getElementById('detail_category_item_sub_item_response').style.display = 'inline';
        document.getElementById('detail_category_item_sub_item_response').innerHTML = 'Please wait ...';

        var room_detail_category_id = <?php if(isset($id)) echo $id; ?>;
        var room_detail_category_item_sub_item_text = $('#room_detail_category_item_sub_item_text').val();
        var room_detail_category_item_id = $('#room_detail_category_item_id').val();

        var fd = new FormData();  
        // fd.append('room_detail_category_id', room_detail_category_id);  
        fd.append('room_detail_category_item_sub_item_text', room_detail_category_item_sub_item_text);
        fd.append('room_detail_category_item_id', room_detail_category_item_id);

        $.ajax({
            url: 'index.php?components=admin&action=ajax_add_room_detail_category_item_sub_item',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
            success: function (response) {
                document.getElementById('detail_category_item_sub_item_response').style.display = 'none';
                document.getElementById('detail_category_item_sub_item_response').innerHTML = '';
                const obj = JSON.parse(response);
                if(obj.status == 'error'){
                    toastr.error(obj.msg);
                    document.getElementById('btn_add_detail_category_item_sub_item').style.display = 'inline';
                }else if(obj.status = 'success'){
                    toastr.success(obj.msg);
                    setTimeout('Redirect('+room_detail_category_id+')', 2000);
                }else{
                    document.getElementById('btn_add_detail_category_item_sub_item').style.display = 'inline';
                    toastr.info("Unknown Error! Try again");
                }
          }
       });
    }

    function deleteDetailCategory(id){
        var room_detail_category_id = <?php if(isset($id)) echo $id; ?>;
        Swal.fire({
            title: 'Delete Room Detail Category Item',
            text: "Are you sure you want to delete this room detail category item? If you delete this room detail category item, you will permanetly delete room detail category item and all other details related to this category. This is action cannot be undo!",
            confirmButtonText: 'Yes, I"m Sure',
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $("#td_"+id).hide();
                var fd = new FormData();  
                fd.append('room_detail_category_item_id', id);  

                $.ajax({
                    url: 'index.php?components=admin&action=ajax_delete_room_details_category_item',
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
                            setTimeout('Redirect('+room_detail_category_id+')', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                            $("#td_"+id).show();
                        }
                    }
                });
            }
        });
    }

    function deleteDetailCategoryItemSubItem(id){
        var room_detail_category_id = <?php if(isset($id)) echo $id; ?>;
        Swal.fire({
            title: "Delete Room Detail Category Item's Sub Item",
            text: "Are you sure you want to delete this room detail category item's sub item? If you delete this item, you will permanetly delete this room detail category item sub item. This is action cannot be undo!",
            confirmButtonText: 'Yes, I"m Sure',
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $("#td1_"+id).hide();
                var fd = new FormData();  
                fd.append('room_details_category_item_sub_item', id);  

                $.ajax({
                    url: 'index.php?components=admin&action=ajax_delete_room_details_category_item_sub_item',
                    type: 'POST',
                    data: fd,
                    processData: false,
                    contentType: false,
                    success: function (response) {
                        const obj = JSON.parse(response);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                            $("#td1_"+id).show();
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect('+room_detail_category_id+')', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                            $("#td1_"+id).show();
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