<?php 
    // Include constant.php
    include('../config/constants.php');

    // Check whether the id and image_name value is set or not
    if(isset($_GET['id']) AND isset($_GET['image_name'])) {
        $id = $_GET['id'];
        $image_name = $_GET['image_name'];

        //remove the physical image file is available
        if($image_name != ""){
            //image is available. Remove it
            $path = "../images/food/".$image_name;
            //remove image
            $remove = unlink($path);
            // If failed to remove image then add error message and stop the process
            if($remove == false) {
                // Set the session message
                $_SESSION['remove'] = "Failed to remove food image.";
                // Redirect to manage category page
                header("location:".SITEURL.'admin/manage-food.php');
                die();
            }
        }
        //Delete data from database 
        // Create SQL Query to delete admin
        $sql = "DELETE FROM tbl_food WHERE id=$id";
        // Execute the Query
        $res = mysqli_query($conn,$sql);

        // Check whether the data is delete from database or not
        if($res==true)
        {
            // Creat a session variable to display message
            $_SESSION['delete'] = "Food deleted successfully.";
            // Redirect page
            header("location:".SITEURL.'admin/manage-food.php');
        }
        else 
        {
            // Creat a session variable to display message
            $_SESSION['delete'] = "Failed to delete.";
            // Redirect page
            header("location:".SITEURL.'admin/delete-food.php');
        }

        //Redirect to manage category page with message
    } else {

        header("location:".SITEURL.'admin/manage-food.php');

    }

?>