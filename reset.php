<?php  include "includes/db.php"; ?>
<?php  include "includes/header_forgot.php"; ?>
<?php include "admin/functions.php"; ?>


<?php 
if (!isset($_GET['email']) && !isset($_GET['forgot'])) {
    redirectTo('/cms/');
}

$forgot_token = $_GET['forgot'];
$forgot_email = $_GET['email'];
if($stmt = mysqli_prepare($connection, "SELECT user_name, user_email, user_token FROM users WHERE user_token = ? AND user_email = ?")) {
    mysqli_stmt_bind_param($stmt, "ss", $forgot_token, $forgot_email);
    mysqli_stmt_execute($stmt);  
    mysqli_stmt_bind_result($stmt, $db_username, $db_email, $db_token);
    //mysqli_stmt_store_result($stmt);
    mysqli_stmt_fetch($stmt);
    mysqli_stmt_close($stmt);
    //echo $db_username . "<br>" . $db_email . "<br>" . $db_token;
    if (empty($db_username) || empty($db_token)) {
        redirectTo('/cms/');
    }

    $err_show = "hidden";
    $err_message = "";
    if (isCurrentHttpMethod('post')){
        if (!empty($_POST['password']) && !empty($_POST['confirmPassword'])) {
            //echo "first: " . $_POST['password'] . " second: " . $_POST['confirmPassword'] . " end";        
            if ($_POST['password'] === $_POST['confirmPassword']) {
                
                $password = $_POST['password'];
                $hashed_password = password_hash($password, PASSWORD_BCRYPT, array('cost' => 10));
                //---------------------
                if(updatePassword($hashed_password, $db_email)) {
                    // $err_show = "bg-success show";
                    // $err_message .= " Password updated!";
                    redirectTo('/cms/login');
                } else {
                    $err_show = "bg-danger show";
                    $err_message .= " Updating pass error";                    
                }

            }else {
                $err_show = "bg-danger show";
                $err_message .= " Entered passwords mismatch";
            }
        } else {
            $err_show = "bg-danger show";
            $err_message .= "Empty field";
        }
    }    
}
?>


<!-- Page Content -->
<div class="container">
 
 
 
    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-body">
                        <div class="text-center">
 
 
                            <h3><i class="fa fa-lock fa-4x"></i></h3>
                            <h2 class="text-center">Reset Password</h2>
                            <p>You can reset your password here.</p>
                            <div class="panel-body">
 
 
                                <form id="register-form" role="form" autocomplete="off" class="form" method="post">
 
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-user color-blue"></i></span>
                                            <input id="password" name="password" placeholder="Enter password" class="form-control"  type="password">
                                        </div>
                                    </div>
 
                                    <div class="form-group">
                                        <div class="input-group">
                                            <span class="input-group-addon"><i class="glyphicon glyphicon-ok color-blue"></i></span>
                                            <input id="confirmPassword" name="confirmPassword" placeholder="Confirm password" class="form-control"  type="password">
                                        </div>
                                    </div>
 
                                    <div class="form-group">
                                        <input name="resetPassword" class="btn btn-lg btn-primary btn-block" value="Reset Password" type="submit">
                                    </div>
 
                                    <input type="hidden" class="hide" name="token" id="token" value="">
                                    <p class=" <?php print $err_show; ?>"><?php print $err_message; ?></p>
                                </form>
 
                            </div><!-- Body-->
 
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 
 
    <div id="bamper"></div>
    <hr>

    <?php include "includes/footer.php";?>



