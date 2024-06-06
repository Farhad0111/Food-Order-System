<?php
// Include constants.php for SITEURL and database connection
include('../config/constants.php');

// Check whether the id is set
if (isset($_GET['id'])) {
    // Get the Order ID
    $id = $_GET['id'];

    // SQL query to delete order
    $sql = "DELETE FROM tbl_order WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if ($res == true) {
        // Order deleted
        $_SESSION['delete'] = "<div class='success'>Order Deleted Successfully.</div>";
    } else {
        // Failed to delete order
        $_SESSION['delete'] = "<div class='error'>Failed to Delete Order.</div>";
    }

    // Redirect to Manage Order Page
    header('location:' . SITEURL . 'admin/manage-order.php');
} else {
    // Redirect to Manage Order Page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-order.php');
}
?>

