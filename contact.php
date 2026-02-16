<?php include_once('templates/header.php'); ?>

<?php
    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $out=true;
        $full_name = $email = $message = $subject = '';
        $msg='Your enquiry is recived, We will reach you as soon as possible. Thank you!';

        // Name validation
        if($out){
            if((isset($_REQUEST['name'])) && ($_REQUEST['name'] != '')) {
                $full_name = ucwords(trim($_REQUEST['name']));
            }else{
                $msg='Please fill your full name.';
                $out=false;
            }
        }

        // Contact validation
        // if($out){
        //     if((isset($_REQUEST['contact_no'])) && ($_REQUEST['contact_no'] != '')) {
        //         $contact_no = trim($_REQUEST['contact_no']);
        //     }else{
        //         $msg='Please check your contact no.';
        //         $out=false;
        //     }
        // }

        // Validate email 
        if($out){
            if((isset($_REQUEST['email'])) && ($_REQUEST['email'] != '')) {
                if(filter_var($_REQUEST['email'], FILTER_VALIDATE_EMAIL)){
                    $email = trim($_REQUEST['email']);
                }else{
                    $msg="Email is not in correct email format";
                    $out=false;
                }
            }else{
                $msg='Please fill your working email address.';
                $out=false;
            }
        }

        // Subject validation
        if($out){
            if((isset($_REQUEST['subject'])) && ($_REQUEST['subject'] != '')) {
                $subject = trim($_REQUEST['subject']);
            }else{
                $msg="Subject cannot be empty!";
                $out=false;
            }
        }

        // Message validation
        if($out){
            if((isset($_REQUEST['message'])) && ($_REQUEST['message'] != '')) {
                $message = trim($_REQUEST['message']);
            }else{
                $msg="Message cannot be empty!";
                $out=false;
            }
        }

        if($out){
            $messageBody = $mailSubject = '';
            $mailSubject = 'Enquiry from '.getCompanyName().' Website';

            // <p><b>Phone No:</b> ".$contact_no."</p>
            $messageBody = "<p>Hi,</p>
            <p><b>".$full_name."</b> has sent a message having </p>
            <p><b>Email :</b> ".$email."</p>
            <p><b>Subject:</b> ".$subject."</p>
            <p><b>Query is:<br></b> ".$message."</p>";
            
            $fromEmail = getFromEmail();
            $toEmail = getToEmail();
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            $headers .= "From: <$fromEmail>" . "\r\n";
    
            if(!mail($toEmail , $mailSubject , $messageBody , $headers)){
                $out=false;
                $msg='Something went to wrong, Please try again';
            }
        }
        if($out){ 
            $_REQUEST['name'] = $_REQUEST['email'] = $_REQUEST['subject'] = ''; 
            $response = ' 
                <div class="alert alert-success alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                Thank you for contacting us and we will get back to you as soon as possible.
            </div>';
        }else{
            $response = ' <div class="alert alert-danger alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <strong>Error: </strong>'.$msg.'
                    </div>';
        }
    }
?>

<!-- TODO  -->

    <!-- BANNER -->
    <section class="banner-tems text-center bg-contact-us">
        <div class="container">
            <div class="banner-content">
                <h2>Contact us</h2>
                <p>For all enquiries, please email us using the form below.</p>
            </div>
        </div>
    </section>
    <!-- END / BANNER -->

    <!-- CONTACT -->
    <section class="section-contact">
        <div class="container">
            <div class="contact">
                <div class="row" id="div-email-response">
                    <div class="col-12 text-center">
                        <?php 
                            if(isset($response)) {
                                echo $response;
                            }
                        ?>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-lg-5">
                        <div class="text">
                            <h2>Contact</h2>
                            <p>Contact Help team.</p>
                            <ul>
                                <li><i class=" fa ion-ios-location-outline"></i> <?php echo getAddress(); ?></li>
                                <li><i class="fa fa-phone" aria-hidden="true"></i> <?php echo getContactMobileNumber(); ?></li>
                                <li><i class="fa fa-envelope-o" aria-hidden="true"></i><?php echo getSupportEmail(); ?></li>
                            </ul>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-6 col-lg-offset-1">
                        <div class="contact-form">
                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <input type="text" id="name" class="field-text" name="name" placeholder="Name" value="<?php  if(isset($_POST['submit'])) echo $_REQUEST['name']; ?>">
                                    </div>
                                    <div class="col-sm-6">
                                        <input type="text" id="email" class="field-text" name="email" placeholder="Email" value="<?php  if(isset($_POST['submit'])) echo $_REQUEST['email']; ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <input type="text" id="subject" class="field-text" name="subject" placeholder="Subject" value="<?php  if(isset($_POST['submit'])) echo $_REQUEST['subject']; ?>">
                                    </div>
                                    <div class="col-sm-12">
                                        <textarea cols="30" rows="10" name="message" class="field-textarea" placeholder="Write your enquire"></textarea>
                                    </div>
                                    <div id="div-waiting" class="text-center"></div>
                                    <div class="col-sm-6">
                                        <button type="submit" id="button" class="btn btn-room" name="submit" onclick="clearForm();">SEND</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- END / CONTACT -->

    <!-- MAP -->
    <div class="section-map">
       <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3965.7826495338822!2d80.03852911506368!3d6.292271595445915!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3ae181cebc603721%3A0xfb00e78076c39c45!2sAmore!5e0!3m2!1sen!2slk!4v1666582653866!5m2!1sen!2slk" height="470" allowfullscreen></iframe>
    </div>
    <!-- END / MAP -->

<script type="text/javascript">
    function clearForm() {
        document.getElementById('button').style.display = 'none';
        document.getElementById('div-waiting').innerHTML = 'Wait, Your message is in sending queue..';
    }

    function displayButton(){
        document.getElementById('button').style.display = 'inline';
    }
</script>

<?php include_once('templates/footer.php'); ?>
