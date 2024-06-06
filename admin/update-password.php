<?php include('partials/menu.php'); ?>

<div class="main-content">
    <div class="wrapper">
        <h1>Change Password</h1>
        <br><br>

        <?php
        if (isset($_GET['id'])) {
            $id = $_GET['id'];
        }
        ?>

        <form action="" method="POST">
            <table class="tbl-30">
                <tr>
                    <td>Old Password: </td>
                    <td>
                        <input type="password" name="old_password" placeholder="Old Password">
                    </td>
                </tr>
                <tr>
                    <td>New Password: </td>
                    <td>
                        <input type="password" name="new_password" placeholder="New Password">
                    </td>
                </tr>
                <tr>
                    <td>Confirm Password: </td>
                    <td>
                        <input type="password" name="confirm_password" placeholder="Confirm Password">
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Change Password" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

<?php
if (isset($_POST['submit'])) {
    // Include database connection
    include('config/constants.php');

    // Get all the values from the form
    $id = $_POST['id'];
    $old_password = md5($_POST['old_password']);
    $new_password = md5($_POST['new_password']);
    $confirm_password = md5($_POST['confirm_password']);

    // Check whether the user with current id and password exists or not
    $sql = "SELECT * FROM tbl_admin WHERE id = $id AND password='$old_password'";
    $result = mysqli_query($conn, $sql);

    // Check if the query executed successfully
    if ($result) {
        $count = mysqli_num_rows($result);

        if ($count == 1) {
            // User exists and password can be changed
            // Check whether the new password and confirm password match or not
            if ($new_password == $confirm_password) {
                $sql2 = "UPDATE tbl_admin SET
                        password = '$new_password'
                        WHERE id = $id";

                $res = mysqli_query($conn, $sql2);
                if ($res == true) {
                    // Display Success Message
                    $_SESSION['change-pwd'] = "<div class='success'>Password Changed Successfully.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                } else {
                    // Display Error Message
                    $_SESSION['change-pwd'] = "<div class='error'>Failed to Change Password.</div>";
                    header('location:' . SITEURL . 'admin/manage-admin.php');
                }
            } else {
                $_SESSION['pwd-not-match'] = "<div class='error'>Password Did Not Match.</div>";
                header('location:' . SITEURL . 'admin/manage-admin.php');
            }
        } else {
            // User does not exist
            $_SESSION['user-not-found'] = "<div class='error'>User Not Found</div>";
            header('location:' . SITEURL . 'admin/manage-admin.php');
        }
    } else {
        echo "Query failed: " . mysqli_error($conn);
    }
}
?>

<?php include('partials/footer.php'); ?>


