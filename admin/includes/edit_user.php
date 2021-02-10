<?php 
if (isset($_GET['user_id'])) {
    $user_id = escapeStr($_GET['user_id']);
    
    $query = "SELECT * FROM users WHERE user_id = {$user_id}";
    $select_user_edit_query = mysqli_query($connection, $query);
    confirmQuery($select_user_edit_query);                              
    while($row = mysqli_fetch_assoc($select_user_edit_query)) {
        $user_name = $row['user_name'];
        $user_password = $row['user_password'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];


?>
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_name">Username</label>
        <input type="text" class="form-control" name="user_name" value="<?php print $user_name;?>">  
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input autocomplete="off" type="password" class="form-control" name="user_password" value="<?php //print $user_password;?>">       
    </div>
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname" value="<?php print $user_firstname;?>">       
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname" value="<?php print $user_lastname;?>">       
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
         <input type="text" class="form-control" name="user_email" value="<?php print $user_email;?>">
    </div> 
               
    <div class="form-group">
        <label for="user_role">User role</label>
        <select name="user_role" id="user_role" class="form-control">
           <option value="<?php print $user_role; ?>"><?php print $user_role; ?></option>
<?php
    if ($user_role == 'admin') {
       print "<option value='subscriber'>Subscriber</option>";
    }else {
        print "<option value='admin'>Admin</option>";
    }
    //getRolesList(); 
?>
        </select>
    </div>
    
    <div class="form-group">
        <label for="image">User Image</label>
         <input type="file"  name="image">  <!-- class="form-control"--> <p><?php print $user_image; ?> </p>
        <img src="../images/<?php print $user_image; ?>" width="100" alt="">    
    </div>
    
    <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="edit_user" value="Edit">  
    </div>    
    
</form>
<?php } ?>
<?php

if (isset($_POST['edit_user'])){
    $user_name = escapeStr($_POST['user_name']);
    $user_password = trim($_POST['user_password']);
    $user_firstname = escapeStr($_POST['user_firstname']);
    $user_lastname = escapeStr($_POST['user_lastname']);
    $user_email = escapeStr($_POST['user_email']);
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    $user_role = $_POST['user_role'];  
    move_uploaded_file($user_image_temp, "../images/$user_image");
    //crypting edited password

    //$hashed_password = 
    if (!empty($user_password)) {
        $query_password = "SELECT user_password FROM users WHERE user_id = {$user_id}";
        $get_user_query =  mysqli_query($connection, $query_password);
        confirmQuery($get_user_query); 
        $row = mysqli_fetch_array($get_user_query);
        $db_user_password = $row['user_password']; 
        if ($db_user_password != $user_password) {
            $hashed_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
        } else {
            $hashed_password = $db_user_password;
        }
        $query = "UPDATE users SET user_name='{$user_name}', user_password='{$hashed_password}', user_firstname='{$user_firstname}', user_lastname='{$user_lastname}', user_email='{$user_email}' "; 
        
        if (!empty($user_image)){
            $query.=", user_image='{$user_image}' ";
        }
        
        $query.= ", user_role = '{$user_role}' WHERE user_id = {$user_id} ";

        $edit_user_query = mysqli_query($connection, $query);
        confirmQuery($edit_user_query);
        header("Location: users.php");
    } else { 
        print "<script> alert('Password field cannot be empty!');</script>"; 
    }
}
} else {
    header("Location: users.php");
}
    
?>
