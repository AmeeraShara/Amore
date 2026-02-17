<?php include '../../../templates/admin/admin_header.php'; ?>
<link rel="stylesheet" type="text/css" href="../../../css/admin/toastr.min.css" />
<style>
    span{font-family: ubuntu;}
    .required-span{color:red}
    .table td {vertical-align: middle;}
    .img-preview{padding-top: 10px;padding-bottom: 10px;width: 100px;height: 100px;margin-right: 5px;}
</style>
<?php include '../../../templates/admin/admin_menu.php'; ?>

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
                            <h4 style="margin: 10px;">ADD ROOM SLIDER IMAGES - Room No: <?php if(isset($room_number)) echo $room_number; ?></h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="image_text">Image Text <span class="required-span">*</span></label>
                                        <input type="text" class="form-control" name="image_text" id="image_text"  placeholder="Enter Image Text">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="image_file">Image (870x496px)<span class="required-span">*</span></label>
                                        <input type="file" class="form-control-file" name="image_file" id="image_file">
                                        <img id="image_preview" src="" alt="Inside Slider Image" class="img-preview">
                                    </div>
                                </div>
                                <div class="row text-left">
                                    <div class="col-12">
                                        <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add" onclick="saveImage()">
                                        <small id="response" class="text-success" style="display:none"></small>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th class="text-left">ROOM NO</th>
                                            <th class="text-left">ROOM NAME</th>
                                            <th class="text-left">IMAGES</th>
                                        </tr>
                                    </thead>
                                    <tfoot>
                                        <tr>
                                            <th class="text-left">ROOM NO</th>
                                            <th class="text-left">ROOM NAME</th>
                                            <th class="text-left">IMAGES</th>
                                        </tr>
                                    </tfoot>
                                    <tbody class="table">
                                        <?php 
                                            print '<tr>
                                                <td>'.$room_number.'</td>
                                                <td>'.$room_name.'</td>
                                                <td>';
                                                    $image_count = 1;
                                                    for($i=0; $i<sizeof($image_ids); $i++){
                                                        print '<img src="'.$room_images[$i].'" alt="image '.$image_count.'" class="img-preview" onclick="deleteImage('.$image_ids[$i].');">';
                                                        $image_count++;
                                                    }
                                                print '</td>
                                            </tr>';
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

    function Redirect(id) { 
        window.location='index.php?components=admin&action=room_inside_image_add&id='+id; 
    }

    $('#image_file').change(function() {
        var url = window.URL.createObjectURL(this.files[0]);
        $('#image_preview').attr('src',url);
    });

    function deleteImage(id){
        document.getElementById('btn_add').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait image deleting is processing...';
        Swal.fire({
            title: 'Delete Room Inside Image',
            text: "Are you sure you want to delete this selected images? If you delete this image, you will permanetly delete the image. This action cannot be undo!",
            confirmButtonText: "Yes, I'm Sure",
            icon: 'warning',
            showCancelButton: true,
            preConfirm: () => {
                $.ajax({
                    url: 'index.php?components=admin&action=room_inside_image_delete',
                    type: 'POST',
                    data: {image_id:id},
                    success: function (response) {
                        const obj = JSON.parse(response);
                        console.log(obj);
                        if(obj.status == 'error'){
                            toastr.error(obj.msg);
                        }else if(obj.status = 'success'){
                            toastr.success(obj.msg);
                            setTimeout('Redirect('+room_id+')', 2000);
                        }else{
                            toastr.info("Unknown Error! Try again");
                        }
                    }
                });
            }
        });
    }

    function saveImage(){
        document.getElementById('btn_add').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait ...';
        var room_id = <?php if(isset($room_id)) echo $room_id; ?>;
        var image_file = document.getElementById('image_file').files[0];
        var text = $('#image_text').val();

        var fd = new FormData();  
        fd.append('room_id', room_id);  
        fd.append('image_file', image_file);
        fd.append('text', text);

        $.ajax({
            url: 'index.php?components=admin&action=save_room_inside_image',
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
                setTimeout('Redirect('+room_id+')', 3000);
            }else{
                document.getElementById('btn_add').style.display = 'inline';
                toastr.info("Unknown Error! Try again");
            }
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