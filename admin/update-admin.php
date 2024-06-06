<?php ?>

<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Admin</h1>
        <br><br>

        <?php
    // Check if the 'id' parameter is provided in the URL
    if(isset($_GET['id'])) {
        // Get the id of the selected admin
        $id = $_GET['id'];

        // Create SQL query to get the details of the selected admin
        $sql = "SELECT * FROM tbl_admin WHERE id = $id";

        // Execute the query
        $res = mysqli_query($conn, $sql);

        // Check whether the query executed successfully
        if ($res) {
            // Check whether the admin data is available
            $count = mysqli_num_rows($res);
            if ($count == 1) {
                // Get the details of the admin
                $row = mysqli_fetch_assoc($res);
                $full_name = $row['full_name'];
                $username = $row['username'];
                // You can continue extracting other details similarly
                //echo "Admin Full Name: $fullname";
                // Continue extracting and displaying other details as needed
            } else {
                // Redirect to the manage-admin page if admin data is not found
                header('location:' . SITEURL . 'admin/manage-admin.php');
                exit; // Ensure no further code execution after redirection
            }
        } else {
            // Handle query execution failure
            echo "Query execution failed. Please try again later.";
        }
    } else {
        // Handle case where 'id' parameter is not provided in the URL
        echo "Admin ID is not provided.";
    }
?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Full Name:</td>
                    <td>
                        <input type="text" name="full_name" value="<?php echo $full_name;  ?>">
                    </td>
                </tr>
                <tr>
                    <td>Username: </td>
                    <td>
                        <input type="text" name="username" value="<?php echo $username; ?>">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value ="<?php echo $id;?>">
                        <input type="submit" name="submit" value="Update Admin" class="btn-secondary">
                    </td>
                </tr>

            </table>

        </form>
    </div>
</div>

<?php

    //Check whether the submit button is clicked or not
    if(isset($_POST['submit']))
    {
        //echo "Button Clicked";
        //Get all the value from the form to update
        echo $id = $_POST['id'];
        echo $full_name = $_POST['full_name'];
        echo $username = $_POST['username'];

        //Create a sql query to update admin
        $sql = "UPDATE tbl_admin SET 
        full_name = '$full_name',
        username = '$username'
        WHERE id = '$id'
        ";

        //Execute the query
        $res = mysqli_query($conn, $sql);

        //Check whether the query executed succesfully or not
        if ($res == true) {
            // Set the session variable for a successful update
            $_SESSION['update'] = "<div class='success'>Admin Updated Successfully.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        } 
        else {
            // Set the session variable for a failed update
            $_SESSION['update'] = "<div class='error'>Failed to Update Admin.</div>";
            header('location:'.SITEURL.'admin/manage-admin.php');
        }

    }


?>

<?php include('partials/footer.php'); ?>