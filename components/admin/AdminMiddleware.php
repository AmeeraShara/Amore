<?php
    if(isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])){   
        if((isset($_SESSION['email'])) && (isset($_SESSION['user_type']))){
            include_once  'components/admin/controller/AdminController.php';
        }else{
            session_destroy();
            header('Location: index.php?components=authentication&action=show_login');
            exit();
        }
    }else{
        session_destroy();
        header('Location: index.php?components=authentication&action=show_login');
        exit();
    }
?>