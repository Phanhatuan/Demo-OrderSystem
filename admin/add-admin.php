<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Admin</h1>
        <br><br>
        <?php 
                if(isset($_SESSION['add'])){
                    echo $_SESSION['add']; // Display session message
                    unset($_SESSION['add']); // Remove session message
                }
        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your username"></td>
                </tr>

                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter your password"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Admin" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php include('partials/footer.php')?>
<?php 
    //Process the vulue from form and save it in database

    //Check whether the button is clicked or not

    if(isset($_POST['submit'])){
        //echo "button clicked";

        //1. Get the data from form
        $full_name=$_POST['full_name'];
        $username=$_POST['username'];
        $password=md5($_POST['password']);

        //2. SQL Query to the data into database
        $sql = "INSERT INTO  tbl_admin SET 
        full_name = '$full_name',
        username = '$username',
        password = '$password' 
        ";
        
        //3. Execute Query and Save in Database
        
        $res = mysqli_query($conn,$sql) or die(mysqli_error());

        //4. Check whether the data is inserted or not and display appropriate message
        if($res==TRUE)
        {
            //echo("Data inserted");
            // Creat a session variable to display message
            $_SESSION['add'] = "Admin added successfully";
            // Redirect page
            header("location:".SITEURL.'admin/manage-admin.php');
        } else {
            //echo("fail"); 
             // Creat a session variable to display message
             $_SESSION['add'] = "Failed to add admin";
             // Redirect page
             header("location:".SITEURL.'admin/add-admin.php');
        }
    }
?>