<?php include('partials-front/menu.php'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Menu</title>
    <style>
        /* Include the updated CSS here */
        body {
            background-color: #70a1ff; /* Change this to the desired background color */
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }
        .error {
            color: red;
            text-align: center;
        }
        .footer {
            background-color: #333; /* Change this to the desired footer background color */
            color: #fff;
            text-align: center;
            padding: 20px 0;
            position: relative;
            width: 100%;
        }
        .footer p {
            margin: 10px 0 0;
        }
        .footer ul {
            list-style: none;
            padding: 0;
        }
        .footer ul li {
            display: inline;
            margin: 0 10px;
        }
        .footer ul li a img {
            vertical-align: middle;
            width: 24px; /* Adjust the size of the icons as needed */
            height: 24px;
        }
        .all-foods {
            padding: 20px 0;
            margin-bottom: 80px; /* Add margin to the bottom to create space for the footer */
        }
        .text-center {
            text-align: center;
        }
        .food-menu {
            display: flex;
            flex-wrap: wrap;
            justify-content: center;
        }
        .food-menu-box {
            display: flex;
            width: 400px; /* Adjust the width as needed */
            margin: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.2);
            border-radius: 8px;
            overflow: hidden;
            background-color: #fff;
        }


        .food-menu-img {
            flex: 1;
        }
        .food-menu-img img {
            width: 100%;
            height: 100%;
            display: block;
        }
        .food-menu-desc {
            flex: 2;
            padding: 15px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        .food-price {
            color: #ff6b81;
            font-size: 1.2em;
            margin: 5px 0;
        }
        .btn-primary {
            display: inline-block;
            width: 120px; /* Adjust the width as needed */
            padding: 8px 0; /* Keep the padding or adjust as needed */
            background-color: #ff6b81;
            color: #fff;
            text-align: center; /* Center the text horizontally within the button */
            text-decoration: none;
            border-radius: 5px;
            font-size: 0.9em;
            box-sizing: border-box; /* Include padding and border in the element's total width and height */
        }

    </style>
</head>
<body>

<!-- All Foods Section Starts Here -->
<section class="all-foods">
    <div class="container">
        <h2 class="text-center">All Foods</h2>

        <div class="food-menu">
            <?php
            // Check if database connection is established
            if ($conn) {
                // SQL query to get all food items
                $sql = "SELECT * FROM tbl_food WHERE active='Yes'";
                $res = mysqli_query($conn, $sql);

                // Check if query executed successfully
                if ($res) {
                    // Check if any food items are available
                    if (mysqli_num_rows($res) > 0) {
                        // Food Available
                        while ($row = mysqli_fetch_assoc($res)) {
                            $id = $row["id"];
                            $title = $row["title"];
                            $price = $row['price'];
                            $description = $row['description'];
                            $image_name = $row['image_name'];
                            ?>

                            <div class="food-menu-box">
                                <div class="food-menu-img">
                                    <?php if (!empty($image_name) && file_exists("images/food/$image_name")) { ?>
                                        <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                                    <?php } else { ?>
                                        <div class='error'>Image Not Available.</div>
                                    <?php } ?>
                                </div>
                                <div class="food-menu-desc">
                                    <h4><?php echo $title; ?></h4>
                                    <p class="food-price">$<?php echo $price; ?></p>
                                    <p class="food-detail"><?php echo $description; ?></p>
                                    <br>
                                    <a href="<?php echo SITEURL; ?>order.php?food_id=<?php echo $id; ?>" class="btn btn-primary">Order Now</a>
                                </div>
                            </div>

                        <?php
                        }
                    } else {
                        echo "<div class='error'>No Food Items Available.</div>";
                    }
                } else {
                    echo "<div class='error'>Failed to Execute Query: " . mysqli_error($conn) . "</div>";
                }
            } else {
                echo "<div class='error'>Database Connection Error.</div>";
            }
            ?>
        </div>
    </div>
</section>

<!-- Footer Section Starts Here -->
<section class="footer">
    <div class="container text-center">
        <ul>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/50/000000/facebook-new.png"/></a>
            </li>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/48/000000/instagram-new.png"/></a>
            </li>
            <li>
                <a href="#"><img src="https://img.icons8.com/fluent/48/000000/twitter.png"/></a>
            </li>
        </ul>
        <p>@All rights reserved</p>
    </div>
</section>
<!-- Footer Section Ends Here -->

</body>
</html>
