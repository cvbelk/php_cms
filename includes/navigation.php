  
      <!-- Navigation -->
    <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="/cms/">TrollCMS</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                
                <?php 
                    
                    $query = "SELECT * FROM categories";
                    $select_all_categories_query = mysqli_query($connection, $query);
                    if (!$select_all_categories_query) {
                        die("cannnot query to db for categories list");
                    }
                    while($row = mysqli_fetch_assoc($select_all_categories_query)) {
                        $cat_title = $row['cat_title'];
                        $cat_id = $row['cat_id'];
                        //making menu links active
                        $category_class = '';
                        $registration_class = '';
                        $login_class = '';
                        $pageName = basename($_SERVER['PHP_SELF']);
                        $registration_page = "registration.php";
                        $login_page = "login.php";
                        if(isset($_GET['c_id']) && $_GET['c_id'] == $cat_id) {
                          $category_class = 'active';
                        } else if($pageName == $registration_page) {
                          $registration_class = 'active';
                        } else if($pageName == $login_page) {
                          $login_class = 'active';
                        }
                        print "<li class='{$category_class}'> <a href='/cms/category/{$cat_id}'>{$cat_title} </a></li>";

                    }
                ?>
                  </ul>
                  <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="/cms/admin/">Admin</a>
                    </li>
            <?php  //"edit" post in top navbar
                 session_start();
                 if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == "admin") {
                     //echo "<li>'{$_SESSION['user_role']}'</li>";
                     //$the_user_role = $_SESSION['user_role'];
                     //if ($the_user_role = 'admin') {
                         if (isset($_GET['p_id'])) {
                             $the_post_id = $_GET['p_id'];
                             print "<li><a href='/cms/admin/posts.php?source=edit_post&post_id={$the_post_id}'>Edit Post</a></li>";
                         }
                    //}   
                 }
            ?>       
 
            <?php
                 if (!isset($_SESSION['user_name'])){    
                    print "<li class='{$registration_class}'><a href='/cms/registration'>Register</a></li>";
                    print "<li class='{$login_class}'><a href='/cms/login'>Login</a></li>";
                 }
            ?>
<li><a href='/cms/contact'>Contact</a></li>            
        <!-- start-->
                                
<?php if (isset($_SESSION['user_name'])) {
    print "<li class='dropdown'><a href='#' class='dropdown-toggle' data-toggle='dropdown'><i class='fa fa-user'></i>"; 

    print " " . $_SESSION['user_name'];

    print "<b class='caret'></b></a><ul class='dropdown-menu'> <li>
            <a href='/cms/admin/profile.php'><i class='fa fa-fw fa-user'></i> Profile</a> </li> <li class='divider'></li> <li>
            <a href='includes/logout.php'><i class='fa fa-fw fa-power-off'></i> Log Out</a> </li> </ul> </li>";
} else{
   // header("Location: ../index.php");
    //print "<li><a href='registration.php'>register</a></li>";

}
?>                
                            
        <!-- end-->      
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav>