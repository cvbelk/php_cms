<?php
//security function lesson 240; USE IT FOR ALL USER-ENTERED DATA
//USE IT BEFORE ALL $_GET RECEIVED PARAMETERS
function escapeStr($string) {
   global $connection;
   return mysqli_real_escape_string($connection, trim(strip_tags($string)));
}

function confirmQuery($create_post_query){
    global $connection;
    if (!$create_post_query){
        die('Error in query: ' . mysqli_error($connection));
    }
}

function redirectTo($location) {
    header("Location:" . $location);
    exit;
}
//chapter 40 functions
function isCurrentHttpMethod($method = NULL) {
    if ($_SERVER['REQUEST_METHOD'] == strtoupper($method)) {
        return true;
    }
        return false;
}

function isLoggedIn(){
    if(isset($_SESSION['user_role'])){
        return true;
    }
    return false;
}

function checkIfLoggedInAndRedirect($redirectLocation=null){
    if (isLoggedIn()){
        redirectTo($redirectLocation);
    }

}
//----------------------------40--------------
function initCkEditor(){
print "<script>
     ClassicEditor
        .create( document.querySelector( '#body' ) )
        .catch( error => {
            console.error( error );
        } );
</script>" ;    
}

function insertCategories(){
    global $connection;
    if (isset($_POST['cat-title'])){
        $cat_title = trim($_POST['cat-title']);
        if ($cat_title == "" || empty($cat_title)){
            print "This field should not be empty";
        } else {
        //Prepared statements used chapter 38    
            $stmt = mysqli_prepare($connection, "INSERT INTO categories (cat_title) VALUES (?) ");
            mysqli_stmt_bind_param($stmt, "s", $cat_title);
            mysqli_stmt_execute($stmt);
            confirmQuery($stmt);
            mysqli_stmt_close($stmt);
            //$query = "INSERT INTO categories (cat_title) VALUES ('{$cat_title}') ";
            //$query_add_cat = mysqli_query($connection, $query);

        }
    }
}

function findAllCategories(){
    global $connection;
    $query = "SELECT * FROM categories "; // 'LIMIT 3' limited to 3 
    $select_categories = mysqli_query($connection, $query);
    confirmQuery($select_categories);
    while($row = mysqli_fetch_assoc($select_categories)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        print "<tr>";
        print "<td>{$cat_id} </td>";
        print "<td>{$cat_title} </td>";
        print "<td> <a href='categories.php?delete={$cat_id}'>Delete</a> </td>";
        print "<td> <a href='categories.php?edit={$cat_id}'>Edit</a></td>";            
        print "</tr>";
    }
}

function deleteCategory(){
    global $connection;
    if (isset($_GET['delete'])) {
        $delete_id = $_GET['delete'];
        $query = "DELETE FROM categories WHERE cat_id = {$delete_id} ";
        $delete_query = mysqli_query($connection, $query);
        confirmQuery($delete_query);
        header("Location: categories.php");
    }            
}

function deletePost($delete_id){
    global $connection;
    $query = "DELETE FROM posts WHERE post_id = {$delete_id} ";
    $delete_query = mysqli_query($connection, $query);
    confirmQuery($delete_query);
    header("Location: posts.php");
}           

function getCategoriesList($post_category_id=0){
    global $connection;
    $query = "SELECT * FROM categories "; 
    $select_categories_list = mysqli_query($connection, $query);
    confirmQuery($select_categories_list); 
    while($row = mysqli_fetch_assoc($select_categories_list)) {
        $cat_id = $row['cat_id'];
        $cat_title = $row['cat_title'];
        if ($post_category_id == $cat_id && $post_category_id!=0) {
            print "<option selected='selected' value='{$cat_id}'>{$cat_title}</option>";
        } else {
            print "<option value='{$cat_id}'>{$cat_title}</option>";
        }
    }
}
function getPostCatById($post_category_id) {
    global $connection;
    $cat_title = "";
    $query = "SELECT * FROM categories where cat_id = {$post_category_id}";
    $select_category_byID = mysqli_query($connection, $query);
    confirmQuery($select_category_byID); 
    while($row = mysqli_fetch_assoc($select_category_byID)) {
        $cat_title = $row['cat_title'];
    }
    return $cat_title;
}
//=====================users=====================
function deleteUser($delete_id){
    global $connection;
    $query = "DELETE FROM users WHERE user_id = {$delete_id} ";
    $delete_user_query = mysqli_query($connection, $query);
    confirmQuery($delete_user_query);
}     

