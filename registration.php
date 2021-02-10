<?php  include "includes/db.php"; ?>
<?php  include "includes/header.php"; ?>
<!-- Navigation -->
<?php  include "includes/navigation.php"; ?>
<?php  include "admin/functions.php"; ?>
<?php
//if (isset($_POST['submit'])) {     //BETTER WAY TO HANDLE POST REQUEST
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    $user_name = trim($_POST['username']);
    $user_email = trim($_POST['email']);
    $user_password = trim($_POST['password']);
    $error = [
        'username' => '',
        'email' => '',
        'password' => ''
    ];
    if (strlen($user_name) < 4) {
        $error['username'] = 'Username too short';
    }
    if ($user_name == '') {
        $error['username'] = 'Username cannot be empty!';
    }
    if (usernameExists($user_name)) {
        $error['username'] = 'Username exists';
    }

    if ($user_email == '') {
        $error['email'] = 'Email cannot be empty!';
    }
    if (emailExists($user_name)) {
        $error['email'] = "Email exists, <a href='index.php'>Login</a>";
    }

    if ($user_password == '') {
        $error['password'] = 'Password cannot be empty!';
    }
    foreach ($error as $key => $value) {
        if(empty($value)){
            unset($error[$key]);
        }
    }//foreach
    if(empty($error)){
        registerUser($user_name, $user_email, $user_password);
        if( loginUser($user_name, $user_password)) {
            redirectTo(" admin/profile.php");
       }
    }
}

?>    
<!-- Page Content -->
<div class="container">
    
<section id="login">
    <div class="container">
        <div class="row">
            <div class="col-xs-6 col-xs-offset-3">
                <div class="form-wrap">
                <h1 class="text-center">Register</h1>
                    <form role="form" action="registration.php" method="post" id="login-form" autocomplete="off">
                        <h6 <?php //print $message_class; ?>><?php //print $message; ?></h6>
                        <div class="form-group">
                            <label for="username" class="sr-only">username</label>
                            <input type="text" name="username" id="username" class="form-control" placeholder="Enter Desired Username" autocomplete="on" value="<?php echo isset($user_name) ? $user_name : ''; ?>">
                            <p><?php echo isset($error['username']) ? $error['username'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="email" class="sr-only">Email</label>
                            <input type="email" name="email" id="email" class="form-control" placeholder="somebody@example.com" autocomplete="on" value="<?php echo isset($user_email) ? $user_email : ''; ?>">
                            <p><?php echo isset($error['email']) ? $error['email'] : ''; ?></p>
                        </div>
                         <div class="form-group">
                            <label for="password" class="sr-only">Password</label>
                            <input type="password" name="password" id="key" class="form-control" placeholder="Password">
                            <p><?php echo isset($error['password']) ? $error['password'] : ''; ?></p>
                        </div>
                        <input type="submit" name="register" id="btn-login" class="btn btn-custom btn-lg btn-block" value="Register">
                    </form>
                 
                </div>
            </div> <!-- /.col-xs-12 -->
        </div> <!-- /.row -->
    </div> <!-- /.container -->
</section>
<hr>
<?php include "includes/footer.php";?>