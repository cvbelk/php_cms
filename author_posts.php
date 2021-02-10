<?php include "includes/db.php"; ?>
<?php include "includes/header.php";?>
<?php include "admin/functions.php";?>
<!-- Navigation -->
<?php include "includes/navigation.php"?>
    <!-- Page Content -->
    <div class="container">
        <div class="row">
            <!-- Blog Entries Column -->
            <div class="col-md-8">
                
<?php
    if (isset($_GET['user'])) {
    $the_post_id = $_GET['p_id'];    
    $user = $_GET['user'];    
    $query = "SELECT * FROM posts WHERE post_user = '{$user}' ";
    $select_post_query = mysqli_query($connection, $query);
    confirmQuery($select_post_query);    
    while($row = mysqli_fetch_assoc($select_post_query)) {
        $post_title = $row['post_title'];
        $post_user = $row['post_user'];
        $post_date = $row['post_date'];
        $post_image = $row['post_image'];
        $post_content = $row['post_content'];
        $post_id = $row['post_id'];
?>
    <h1 class="page-header">
        All posts by <?php echo $post_user; ?>
        <small>Secondary Text</small>
    </h1>
    <!-- First Blog Post -->
    <h2>
        <a href="/cms/post/<?php echo $post_id;?>"><?php echo $post_title; ?></a>
    </h2>
    <p class="lead">
        by <?php echo $post_user; ?>
    </p>
    <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
    <hr>
    <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
    <hr>
    <p><?php echo $post_content; ?></p>
    <a class="btn btn-primary" href="/cms/post/<?php echo $post_id;?>">Read More <span class="glyphicon glyphicon-chevron-right"></span></a>    
    <hr>
<?php 
    }
}
?>
    </div>
            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->
        <hr>
<?php include "includes/footer.php"?>