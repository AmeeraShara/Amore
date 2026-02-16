<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8" />
        <title><?php echo getCompanyName(); ?> - Forgot Password</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="author" content="" />
        <meta name="MobileOptimized" content="320" />
        <!--Template style -->
        <link rel="stylesheet" type="text/css" href="css/admin/animate.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/fonts.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/flaticon.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/style.css" />
        <link rel="stylesheet" type="text/css" href="css/admin/responsive.css" />
    </head>
<script>
    function validateForgotPassword(){
        var $count=0;
        if(document.getElementById('email').value=='') $count++;
        if ($count!=0) {
            alert('Please fill the email feild');
        }else{
            document.getElementById('forgot_div').innerHTML="";
            document.getElementById('email_form').submit();
        }
    }

    function validatePasswords(){
        var count=0;
        password = document.getElementById('password').value;
        c_password = document.getElementById('c_password').value;
        if(password=='') count++;
        if(c_password=='') count++;
        if (count!=0) {
            alert('Please fill the all the required fields');
        }else{
            if(c_password != password){
                alert('Please make sure your passwords match');
            }else{
                var condtions =  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,15}$/;
                if(password.match(condtions)) { 
                    document.getElementById('change_pass_div').innerHTML="";
                    document.getElementById('change_pass_form').submit();
                }else{
                    alert('Password should be at least 8 characters (max 15) in length and should include at least one capital letter, one simple letter, one number, and one special character');
                }
            }
        }
    }

    function togglePassword(){
        const togglePassword = document.getElementById('toggle_password');
        const password = document.getElementById('password');
        const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
        password.setAttribute('type', type);
        togglePassword.classList.toggle('fa-eye-slash');
    }
    function toggleCPassword(){
        const toggleCPassword = document.getElementById('toggle_c_password');
        const c_password = document.getElementById('c_password');
        const type = c_password.getAttribute('type') === 'password' ? 'text' : 'password';
        c_password.setAttribute('type', type);
        toggleCPassword.classList.toggle('fa-eye-slash');
    }

</script>

<body>
    <!-- login wrapper start -->
    <div class="login_wrapper float_left" style="margin-bottom: 100px;">
        <div class="container">
            <div class="row">
                <?php if(isset($_REQUEST['message'])){ ?>
                <div class="container">
                    <div class="row" style="text-align: center; margin-bottom: 40px;">
                        <div class="col-12">
                            <?php if(isset($_REQUEST['re']) && ($_REQUEST['re'] == 'fail')){ ?>
                                <div class="alert alert-danger" role="alert">
                                    <h5 class="alert-heading">Opps.. Something is wrong here.</h5>
                                    <br>
                                    <p><?php echo $_REQUEST['message']; ?></p>
                                    <hr>
                                    <p class="mb-0">Please fix the errors and resubmit login form.</p>
                                </div>
                            <?php } ?>
                            <?php if(isset($_REQUEST['re']) && ($_REQUEST['re'] == 'success')){ ?>
                                <div class="alert alert-success" role="alert">
                                    <p><?php echo $_REQUEST['message']; ?></p>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </div>
                <?php } ?>
                <div class="col-lg-12 col-md-12 col-sm-12">
                    <div class="login_top_box float_left">
                        <div class="login_banner_wrapper">
                        </div>
                        <?php if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'show_forgot_password')){ ?>
                        <div class="login_form_wrapper">
                            <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd">
                                <h3 style="color:black;"> Forgot Password? </h3>
                            </div>
                            <form action="index.php?components=authentication&action=forgot_validate_email" id="email_form" method="POST">
                                <div class="form-group icon_form comments_form">
                                    <input type="email" class="form-control require" id="email" name="email"
                                        placeholder="Enter your email address *">
                                </div>
                                <br>
                                <div class="about_btn login_btn float_left" id="forgot_div">
                                    <a href="#" onclick="validateForgotPassword();">Send Password Change Link</a>
                                </div>
                                <div class="dont_have_account float_left" id="sign_up_div">
                                    <p>Go back to <a href="index.php?components=authentication&action=show_login">Login</a></p>
                                </div>
                            </form>
                        </div>
                        <?php } ?>
                        <?php if(isset($_REQUEST['action']) && ($_REQUEST['action'] == 'show_change_forgot_password')){ ?>
                            <div class="login_form_wrapper">
                                <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd">
                                    <h3 style="color:black;"> Change Password </h3>
                                </div>
                                <form action="index.php?components=authentication&action=change_forgot_password" id="change_pass_form" method="POST">
                                    <input type="hidden" name="token" value="<?php if(isset($_REQUEST['token'])) print $_REQUEST['token']; ?>">
                                    <div class="form-group icon_form comments_form register_contact">
                                        <input type="password" class="form-control require" id="password" name="password" placeholder="New Password *">
                                        <i class="fa fa-eye" id="toggle_password" style="cursor: pointer;" onclick="togglePassword()"></i>
                                    </div>
                                    <div class="form-group icon_form comments_form register_contact">
                                        <input type="password" class="form-control require" id="c_password" name="c_password" placeholder="Confirm Password *">
                                        <i class="fa fa-eye" id="toggle_c_password" style="cursor: pointer;" onclick="toggleCPassword()"></i>
                                    </div>
                                    <br>
                                    <div class="about_btn login_btn float_left" id="change_pass_div">
                                        <a href="#" onclick="validatePasswords();">Change Password</a>
                                    </div>
                                </form>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login wrapper end -->

    <!--custom js files-->
    <script src="js/admin/jquery-3.3.1.min.js"></script>
    <script src="js/admin/bootstrap.min.js"></script>
    <!-- custom js-->
</body>

</html>