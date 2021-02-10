<?php
if (isset($_POST['checkBoxArray'])){
   
    foreach($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options) {
            case 'approve':
                updateCommentStatus('Approved', $checkBoxValue);
                break;
            case 'unapprove':
                updateCommentStatus('Unapproved', $checkBoxValue);
                break;
            case 'delete':
                deleteComment($checkBoxValue);
                break;
    
            default:
                break;
        }
    }
}
?>
<form action="" method="post">
      <table class="table table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4" style="padding-left:0px; padding-bottom:10px;">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select options</option>
                <option value="approve">Approve</option>
                <option value="unapprove">Unapprove</option>
                <option value="delete">Delete</option>
            </select>
        </div> 
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <!--a class="btn btn-primary" href="posts.php?source=add_post">Add New</a-->
        </div>       
             
            <thead>
                 <tr>
                    <th><input id="selectAllBoxes" type="checkbox"></th>
                     <th>Id</th>
                     <th>Author</th>
                     <th>Comment</th>
                     <th>Email</th>
                     <th>Status</th>
                     <th>In response to</th>
                     <th>Date</th>
                     <th>Approve</th>
                     <th>Unapprove</th>
                     <th>Delete</th>

                     </tr>
             </thead>
             <tbody>
<?php
    $query = "SELECT * FROM comments "; // 'LIMIT 3' limited to 3 
    $select_comments = mysqli_query($connection, $query);
    confirmQuery($select_comments);                        
    while($row = mysqli_fetch_assoc($select_comments)) {
        $comment_id = $row['comment_id'];
        $comment_author = $row['comment_author'];
        $comment_post_id = $row['comment_post_id'];
        $comment_status = $row['comment_status'];
        $comment_date = $row['comment_date'];
        $comment_email = $row['comment_email'];
        $comment_content = $row['comment_content'];
        
        print "<tr>";
?> 
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $comment_id; ?>' ></td>
<?php           
        print "<td>{$comment_id} </td>";
        print "<td>{$comment_author} </td>";
        print "<td>{$comment_content} </td>";
        print "<td>{$comment_email}</td>";
        print "<td>{$comment_status} </td>";
        $query = "SELECT * FROM posts WHERE post_id = {$comment_post_id} ";
        $select_post_id_query = mysqli_query($connection, $query);
        while ($row = mysqli_fetch_assoc($select_post_id_query)) {
            $post_id = $row['post_id'];
            $post_title = $row['post_title'];
            print "<td> <a href='../post.php?p_id={$post_id}'>{$post_title}</a></td>";
        }
        print "<td>{$comment_date} </td>";
        print "<td> <a href='comments.php?approve={$comment_id}'>Approve</a> </td>";
        print "<td> <a href='comments.php?unapprove={$comment_id}'>Unapprove</a> </td>";
        print "<td> <a href='comments.php?delete={$comment_id}'>Delete</a> </td>";
    
        print "</tr>";
    }    
?>    
                               
                                </tbody>
                             </table>
                            </form>
<?php
if (isset($_GET['delete'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $delete_id = escapeStr($_GET['delete']);
            $query = "DELETE FROM comments WHERE comment_id = {$delete_id} ";
            $delete_comment_query = mysqli_query($connection, $query);
            confirmQuery($delete_comment_query);
            header("Location: comments.php");
        }
    }
}
if (isset($_GET['unapprove'])) { 
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $comment_id = escapeStr($_GET['unapprove']);
            $query = "UPDATE comments SET comment_status = 'Unapproved' WHERE comment_id = {$comment_id} ";
            $unapprove_comment_query = mysqli_query($connection, $query);
            confirmQuery($unapprove_comment_query);
            header("Location: comments.php");
        }
    }
}
if (isset($_GET['approve'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $comment_id = escapeStr($_GET['approve']);
            $query = "UPDATE comments SET comment_status = 'Approved' WHERE comment_id = {$comment_id} ";
            $approve_comment_query = mysqli_query($connection, $query);
            confirmQuery($approve_comment_query);
            header("Location: comments.php");
        }
    }
}
?>                             