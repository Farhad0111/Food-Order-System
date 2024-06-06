<?php 
include('config/constants.php'); 
include('partials-front/menu.php'); 

// Check if a session is not already active before starting one
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in, if not then redirect to login page
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header("location: customer-login.php");
    exit;
}
?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search text-center">
    <div class="container">
        <form action="<?php echo SITEURL; ?>food-search.php" method="POST">
            <input type="search" name="search" placeholder="Search for Food.." required>
            <input type="submit" name="submit" value="Search" class="btn btn-primary">
        </form>
    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<?php 
    if(isset($_SESSION['order'])) {
        echo $_SESSION['order'];
        unset($_SESSION['order']);
    }
?>

<!-- CATEGORIES Section Starts Here -->
<section class="categories">
    <div class="container">
        <h2 class="text-center">Explore Foods</h2>

        <?php 
            // Create SQL query to display active and featured categories from database
            $sql = "SELECT * FROM tbl_category WHERE active = 'Yes' AND featured = 'Yes' LIMIT 3";
            $res = mysqli_query($conn, $sql);

            if($res == TRUE) {
                $count = mysqli_num_rows($res);

                if($count > 0) {
                    // Categories Available
                    while($row = mysqli_fetch_assoc($res)) {
                        $id = $row['id'];
                        $title = $row['title'];
                        $image_name = $row['image_name'];
                        ?>
                        <a href="<?php echo SITEURL;?>category-foods.php?category_id=<?php echo $id; ?>">
                            <div class="box-3 float-container">
                                <?php
                                if($image_name == "") {
                                    echo "<div class='error'>Image not Available</div>";
                                } else {
                                    ?>
                                    <img src="<?php echo SITEURL; ?>images/category/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                    <?php
                                }
                                ?>
                                <h3 class="float-text text-white"><?php echo $title; ?></h3>
                            </div>
                        </a>
                        <?php
                    }
                } else {
                    // Categories not Available
                    echo "<div class='error'>Category not Added.</div>";
                }
            } else {
                echo "<div class='error'>Failed to Execute Query.</div>";
            }
        ?>

        <div class="clearfix"></div>
    </div>
</section>
<!-- CATEGORIES Section Ends Here -->

<!-- FOOD MENU Section Starts Here -->
<section class="food-menu">
    <div class="container">
        <h2 class="text-center">Food Menu</h2>

        <?php
        // SQL query to get active and featured food items
        $sql2 = "SELECT * FROM tbl_food WHERE active='Yes' AND featured='Yes' LIMIT 6";
        $res2 = mysqli_query($conn, $sql2);

        if($res2 == TRUE) {
            $count2 = mysqli_num_rows($res2);
        
            if($count2 > 0) {
                // Food Available
                while($row= mysqli_fetch_assoc($res2)) {
                    $id = $row["id"];
                    $title = $row["title"];
                    $price = $row['price'];
                    $description = $row['description'];
                    $image_name = $row['image_name'];
                    ?>

                    <div class="food-menu-box">
                        <div class="food-menu-img">
                            <?php
                            if($image_name == '') {
                                echo "<div class='error'>Image Not Available.</div>";
                            } else {
                                ?>
                                <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                <?php
                            }
                            ?>
                        </div>
                        <div class="food-menu-desc">
                            <h4><?php echo $title; ?></h4>
                            <p class="food-price">$<?php echo $price; ?></p>
                            <p class="food-detail">
                                <?php echo $description; ?>
                            </p>
                            <br>
                            <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                        </div>
                    </div>

                    <?php
                }
            } else {
                echo "<div class='error'>Food Not Available.</div>";
            }
        } else {
            echo "<div class='error'>Failed to Execute Query.</div>";
        }
        ?>

        <div class="clearfix"></div>
    </div>

    <p class="text-center">
    <a href="<?php echo SITEURL; ?>foods.php">See All Foods</a>
    </p>

</section>
<!-- FOOD MENU Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

