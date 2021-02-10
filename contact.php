<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
    <!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<?php  include "admin/functions.php"; ?>
<script type="text/javascript" src="ckeditor5/ckeditor.js" ></script>
<?php
if (isset($_POST['submit'])) {
    $to = "support@trollcms.com";
    $user_email = "From: " . escapeStr($_POST['email']);
    $subject = escapeStr($_POST['subject']);    
    $body = trim($_POST['message']);
    $body = wordwrap($body,70);
    
    mail($to,$subject,$body,$user_email);
}
?>    
<!-- Page Content -->
<div class="container">

<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center">Contact</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com">
                        </div>
                         <div class="form-group">
                            <label for="subject" class="sr-only">Subject</label>
                            <input type="text" name="subject" id="subject" class="form-control" placeholder="Subject...">
                        </div>
                         <div class="form-group">
                            <label for="message" class="sr-only">Message</label>
                            <textarea name="message" id="body" rows="10" class="form-control"></textarea>
                            <!--input type="password" name="password" id="key" class="form-control" placeholder="Password"-->
                        </div>
                        <input type="submit" name="submit" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Send">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>
<?php initCkEditor(); ?>
<?php include "includes/footer.php";?>
