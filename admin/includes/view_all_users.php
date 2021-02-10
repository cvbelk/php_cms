                             <table class="table table-bordered table-hover">
                                 <thead>
                                     <tr>
                                         <th>Id</th>
                                         <th>Username</th>
                                         <th>Firstname</th>
                                         <th>Lastname</th>
                                         <th>Email</th>
                                         <th>Image</th>
                                         <th>Role</th>
                                         <th>Admin</th>
                                         <th>Subscriber</th>
                                         <th>Delete</th>
                                         <th>Edit</th>
                                     </tr>
                                 </thead>
                                 <tbody>
<?php
    $query = "SELECT * FROM users "; 
    $select_all_users = mysqli_query($connection, $query);
    confirmQuery($select_all_users);                              
    while($row = mysqli_fetch_assoc($select_all_users)) {
        $user_id = $row['user_id'];
        $user_name = $row['user_name'];
        $user_firstname = $row['user_firstname'];
        $user_lastname = $row['user_lastname'];
        $user_email = $row['user_email'];
        $user_image = $row['user_image'];
        $user_role = $row['user_role'];
        
        print "<tr>";
        print "<td>{$user_id} </td>";
        print "<td>{$user_name} </td>";
        print "<td>{$user_firstname} </td>";
        print "<td>{$user_lastname}</td>";
        print "<td>{$user_email} </td>";
        print "<td><img src='../images/{$user_image}' alt='image' width='100'></td>";
        print "<td>{$user_role} </td>";
        print "<td> <a href='users.php?change_to_admin={$user_id}'>Admin</a> </td>";
        print "<td> <a href='users.php?change_to_subsc={$user_id}'>Subscriber</a> </td>";
        print "<td> <a href='users.php?delete={$user_id}'>Delete</a> </td>";
        print "<td> <a href='users.php?source=edit_user&user_id={$user_id}'>Edit</a> </td>";
        print "</tr>";
    }    
?>    
                               
                                </tbody>
                             </table>
<?php
if (isset($_GET['delete'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $delete_id = escapeStr($_GET['delete']);
            deleteUser($delete_id); 
            header("Location: users.php");
        }
    }    
}

if (isset($_GET['change_to_admin'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {
            $admin_id = escapeStr($_GET['change_to_admin']);
            adminUser($admin_id);
            header("Location: users.php");
        }
    }
}

if (isset($_GET['change_to_subsc'])) {
    if(isset($_SESSION['user_role'])) { 
        if($_SESSION['user_role'] == 'admin') {    
            $subsc_id = escapeStr($_GET['change_to_subsc']);
            subscUser($subsc_id);
            header("Location: users.php");
        }
    }
}
?>                             