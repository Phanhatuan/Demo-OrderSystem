<?php include('../config/constants.php');?>
<html>
    <head>
        <title>Login - Food Order System</title>
    <link rel="stylesheet" href=" ../css/admin.css">
    </head>

    <body>
        <div class="login">
            <h1 class="text-center">Login</h1>
            <br><br>
            <?php
                 if(isset($_SESSION['login'])){
                    echo $_SESSION['login']; // Display session message
                    unset($_SESSION['login']); // Remove session message
                }

                if(isset($_SESSION['bo-login-message'])){
                    echo $_SESSION['bo-login-message']; // Display session message
                    unset($_SESSION['bo-login-message']); // Remove session message
                }
            ?>

            <br><br>
            <!-- Login form starts here -->
            <form action="" method="POST" class="text-center">
                Username: <br>
                <input type="text" name="username" placeholder="Enter Username"> <br> <br>
                Password: <br>
                <input type="password" name="password" placeholder="Enter Password"> <br> <br>

                <input type="submit" name="submit" value="login" class="btn-primary"> <br> <br> 
            </form>
            <!-- Login form ends here -->
            <p class="text-center"> Created by - <a href="#">Tuan</a></p>
        </div>
    </body>
</html>

<?php
    // Check whether the submit btn clicked or not
    if(isset($_POST['submit'])){
        // Process for login
        //1. Get the data from the form
        $username= mysqli_real_escape_string($conn,$_POST['username']); // using this func to avoid " ' 
        $password= mysqli_real_escape_string($conn,md5($_POST['password']));

        //2. SQL to check whether the user whit username and password exists or not
        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password='$password'"; 

        //3. Execute Query and Save in Database
        $res = mysqli_query($conn,$sql);

        // 4. Count rows to check wheher the user exists or not
        $count = mysqli_num_rows($res);
        if($count==1){
            // User available
            $_SESSION['login'] = "Login successfully";
            $_SESSION['user'] = $username;

            header("location:".SITEURL.'admin/index.php');
        } else {
            // User not found
            $_SESSION['login'] = "Failed to login. Check the username or password";
            header("location:".SITEURL.'admin/login.php');
        }
    }

?>