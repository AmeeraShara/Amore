<?php
    if(isset($_SESSION['fingerprint']) && $_SESSION['fingerprint'] == md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR'])){   
        if(isset($_SESSION['email'])){
            header('Location: index.php?components=admin&action=index');
        }else{
            session_destroy();
            include_once  'components/authentication/controller/AuthenticationController.php';
            exit();
        }
    }else{
        session_destroy();
        include_once  'components/authentication/controller/AuthenticationController.php';
        exit();
    }
?>