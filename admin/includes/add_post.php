<?php
if (isset($_POST['create_post'])){
    $post_title = escapeStr($_POST['post_title']);
    //$post_author = trim($_POST['post_author']);
    $post_user = escapeStr($_POST['post_user']);
    $post_category_id = $_POST['post_category_id'];
    $post_status = $_POST['post_status'];
    $post_image = $_FILES['image']['name'];
    $post_image_temp = $_FILES['image']['tmp_name'];

    $post_tags = escapeStr($_POST['post_tags']);
    $post_content = trim($_POST['post_content']);
    //$post_content = preg_replace('/(<br>)+$/', "", $string); //delete all <br> in the end of string
    $post_date = date('d-m-y');
    move_uploaded_file($post_image_temp, "../images/$post_image");

    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, 
    post_image, post_content, post_tags, post_comment_count, post_status) "; 

    $query.= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), 
    '{$post_image}', '{$post_content}', '{$post_tags}', 0, '{$post_status}') ";

    $create_post_query = mysqli_query($connection, $query);
    confirmQuery($create_post_query);
    
    $last_post_id = mysqli_insert_id($connection); // -- this function gets the lastest id in table 
    print "<p class='bg-success'>Post created. <a href='../post.php?p_id={$last_post_id}'>View </a> or <a href='posts.php'> Edit more posts</a></p>";
}
?>

<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="post_title">Post Title</label>
        <input type="text" class="form-control" name="post_title">  
    </div>
    <div class="form-group">
        <label for="post_category_id">Post Category Id</label>
            <select name="post_category_id" id="post-category_id" class="form-control">
                <?php getCategoriesList(0); ?>
            </select>           
            <!--input type="text" class="form-control" name="post_category_id"--> 
    </div>
    <div class="form-group">
        <label for="post_user">Post User</label>
        <!--input type="text" class="form-control" name="post_author"--> <select class="form-control" name="post_user"> 
        <option value="<?php print $_SESSION['user_name']; ?>"> <?php print $_SESSION['user_name']; ?> </option>
            <?php getUsersList($_SESSION['user_name']); ?>
        </select> 
        
                  
    </div>
    <div class="form-group">
        <label for="post_status">Post Status</label>
        <input type="text" class="form-control" name="post_status" value="draft" readonly>       
    </div>
     <div class="form-group">
        <label for="image">Post Image</label>
        <input type="file"  name="image">  <!-- class="form-control"-->     
    </div>
    <div class="form-group">
        <label for="post_tags">Post Tags</label>
        <input type="text" class="form-control" name="post_tags">       
    </div>
     <div class="form-group" style="height: 100;">
        <label for="post_content">Post Content</label>
        
        <textarea name="post_content" id="body" class="form-control" cols="30" rows="10"></textarea> <!--class="form-control" cols="30" rows="10"-->
        <!--input type="text" class="form-control" name="post_content"-->
           
    </div>
     <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="create_post" value="Publish Post">  
    </div>
    
</form>

<script>
     ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>