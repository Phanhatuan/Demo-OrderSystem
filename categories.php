<?php include('partials-front/menu.php');?>

    <!-- CAtegories Section Starts Here -->
    <section class="categories">
        <div class="container">
            <h2 class="text-center">Explore Foods</h2>

            <?php 
                // Create SQL query to display categories from database
                $sql ="SELECT * FROM tbl_category WHERE active ='Yes' AND featured ='Yes'";

                // Execute the query
                $res = mysqli_query($conn,$sql);
                // Count the category
                $count = mysqli_num_rows($res);
                if($count > 0){
                    // category available
                    while($row = mysqli_fetch_assoc($res)){
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php  echo SITEURL; ?>category-foods.php?category_id=<?php echo $id;?>">
                            <div class="box-3 float-container">
                                <?php
                                    if($image_name ==""){
                                        echo "Image Not available";
                                    }
                                    else {
                                        ?>
                                        <img src="<?php echo SITEURL;?>images/category/<?php echo $image_name;?>" alt="Pizza" class="img-responsive img-curve">
                                        <?php
                                    }
                                ?>
                                
                                <h3 class="float-text text-white"><?php echo $title?></h3>
                             </div>
                         </a>
                        <?php
                    }   
                } 
                else{
                    // Category no available
                    echo "Category is not added";
                }
            ?>
           

           
            <div class="clearfix"></div>
        </div>
    </section>
    <!-- Categories Section Ends Here -->


    <?php include('partials-front/footer.php')?>

</body>
</html>