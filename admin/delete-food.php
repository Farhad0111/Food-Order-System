<?php

include('../config/constants.php');

if (isset($_GET['id']) && isset($_GET['image_name'])) {
    // Process to delete
    $id = $_GET['id'];
    $image_name = $_GET['image_name'];

    if ($image_name != "") {
        $path = "../images/food/" . $image_name;

        // Check if file exists before trying to delete it
        if (file_exists($path)) {
            $remove = unlink($path);

            if ($remove == false) {
                $_SESSION['upload'] = "<div class='error'>Failed to delete image file.</div>";
                header('location:' . SITEURL . 'admin/manage-food.php');
                die();
            }
        }
    }

    // Delete food from database
    $sql = "DELETE FROM tbl_food WHERE id=$id";
    $res = mysqli_query($conn, $sql);

    if ($res == true) {
        $_SESSION['delete'] = "<div class='success'>Food deleted successfully.</div>";
    } else {
        $_SESSION['delete'] = "<div class='error'>Failed to delete food.</div>";
    }

    header('location:' . SITEURL . 'admin/manage-food.php');
} else {
    // Redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:' . SITEURL . 'admin/manage-food.php');
}
?>

