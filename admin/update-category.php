<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Category</h1>
        <br><br>
        <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }
        ?>

        <?php 
            // Check whether the id is set or not
            if(isset($_GET['id']))
            {
                $id = $_GET['id'];
                // Create SQL query to get all other details
                $sql = "SELECT * FROM tbl_category WHERE id =$id";

                // Execute the query
                $res = mysqli_query($conn,$sql);

                // Count the rows to check whether the id is valid or not
                $count = mysqli_num_rows($res);

                if($count == 1) 
                {
                    // Get all the data
                    $row=mysqli_fetch_assoc($res);
                    $title = $row['title'];
                    $current_image = $row['image_name'];
                    $featured = $row['featured'];
                    $active = $row['active'];
                } 
                else 
                {
                    $_SESSION['no-category-found'] = "Category not found";
                    // Redirect to manage session
                    header('location:'.SITEURL.'admin/manage-category.php');

                }
            }
            else 
            {
                header('location:'.SITEURL.'admin/manage-category.php');
            }
        ?>
        <form action="" method="POST" enctype="multipart/form-data">

        <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Category Title" value="<?php echo $title?>"></td>
                </tr>

                <tr>
                    <td>Current image: </td>
                    <td>
                        <?php 
                            if($current_image != "")
                            {
                                ?> <img src="<?php echo SITEURL?>images/category/<?php echo $current_image;?>"width=160px>
                                <?php
                            } 
                            else 
                            {
                                echo "image was not added";
                            }
                        ?>
                    </td>
                </tr>

                <tr>
                    <td>New image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input <?php if($featured == "Yes") {echo "checked";} ?> type="radio" name="featured" value="Yes">Yes
                        <input <?php if($featured == "No") {echo "checked";} ?> type="radio" name="featured" value="No">No
                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input <?php if($active == "Yes") {echo "checked";} ?> type="radio" name="active" value="Yes">Yes
                        <input <?php if($active == "No") {echo "checked";} ?> type="radio" name="active" value="No">No
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Category" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>
        <?php 
            if(isset($_POST['submit'])){
                // echo "clicked";
                //1. Get all the value from form update
                $id = $_POST['id'];
                $title = $_POST['title'];
                $current_image = $_POST['current_image'];
                $featured = $_POST['featured'];
                $active = $_POST['active'];

                // 2. Updating new image if selected
                // Check whether the image is selected or not
                if (isset($_FILES['image']['name']))
                {
                    $image_name = $_FILES['image']['name'];
                    if($image_name != "")
                    {
                        // Image available
                        // Upload the new image
                        // Auto rename our image
                        // Get the extension of image (jpg,png,etc)
                        $ext = end(explode('.',$image_name));
                        
                        // Rename image
                        $image_name = "Food_Category_".rand(000,999).'.'.$ext;

                
                        $source_path = $_FILES['image']['tmp_name'];
                        $destination_path = "../images/category/".$image_name;

                        // Update the image
                        $upload = move_uploaded_file($source_path,$destination_path);

                        // Check whether the image is uploaded or not
                        // and if the image is not uploaded when we will stop the process and redirect with error message
                        if($upload == false) {
                            $_SESSION['upload'] ="Failed to upload the image";
                            header("location:".SITEURL.'admin/manage-category.php');
                            // Stop the process
                            die();
                        }
                        // Remove the current image if available
                        if($current_image != "")
                        {
                            $remove_path = "../images/category/".$current_image;
                        
                            $remove = unlink($remove_path);
    
                            // Check whether the image is removed or not
                            // If failed to remove then display message and stop the process
                            if($remove == false)
                            {
                                // Failed to remove image
                                $_SESSION['failed-remove'] = "Failed to remove image";
                                // redirect to manage admin page
                                header('location:'.SITEURL.'admin/manage-category.php');
                                die();
                            }
                        }
                    }         
                    else
                    {
                        $image_name = $current_image;
                    }
                }   
                else 
                {
                    $image_name = $current_image;
                }

                // 3. Update the database
                $sql2 = "UPDATE tbl_category SET 
                    title = '$title',
                    image_name ='$image_name',
                    featured = '$featured',
                    active = '$active'
                    WHERE id =$id
                ";
                // Execute the query
                $res2 = mysqli_query($conn,$sql2);
                // 4. Redirect to manage category with message
                // Check whether executed or not
                if($res2 == true)
                {
                    // category updated
                    $_SESSION['update'] = "Category updated successfully";
                    // redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
                else 
                {
                    // Failed to update
                    $_SESSION['update'] = "Failed to update successfully";
                    // redirect to manage admin page
                    header('location:'.SITEURL.'admin/manage-category.php');
                }
            }
        ?>
    </div>
</div>

<?php include('partials/footer.php');?>
