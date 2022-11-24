
<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Food</h1>

        <br><br>

        <!-- Button to add food -->
        <a href="add-food.php" class="btn-primary">Add Food</a>

        <br><br>
        <?php
            if(isset($_SESSION['add'])){
                echo $_SESSION['add']; // Display session message
                unset($_SESSION['add']); // Remove session message
            }
            
            if(isset($_SESSION['remove'])){
                echo $_SESSION['remove']; // Display session message
                unset($_SESSION['remove']); // Remove session message
            }

            if(isset($_SESSION['delete'])){
                echo $_SESSION['delete']; // Display session message
                unset($_SESSION['delete']); // Remove session message
            }

            if(isset($_SESSION['no-category-found'])){
                echo $_SESSION['no-category-found']; // Display session message
                unset($_SESSION['no-category-found']); // Remove session message
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; // Display session message
                unset($_SESSION['update']); // Remove session message
            }

            if(isset($_SESSION['upload'])){
                echo $_SESSION['upload']; // Display session message
                unset($_SESSION['upload']); // Remove session message
            }

            if(isset($_SESSION['failed-remove'])){
                echo $_SESSION['failed-remove']; // Display session message
                unset($_SESSION['failed-remove']); // Remove session message
            }
        ?>
        <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Image</th>
                    <th>Category</th>
                    <th>Featured</th>
                    <th>Active</th>
                    <th>Action</th>

                </tr>

                <?php
                    //Query to get all foods
                    $sql = "SELECT * FROM tbl_food";

                    // Execute the Query
                    $res = mysqli_query($conn,$sql);

                    // Check wether the query is executed or not
                    if($res == TRUE) {
                        // Count rows to check we have data in database or not
                        $count = mysqli_num_rows($res); // Function to get all the rows in database

                        $sn=1; //Create a varible and assign the value
                        // Check the number of rows

                        if($count > 0) {
                            // we have data in database
                            while($rows = mysqli_fetch_assoc($res)) {
                                // USe While loop to get all the data from database
                                // The loop will run as long as we still have data in database

                                // Get individual data
                                $id = $rows['id'];
                                $title = $rows['title'];
                                $description = $rows['description'];
                                $price = $rows['price'];
                                $image_name = $rows['image_name'];
                                $category = $rows['category_id'];
                                $featured = $rows['featured'];
                                $active = $rows['active'];
                                
                                // Display the values in the table
                                ?>
                                <tr>
                                    <td><?php echo $sn++;?></td>
                                    <td><?php echo $title;?></td>
                                    <td><?php echo $description?></td>
                                    <td><?php echo $price?></td>
                                    <td>
                                        <?php 
                                            // Check whether image name is available or not
                                            if($image_name !=""){
                                                //Display the image
                                                ?>
                                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name ?>" width="150px"> 
                                                <?php
                                            } else {
                                                echo "The image is not available";
                                            }
                                        ?>
                                    </td>
                                    <td><?php echo $category;?></td>
                                    <td><?php echo $featured;?></td>
                                    <td><?php echo $active;?></td>
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-food.php?id=<?php echo $id;?>" class="btn-secondary">Update Food</a> 
                                        <a href="<?php echo SITEURL; ?>admin/delete-food.php?id=<?php echo $id;?> & image_name=<?php echo $image_name?>" class="btn-danger">Delete Food</a> 
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">No food added</td>
                            </tr>

                            <?php
                        }
                    }
                ?>
        </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
