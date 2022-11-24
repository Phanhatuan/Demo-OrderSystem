<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php 

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
                    <td><input type="text" name="title" placeholder="Food Title"></td>
                </tr>

                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the food"></textarea>
                    </td>
                </tr>

                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>

                <tr>
                    <td>Select image: </td>
                    <td><input type="file" name="image"></td>
                </tr>

                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                                // Create to display the category from database
                                // 1. Create SQL to get all the active category from database
                                $sql = "SELECT* FROM tbl_category WHERE active ='Yes'";
                                // Executing the query
                                $res = mysqli_query($conn,$sql);
                                // Count the rows to check whether have category or not
                                $count = mysqli_num_rows($res);
                                // If count is greater than 0 we have category
                                if($count > 0)
                                {
                                    // we have category
                                    while($row = mysqli_fetch_assoc($res))
                                    {
                                        // Get the value of category
                                        $id = $row['id'];
                                        $title = $row['title'];
                                        ?>

                                        <option value="<?php $id ?>"> <?php echo "$title"?></option>

                                        <?php
                                    }
                                } 
                                else
                                {
                                    // We have no category
                                    ?>
                                    <option value="0">No category found</option>
                                    <?php
                                   
                                }
                            ?>

                        </select>
                    </td>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>
        <?php
            if(isset($_POST['submit']))
            {
                //echo "clicked";
                //1. Get the data from form
                $title = $_POST['title'];
                $description = $_POST['description'];
                $price = $_POST['price'];
                $category_id = $_POST['category'];

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
                        $image_info = explode (".", $image_name);
                        $ext = end ($image_info);
                        
                        // Rename image
                        $image_name = "Food-Name-".rand(0000,9999).".".$ext;

                        $src = $_FILES['image']['tmp_name'];
                        $dst = "../images/food/".$image_name;

                        // Update the image
                        $upload = move_uploaded_file($src,$dst);

                        // Check whether the image is uploaded or not
                        // and if the image is not uploaded when we will stop the process and redirect with error message
                        if($upload == false) {
                            $_SESSION['upload'] ="Failed to upload the image";
                            header("location:".SITEURL.'admin/add-food.php');
                            // Stop the process
                            die();
                        }
                    }
                } else {
                    // Dont upload image and set the image_name as blank
                    $image_name ="";
                }

                //2. SQL Query to the data into database
                try {
                    $sql2 = "INSERT INTO  tbl_food SET
                    title = '$title',
                    description = '$description',
                    price = $price,
                    image_name = '$image_name',
                    category_id = '$category',
                    featured = '$featured',
                    active = '$active'
                    ";
                    $res2 = mysqli_query($conn,$sql2);
                } catch (mysqli_sql_exception $e) {
                   var_dump($e);
                   exit; 
                }

                //4. Check whether the data is inserted or not and display appropriate message
                 if($res2 == true)
                 {
                     //echo("Data inserted");
                     // Creat a session variable to display message
                     $_SESSION['add'] = "food added successfully";
                     // Redirect page
                     header("location:".SITEURL.'admin/manage-food.php');
                 } else {
                     //echo("fail"); 
                      // Creat a session variable to display message
                      $_SESSION['add'] = "Failed to add food";
                      // Redirect page
                      header("location:".SITEURL.'admin/add-food.php');
                 }
            }
        ?>
    </div>
</div>
<?php include('partials/footer.php'); ?>
