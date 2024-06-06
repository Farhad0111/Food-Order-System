<?php include('partials/menu.php'); ?>

<?php 

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql2 = "SELECT * FROM tbl_food WHERE id = $id";

    $res2 = mysqli_query($conn, $sql2);

    if ($res2 == true) {
        $count = mysqli_num_rows($res2);
        if ($count == 1) {
            // Get the details
            $row2 = mysqli_fetch_assoc($res2);

            $title = $row2["title"];
            $description = $row2["description"];
            $price = $row2["price"];
            $current_image = $row2["image_name"];
            $category = $row2["category_id"];
            $featured = $row2["featured"];
            $active = $row2["active"];
        } else {
            // Redirect to manage food page with session message
            $_SESSION['no-food-found'] = "<div class='error'>Food not found.</div>";
            header('location:'.SITEURL.'admin/manage-food.php');
        }
    }
} else {
    // Redirect to manage food page
    $_SESSION['unauthorize'] = "<div class='error'>Unauthorized Access.</div>";
    header('location:'.SITEURL.'admin/manage-food.php');
}

?>

<div class="main-content">
    <div class="wrapper">
        <h1>Update Food</h1>
        <br><br>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food" value="<?php echo $title; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"><?php echo $description; ?></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price" value="<?php echo $price; ?>">
                    </td>
                </tr>
                <tr>
                    <td>Current Image: </td>
                    <td>
                        <?php
                        if ($current_image == "") {
                            echo "<div class='error'>Image not Available.</div>";
                        } else {
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $current_image; ?>" width="150px">
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>New Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <select name="category">
                            <?php 
                            // Display Category from database
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                // Categories
                                while ($row = mysqli_fetch_assoc($res)) {
                                    $category_id = $row['id'];
                                    $category_title = $row['title'];
                                    ?>
                                    <option value="<?php echo $category_id; ?>" <?php if($category_id == $category) { echo "selected"; } ?>><?php echo $category_title; ?></option>
                                    <?php
                                }
                            } else {
                                // No category
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if ($featured == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if ($featured == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if ($active == "Yes") { echo "checked"; } ?>> Yes
                        <input type="radio" name="active" value="No" <?php if ($active == "No") { echo "checked"; } ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="hidden" name="current_image" value="<?php echo $current_image; ?>">
                        <input type="hidden" name="id" value="<?php echo $id; ?>">
                        <input type="submit" name="submit" value="Update Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if (isset($_POST['submit'])) {
            // Get all the details from the form
            $id = $_POST['id'];
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];
            $current_image = $_POST['current_image'];
            $featured = $_POST['featured'];
            $active = $_POST['active'];

            // Upload the new image if selected
            if (isset($_FILES['image']['name'])) {
                $image_name = $_FILES['image']['name'];

                if ($image_name != "") {
                    // Image available
                    $parts = explode('.', $image_name);
                    $ext = end($parts);

                    $image_name = "Food_Category_".rand(000, 999).'.'.$ext;

                    $src = $_FILES['image']['tmp_name'];
                    $dst = "../images/food/".$image_name;

                    $upload = move_uploaded_file($src, $dst);

                    // Check whether the image is uploaded or not
                    if ($upload == false) {
                        // Failed to upload the image
                        $_SESSION['upload'] = "<div class='error'>Failed to upload new image.</div>";
                        header('location:'.SITEURL.'admin/manage-food.php');
                        die();
                    }

                    // Remove current image if available
                    if ($current_image != "") {
                        $remove_path = "../images/food/".$current_image;
                        $remove = unlink($remove_path);

                        // Check whether the image is removed or not
                        if ($remove == false) {
                            // Failed to remove the image
                            $_SESSION['remove-failed'] = "<div class='error'>Failed to remove current image.</div>";
                            header('location:'.SITEURL.'admin/manage-food.php');
                            die();
                        }
                    }
                } else {
                    $image_name = $current_image; // Default image when image is not selected
                }
            } else {
                $image_name = $current_image; // Default image when button is not clicked
            }

            // Update the food in the database
            $sql3 = "UPDATE tbl_food SET
                title = '$title',
                description = '$description',
                price = '$price',
                image_name = '$image_name',
                category_id = '$category',
                featured = '$featured',
                active = '$active'
                WHERE id=$id
            ";

            $res3 = mysqli_query($conn, $sql3);

            // Check whether the query executed successfully or not
            if ($res3 == true) {
                // Food updated
                $_SESSION['update'] = "<div class='success'>Food updated successfully.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            } else {
                // Failed to update food
                $_SESSION['update'] = "<div class='error'>Failed to update food.</div>";
                header('location:'.SITEURL.'admin/manage-food.php');
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php'); ?>
