<?php
//bootstrap modal on delete post action
include ("delete_modal.php");

if (isset($_POST['checkBoxArray'])){
   
    foreach($_POST['checkBoxArray'] as $checkBoxValue) {
        $bulk_options = $_POST['bulk_options'];
        switch($bulk_options) {
            case 'published':
                updatePostStatus('published', $checkBoxValue);
                break;
            case 'draft':
                updatePostStatus('draft', $checkBoxValue);
                break;
            case 'deleted':
                deletePost($checkBoxValue);
                break;
            case 'clone':
                clonePost($checkBoxValue); 
                break;
    
            default:
                break;
        }
    }
}
?>
<form action="" method="post">
    <table class="table table-dark table-bordered table-hover">
        <div id="bulkOptionsContainer" class="col-xs-4" style="padding-left:0px; padding-bottom:10px;">
            <select name="bulk_options" id="" class="form-control">
                <option value="">Select options</option>
                <option value="published">Publish</option>
                <option value="draft">Draft</option>
                <option value="deleted">Delete</option>
                <option value="clone">Clone</option>
            </select>
        </div> 
        <div class="col-xs-4">
            <input type="submit" name="submit" class="btn btn-success" value="Apply">
            <a class="btn btn-primary" href="posts.php?source=add_post">Add New</a>
        </div>   
         <thead>
             <tr>
                 <th><input id="selectAllBoxes" type="checkbox"></th>
                 <th>Id</th>
                 <th>User</th>
                 <th>Title</th>
                 <th>Category</th>
                 <th>Status</th>
                 <th>Image</th>
                 <th>Tags</th>
                 <th>Date</th>
                 <th>Comments</th>
                 <th>Views</th>
                 <th>Delete</th>
                 <th>Edit</th>
             </tr>
         </thead>
         <tbody>
<?php
//$query = "SELECT * FROM posts ORDER BY post_id DESC ";
//better  query2 with JOIN
$query = "SELECT posts.post_id, posts.post_author, posts.post_user, posts.post_title, posts.post_category_id, posts.post_status,";
$query .= " posts.post_image, posts.post_tags, posts.post_comment_count, posts.post_date, posts.post_views_count, ";
$query .= "categories.cat_id, categories.cat_title FROM posts LEFT JOIN categories ON posts.post_category_id = categories.cat_id ";
$query .= "ORDER BY posts.post_id DESC ";

$select_posts = mysqli_query($connection, $query);
confirmQuery($select_posts);        
while($row = mysqli_fetch_assoc($select_posts)) {
    $post_id = $row['post_id'];
    $post_author = $row['post_author'];
    $post_user = $row['post_user']; //user-related post?
    $post_title = $row['post_title'];
    $post_category_id = $row['post_category_id'];
    //$post_category = getPostCatById($post_category_id);
    $post_category = $row['cat_title'];
    $cat_id = $row['cat_id'];
    $post_status = $row['post_status'];
    $post_image = $row['post_image'];
    $post_tags = $row['post_tags'];
    $post_comment_count = getCommentsCountById($post_id); //$row['post_comment_count']; 
    $post_date = $row['post_date'];
    $post_views_count = $row['post_views_count'];
    print "<tr>";
?> 
        <td><input class='checkBoxes' type='checkbox' name='checkBoxArray[]' value='<?php echo $post_id; ?>' ></td>
<?php                            
        print "<td>{$post_id} </td>";
        //--------user-related post?
        if (!empty($post_user)){
           print "<td><a>{$post_user}</a></td>"; 
        } else if (!empty($post_author)){
            print "<td>{$post_author}</td>";
        }
       
        print "<td><a href='../post.php?p_id={$post_id}'>{$post_title} </a></td>";
        print "<td>$post_category</td>";
        print "<td>{$post_status} </td>";
        print "<td><img src='../images/{$post_image}' alt='image' width='100'></td>";
        print "<td>{$post_tags} </td>";
        print "<td>{$post_date} </td>";
        print "<td><a href='post_comments.php?p_id={$post_id}'>{$post_comment_count} </a></td>";
        //print "<td>{$post_views_count} <a href='posts.php?r_views={$post_id}'><img src='images/delete.png'></a></td>";
        //print "<td> <a onClick=\"javascript: return confirm('Delete item?'); \" href='posts.php?delete={$post_id}'>Delete</a> </td>";
        //print "<td> <a onClick='showDelDialog({$post_id})' href='#'>Delete</a> </td>";

        ?>
        <!--deleting with POST method-->
        <form action="" method="POST">
            <input type="hidden" value="<?php echo $post_id; ?>" name="r_views">
         <?php
        print "<td><p><button class='btn btn-danger' type='submit' name='reset'><span class='glyphicon glyphicon-trash'></span> {$post_views_count} </button></p></td>";
            //print "<td>{$post_views_count} <a href='posts.php?r_views={$post_id}'><img src='images/delete.png'></a></td>";

         ?> 
        </form> 

        <?php
        print "<td> <a rel='$post_id' href='javascript:void(0)' class='btn btn-danger delete_link'>Delete</a> </td>";

        print "<td> <a class='btn btn-primary' href='posts.php?source=edit_post&post_id={$post_id}'>Edit</a> </td>";
        print "</tr>";
    }    
?>    
                               
                                </tbody>
                             </table>
                             </form> 
<?php
//Commented because POST method implemented
if (isset($_GET['delete'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $delete_id = escapeStr($_GET['delete']);
            deletePost($delete_id); 
            header("Location: posts.php");
        }
    }
}
if (isset($_POST['reset'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $reset_id = $_POST['r_views'];
            resetPostViews($reset_id); 
            header("Location: posts.php");
        }
    }
}
?>
<?php
// if (isset($_GET['r_views'])) {
//     if(isset($_SESSION['user_role'])) { 
//         if($_SESSION['user_role'] == 'admin') {
//             $reset_id = escapeStr($_GET['r_views']);
//             resetPostViews($reset_id); 
//             header("Location: posts.php");
//         }
//     }
// }

?>  
   <!--\"javascript: return confirm('Delete item?'); \"-->
<!--script>
const showDelDialog = function(id){
   let result =  confirm('Delete item?');
    if (result) {
        location.assign(`posts.php?delete=${id}`);
    } else {
        console.log(`del cancelled id= ${id}`);
    }
} 
</script-->        
<script>
// $(document).ready(function(){ 
//     $(".delete_link").on('click', function(){
//         const postId = $(this).attr("rel");
//         const deleteUrl = "posts.php?delete=" + postId + " ";
//         $(".modal_delete_link").attr("href", deleteUrl);
//         $("#myModal").modal('show');
//     });
// });
window.onload = () => {
    const delLinks = document.querySelectorAll('.delete_link');
    delLinks.forEach((delLink) => delLink.addEventListener('click', (e) => {
        let postId = e.target.getAttribute('rel');
        let deleteUrl = "posts.php?delete=" + postId + " ";
        document.querySelector('.modal_delete_link').setAttribute("href", deleteUrl);
        $("#myModal").modal('show');
        //document.querySelector('#myModal').style.display = "block";
    }));
};
</script>                  