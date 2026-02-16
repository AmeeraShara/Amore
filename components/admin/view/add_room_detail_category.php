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
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-6 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">ADD NEW ROOM DETAILS CATEGORY</h4>
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
                                            <option selected value="">Select Room</option>
                                            <?php 
                                                for($i=0; $i<sizeof($room_id); $i++){
                                                    print '<option value="'.$room_id[$i].'">'.$room_no[$i].' - '.$room_name[$i].'</option>';
                                                }
                                            ?>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="detail_category_name">Detail Category Name <span class="required-span">*</span></label>
                                        <input type="text" class="form-control" name="detail_category_name" id="detail_category_name"  placeholder="Enter Detail Category Name">
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="detail_category_text">Detail Category Description <span class="required-span">*</span></label>
                                        <textarea id="summernote" class="mt-5" name="content"></textarea>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-12">
                                        <label for="detail_category_text">Detail Category Description for Room Availability Page<span class="required-span">*</span></label>
                                        <textarea id="summernote_2" class="mt-5" name="content"></textarea>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add" onclick="saveCategory()">
                                        <small id="response" class="text-success" style="display:none"></small>
                                    </div>
                                </div>
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

    function Redirect() { 
        window.location='index.php?components=admin&action=room_inside_details'; 
    }

    function saveCategory(){
        document.getElementById('btn_add').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait ...';
        var room_id = $('#room_id').val();
        var name = $('#detail_category_name').val();
        var text = $('#summernote').summernote('code');
        var text2 = $('#summernote_2').summernote('code');

        var fd = new FormData();  
        fd.append('room_id', room_id);  
        fd.append('name', name);  
        fd.append('text', text);    
        fd.append('text2', text2);    

        $.ajax({
            url: 'index.php?components=admin&action=save_room_detail_category',
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
                    setTimeout('Redirect()', 3000);
                }else{
                    document.getElementById('btn_add').style.display = 'inline';
                    toastr.info("Unknown Error! Try again");
                }
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