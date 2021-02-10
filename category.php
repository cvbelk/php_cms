<?php include "includes/db.php"; ?>
<?php include "includes/header.php"?>
<?php include "admin/functions.php";?>
<!-- Navigation -->
<?php include "includes/navigation.php"?>

    <!-- Page Content -->
    <div class="container">

        <div class="row">

            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
<?php                
if (isset($_GET['c_id'])) {
    $category_id = $_GET['c_id'];
    //chapter 38 PREPARE STATEMENTS
    //if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
    if(isset($_SESSION['user_role']) && is_Admin($_SESSION['user_name'])) {
        $stmt1 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? ORDER BY post_id DESC");
        //$query = "SELECT * FROM posts WHERE post_category_id = $category_id ORDER BY post_id DESC";

    } else {
        $stmt2 = mysqli_prepare($connection, "SELECT post_id, post_title, post_user, post_date, post_image, post_content FROM posts WHERE post_category_id = ? AND post_status = ? ORDER BY post_id DESC");
        $published = 'published';
        //$query = "SELECT * FROM posts WHERE post_category_id = $category_id AND post_status = 'published' ORDER BY post_id DESC";
    }        

    //$select_all_posts_query = mysqli_query($connection, $query);
    //confirmQuery($select_all_posts_query);
    if(isset($stmt1)) {
        mysqli_stmt_bind_param($stmt1, "i", $category_id); //if param type int: "i", if string: "s"
        mysqli_stmt_execute($stmt1);
        mysqli_stmt_bind_result($stmt1, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
        $stmt = $stmt1;
    } else {
        mysqli_stmt_bind_param($stmt2, "is", $category_id, $published);
        mysqli_stmt_execute($stmt2);
        mysqli_stmt_bind_result($stmt2, $post_id, $post_title, $post_user, $post_date, $post_image, $post_content);
        $stmt = $stmt2;  
    }
    mysqli_stmt_store_result($stmt);
    //print "<h1>num rows: " . mysqli_stmt_num_rows($stmt) . "</h1>";
    if(mysqli_stmt_num_rows($stmt) < 1) {

        print "<h1 class='text-center'>No published posts available in category {$category_id}</h1>";
    }else {
        while(mysqli_stmt_fetch($stmt)){
        
    ?>
                <h1 class="page-header">
                    Page Heading
                    <small>Secondary Text</small>
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="/cms/post/<?php echo $post_id;?>"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts.php?user=<?php echo $post_user; ?>&p_id=<?php echo $post_id;?>"><?php echo $post_user; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <a href="/cms/post/<?php echo $post_id;?>">
                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                </a>
                <hr>
                <p><?php echo $post_content; ?></p>
                <a class="btn btn-primary" href="/cms/post/<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>
                <hr>
<?php 
        }   
    }    
    
mysqli_stmt_close($stmt);
} else {
    header("Location: /cms/");
}
?>


            </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"?>
