                           <form action="" method="post">
                               <div class="form-group">
                                   <label for="cat-update">Edit Category</label>
<?php
        //UPDATE with prepare statements
    if (isset($_GET['edit'])) {
        $cat_id = escapeStr($_GET['edit']);
        $stmt = mysqli_prepare($connection, "SELECT cat_id, cat_title FROM categories WHERE cat_id = ? ");
        mysqli_stmt_bind_param($stmt, "i", $cat_id);
        mysqli_stmt_execute($stmt);        
        confirmQuery($stmt);
        mysqli_stmt_bind_result($stmt, $cat_id, $cat_title);
        mysqli_stmt_store_result($stmt);
        while(mysqli_stmt_fetch($stmt)) {
?>
<input value="<?php if(isset($cat_title)) {echo $cat_title;} ?>" type="text" class="form-control" name="cat-update">
<?php   
        }
    }
?>   
<?php 
    if (isset($_POST['update'])){
        $cat_update = escapeStr($_POST['cat-update']);
        if ($cat_update == "" || empty($cat_update)){
            print "This field should not be empty";
        } else {
            $stmt = mysqli_prepare($connection, "UPDATE categories SET cat_title = ? WHERE cat_id = ? ");
            mysqli_stmt_bind_param($stmt, "si", $cat_update, $cat_id);
            mysqli_stmt_execute($stmt);        
            confirmQuery($stmt);
            mysqli_stmt_close($stmt);
            redirectTo("categories.php");
        }
    }                                   
?>                                                                  
                                   
                               </div> 
                               <div class="form-group">
                                   <input class="btn btn-primary" type="submit" name="update" value="Update category">
                               </div> 
  
                            </form>  
     