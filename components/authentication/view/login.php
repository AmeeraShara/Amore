<!DOCTYPE html>
<html lang="eng">
    <head>
        <meta charset="utf-8" />
        <title><?php  ?> - Login</title>
        <meta content="width=device-width, initial-scale=1.0" name="viewport" />
        <meta name="author" content="" />
        <meta name="MobileOptimized" content="320" />
        <!--Template style -->
        <link rel="stylesheet" type="text/css" href="../../../css/admin/animate.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/bootstrap.min.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/fonts.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/flaticon.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/font-awesome.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/style.css" />
        <link rel="stylesheet" type="text/css" href="../../../css/admin/responsive.css" />
        <!--favicon-->
        <!-- <link rel="shortcut icon" type="image/png" href="images/favicon.png" /> -->
    </head>
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
                        <div class="login_form_wrapper">
                            <div class="sv_heading_wraper heading_wrapper_dark dark_heading hwd">
                                <h3 style="color:black;"> login to enter</h3>
                            </div>
                            <form action="index.php?components=authentication&action=login" id="login_form" method="POST">
                                <div class="form-group icon_form comments_form">
                                    <input type="email" class="form-control require" id="email" name="email"
                                        placeholder="Email Address *">
                                </div>
                                <div class="form-group icon_form comments_form">
                                    <input type="password" class="form-control require" id="password" name="password" placeholder="Password *">
                                    <i class="fa fa-eye" id="toggle_password" style="cursor: pointer;" onclick="togglePassword()"></i>
                                </div>
                                <div class="login_remember_box">
                                    <a href="index.php?components=authentication&action=show_forgot_password" class="forget_password">
                                        Forgot Password
                                    </a>
                                </div>
                                <div class="about_btn login_btn float_left" id="login_div">
                                    <a href="#" onclick="validateLogin();">login</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- login wrapper end -->
    
    <script src="js/admin/jquery-3.3.1.min.js"></script>
    <script src="js/admin/bootstrap.min.js"></script>
    
    <!--custom js files-->
    <script>
        function validateLogin(){
            var $count=0;
            if(document.getElementById('email').value=='') $count++;
            if(document.getElementById('password').value=='') $count++;
            if ($count!=0) {
                alert('Please fill the all the required fields');
            }else{
                document.getElementById('login_div').innerHTML="";
                document.getElementById('login_form').submit();
            }
        }
        function togglePassword(){
            const togglePassword = document.getElementById('toggle_password');
            const password = document.getElementById('password');
            const type = password.getAttribute('type') === 'password' ? 'text' : 'password';
            password.setAttribute('type', type);
            togglePassword.classList.toggle('fa-eye-slash');
        }

    </script>
    <!-- custom js-->
</body>


</html>