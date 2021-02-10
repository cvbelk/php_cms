<?php 
if (isset($_GET['post_id'])) {
    $edit_id = $_GET['post_id'];
    $query = "SELECT * FROM posts WHERE post_id = {$edit_id}"; // 'LIMIT 3' limited to 3 
    $select_post = mysqli_query($connection, $query);
    confirmQuery($select_post);         
    while($row = mysqli_fetch_assoc($select_post)) {
        $post_id = $row['post_id'];
        $post_user = $row['post_user'];
        $post_title = $row['post_title'];
        $post_category_id = $row['post_category_id'];
        $post_status = $row['post_status'];
        $post_image = $row['post_image'];
        $post_tags = $row['post_tags'];
        $post_comment_count = $row['post_comment_count'];
        $post_date = $row['post_date'];
        $post_content = $row['post_content'];
    }

?>
<?php
    
if (isset($_POST['edit_post'])){
    
    $post_title = escapeStr($_POST['post_title']);
    $post_user = $_POST['post_user'];
    $post_category_id = $_POST['post_category'];
    $post_content = trim($_POST['post_content']);
    $post_tags = escapeStr($_POST['post_tags']);
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];
    
    move_uploaded_file($post_image_temp, "../images/$post_image");
    
    $query = "UPDATE posts SET post_category_id={$post_category_id}, post_title='{$post_title}', post_user='{$post_user}', post_content='{$post_content}', post_tags='{$post_tags}', post_date=now(), post_status='{$post_status}' "; 
    if (!empty($post_image)){
        $query.=", post_image='{$post_image}' ";
    }
    $query.= "WHERE post_id = {$edit_id} ";

    $edit_post_query = mysqli_query($connection, $query);
    confirmQuery($edit_post_query);
    print "<p class='bg-success'>Post updated. <a href='../post.php?p_id={$edit_id}'>View </a> or <a href='posts.php'> Edit more posts</a></p>";
    //header("Location: posts.php");
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title" value="<?php print $post_title;?>">  
    </div>
    <div class="form-group">
        <label for="post-category">Post Category</label>
        <select name="post_category" id="post-category" class="form-control">
            <?php getCategoriesList($post_category_id); ?>
        </select>
    </div>
    <div class="form-group">
        <label for="post_user">Post User</label>
        <select class="form-control" name="post_user"> 
        <option value="<?php print $post_user; ?>"> <?php print $post_user; ?> </option>
            <?php getUsersList($post_user); ?>
        </select>
        <!--input type="text" class="form-control" name="post_author" value="<?php //print $post_user;?>"-->       
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <select name="post_status" class="form-control">
           <option value="<?php print $post_status; ?>"><?php print $post_status; ?></option>
    <?php
        if ($post_status == 'draft') {
            print "<option value='published'>Published</option>";
        }else {
            print "<option value='draft'>Draft</option>";
        } 
    ?>
        <!--input type="text" class="form-control" name="post_status" value="<?php //print $post_status;?>"-->       
        </select>    
    </div>
    
     <div class="form-group">
        <label for="image">Post Image</label>
         <input type="file"  name="image">  <!-- class="form-control"--> <p><?php print $post_image; ?> </p>
        <img src="../images/<?php print $post_image; ?>" width="100" alt="">    
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags" value="<?php print $post_tags;?>">       
    </div>
     <div class="form-group">
        <label for="post_content">Post Content</label>
        <textarea name="post_content" class="form-control" id="body" cols="30" rows="10"><?php print $post_content;?>
        </textarea>  
    </div>
     <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="edit_post" value="Edit Post">  
    </div>    
    
</form>
<script>
     ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>
<?php }?>