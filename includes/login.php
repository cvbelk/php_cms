<?php include "db.php"; ?>
<?php include "../admin/functions.php"; ?>
<?php session_start(); ?>
<?php
//=================WE DONT NEED IT AFTER CHAPTER 40-- ALL DONE IN SIDEBAR.PHP
if (isset($_POST['login'])) {
   if (loginUser(trim($_POST['user_name']), trim($_POST['user_password']))) {
    redirectTo(" ../admin/");
   }
}
?>    