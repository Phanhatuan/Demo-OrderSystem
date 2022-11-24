<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php 
            if(isset($_GET['id']))
            {
                $id=$_GET['id'];
            }
        ?>
        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Current password: </td>
                    <td>
                        <input type="password" name="current_password" placehoder="Old Password">
                    </td>
                </tr>

                <tr>
                    <td>New password: </td>
                    <td>
                        <input type="password" name="new_password" placehoder="New Password">
                    </td>
                </tr>

                <tr>
                    <td>Confirm password: </td>
                    <td>
                        <input type="password" name="confirm_password" placehoder="Confirm Password">
                    </td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    // check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        //echo "button clicked";

        //1. Get the data from form
        $id=$_POST['id'];
        $current_password=md5($_POST['current_password']);
        $new_password=md5($_POST['new_password']);
        $confirm_password=md5($_POST['confirm_password']);

        // 2. Check whether the user with current id and current password exist or not
        $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password='$current_password'"; 

        // Execute the query
        $res = mysqli_query($conn,$sql) or die(mysqli_error());

        if($res == true) {
            // Check whether data is available or not
            $count = mysqli_num_rows($res);

            if($count==1){
                // User exists and password can be changed
                //echo "User Found";

                if($new_password == $confirm_password){
                    $sql2 = "UPDATE  tbl_admin SET 
                    password = '$new_password' WHERE id = $id 
                    ";

                    $res2 = mysqli_query($conn,$sql2);

                    if($res2 == true){
                        $_SESSION['change-pwd'] = "Password changed successfully";
                        header("location:".SITEURL.'admin/manage-admin.php');
                    } else {
                        $_SESSION['change-pwd'] = "Failed to change password";
                        header("location:".SITEURL.'admin/manage-admin.php');

                    }
                } else {
                    $_SESSION['pw-not-match'] = "Password not match";
                    header("location:".SITEURL.'admin/manage-admin.php');
                }
            }
            else {
                $_SESSION['user-not-found'] = "User not found";
                header("location:".SITEURL.'admin/manage-admin.php');
            }
        }
        // 3. Check whether the new password and confirm match or not

        // 4. Change password if all above is true
    }
?>
<?php include('partials/footer.php'); ?>