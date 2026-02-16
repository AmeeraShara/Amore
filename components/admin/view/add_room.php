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
                            <h4 style="margin: 10px;">ADD NEW ROOM</h4>
                        </div>
                        <div class="row w-100 p-md-5">
                            <div class="col-12">
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_number">Room Number <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_number" id="room_number" placeholder="Enter Room Number">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_name">Room Name <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_name" id="room_name"  placeholder="Enter Room Name">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_price">Room Price <?php print '('.getCurrency().')'; ?> <span class="required-span">*</span></label>
                                        <input type="number" class="form-control form-control" name="room_price" id="room_price"  placeholder="Enter Room Price" step="0.01">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="room_adults">Room Adults Limit <span class="required-span">*</span></label>
                                        <input type="number" class="form-control form-control" name="room_adults" id="room_adults"  placeholder="Enter Adults Limit" step="1">
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label for="room_children">Room Children Limit</label>
                                        <input type="number" class="form-control form-control" name="room_children" id="room_children"  placeholder="Enter Children Limit" step="1">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_bed">Room Bed <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_bed" id="room_bed" placeholder="Ex: Kingsize / Twin">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_view">Room View <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_view" id="room_view"  placeholder="Ex: Sea Balcony">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_size">Room Size <span class="required-span">*</span></label>
                                        <input type="text" class="form-control form-control" name="room_size" id="room_size"  placeholder="Ex: 35m2 / 376ft2">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_subtitle">Room Subtitle [Location : ROOMS Page, Under Room Name] </label>
                                        <input type="text" class="form-control form-control" name="room_subtitle" id="room_subtitle" placeholder="Ex: START FORM $120 PER DAY">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_overview_description">Room Overview Description [Location : ROOMS Page, Under Subtitle] </label>
                                        <input type="text" class="form-control form-control" name="room_overview_description" id="room_overview_description" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_description">Room Description [Location : ROOM Page, Under Room Name] </label>
                                        <input type="text" class="form-control form-control" name="room_description" id="room_description" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-12">
                                        <label for="room_home_description">Home Page Room Description [Location : Home Page] </label>
                                        <input type="text" class="form-control form-control" name="room_home_description" id="room_home_description" placeholder="">
                                    </div>
                                </div>
                                <div class="form-row">
                                    <div class="form-group col-md-4">
                                        <label for="room_overview_image">Room Overview Image [Location : Rooms Page] 770x440px</label>
                                        <input type="file" class="form-control-file" name="room_overview_image" id="room_overview_image">
                                        <img id="room_overview_image_preview" src="" alt="Overview Image" class="img-preview">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_header_bg_image">Room Header Background Image [Location : Room Page] 1920x312px</label>
                                        <input type="file" class="form-control-file" name="room_header_bg_image" id="room_header_bg_image">
                                        <img id="room_header_bg_image_preview" src="" alt="Header Background Image" class="img-preview">
                                    </div>
                                    <div class="form-group col-md-4">
                                        <label for="room_home_image">Room Home Image [Location : Home Page] 370x370px</label>
                                        <input type="file" class="form-control-file" name="room_home_image" id="room_home_image">
                                        <img id="room_home_image_preview" src="" alt="Home Image" class="img-preview">
                                    </div>
                                </div>
                                <div class="row ml-1 mt-1">
                                    <span><span class="required-span">*</span> Required fields.</span>
                                </div>
                                <div class="row text-center">
                                    <div class="col-12">
                                        <input type="button" value="SUBMIT" class="btn btn-lg btn-success" id="btn_add" onclick="saveRoom()">
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

    function Redirect() { 
        window.location='index.php?components=admin&action=rooms'; 
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

    function saveRoom(){
        document.getElementById('btn_add').style.display = 'none';
        document.getElementById('response').style.display = 'inline';
        document.getElementById('response').innerHTML = 'Please wait ...';
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
        // console.log(room_number);

        var fd = new FormData();  
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

        $.ajax({
            url: 'index.php?components=admin&action=save_room',
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