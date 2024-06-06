<?php include('partials/menu.php')?>

<div class="main-content">
    <div class="wrapper">
        <h1>Add Food</h1>
        <br><br>

        <?php 
        if(isset($_SESSION['upload'])) {
            echo $_SESSION['upload'];
            unset($_SESSION['upload']);
        }
        ?>

        <form action="" method="POST" enctype="multipart/form-data">
            <table class="tbl-30">
                <tr>
                    <td>Title: </td>
                    <td>
                        <input type="text" name="title" placeholder="Title of the Food">
                    </td>
                </tr>
                <tr>
                    <td>Description: </td>
                    <td>
                        <textarea name="description" cols="30" rows="5" placeholder="Description of the Food"></textarea>
                    </td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td>
                        <input type="number" name="price">
                    </td>
                </tr>
                <tr>
                    <td>Select Image: </td>
                    <td>
                        <input type="file" name="image">
                    </td>
                </tr>
                <tr>
                    <td>Category: </td>
                    <td>
                        <Select name="category">
                            <?php 
                            //Display Category from database
                            //Create sql
                            $sql = "SELECT * FROM tbl_category WHERE active='Yes'";
                            $res = mysqli_query($conn, $sql);

                            //Count rows to check
                            $count = mysqli_num_rows($res);

                            if ($count > 0) {
                                //Categories
                                while ($row = mysqli_fetch_array($res)) {
                                    $id = $row['id'];
                                    $title = $row['title'];
                                    ?>
                                    <option value="<?php echo $id?>"><?php echo $title; ?></option>
                                    <?php
                                }
                            } else {
                                //No category
                                ?>
                                <option value="0">No Category Found</option>
                                <?php
                            }
                            ?>
                        </Select>
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
                        <input type="submit" name="submit" value="Add Food" class="btn-secondary">
                    </td>
                </tr>
            </table>
        </form>

        <?php 
        if(isset($_POST['submit'])) {
            //Add the food in database
            $title = $_POST['title'];
            $description = $_POST['description'];
            $price = $_POST['price'];
            $category = $_POST['category'];

            if(isset($_POST['featured'])) {
                $featured = $_POST['featured'];
            } else {
                $featured = "No";
            }
            if(isset($_POST['active'])) {
                $active = $_POST['active'];
            } else {
                $active = "No";
            }

            // Check if the image is selected or not
            if(isset($_FILES['image']['name']) && $_FILES['image']['name'] != "") {
                // Image is selected
                $image_name = $_FILES['image']['name'];
                $parts = explode('.', $image_name);
                $ext = end($parts);

                $image_name = "Food_Category_" . rand(000, 999) . '.' . $ext;

                $src = $_FILES['image']['tmp_name'];
                $dst = "../images/food/" . $image_name;

                $upload = move_uploaded_file($src, $dst);

                // Check whether the image is uploaded or not
                if($upload == false) {
                    //Failed
                    $_SESSION['upload'] = "<div class='error'>Failed to upload image.</div>";
                    header('location:'.SITEURL.'admin/add-food.php');
                    die();
                }
            } else {
                // Image is not selected
                $image_name = "";
            }

            // SQL query to insert data into the database
            $sql2 = "INSERT INTO tbl_food(title, description, price, image_name, category_id, featured, active) 
                     VALUES ('$title', '$description', '$price', '$image_name', '$category', '$featured', '$active')";
            $res2 = mysqli_query($conn, $sql2);

            if ($res2 == true) {
                $_SESSION['add'] = "<div class='success'>Food Added Successfully.</div>";
                header("location:".SITEURL.'admin/manage-food.php');
                exit();
            } else {
                $_SESSION['add'] = "<div class='error'>Failed to Add Food.</div>";
                header("location:".SITEURL.'admin/add-food.php');
                exit();
            }
        }
        ?>
    </div>
</div>

<?php include('partials/footer.php')?>
