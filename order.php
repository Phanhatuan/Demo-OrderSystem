<?php include('partials-front/menu.php');?>
    <?php
        //check whether food is set or not
        if(isset($_GET['food_id']))
        {
            //Get the food id and details of the selected food
            $food_id = $_GET['food_id'];

            //Get the detail of the selected food
            $sql = "SELECT * FROM tbl_food WHERE id = $food_id";
            // Execute the query
            $res = mysqli_query($conn,$sql);
            // COunt row          
            $count = mysqli_num_rows($res);
            // Check whether the data is availbale or not
            if($count==1)
            {
                // have data
                $row = mysqli_fetch_assoc($res);

                $title = $row['title'];
                $price = $row['price'];
                $image_name = $row['image_name'];
            }
            else 
            {   
                //dont have data and redirect to home page
                header('location'.SITEURL);
            }
        }
        else
        {
            //Redirect to the homepage
            header('location'.SITEURL);
        }
    ?>
    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search">
        <div class="container">
            
            <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

            <form action="" class="order" method="POST">
                <fieldset>
                    <legend>Selected Food</legend>

                    <div class="food-menu-img">
                        <?php
                            //Check whether image is vailable or not
                            if($image_name =="")
                            {
                                //  not available
                                echo "image is not available";
                            }
                            else
                            {
                                ?>
                                    <img src="<?php echo SITEURL;?>images/food/<?php echo $image_name;?>" alt="Chicke Hawain Pizza" class="img-responsive img-curve">

                                <?php
                            }
                        ?>
                    </div>
    
                    <div class="food-menu-desc">
                        <h3><?php echo $title;?></h3>
                        <input type="hidden" name="food" value="<?php echo $title;?>">

                        <p class="food-price"><?php echo $price;?></p>
                        <input type="hidden" name="price" value="<?php echo $price;?>">

                        <div class="order-label">Quantity</div>
                        <input type="number" name="qty" class="input-responsive" value="1" required>
                        
                    </div>

                </fieldset>
                
                <fieldset>
                    <legend>Delivery Details</legend>
                    <div class="order-label">Full Name</div>
                    <input type="text" name="full-name" placeholder="E.g. Phan Nhat Tuan" class="input-responsive" required>

                    <div class="order-label">Phone Number</div>
                    <input type="tel" name="contact" placeholder="E.g. 9843xxxxxx" class="input-responsive" required>

                    <div class="order-label">Email</div>
                    <input type="email" name="email" placeholder="E.g. phannhattuan@gmail.com" class="input-responsive" required>

                    <div class="order-label">Address</div>
                    <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                    <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
                </fieldset>

            </form>


            <?php
                //Check whether the btn is click or not
                if(isset($_POST['submit']))
                {
                    //echo 'clicked';
                    // Get the data from form
                    $food = $_POST['food'];
                    $price = $_POST['price'];
                    $qty = $_POST['qty'];
                    $total = $price * $qty;
                    $order_date = date("Y-m-d h:i:sa"); //order date

                    $status = "Ordered"; // Ordered, on delivery, dilivered,cancelled
                    $customer_name=$_POST['full-name'];
                    $customer_contact=$_POST['contact'];
                    $customer_email = $_POST['email'];
                    $customer_address = $_POST['address'];

                    //Create SQL query to save data
                    $sql2 = "INSERT INTO tbl_order SET
                        food = '$food',
                        price = $price,
                        qty= $qty,
                        total= $total,
                        order_date= '$order_date',
                        status= '$status',
                        customer_name = '$customer_name',
                        customer_contact = '$customer_contact',
                        customer_email = '$customer_email',
                        customer_address = '$customer_address'

                    ";
                    // Execute the query
                    $res2 = mysqli_query($conn,$sql2);
                    // check whether query executed or not
                    if($res2==true)
                    {
                        //QUery executed
                        $_SESSION['order']="food ordered successfully.";
                        header('location:'.SITEURL);
                    }
                    else
                    {
                        //Failed to execute
                        $_SESSION['order']="failed to order food.";
                        header('location:'.SITEURL);
                    }
                }
                else
                {

                }
            
            ?>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <?php include('partials-front/footer.php')?>

</body>
</html>