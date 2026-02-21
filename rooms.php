<?php 
include_once('templates/header.php'); 

$rooms = array();

// 1️⃣ Fetch all active rooms
$query = "SELECT id, name, overview_subtitle, overview_decription FROM rooms WHERE status='1'";
$result = mysqli_query($conn, $query);

while($row = mysqli_fetch_assoc($result)){
    $room_id = $row['id'];
    $room_name = $row['name'];

    // 2️⃣ Get images for this specific room from folder
    $images = glob("images/rooms/room".$room_id."-*.*"); 

    // 3️⃣ If no images exist, use a room-specific default
    $default_image = "images/rooms/room".$room_id."-default.jpg";
    if(empty($images)){
        if(file_exists($default_image)){
            $images[] = $default_image;
        } else {
            $images[] = "images/rooms/room-overview-default-image.jpg"; 
        }
    }

    // 4️⃣ Store room info + images
    $rooms[] = [
        'id' => $room_id,
        'name' => $room_name,
        'subtitle' => $row['overview_subtitle'],
        'description' => $row['overview_decription'],
        'images' => $images
    ];
}
?>

<!-- BANNER -->
<section class="banner-tems text-center bg-rooms">
    <div class="container">
        <div class="banner-content">
            <h2>ROOMS & RATES</h2>
            <p>Our living spaces are about more than just air conditioning, gorgeous furnishings, and modern conveniences.</p>
        </div>
    </div>
</section>
<!-- END / BANNER -->

<!-- ROOMS -->
<section class="body-room-2">
    <div class="container">
        <?php 
        if(!empty($rooms)) { 
            foreach($rooms as $i => $room){
                // Alternate layout for odd/even rooms
                $classes_01 = $classes_02 = ''; 
                $image_class = 'img';
                if($i % 2 != 0){
                    $classes_01 = 'col-lg-push-4 col-md-push-4';
                    $classes_02 = 'col-lg-pull-8 col-md-pull-8';
                    $image_class = 'img1';
                }

                // 5️⃣ Build image carousel
                $carousel = '<div class="room-carousel">';
                foreach($room['images'] as $img){
$carousel .= '<a href="room.php?id='.$room['id'].'">
                <img src="'.$img.'" 
                     alt="'.$room['name'].'" 
                     title="'.$room['name'].'"
                     style="width:100%; height:470px; object-fit:cover; display:block;">
              </a>';                }
                $carousel .= '</div>';

                // 6️⃣ Output room HTML
                echo '
                <div class="wrap-room2">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 '.$classes_01.'">
                            <div class="'.$image_class.'">
                                '.$carousel.'
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-4 col-lg-4 '.$classes_02.'">
                            <div class="text">
                                <h2 class="h2-rooms">'.$room['name'].'</h2>
                                <h5 class="h5-room">'.$room['subtitle'].'</h5>
                                <p>'.$room['description'].'</p>
                                <a href="room.php?id='.$room['id'].'&case=book_now" class="view-dateails btn btn-room">VIEW DETAILS</a>
                            </div>
                        </div>
                    </div>
                </div>';
            }
        } else {
            echo '<h3 class="text-center">Rooms details are coming soon.</h3>';
        }
        ?>
    </div>
</section>
<!-- END / ROOMS -->

<?php include_once('templates/footer.php'); ?> 