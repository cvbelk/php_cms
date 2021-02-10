
<?php
$login_err_show = "hidden";
if (isset($_POST['login'])) {
   if (loginUser($_POST['user_name'], $_POST['user_password'])) {
    redirectTo(" /cms/admin/");
   } else {
    $login_err_show = "show";
   }
}
?>   

            <div class="col-md-4">
   
                <!-- Blog Search Well -->
                <div class="well">
                    <h4>Blog Search</h4>
                    <form action="/cms/search.php" method="post">
                    <div class="input-group">
                        <input name="search" type="text" class="form-control">
                        <span class="input-group-btn">
                            <button name="submit" class="btn btn-default" type="submit">
                                <span class="glyphicon glyphicon-search"></span>
                        </button>
                        </span>
                    </div>
                    <!-- /.input-group -->
                    </form><!--search form-->
                </div>

               <!-- Login Well -->
                <div class="well">

                <?php if(isset($_SESSION['user_role'])):  ?> <!--//if() shorthand style-->
                    
                       <h4>Logged in as <?php print $_SESSION['user_name']; ?></h4>
                        <a href="includes/logout.php" class="btn btn-primary" name="Logout" >Logout</a>
                <?php else: ?>
                    <h4>Sign in</h4>
                    <form action="" method="post"> <!--action="includes/login.php"-->
                        <div class="form-group">
                            <input name="user_name" type="text" class="form-control" placeholder="Enter username">
                         </div>
                         <div class="input-group">
                            <input name="user_password" type="password" class="form-control" placeholder="Enter password">
                            <span class="input-group-btn" >
                                <button class="btn btn-primary" name="login" type="submit">Login
                                </button>
                            </span>
                        </div>
                        <div class="form-group <?php print $login_err_show; ?>">
                            <p class="bg-danger ">Incorrect password or username</p>
                            <a href="forgot.php?forgot=<?php echo uniqid(true);?>">Forgot password?</a>
                        </div>
                        
                    </form>
                <?php endif;?>
                    
                </div>
                <!-- Blog Categories Well -->
                <div class="well">

<?php
    $query = "SELECT * FROM categories "; // 'LIMIT 3' query list limited to 3 items
    $select_categories_sidebar = mysqli_query($connection, $query);
    if (!$select_categories_sidebar) {
        die("cannnot query to db for categories list");
    }                
?>
                   
                    <h4>Blog Categories</h4>
                    <div class="row">
                        <div class="col-lg-12">
                           
                            <ul class="list-unstyled">
<?php 
        while($row = mysqli_fetch_assoc($select_categories_sidebar)) {
            $cat_title = $row['cat_title'];
            $cat_id = $row['cat_id'];
            print "<li> <a href='/cms/category/{$cat_id}'>{$cat_title} </a></li>";
        }
?>                                
                            </ul>
                        </div>

                        <!-- /.col-lg-6 -->
                    </div>
                    <!-- /.row -->
                </div>
<?php include "widget.php" ?>


            </div>