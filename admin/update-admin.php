<?php include('partials/menu.php');?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php 
            //1. Get the id of selected admin
            $id = $_GET['id'];

            //2. Create SQL Query top get the details
            $sql = "SELECT * FROM tbl_admin WHERE id=$id";

            // Execute the Query
            $res = mysqli_query($conn,$sql);

            // Check whether the query is executed or not
            if($res == true){
                // Check the data is availble or not
                $count = mysqli_num_rows($res);

                // Check whether we have admin data or not
                if ($count == 1) {
                    $row=mysqli_fetch_assoc($res);
                    $full_name = $row['full_name'];
                    $username=$row['username'];
                } else 
                {
                     header('location:'.SITEURL.'admin/manage-admin.php');
                }
            }

        ?>
        <form action="" method="POST">

            <table class="tbl-30">
                <tr>
                    <td>Full name: </td>
                    <td><input type="text" name="full_name" placeholder="Enter your name" value="<?php echo $full_name; ?>"></td>
                </tr>

                <tr>
                    <td>Username: </td>
                    <td><input type="text" name="username" placeholder="Enter your username" value="<?php echo $username; ?>"></td>
                </tr>

                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary"> 
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php 
    // check whether the submit button is clicked or not
    if(isset($_POST['submit'])){
        // echo "button clicked";
        // Get all the value from form update
        $id = $_POST['id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];

        // Create SQL query to update admin
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";
        // Execute the query
        $res = mysqli_query($conn,$sql);

        // Check whether the query executed successfully or not
        if($res==true){
            // Query executed and admin updated
            $_SESSION['update'] = "Admin updated successfully";
            // redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        } else {
            $_SESSION['update'] = "Failed to update Admin";
            // redirect to manage admin page
            header('location:'.SITEURL.'admin/manage-admin.php');
        }
    }
?>

<?php include('partials/footer.php');?>