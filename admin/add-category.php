<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>
        
        <?php 
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Display session message
                unset($_SESSION['add']); // Remove session message
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload']; // Display session message
                unset($_SESSION['upload']); // Remove session message
            }
        ?>

        <br><br>
        <form action="" method="POST" enctype="multipart/form-data">

            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td><input type="text" name="title" placeholder="Category Title"></td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes">Yes
                        <input type="radio" name="featured" value="No">No

                    </td>
                </tr>

                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes">Yes
                        <input type="radio" name="active" value="No">No

                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>

        <?php
            // Check whether the button clicked or not
            if(isset($_POST['submit'])){
                //1. Get the data from form
                $title = $_POST['title'];

                // For radio button, need to check the button is selected or not
                if(isset($_POST['featured'])){
                    // Get the data from form
                    $featured = $_POST['featured'];
                } else {
                    // Set the default value
                    $featured = "No";
                }

                if(isset($_POST['active'])){
                    // Get the data from form
                    $active = $_POST['active'];
                } else {
                    // Set the default value
                    $active = "No";
                }

                //  Check whether the image is selected or not and set the value image name accoridingly
                //print_r($_FILES['image']);
                //die();
                if(isset($_FILES['image']['name'])){
                    // Upload the image
                    // to update image we need image name, source path and destination path
                    $image_name = $_FILES['image']['name'];

                    // Upload image only image is selected
                    if($image_name != "") 
                    {
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
                            header("location:".SITEURL.'admin/add-category.php');
                            // Stop the process
                            die();
                        }
                    }
                } else {
                    // Dont upload image and set the image_name as blank
                    $image_name ="";
                }

                //2. SQL Query to the data into database
                $sql = "INSERT INTO tbl_category SET 
                    title = '$title',
                    image_name ='$image_name',
                    featured = '$featured',
                    active = '$active' 
                ";

                //3. Execute Query and Save in Database
                $res = mysqli_query($conn,$sql);

                //4. Check whether the data is inserted or not and display appropriate message
                if($res==TRUE)
                {
                    //echo("Data inserted");
                    // Creat a session variable to display message
                    $_SESSION['add'] = "Category added successfully";
                    // Redirect page
                    header("location:".SITEURL.'admin/manage-category.php');
                } else {
                    //echo("fail"); 
                     // Creat a session variable to display message
                     $_SESSION['add'] = "Failed to add Category";
                     // Redirect page
                     header("location:".SITEURL.'admin/add-category.php');
                }
            }
        ?>
    </div>
</div>
<?php include('partials/footer.php')?>
