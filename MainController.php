<?php
    include_once 'templates/common.php';
    if(isset($_REQUEST['components'])){
        if(!(isset($_SESSION['user_id']))) session_start();
        switch ($_REQUEST['components']){
            case "authentication" :
                include_once  'components/authentication/AuthenticationMiddleware.php';
            break;
            case "admin" :
                include_once  'components/admin/AdminMiddleware.php';
            break;
            default:
                header('Location: home.php');
            break;
        }
    }else{
        header('Location: home.php');
    }
?>