function adminUser($admin_id){
    global $connection;
    $query = "UPDATE users SET user_role = 'admin' WHERE user_id = {$admin_id} ";
    $admin_user_query = mysqli_query($connection, $query);
    confirmQuery($admin_user_query);
}     

function subscUser($subsc_id){
    global $connection;
    $query = "UPDATE users SET user_role = 'subscriber' WHERE user_id = {$subsc_id} ";
    $subsc_user_query = mysqli_query($connection, $query);
    confirmQuery($subsc_user_query);
}

//function getRolesList(){
//    global $connection;
//    $query = "SELECT * FROM users";
//    $select_users = mysqli_query($connection, $query);
//    confirmQuery($select_users);
//    while($row = mysqli_fetch_assoc($select_users)){
//        $user_id = $row['user_id'];
//        $user_role = $row['user_role'];
//        print "<option value='$user_role'>{$user_role}</option>";
//    }
//}
//====================dashboard===========================
//FUNCTIONS DOWN BELOW CAN BE REFACTORED TO ONE FUNCTION
//recordCount($tableName);
function getPostsCount(){
    global $connection;
    $query = "SELECT * FROM posts";
    $posts_count_query = mysqli_query($connection, $query);
    confirmQuery($posts_count_query);
    $post_counter = mysqli_num_rows($posts_count_query);
    return $post_counter;
}
function getCommentsCount(){
    global $connection;
    $query = "SELECT * FROM comments";
    $comments_count_query = mysqli_query($connection, $query);
    confirmQuery($comments_count_query);
    $comment_counter = mysqli_num_rows($comments_count_query);
    return $comment_counter;
}
function getUsersCount(){
    global $connection;
    $query = "SELECT * FROM users";
    $users_count_query = mysqli_query($connection, $query);
    confirmQuery($users_count_query);
    $users_counter = mysqli_num_rows($users_count_query);
    return $users_counter;
}
function getCategoriesCount(){
    global $connection;
    $query = "SELECT * FROM categories";
    $categories_count_query = mysqli_query($connection, $query);
    confirmQuery($categories_count_query);
    $categories_counter = mysqli_num_rows($categories_count_query);
    return $categories_counter;
}
function getDraftPostsCount(){
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'draft' ";
    $posts_draft_count_query = mysqli_query($connection, $query);
    confirmQuery($posts_draft_count_query);
    $post_draft_counter = mysqli_num_rows($posts_draft_count_query);
    return $post_draft_counter;
}
function getPublishedPostsCount(){
    global $connection;
    $query = "SELECT * FROM posts WHERE post_status = 'published' ";
    $posts_published_count_query = mysqli_query($connection, $query);
    confirmQuery($posts_published_count_query);
    $post_published_counter = mysqli_num_rows($posts_published_count_query);
    return $post_published_counter;
}
function getUnapprovedCommentsCount(){
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_status='unapproved'";
    $comments_unapproved_count_query = mysqli_query($connection, $query);
    confirmQuery($comments_unapproved_count_query);
    $comment_unapproved_counter = mysqli_num_rows($comments_unapproved_count_query);
    return $comment_unapproved_counter;
}
function getSubscribersCount(){
    global $connection;
    $query = "SELECT * FROM users WHERE user_role = 'subscriber'";
    $subscribers_count_query = mysqli_query($connection, $query);
    confirmQuery($subscribers_count_query);
    $subscribers_counter = mysqli_num_rows($subscribers_count_query);
    return $subscribers_counter;
}
//====================advanced posts page=================
function updatePostStatus($new_status, $p_id){
    global $connection;
    $query = "UPDATE posts SET post_status = '{$new_status}' WHERE post_id = {$p_id} ";
    $update_post_status_query = mysqli_query($connection, $query);
    confirmQuery($update_post_status_query);
}
function clonePost($clone_id) {
    global $connection;
    $query = "SELECT * FROM posts WHERE post_id = {$clone_id} ";
    $select_clone_query = mysqli_query($connection, $query);
    confirmQuery($select_clone_query);
    $row = mysqli_fetch_assoc($select_clone_query);
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    $post_user = $row['post_user'];
    $post_status = $row['post_status'];
    $post_tags = $row['post_tags'];
    $post_image = $row['post_image'];
    $post_comment_count = $row['post_comment_count'];
    $post_content = $row['post_content'];
    //=====================================
    $query = "INSERT INTO posts (post_category_id, post_title, post_user, post_date, 
    post_image, post_content, post_tags, post_comment_count, post_status) "; 

    $query.= "VALUES({$post_category_id}, '{$post_title}', '{$post_user}', now(), 
    '{$post_image}', '{$post_content}', '{$post_tags}', {$post_comment_count}, '{$post_status}') ";

    $clone_post_query = mysqli_query($connection, $query);
    confirmQuery($clone_post_query);
    header("Location: posts.php"); 
}
function resetPostViews($reset_id) {
    global $connection;
    $query = "UPDATE posts SET post_views_count = 0 WHERE post_id = " . mysqli_real_escape_string($connection, $reset_id) . " ";
    $reset_post_views_query = mysqli_query($connection, $query);
    confirmQuery($reset_post_views_query);
}
//------------users online count for navbar---php only version; js version in scrpits.js
function getOnlineUsersCount() {
    //two next if's for calling outside of header.php, first ver of function uses 'return'
    if (isset($_GET['onlineusers'])) {
        global $connection;
        if(!$connection) {
            session_start();
            include ("../includes/db.php");
        
            $session = session_id();
            $time = time();
            $time_out_in_seconds = 05;
            $time_out = $time - $time_out_in_seconds;
            $query = "SELECT * FROM users_online WHERE session = '{$session}' ";
            $user_online_session_query = mysqli_query($connection, $query);
            confirmQuery($user_online_session_query);
            $count = mysqli_num_rows($user_online_session_query);
            if($count == NULL){
               mysqli_query($connection, "INSERT INTO users_online(session, time) VALUES ('{$session}', {$time}) "); 
            } else {
               mysqli_query($connection, "UPDATE users_online SET session = '{$session}', time = {$time} WHERE session = '{$session}' "); 
            }
            $users_online_query = mysqli_query($connection,  "SELECT * FROM users_online WHERE time > {$time_out} ");
            confirmQuery($users_online_query);
            $count_users = mysqli_num_rows($users_online_query);
            //return $count_users;
            echo $count_users;
        }    
    }
}
getOnlineUsersCount(); //hardcalling the function up
//-----view_all_comments_functions----------------------
function getCommentsCountById($c_id){
    global $connection;
    $query = "SELECT * FROM comments WHERE comment_post_id = {$c_id} ";
    $comments_count_query_by_id = mysqli_query($connection, $query);
    confirmQuery($comments_count_query_by_id );
    $comment_counter = mysqli_num_rows($comments_count_query_by_id );
    return $comment_counter;
}

