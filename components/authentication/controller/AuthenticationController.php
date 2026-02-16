<?php
    switch ($_REQUEST['action']){
        case "register":
            include_once  'components/authentication/model/AuthenticationModel.php';
            if(register())
                header('Location: index.php?components=authentication&action=show_register&re=success&message='.$msg);
            else
                header('Location: index.php?components=authentication&action=show_register&email='.$email.'&mobile='.$mobile.'&code='.$ref_code.'&re=fail&message='.$msg);
        break;

        case "login":
            include_once  'components/authentication/model/AuthenticationModel.php';
            if(login()) 
                header('Location: index.php?components=admin&action=index');
            else
                header('Location: index.php?components=authentication&action=show_login&re=fail&message='.$msg);
        break;

        case "show_login":
            include_once  'components/authentication/view/login.php';
        break;

        case "show_register":
            include_once  'components/authentication/view/register.php';
        break;

        case "show_forgot_password":
            include_once  'components/authentication/view/forgot_password.php';
        break;

        case "forgot_validate_email":
            include_once  'components/authentication/model/AuthenticationModel.php';
            if(forgotPasswordEmailValidate())
                header('Location: index.php?components=authentication&action=show_forgot_password&re=success&message='.$msg);
            else
                header('Location: index.php?components=authentication&action=show_forgot_password&re=fail&message='.$msg);
            include_once  'components/authentication/view/forgot_password.php';
        break;

        case "show_change_forgot_password":
            include_once  'components/authentication/view/forgot_password.php';
        break;

        case "change_forgot_password";
            include_once  'components/authentication/model/AuthenticationModel.php';
            if(changeForgotPassword())
                header('Location: index.php?components=authentication&action=show_login&re=success&message='.$msg);
            else
                header('Location: index.php?components=authentication&action=show_change_forgot_password&token='.$token.'&re=fail&message='.$msg);
            include_once  'components/authentication/view/forgot_password.php';
        break;

        default:
            header('Location: index.php');
        break;
    }
?>