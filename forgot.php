<?php
 
use PHPMailer\PHPMailer\PHPMailer; // needs to be on top !!!
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
//require './vendor/phpmailer/phpmailer/src/PHPMailerAutoload.php';
//require './classes/Config.php'; 
require 'vendor/autoload.php';
require './vendor/phpmailer/phpmailer/src/Exception.php';
require './vendor/phpmailer/phpmailer/src/PHPMailer.php';
require './vendor/phpmailer/phpmailer/src/SMTP.php';

?>
<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<?php 

  
?>

<?php
    if(!ifItIsMethod('get') && !isset($_GET['forgot'])){
        redirect('/cms/index');

    }
    if(ifItIsMethod('post')){
        if(isset($_POST['email'])){
            $email = $_POST['email'];
            $length = 50;
            $token = bin2hex(openssl_random_pseudo_bytes($length));

            //var_dump(email_exists($email));
            //exit;
            if(email_exists($email)){
                $stmt = mysqli_prepare($connection, "UPDATE users SET token = '{$token}' WHERE user_email = ?");
                mysqli_stmt_bind_param($stmt, "s", $email);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_close($stmt);


                /*****
                 * configure  PHPmailer
                 * 
                 * 
                 * 
                 * 
                 * 
                 */
                $mail = new PHPMailer();
                try {
                    //Server settings
                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = Config::SMTP_HOST;                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = Config::SMTP_USER;                         //SMTP username
                    $mail->Password   = Config::SMTP_PASSWORD;                             //SMTP password
                    $mail->SMTPSecure = 'tls';            //Enable implicit TLS encryption
                    $mail->Port       = Config::SMTP_PORT;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                    $mail->CharSet = 'UTF-8';
                    //$mail->isHTML(true);
                    //Recipients
                    $mail->setFrom('joshadamkerbel@gmail.com', 'Dr Josh');
                    $mail->addAddress($email);     //Add a recipient
                    // $mail->addAddress('ellen@example.com');               //Name is optional
                    // $mail->addReplyTo('info@example.com', 'Information');
                    // $mail->addCC('cc@example.com');
                    // $mail->addBCC('bcc@example.com');
                
                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name
                
                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->CharSet = 'UTF-8';
                    $mail->Subject = 'Here is the subject';
                    $mail->Body    = '<h1>This is the HTML message body</h1> <b>in bold!</b><br>Cómo estás, hijo de puta';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                
                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
                
            }else{
                echo "Wrong";
            }

        }
    }



?>



<!-- Page Content -->
<div class="container">

    <div class="form-gap"></div>
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">


                                <h3><i class="fa fa-lock fa-4x"></i></h3>
                                <h2 class="text-center">Forgot Password?</h2>
                                <p>You can reset your password here.</p>
                                <div class="panel-body">




                                    <form id="register-form" role="form" autocomplete="off" class="form" method="post">

                                        <div class="form-group">
                                            <div class="input-group">
                                                <span class="input-group-addon"><i class="glyphicon glyphicon-envelope color-blue"></i></span>
                                                <input id="email" name="email" placeholder="email address" class="form-control"  type="email">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <input name="recover-submit" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                        </div>

                                        <input type="hidden" class="hide" name="token" id="token" value="">
                                        <p>Please check your email</p>
                                    </form>

                                </div><!-- Body-->

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <hr>

    <?php include "includes/footer.php";?>

</div> <!-- /.container -->

