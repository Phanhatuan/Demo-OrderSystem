
<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Manage Order</h1>
        <br><br>
        <?php
        
            if(isset($_SESSION['no-order-found'])){
                echo $_SESSION['no-order-found']; // Display session message
                unset($_SESSION['no-order-found']); // Remove session message
            }

            if(isset($_SESSION['update'])){
                echo $_SESSION['update']; // Display session message
                unset($_SESSION['update']); // Remove session message
            }

        ?>
        <br><br>
            <table class="tbl-full small-font">
                <tr>
                    <th>S.N.</th>
                    <th>Food </th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Order Date</th>
                    <th>Status</th>
                    <th>Name</th>
                    <th>Contact</th>
                    <th>Email</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>

                <?php
                     //Query to get all foods
                     $sql = "SELECT * FROM tbl_order ORDER BY id DESC";

                     // Execute the Query
                     $res = mysqli_query($conn,$sql);

                     if($res == TRUE)
                     {
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
                                $food = $rows['food'];
                                $price = $rows['price'];
                                $quantity = $rows['qty'];
                                $total = $rows['total'];
                                $order_date = $rows['order_date'];
                                $status = $rows['status'];
                                $customer_name = $rows['customer_name'];
                                $customer_contact = $rows['customer_contact'];
                                $customer_email = $rows['customer_email'];
                                $customer_address = $rows['customer_address'];
                                
                                // Display the values in the table
                                ?>
                                <tr>
                                    <td><?php echo $sn++;?></td>
                                    <td><?php echo $food;?></td>
                                    <td><?php echo $price?></td>
                                    <td><?php echo $quantity?></td>
                                    <td><?php echo $total?></td>
                                    <td><?php echo $order_date?></td>
                                    <td><?php echo $status?></td>
                                    <td><?php echo $customer_name?></td>
                                    <td><?php echo $customer_contact?></td>
                                    <td><?php echo $customer_email?></td>
                                    <td><?php echo $customer_address?></td>
                                    
                                    <td>
                                        <a href="<?php echo SITEURL; ?>admin/update-order.php?id=<?php echo $id;?>" class="btn-secondary">Update Order</a> 
                                    </td>
                                </tr>
                                <?php
                            }
                        } else {
                            ?>
                            <tr>
                                <td colspan="6">No customer added</td>
                            </tr>

                            <?php
                        }
                    }
                ?>
            </table>
    </div>
</div>

<?php include('partials/footer.php'); ?>