function updateCommentStatus($new_status, $c_id){
    global $connection;
    $query = "UPDATE comments SET comment_status = '{$new_status}' WHERE comment_id = {$c_id} ";
    $update_comment_status_query = mysqli_query($connection, $query);
    confirmQuery($update_comment_status_query);
}

function deleteComment($c_id){
    global $connection;
    $query = "DELETE FROM comments WHERE comment_id = {$c_id} ";
    $delete_comment_query = mysqli_query($connection, $query);
    confirmQuery($delete_comment_query);
}
//----------------------chapter 28--user-related add post page
function getUsersList($current_uname){
    global $connection;
    $query = "SELECT * FROM users ";
    $select_users_list = mysqli_query($connection, $query);
    confirmQuery($select_users_list); 
    while($row = mysqli_fetch_assoc($select_users_list)) {
        //$user_id = $row['user_id'];
        $user_name = $row['user_name'];
        if ($current_uname != $user_name) {
            print "<option value='{$user_name}'>{$user_name}</option>";
        }
    }
}

//improving our cms chapter 37============================
function is_Admin($username) {
    global $connection;
    $query = "SELECT user_role FROM users WHERE user_name = '$username' ";
    $select_role_by_name = mysqli_query($connection, $query);
    confirmQuery($select_role_by_name);
    $row = mysqli_fetch_assoc($select_role_by_name);
    if ($row['user_role'] == 'admin') {
        return true;
    } else {
        return false;
    }
}

