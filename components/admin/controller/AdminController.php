<?php
    switch ($_REQUEST['action']){
        case "index":
            include_once  'components/admin/model/AdminModel.php';
            getRecentBookingDataToCalendar();
            getRoomColors();
            include_once  'components/admin/view/index.php';
        break;

        case "rooms":
            include_once  'components/admin/model/AdminModel.php';
            getAllRooms();
            include_once  'components/admin/view/rooms.php';
        break;

        case "room_delete":
            include_once  'components/admin/model/AdminModel.php';
            if(deleteRoom())
                header('Location: index.php?components=admin&action=rooms&re=success&message='.$msg);
            else
                header('Location: index.php?components=admin&action=rooms&re=fail&message='.$msg);
        break;

        case "room_add":
            include_once  'components/admin/view/add_room.php';
        break;

        case "room_edit":
            include_once  'components/admin/model/AdminModel.php';
            getRoomDetails();
            include_once  'components/admin/view/edit_room.php';
        break;

        case "room_inside_images":
            include_once  'components/admin/model/AdminModel.php';
            getRoomsImages();
            include_once  'components/admin/view/room_inside_images.php';
        break;

        case "delete_room_inside_images":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomInsideImagesAjax();
        break;

        case "room_inside_image_manage":
            include_once  'components/admin/model/AdminModel.php';
            getRoomImages();
            include_once  'components/admin/view/manage_room_inside_images.php';
        break;

        case "save_room_inside_image":
            include_once  'components/admin/model/AdminModel.php';
            print saveRoomInsideImageAjax();
        break;

        case "room_inside_image_delete":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomInsideImageAjax();
        break;

        case "update_room":
            include_once  'components/admin/model/AdminModel.php';
            print updateRoomAjax();
        break;

        case "save_room":
            include_once  'components/admin/model/AdminModel.php';
            print addRoomAjax();
        break;

        case "ajax_get_room_data":
            include_once  'components/admin/model/AdminModel.php';
            print getRoomDataAjax();
        break;

        case "ajax_get_rooms_by_dates":
            include_once  'components/admin/model/AdminModel.php';
            print getRoomsByDatesAjax();
        break;

        case "ajax_upcoming_booking_data":
            include_once  'components/admin/model/AdminModel.php';
            print getUpcomingBookingDataAjax();
        break;

        case "ajax_get_booking_data_calendar_even_select":
            include_once  'components/admin/model/AdminModel.php';
            getBookingDataCalendarEventSelect();
        break;

        case "room_inside_details":
            include_once  'components/admin/model/AdminModel.php';
            getRoomsDetailCategories();
            include_once  'components/admin/view/room_inside_details.php';
        break;

        case "add_room_detail_category":
            include_once  'components/admin/model/AdminModel.php';
            getRoomNumbers();
            include_once  'components/admin/view/add_room_detail_category.php';
        break;

        case "save_room_detail_category":
            include_once  'components/admin/model/AdminModel.php';
            print addRoomDetailCategoryAjax();
        break;

        case "edit_room_detail_category":
            include_once  'components/admin/model/AdminModel.php';
            getRoomDetailCategory();
            getRoomDetailCategoriesItems();
            getRoomDetailsCategoryItemsSubItems();
            include_once  'components/admin/view/edit_room_detail_category.php';
        break;

        case "ajax_update_room_detail_category":
            include_once  'components/admin/model/AdminModel.php';
            print updateRoomDetailCategoryAjax();
        break;

        case "ajax_delete_room_details_category":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomDetailCategoryAjax();
        break;

        case "ajax_add_room_detail_category_item":
            include_once  'components/admin/model/AdminModel.php';
            print addRoomDetailCategoryItemAjax();
        break;

        case "ajax_add_room_detail_category_item_sub_item":
            include_once  'components/admin/model/AdminModel.php';
            print addRoomDetailCategoryItemSubItemAjax();
        break;

        case "ajax_delete_room_details_category_item":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomDetailCategoryItemAjax();
        break;

        case "ajax_delete_room_details_category_item_sub_item":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomDetailCategoryItemSubItemAjax();
        break;

        case "room_booking_meal_plans":
            include_once  'components/admin/model/AdminModel.php';
            getRoomBookingMealPalns();
            include_once  'components/admin/view/room_booking_meal_plans.php';
        break;

        case "ajax_add_room_booking_meal_plan":
            include_once  'components/admin/model/AdminModel.php';
            print addRoomBookingMealPlanAjax();
        break;

        case "edit_room_booking_meal_plan":
            include_once  'components/admin/model/AdminModel.php';
            getRoomBookingMealPlan();
            include_once  'components/admin/view/room_booking_meal_plans.php';
        break;

        case "ajax_update_room_booking_meal_plan":
            include_once  'components/admin/model/AdminModel.php';
            print updateRoomBookingMealPlanAjax();
        break;

        case "ajax_delete_room_booking_meal_plan":
            include_once  'components/admin/model/AdminModel.php';
            print deleteRoomBookingMealPlanAjax();
        break;

        case "logout":
            include_once  'components/authentication/model/AuthenticationModel.php';
            if(logout()) header('Location: index.php?components=authentication&action=show_login');
        break;
    }
?>