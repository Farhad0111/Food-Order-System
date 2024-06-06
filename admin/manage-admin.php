<?php include('partials/menu.php'); ?>

<!-- Menu Content Section starts -->
<div class="main-content">
    <div class="wrapper">
        <h1>Manage Admin</h1>
        <br>

        <?php
        if (isset($_SESSION['add'])) {
            echo $_SESSION['add'];
            unset($_SESSION['add']); //Removing Session message
        }

        if (isset($_SESSION['delete'])) {
            echo $_SESSION['delete'];
            unset($_SESSION['delete']); //Removing Session message
        }
        if (isset($_SESSION['update'])) {
            echo $_SESSION['update'];
            unset($_SESSION['update']); //Removing Session message
        }

        if (isset($_SESSION['user-not-found'])) 
        {
            echo $_SESSION['user-not-found'];
            unset($_SESSION['user-not-found']);
        }

        if (isset($_SESSION['pwd-not-match'])) 
        {
            echo $_SESSION['pwd-not-match'];
            unset($_SESSION['pwd-not-match']);
        }
        if (isset($_SESSION['change-pwd'])) 
        {
            echo $_SESSION['change-pwd'];
            unset($_SESSION['change-pwd']);
        }


        ?>

        <br><br><br>
        <!-- Button to add admin -->
        <a href="add-admin.php" class="btn-primary">Add Admin</a>
        <br><br><br>
        <table class="tbl-full">
            <tr>
                <th>S.N.</th>
                <th>Full Name</th>
                <th>Username</th>
                <th>Actions</th>
            </tr>

            <?php
            // Query to get all admin
            $sql = "SELECT * FROM tbl_admin";
            // Execute the query
            $res = mysqli_query($conn, $sql);

            // Check whether the query is executed or not
            if ($res !== false) { // Check if $res is not FALSE (indicating success)
                // Count rows to check whether we have data in the database or not
                $rows = mysqli_num_rows($res);

                $sn = 1; // Create a variable and assign the value
                if ($rows > 0) {
                    // We have data in the database
                    while ($row = mysqli_fetch_assoc($res)) {
                        // Using while loop to get all the data from the database.
                        $id = $row['id'];
                        $full_name = $row['full_name'];
                        $username = $row['username'];

                        //Display the values in our table
                        ?>

                        <tr>
                            <td><?php echo $sn++; ?></td>
                            <td><?php echo $full_name; ?></td>
                            <td><?php echo $username; ?></td>
                            <td>
                            <a href="<?php echo SITEURL; ?>admin/update-password.php?id=<?php echo $id; ?>" class="btn-primary">Change Password</a>
                                <a href="<?php echo SITEURL; ?>admin/update-admin.php?id=<?php echo $id; ?>" class="btn-secondary">Update Admin</a>
                                <a href="<?php echo SITEURL; ?>admin/delete-admin.php?id=<?php echo $id; ?>" class="btn-danger">Delete Admin</a>

                            </td>
                        </tr>



                         <?php
                    }
                } else {
                    // We do not have data in the database
                }
            }
            ?>


        </table>


    </div>
</div>
<!-- Menu Content Section ends -->

<?php include('partials/footer.php'); ?>