<?php 
    // Include constant.php
    include('../config/constants.php');

    // 1. Get the ID of Admin to be deleted
    $id = $_GET['id'];

    // 2. Create SQL Query to delete admin
    $sql = "DELETE FROM tbl_admin WHERE id=$id";

    // Execute the Query
    $res = mysqli_query($conn,$sql);

    // Check whether the query executed successfully or not
    if($res==true)
    {
        // Creat a session variable to display message
        $_SESSION['delete'] = "Admin deleted successfully.";
        // Redirect page
        header("location:".SITEURL.'admin/manage-admin.php');
    }
    else 
    {
        // Creat a session variable to display message
        $_SESSION['delete'] = "Failed to delete.";
        // Redirect page
        header("location:".SITEURL.'admin/delete-admin.php');
    }
    // 3. Redirect to manage admin page with the message (success/error)
?>