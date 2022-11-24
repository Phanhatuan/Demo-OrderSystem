
<?php include('partials/menu.php'); ?>

    <!-- Main Content Section Stars -->
    <div class="main-content">
        <div class="wrapper">
            <h1>MANAGE ADMIN</h1>
            <br>
            <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }

                if(isset($_SESSION['delete'])){
                    echo $_SESSION['delete']; // Display session message
                    unset($_SESSION['delete']); // Remove session message
                }

                if(isset($_SESSION['update'])){
                    echo $_SESSION['update']; // Display session message
                    unset($_SESSION['update']); // Remove session message
                }

                if(isset($_SESSION['user-not-found'])){
                    echo $_SESSION['user-not-found']; // Display session message
                    unset($_SESSION['user-not-found']); // Remove session message
                }

                if(isset($_SESSION['pw-not-match'])){
                    echo $_SESSION['pw-not-match']; // Display session message
                    unset($_SESSION['pw-not-match']); // Remove session message
                }

                if(isset($_SESSION['change-pwd'])){
                    echo $_SESSION['change-pwd']; // Display session message
                    unset($_SESSION['change-pwd']); // Remove session message
                }
            ?>
            <br><br><br>

            <!-- Button to add admin -->
            <a href="add-admin.php" class="btn-primary">Add Admin</a>

            <br><br>
            <table class="tbl-full">
                <tr>
                    <th>S.N.</th>
                    <th>Full Name</th>
                    <th>User Name</th>
                    <th>Actions</th>
                </tr>

                <?php 

                    //Query to get all Admin
                    $sql = "SELECT * FROM tbl_admin";

                    // Execute the Query
                    $res = mysqli_query($conn,$sql);

                    // Check wether the query is executed or not
                    if($res == TRUE)
                    {

                        // Count rows to check we have data in database or not
                        $count = mysqli_num_rows($res); // Function to get all the rows in database

                        $sn=1; //Create a varible and assign the value
                        // Check the number of rows
                        if($count > 0)
                        {
                            // we have data in database
                            while($rows = mysqli_fetch_assoc($res))
                            {
                                // USe While loop to get all the data from database
                                // The loop will run as long as we still have data in database
                                
                                // Get individual data
                                $id = $rows['id'];
                                $full_name= $rows['full_name'];
                                $username = $rows['username'];
                                
                                // Display the values in the table
                                ?>

                                 <tr>
                                    <td><?php echo $sn++?></td>
                                    <td><?php echo $full_name?></td>
                                    <td><?php echo $username?></td>
                                    <td> 
                                        <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id;?>" class="btn-primary">Change Password</a> 
                                        <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id;?>" class="btn-secondary">Update Admin</a> 
                                        <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id;?>" class="btn-danger">Delete Admin</a> 
                                    </td>
                                </tr>

                                <?php
                            }
                        }
                        else {
                            ?>
                            <tr>
                                <td colspan="6">No admin added</td>
                             </tr>
                             <?php
                        }
                    }
                    ?>
            </table>
        </div>
    </div>
    <!-- Main Content Section Ends -->

<?php include('partials/footer.php'); ?>