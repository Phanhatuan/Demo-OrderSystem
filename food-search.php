<?php include('partials-front/menu.php');?>

    <!-- fOOD sEARCH Section Starts Here -->
    <section class="food-search text-center">
        <div class="container">
            <?php
                 // Get the value from search button
                 // $search = $_POST['search'];
                 $search = mysqli_real_escape_string($conn,$_POST['search']); // using this func to avoid " ' 

            ?>
            <h2>Foods on Your Search <a href="#" class="text-white">"<?php echo $search;?>"</a></h2>

        </div>
    </section>
    <!-- fOOD sEARCH Section Ends Here -->

    <!-- fOOD MEnu Section Starts Here -->
    <section class="food-menu">
        <div class="container">
            <h2 class="text-center">Food Menu</h2>
            <?php
                //Create SQL query to display categories from database
                $sql = "SELECT * FROM tbl_food WHERE title LIKE '%$search%' OR description LIKE '%$search%'";

                //Execute the query
                $res = mysqli_query($conn,$sql);

                //Count the row
                $count = mysqli_num_rows($res);

                //Check whethe have food or not
                if($count > 0)
                {
                    // Have food
                    while($row = mysqli_fetch_assoc($res))
                    {   
                        // get data from each row
                        $id = $row['id'];
                        $title = $row['title'];
                        $description =$row['description'];
                        $price = $row['price'];
                        $image_name = $row['image_name'];

                        ?>
                        
                         <div class="food-menu-box">
                            <div class="food-menu-img">
                                <?php
                                    if($image_name =="")
                                    {
                                        echo "Image not added";
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
                                <h4><?php echo $title; ?></h4>
                                <p class="food-price"><?php echo $price; ?>$</p>
                                <p class="food-detail">
                                    <?php echo $description;?>
                                </p>
                                <br>

                                <a href="order.html" class="btn btn-primary">Order Now</a>
                            </div>
                        </div>
                        <?php
                    }
                }
                else
                {
                    //dont have any
                    echo "The food is not available";
                }
            
            ?>

            <div class="clearfix"></div>

        </div>

    </section>
    <!-- fOOD Menu Section Ends Here -->

    <?php include('partials-front/footer.php')?>

</body>
</html>