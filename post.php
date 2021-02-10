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
if (isset($_GET['p_id'])) {
    $post_id = $_GET['p_id'];    
    //post views modify
    $view_query = "UPDATE posts SET post_views_count = post_views_count + 1 WHERE post_id = $post_id ";
    $send_query = mysqli_query($connection, $view_query);
    confirmQuery($send_query);

    if(isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        $query = "SELECT * FROM posts WHERE post_id = {$post_id} ";
    } else {
        $query = "SELECT * FROM posts WHERE post_id = {$post_id} AND post_status = 'published'";
    }

    $select_post_query = mysqli_query($connection, $query);
    confirmQuery($select_post_query);

    if(mysqli_num_rows($select_post_query) < 1) {
        print "<h1 class='text-center'>No published post available</h1>";
    } else {
        while($row = mysqli_fetch_assoc($select_post_query)) {
            $post_title = $row['post_title'];
            $post_user = $row['post_user'];
            $post_date = $row['post_date'];
            $post_image = $row['post_image'];
            $post_content = $row['post_content'];
    ?>
                <h1 class="page-header">
                    Posts
                    <!--small>Secondary Text</small-->
                </h1>
                <!-- First Blog Post -->
                <h2>
                    <a href="#"><?php echo $post_title; ?></a>
                </h2>
                <p class="lead">
                    by <a href="/cms/author_posts.php?user=<?php echo $post_user; ?>&p_id=<?php echo $post_id;?>"><?php echo $post_user; ?></a>
                </p>
                <p><span class="glyphicon glyphicon-time"></span> Posted on <?php echo $post_date; ?></p>
                <hr>
                <img class="img-responsive" src="/cms/images/<?php echo imagePlaceholder($post_image); ?>" alt="">
                <hr>
                <p><?php echo $post_content; ?></p>
                <!--a class="btn btn-primary" href="#">Read More <span class="glyphicon glyphicon-chevron-right"></span></a-->
                <hr>
<?php 
    }

?>
             <!-- Blog Comments -->
<?php
    if (isset($_POST['create_comment'])){
        $post_id = $_GET['p_id'];
        $comment_author = $_POST['comment_author'];
        $comment_email = $_POST['comment_email'];
        $comment_content = $_POST['comment_content'];       
        if (!empty($comment_author) && !empty($comment_email) && !empty($comment_content)) {
                
            $query = "INSERT INTO comments (comment_post_id, comment_author, comment_email, comment_content, comment_status, comment_date) ";
            $query .= "VALUES({$post_id}, '{$comment_author}', '{$comment_email}', '{$comment_content}', 'unapproved', now() ) ";
            $create_comment_query = mysqli_query($connection, $query);
            confirmQuery($create_comment_query);
            //<!--table posts comments counters updating -->
            
//            $query = "UPDATE posts SET post_comment_count = post_comment_count + 1 ";
//            $query .= "WHERE post_id = $post_id ";
//            
//            $update_comment_count_query = mysqli_query($connection, $query);
//            confirmQuery($update_comment_count_query);
        } else {
            print "<script> alert('Fields can not be empty');</script>";
        }
    }
?>
                <!-- Comments Form -->
                <div class="well">
                    <h4>Leave a Comment:</h4>
                    <form role="form" method="post" action="">
                        <div class="form-group">
                           <label for="comment_author">Author</label>
                            <input type="text" class="form-control" name="comment_author">
                        </div>
                        <div class="form-group">
                           <label for="comment_email">Email</label>
                            <input type="text" class="form-control" name="comment_email">
                        </div>                                                     
                        <div class="form-group">
                           <label for="comment_content">Your comment</label>
                            <textarea class="form-control" rows="3" name="comment_content"></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary" name="create_comment">Submit</button>
                    </form>
                </div>

                <hr>
                <!-- Posted Comments -->
<?php
  
    $post_id = $_GET['p_id'];    
    $query = "SELECT * FROM comments WHERE comment_post_id = {$post_id} ";
    $query .= "AND comment_status = 'Approved' ";
    //$query .= "ORDER BY commment_id DESC";            
    $select_comments_query = mysqli_query($connection, $query);
    confirmQuery($select_comments_query);    
    while($row = mysqli_fetch_assoc($select_comments_query)) {
        
        $comment_author = $row['comment_author'];
        $comment_date = $row['comment_date'];
        $comment_content = $row['comment_content'];
        
?>
                <!-- Comment -->
                <div class="media">
                    <a class="pull-left" href="#">
                        <img class="media-object" src="http://placehold.it/64x64" alt="">
                    </a>
                    <div class="media-body">
                        <h3 class="media-heading"><?php print $comment_author; ?>
                            <small><?php print $comment_date; ?></small>
                        </h3> <?php print $comment_content; ?>
                    </div>
                </div>                
<?php
        }
    }    
} else {
    header("Location: index.php");
} 
?>

    </div>

            <!-- Blog Sidebar Widgets Column -->
<?php include "includes/sidebar.php"?>

        </div>
        <!-- /.row -->

        <hr>
<?php include "includes/footer.php"?>
