<?php
if (isset($_POST['create_user'])){
    $user_name = escapeStr($_POST['user_name']);
    $user_password = trim($_POST['user_password']);
    $user_firstname = escapeStr($_POST['user_firstname']);
    $user_lastname = escapeStr($_POST['user_lastname']);
    $user_email = escapeStr($_POST['user_email']);
    $user_image = $_FILES['image']['name'];
    $user_image_temp = $_FILES['image']['tmp_name'];
    $user_role = $_POST['user_role'];
    //$randSalt = " ";
    move_uploaded_file($user_image_temp, "../images/$user_image");
//    $query = "SELECT randSalt FROM users";
//    $select_randsalt_query = mysqli_query($connection, $query);
//    confirmQuery($select_randsalt_query);
//    $row = mysqli_fetch_assoc($select_randsalt_query);
//    $salt = $row['randSalt'];
//    $user_password = crypt($user_password, $salt);
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    $query = "INSERT INTO users (user_name, user_password, user_firstname, user_lastname, user_email, user_image, user_role) "; 
    $query.= "VALUES('{$user_name}', '{$user_password}', '{$user_firstname}', '{$user_lastname}', '{$user_email}', '{$user_image}', '{$user_role}') ";
    $create_user_query = mysqli_query($connection, $query);
    confirmQuery($create_user_query);
    print "User created: " . " " . "<a href='users.php'>View users</a>";
}
?>
   
<form action="" method="post" enctype="multipart/form-data">
    <div class="form-group">
        <label for="user_name">Username</label>
        <input type="text" class="form-control" name="user_name">  
    </div>
    <div class="form-group">
        <label for="user_password">Password</label>
        <input type="password" class="form-control" name="user_password"> 
    </div>
    <div class="form-group">
        <label for="user_firstname">Firstname</label>
        <input type="text" class="form-control" name="user_firstname">       
    </div>
    <div class="form-group">
        <label for="user_lastname">Lastname</label>
        <input type="text" class="form-control" name="user_lastname">       
    </div>
    <div class="form-group">
        <label for="user_email">Email</label>
        <input type="text" class="form-control" name="user_email">       
    </div>
     <div class="form-group">
        <label for="image">User image</label>
        <input type="file"  name="image">  <!-- class="form-control"-->     
    </div>
    
        <div class="form-group">
        <label for="user_role">Role</label>

        <select name="user_role" class="form-control">
            <option value='subscriber'>Select role</option>
            <option value='admin'>Admin</option>
            <option value='subscriber'>Subscriber</option>
<?php

    ?>
       </select>
        <!--input type="text" class="form-control" name="user_role"-->
    </div>
    
     <div class="form-group">
        <input class="btn btn-primary" type="submit" class="form-control" name="create_user" value="Create">  
    </div>
</form>