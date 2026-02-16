<?php
    function passwordHash($password){
        $options = ['cost' => 12];
        $hashed_password = password_hash($password, PASSWORD_BCRYPT, $options);
        return $hashed_password;
    }

    function tokenGenerate(){
        return md5(time()+rand());
    }

    function changeForgotPassword(){
        global $msg, $token;
        $out=true;
        $msg="Password change is successful! <br>Please login with your new password";
        $password = $c_password = '';
        include('config.php');

        if(isset($_REQUEST['password'])) $password=$_REQUEST['password'];
        if(isset($_REQUEST['c_password'])) $c_password=$_REQUEST['c_password'];
        if(isset($_REQUEST['token'])) $token=trim(mysqli_real_escape_string($conn,$_REQUEST['token']));

        // Empty fileds validation
        if($out){
            if(($password == '') || ($c_password == '') || ($token == '')){
                $msg = 'Please fill all the required feilds';
                $out=false;
            }
        }

        // Validate password strength
        if($out){
            $uppercase = preg_match('@[A-Z]@', $password);
            $lowercase = preg_match('@[a-z]@', $password);
            $number    = preg_match('@[0-9]@', $password);
            $specialChars = preg_match('@[^\w]@', $password);

            if(!$uppercase || !$lowercase || !$number || !$specialChars || strlen($password) < 8) {
                $msg='Password should be <b>at least 8 characters in length</b> and should include <b>at least one</b> <i><b>capital letter</b></i>, one <i><b>simple letter</b></i>, one <i><b>number</b></i>, and one <i><b>special character</b></i>.';
                $out=false;
            }
        }

        // Validate passwrod and cofirm password
        if($out){
            if($password != $c_password){
                $msg='Password and Confirm Password is miss match!';
            }
        }

        // Token validation
        if($out && $token != ''){
            $query="SELECT COUNT(`token`) FROM `admins` WHERE `token`='$token'";
            $row=mysqli_fetch_row(mysqli_query($conn,$query));
            if($row[0] != 1){
                $msg='Your token is not valid or expired!'; 
                $out=false; 
            }
        }

        if($out){
            $options = ['cost' => 12];
            $hashed_password = passwordHash($password);

            $query="UPDATE `admins` SET `password`='$hashed_password', `token`='' WHERE `token`='$token'";
            $result=mysqli_query($conn,$query);
            if(!$result){
                $msg='Something went to wrong! <br> Please contact support: '.getSupportEmail(); 
                $out=false; 
            }
        }

        return $out;
    }

    function forgotPasswordEmailValidate(){
        global $msg;
        $out=true;
        include('config.php');
        $token=tokenGenerate();

        if(isset($_REQUEST['email']))  $email=trim(mysqli_real_escape_string($conn,$_REQUEST['email']));

        // Empty fileds validation
        if($out){
            if(($email == '')){
                $msg = 'Please fill email feild';
                $out=false;
            }
        }
        // Validate email format
        if($out){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg="Email is not in correct email format";
                $out=false;
            }
        }

        if($out){
            $query="SELECT COUNT(`id`), `status` FROM `admins` WHERE `email`='$email'";
            $row=mysqli_fetch_row(mysqli_query($conn,$query));
            if($row[0]==1){
                if($row[1]==0){
                    $msg='Sorry, Your account is deactived! <br>If you need any help, Please contact support: '.getSupportEmail(); 
                    $out=false;
                }else{
                    $query="UPDATE `admins` SET `token`='$token' WHERE `email`='$email'";
                    $result=mysqli_query($conn,$query);
                    if(!$result){
                        $msg='Something went to wrong<br> Please contact support: '.getSupportEmail(); 
                        $out=false; 
                    }
                    if($out){
                        $email_inside_title = 'CHANGE PASSWORD';
                        $action_url=''.getPrimaryUrl().'/index.php?components=authentication&action=show_change_forgot_password&token='.$token;
                        include  'templates/emails/change_password.php';
                        $subject = 'Change '.getCompanyName().' account password';
                        $headers = "MIME-Version: 1.0" . "\r\n";
                        $headers .= "Content-type:text/html;charset=iso-8859-1" . "\r\n";
                        $headers .= "From: ".getFromEmail()."\r\n";
                        $sent=mail($email,$subject,$message,$headers);
                        if(!$sent){ 
                            $msg='Email Could Not be Sent.<br/> Please contact support: '.getSupportEmail(); 
                            $out=false; 
                        }else{
                            $msg='<br>We have sent you an email to change your current password (<b>'.$email.'</b>)<br>(Please wait 1-5 minutes)';
                        }
                    }
                }
            }else{
                $msg="Sorry, we could not find a associated account linked with this email";
                $out=false;
            }
        }

        return $out;
    }

    function login(){
        global $msg;
        $email = $password = '';
        $out=true;
        include('config.php');

        if($out){
            if(isset($_REQUEST['email']))  $email=trim(mysqli_real_escape_string($conn,$_REQUEST['email']));
            if(isset($_REQUEST['password'])) $password=$_REQUEST['password'];
        }

        // Empty fileds validation
        if($out){
            if(($email == '') || ($password == '')){
                $msg = 'Please fill all the required feilds';
                $out=false;
            }
        }

        // Validate email format
        if($out){
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $msg="Email is not in correct email format";
                $out=false;
            }
        }

        // Validate user
        if($out){
            $query="SELECT `id`,`password`,`type`,`status` FROM `admins` WHERE `email` = '$email'";
            $result = mysqli_query($conn,$query);
            $rows = mysqli_num_rows($result);
            if($rows != 1){
                $msg='Email or password is incorrect please check your credentials';
                $out=false;
            }else{
                $row = mysqli_fetch_row($result);
                $user_id = $row[0];
                $user_type = $row[2];
                $status = $row[3];
                if($status == 1){
                    $db_password = $row[1];
                    if(!password_verify($password, $db_password)){
                        $msg='Email or password is incorrect please check your credentials';
                        $out=false;
                    }else{
                        sessionsSet($email,$user_id,$user_type);
                    }
                }
                else if($status == 0){
                    $msg='Your account is disabled.<br>Please contact support: '.getSupportEmail();
                    $out=false;
                }
            }
        }
        return $out;
    }

    function sessionsSet($email,$user_id,$user_type){
        session_start();
        $_SESSION['email'] = $email;
        $_SESSION['user_id'] = $user_id;
        $_SESSION['user_type'] = $user_type;
        $_SESSION['fingerprint'] = md5($_SERVER['HTTP_USER_AGENT'] . $_SERVER['REMOTE_ADDR']);
    }

    function sessionsDestroy(){
        // remove all session variables
        session_unset();
        // destroy the session
        session_destroy();
    }

    function logout(){
        sessionsDestroy();
        return true;
    }

?>