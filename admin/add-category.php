<?php 
    include('partials/menu.php');
?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Category</h1>
        <br><br>

        <?php 
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }

            if(isset($_SESSION['upload'])) {
                echo $_SESSION['upload'];
                unset($_SESSION['upload']);
            }
        ?>

        <br><br>

        <!-- Add Category Form Starts -->
        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Category Title" required>
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Featured: </td>
                    <td>
                        <input type="radio" name="featured" value="Yes" <?php if(isset($_POST['featured']) && $_POST['featured'] == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="featured" value="No" <?php if(isset($_POST['featured']) && $_POST['featured'] == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                <tr>
                    <td>Active: </td>
                    <td>
                        <input type="radio" name="active" value="Yes" <?php if(isset($_POST['active']) && $_POST['active'] == 'Yes') echo 'checked'; ?>> Yes
                        <input type="radio" name="active" value="No" <?php if(isset($_POST['active']) && $_POST['active'] == 'No') echo 'checked'; ?>> No
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <input type="submit" name="submit" value="Add Category" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>
        <!-- Add Category Form Ends -->

        <?php 
            // Process the form data
            if(isset($_POST['submit'])) {
                $title = $_POST['title'];
                $featured = isset($_POST['featured']) ? $_POST['featured'] : "No";
                $active = isset($_POST['active']) ? $_POST['active'] : "No";

                // Escape special characters to prevent SQL injection
                $title = mysqli_real_escape_string($conn, $title);
                $featured = mysqli_real_escape_string($conn, $featured);
                $active = mysqli_real_escape_string($conn, $active);

                // Check whether the image is selected or not and set the value for image name
                if ($image_name != "") {
                    // Auto rename our image
                    // Get the extension of our image (jpg, png, gif, etc)
                    $parts = explode('.', $image_name); // Store the result of explode in a variable
                    $ext = end($parts); // Get the last element from the array which is the extension
                    
                    // Rename the image
                    $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;
                
                    $source_path = $_FILES['image']['tmp_name'];
                    $destination_path = "../images/category/" . $image_name;
                
                    $upload = move_uploaded_file($source_path, $destination_path);
                
                    // Check whether the image is uploaded or not
                    if ($upload == false) {
                        $_SESSION['upload'] = "<div class='error'>Failed to Upload Image.</div>";
                        header('Location: ' . SITEURL . 'admin/add-category.php');
                        // Stop the process
                        die();
                    }
                } else {
                    // Don't upload image and set the image value as blank
                    $image_name = "";
                }
                

                // SQL query to insert data into the database
                $sql = "INSERT INTO tbl_category (title, image_name, featured, active) VALUES ('$title', '$image_name', '$featured', '$active')";
                $res = mysqli_query($conn, $sql);

                if ($res) {
                    $_SESSION['add'] = "<div class='success'>Category Added Successfully.</div>";
                    header("location:".SITEURL.'admin/manage-category.php');
                    exit();
                } else {
                    $_SESSION['add'] = "<div class='error'>Failed to Add Category.</div>";
                    header("location:".SITEURL.'admin/add-category.php');
                    exit();
                }
            }
        ?>
    </div>
</div>    

<?php 
    include('partials/footer.php');
?>
