<?php include 'templates/admin/admin_header.php'; ?>
<link rel="stylesheet" type="text/css" href="css/admin/toastr.min.css" />
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
                        <h3>ROOMS</h3>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 col-md-12 col-lg-12 col-sm-12 col-12">
                <div class="view_profile_wrapper float_left">
                    <div class="row">
                        <div class="col-md-3 col-sm-12 text-md-left text-center">
                            <h4 style="margin: 10px;">EDIT ROOM - Room No: <?php if(isset($room_number)) echo $room_number; ?></h4>
                        </div>
                        <div class="col-md-9 col-sm-12 text-md-right text-center">
                            <div>
                                <button title="Back to Rooms" type="button" class="btn btn-success" onclick="back()">
                                    <i class="fa fa-arrow-left" aria-hidden="true"><span> BACK TO ROOMS</span></i>
                                </button>
                                <button title="View Room" type="button" class="btn btn-warning" onclick="viewRoom('<?php if(isset($room_id)) echo $room_id; ?>')">
                                    <i class="fa fa fa-eye" aria-hidden="true"><span> VIEW ROOM</span></i>
                                </button>
                            </div>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_number">Room Number <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_number" id="room_number" placeholder="Enter Room Number" value="<?php if(isset($room_number)) echo $room_number; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_name">Room Name <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_name" id="room_name"  placeholder="Enter Room Name" value="<?php if(isset($room_name)) echo $room_name; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_price">Room Price <?php if(isset($currency)) echo '('.$currency.')'; ?> <span class="required-span">*</span></label>
                                        <input type="number" class="form-control form-control" name="room_price" id="room_price"  placeholder="Enter Room Price" step="0.01" value="<?php if(isset($room_price)) echo $room_price; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="room_adults">Room Adults Limit <span class="required-span">*</span></label>
                                        <input type="number" class="form-control form-control" name="room_adults" id="room_adults"  placeholder="Enter Adults Limit" step="1" value="<?php if(isset($room_adults)) echo $room_adults; ?>">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="room_children">Room Children Limit</label>
                                        <input type="number" class="form-control form-control" name="room_children" id="room_children"  placeholder="Enter Children Limit" step="1" value="<?php if(isset($room_children)) echo $room_children; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_bed">Room Bed <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_bed" id="room_bed" placeholder="Ex: Kingsize / Twin" value="<?php if(isset($room_bed)) echo $room_bed; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_view">Room View <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_view" id="room_view"  placeholder="Ex: Sea Balcony" value="<?php if(isset($room_view)) echo $room_view; ?>">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_size">Room Size <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_size" id="room_size"  placeholder="Ex: 35m2 / 376ft2" value="<?php if(isset($room_size)) echo $room_size; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_subtitle">Room Subtitle [Location : ROOMS Page, Under Room Name] </label>
                                        <input type="text" class="form-control form-control" name="room_subtitle" id="room_subtitle" placeholder="Ex: START FORM $120 PER DAY" value="<?php if(isset($room_subtitle)) echo $room_subtitle; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_overview_description">Room Overview Description [Location : ROOMS Page, Under Subtitle] </label>
                                        <input type="text" class="form-control form-control" name="room_overview_description" id="room_overview_description" placeholder="" value="<?php if(isset($room_overview_description)) echo $room_overview_description; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_description">Room Description [Location : ROOM Page, Under Room Name] </label>
                                        <input type="text" class="form-control form-control" name="room_description" id="room_description" placeholder="" value="<?php if(isset($room_description)) echo $room_description; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_home_description">Home Page Room Description [Location : Home Page] </label>
                                        <input type="text" class="form-control form-control" name="room_home_description" id="room_home_description" placeholder="" value="<?php if(isset($room_home_description)) echo $room_home_description; ?>">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_overview_image">Room Overview Image [Location : Rooms Page] 770x440px</label>
                                        <input type="file" class="form-control-file" name="room_overview_image" id="room_overview_image" placeholder="">
                                        <img id="room_overview_image_preview" src="<?php if(isset($room_overview_image)) echo $room_overview_image; ?>" alt="Overview Image" class="img-preview">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_header_bg_image">Room Header BG Image [Location : Room Page] 1920x312px</label>
                                        <input type="file" class="form-control-file" name="room_header_bg_image" id="room_header_bg_image" placeholder="">
                                        <img id="room_header_bg_image_preview" src="<?php if(isset($room_header_bg_image)) echo $room_header_bg_image; ?>" alt="Header Background Image" class="img-preview">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_home_image">Room Home Image [Location : Home Page] 370x370px</label>
                                        <input type="file" class="form-control-file" name="room_home_image" id="room_home_image" placeholder="">
                                        <img id="room_home_image_preview" src="<?php if(isset($room_home_image)) echo $room_home_image; ?>" alt="Home Image" class="img-preview">
                                    </div>
                                </div>
                                <div class="row mt-1">
                                    <div class="col-12">
                                        <div class="">
                                            <label for="room_status" class="mr-2 font-weight-bold text-primary">Room Active Status</label>
                                            <input type="checkbox" name="room_status" id="room_status" <?php if($status==1) print 'checked="checked"'; ?> />
                                        </div>
                                    </div>
                                </div>
                                <div class="row ml-1 mt-1 mb-2">
                                    <div class="col-12">
                                        <span><span class="required-span">*</span> Required fields.</span>
                                        <br>
                                        <span class="ml-2 font-weight-bold"> If you don't want to change current active images, leave those fields as empty</span>
                                    </div>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <input type="button" value="UPDATE" class="btn btn-lg btn-success" id="btn_edit" onclick="updateRoom()">
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

    $('#room_overview_image').change(function() {
        var url = window.URL.createObjectURL(this.files[0]);
        $('#room_overview_image_preview').attr('src',url);
    });

    $('#room_header_bg_image').change(function() {
        var url = window.URL.createObjectURL(this.files[0]);
        $('#room_header_bg_image_preview').attr('src',url);
    });

    $('#room_home_image').change(function() {
        var url = window.URL.createObjectURL(this.files[0]);
        $('#room_home_image_preview').attr('src',url);
    });

    function back(){
        window.location='index.php?components=admin&action=rooms'; 
    }

    function viewRoom(id){
        window.open('room.php?id='+id);
    }

    function Redirect() { 
        window.location='index.php?components=admin&action=room_edit&id='+<?php if(isset($room_id)) echo $room_id; ?>; 
    } 

    function updateRoom(){
        document.getElementById('btn_edit').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait ...';
        var room_status;
        var room_id = <?php if(isset($room_id)) echo $room_id; ?>;
        var room_number = $('#room_number').val();
        var room_name = $('#room_name').val();
        var room_price = $('#room_price').val();
        var room_adults = $('#room_adults').val();
        var room_children = $('#room_children').val();
        var room_bed = $('#room_bed').val();
        var room_view = $('#room_view').val();
        var room_size = $('#room_size').val();
        var room_subtitle = $('#room_subtitle').val();
        var room_overview_description = $('#room_overview_description').val();
        var room_description = $('#room_description').val();
        var room_home_description = $('#room_home_description').val();
        var room_overview_image = document.getElementById('room_overview_image').files[0];
        var room_header_bg_image = document.getElementById('room_header_bg_image').files[0];
        var room_home_image = document.getElementById('room_home_image').files[0];
        if ($('#room_status').is(":checked")) room_status = 1; else room_status = 0;

        var fd = new FormData();  
        fd.append('room_id', room_id);  
        fd.append('room_number', room_number);  
        fd.append('room_name', room_name);  
        fd.append('room_price', room_price);  
        fd.append('room_adults', room_adults);  
        fd.append('room_children', room_children);  
        fd.append('room_bed', room_bed);  
        fd.append('room_view', room_view);  
        fd.append('room_size', room_size);  
        fd.append('room_subtitle', room_subtitle);  
        fd.append('room_overview_description', room_overview_description);  
        fd.append('room_description', room_description);  
        fd.append('room_home_description', room_home_description);  
        fd.append('room_overview_image', room_overview_image);  
        fd.append('room_header_bg_image', room_header_bg_image);  
        fd.append('room_home_image', room_home_image);  
        fd.append('room_status', room_status);  

        $.ajax({
            url: 'index.php?components=admin&action=update_room',
            type: 'POST',
            data: fd,
            processData: false,
            contentType: false,
          success: function (response) {
            const obj = JSON.parse(response);
            document.getElementById('response').style.display = 'none';
            document.getElementById('response').innerHTML = '';
            if(obj.status == 'error'){
                toastr.error(obj.msg);
                document.getElementById('btn_edit').style.display = 'inline';
            }else if(obj.status = 'success'){
                toastr.success(obj.msg);
                setTimeout('Redirect()', 2000);
            }else{
                document.getElementById('btn_edit').style.display = 'inline';
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