function usernameExists($username) {
    global $connection;
    $query = "SELECT user_name FROM users WHERE user_name = '$username' ";
    $select_role_by_name = mysqli_query($connection, $query);
    confirmQuery($select_role_by_name);
    $result = mysqli_num_rows($select_role_by_name);
    if ($result < 1) {
        return false;
    } else {
        return true;
    }  
}

function emailExists($usermail) {
    global $connection;
    $query = "SELECT user_email FROM users WHERE user_email = '$usermail' ";
    $select_email_exists = mysqli_query($connection, $query);
    confirmQuery($select_email_exists);
    $result = mysqli_num_rows($select_email_exists);
    if ($result < 1) {
        return false;
    } else {
        return true;
    }  
}

function emailExistsStmt($usermail) {
    global $connection;
    $stmt = mysqli_prepare($connection, "SELECT user_email FROM users WHERE user_email = ? ");
    mysqli_stmt_bind_param($stmt, "s", $usermail);
    mysqli_stmt_execute($stmt);        
    confirmQuery($stmt);
    mysqli_stmt_store_result($stmt);
    $result = mysqli_stmt_num_rows($stmt);
    mysqli_stmt_close($stmt);
    if ($result < 1) {
        //echo "false: " . $result;
        return false;
    } else {
        //echo "true: " . $result;
        return true;
    }  
}

function registerUser($user_name, $user_email, $user_password){
    global $connection;    
    $user_name = escapeStr($user_name);
    $user_email = escapeStr($user_email);
    $user_password = escapeStr($user_password);   
    $user_role = 'subscriber';
    //------------encrypting password block---      
    $user_password = password_hash($user_password, PASSWORD_BCRYPT, array('cost' => 10));
    $query = "INSERT INTO users (user_name, user_password, user_email, user_role) "; 
    $query.= "VALUES('{$user_name}', '{$user_password}', '{$user_email}', '{$user_role}') ";
    $register_user_query = mysqli_query($connection, $query);
    confirmQuery($register_user_query);
}

function loginUser($user_name, $user_password){
    global $connection;

    $user_name = escapeStr($user_name);
    $user_password = escapeStr($user_password); 
    
    $query = "SELECT * FROM users WHERE user_name = '{$user_name}' ";
    $user_login_query = mysqli_query($connection, $query);
    confirmQuery($user_login_query);
    while($row = mysqli_fetch_assoc($user_login_query)){
        $db_user_id = $row['user_id'];
        $db_user_name = $row['user_name'];
        $db_user_password = $row['user_password'];
        $db_user_firstname = $row['user_firstname'];
        $db_user_lastname = $row['user_lastname'];
        $db_user_role = $row['user_role'];
        //$db_user_salt = $row['randSalt'];
        
        if(password_verify($user_password, $db_user_password)){
            $_SESSION['user_id'] = $db_user_id;
            $_SESSION['user_name'] = $db_user_name;
            $_SESSION['user_firstname'] = $db_user_firstname;
            $_SESSION['user_lastname'] = $db_user_lastname;
            $_SESSION['user_role'] = $db_user_role;
            return true;
        } else {
            //print "<hr>error login: " . $user_name . "password: " . $user_password;
            return false;
            //redirectTo(" index.php");
       }
    }  
   // return true; 
}
function updatePassword($hashed_password, $user_email){
    global $connection;
    
    if($stmt = mysqli_prepare($connection, "UPDATE users SET user_token='', user_password='{$hashed_password}' WHERE user_email=? ")){
        mysqli_stmt_bind_param($stmt, 's', $user_email);
        mysqli_stmt_execute($stmt);
        if(mysqli_stmt_affected_rows($stmt) >= 1) {
            mysqli_stmt_close($stmt);
            return true;    
        } else {
            mysqli_stmt_close($stmt);
            return false;
        }
        //return true;
        
    } else {
        return false;
    }
}

function currentUser(){
    if(isset($_SESSION['user_name'])){
        return $_SESSION['user_name'];
    }
    return false;
}

function imagePlaceholder($image=''){
    if(!$image){
        return '640x320.jpg';
    }else {
        return $image;
    }    
}

?>