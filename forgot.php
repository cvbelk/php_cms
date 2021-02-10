<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
?>
<?php include "includes/db.php"; ?>
<?php include "includes/header_forgot.php"; ?>
<?php include "admin/functions.php"; ?>


<?php
require './vendor/autoload.php';
//require './classes/config.php';
$err_show = "hidden";
$err_message = "";
if (!isCurrentHttpMethod('get') && !isset($_GET['forgot'])) {
    redirectTo('/cms/');
} //else {
//     $forgot_id = $_GET['forgot'];
//     //print "<pre>" . $forgot_id . "</pre>";
// }
// $tem = new Config();
// echo get_class($tem);
//echo "SERVER_NAME: " . $_SERVER['SERVER_NAME'] . " self: " . $_SERVER['PHP_SELF'];

if (isCurrentHttpMethod('post')){
    if (isset($_POST['email'])){
        $user_email = escapeStr($_POST['email']);
        $token_length = 50;
        $token = bin2hex(openssl_random_pseudo_bytes($token_length));
        if (emailExistsStmt($user_email)) {

            if($stmt = mysqli_prepare($connection, "UPDATE users SET user_token = '{$token}' WHERE user_email = ? ")) {
                mysqli_stmt_bind_param($stmt, "s", $user_email);
                mysqli_stmt_execute($stmt);        
                mysqli_stmt_close($stmt);
                
                //  Configuring mailer    
                 
                $mail = new PHPMailer(true);
                //echo get_class($mail);
                try {
                    $mail->SMTPDebug = 0; //SMTP::DEBUG_SERVER;                      
                    $mail->isSMTP();                                            
                    $mail->Host       = Config::SMTP_HOST;                    
                    $mail->SMTPAuth   = true;                                   
                    $mail->Username   = Config::SMTP_USER;                     
                    $mail->Password   = Config::SMTP_PASSWORD;                               
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;         
                    $mail->Port       = Config::SMTP_PORT;

                    $mail->CharSet = 'UTF-8'; //localisation !!!
                    //$mail->setLanguage('ru', './vendor/phpmailer/phpmailer/language/');
                    //--------
                    $mail->setFrom('site@trollcms.com', 'TrollCMS');
                    $mail->addAddress($user_email, 'Joe User');
                    $mail->isHTML(true);
                    $mail->Subject = 'Forgot password ';
                    $token_link = "<a href='http://" . $_SERVER['SERVER_NAME'] . "/cms/reset.php?email=".$user_email."&forgot=" . $token . "'>посиланням</a>"; 
                    $mail->Body = "<p>Для зміни паролю перейдіть за " . $token_link . " <br>From  <b>TrollCMS</b></p>";
                    if ($mail->send()) {
                        //echo 'Message has been sent';
                        $emailSent = true;
                        //$err_show = "show bg-success";
                        //$err_message .= "Message sent! Check your email";
                    }   
                } catch (Exception $e) {
                    //echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                    $err_show = "bg-danger show";
                    $err_message .= " Emailing goes wrong ";
                }
            }else{
                $err_show = "bg-danger show";
                $err_message .= " Error in DB: " . mysqli_stmt_error($stmt);
            }
        } else {
            $err_show = "bg-danger show";
            $err_message .= " Email no exist ";
        } 
    }//endif isset email
} //endif POST

?>

<div class="container">

    <!--div class="form-gap"></div-->
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">

                                <?php if(!isset( $emailSent)): ?>
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
                                        <p class=" <?php print $err_show; ?>"><?php print $err_message; ?></p>
                                    </form>

                                </div><!-- Body-->
                                <?php else: ?>
                                    <h3><i class="fa fa-envelope fa-4x"></i></h3>
                                    <h2 class="text-center">Email Sent</h2>
                                    <p>Check your email to reset your password.</p>
                                    <div class="panel-body"> </div>


                                <?php endIf; ?>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

<div id="bamper"></div>
    <hr>
<!--/div--> <!-- /.container -->
    <?php include "includes/footer.php";?>



