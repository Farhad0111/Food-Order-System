<?php
ob_start(); // Start output buffering
include('partials-front/menu.php');

// Your existing PHP code here...

// Check whether the food_id is passed or not
if(isset($_GET['food_id'])) {
    $food_id = $_GET['food_id'];

    // Get the details of the selected food
    $sql = "SELECT * FROM tbl_food WHERE id=$food_id";
    $res = mysqli_query($conn, $sql);

    // Check whether the query executed successfully or not
    if($res == true) {
        // Check whether data is available or not
        $count = mysqli_num_rows($res);

        // Check whether we have food data or not
        if($count == 1) {
            // We have data
            $row = mysqli_fetch_assoc($res);

            $title = $row['title'];
            $price = $row['price'];
            $image_name = $row['image_name'];
        } else {
            // Food not available
            header('location:'.SITEURL);
            exit; // Stop further execution
        }
    }
} else {
    // Redirect to homepage
    header('location:'.SITEURL);
    exit; // Stop further execution
}

?>

<!-- FOOD SEARCH Section Starts Here -->
<section class="food-search">
    <div class="container">
        
        <h2 class="text-center text-white">Fill this form to confirm your order.</h2>

        <form action="" method="POST" class="order">
            <fieldset>
                <legend>Selected Food</legend>

                <div class="food-menu-img">
                    <?php 
                        // Check whether the image is available or not
                        if($image_name == "") {
                            // Image not available
                            echo "<div class='error'>Image not available.</div>";
                        } else {
                            // Image available
                            ?>
                            <img src="<?php echo SITEURL; ?>images/food/<?php echo $image_name; ?>" alt="<?php echo $title; ?>" class="img-responsive img-curve">
                            <?php
                        }
                    ?>
                </div>

                <div class="food-menu-desc">
                    <h3><?php echo $title; ?></h3>
                    <input type="hidden" name="food" value = "<?php echo $title; ?>">
                    <p class="food-price">$<?php echo $price; ?></p>
                    <input type="hidden" name="price" value = "<?php echo $price; ?>">

                    <div class="order-label">Quantity</div>
                    <input type="number" name="qty" class="input-responsive" value="1" required>
                    
                </div>

            </fieldset>
            
            <fieldset>
                <legend>Delivery Details</legend>
                <div class="order-label">Full Name</div>
                <input type="text" name="full-name" placeholder="E.g. Arham Khan" class="input-responsive" required>

                <div class="order-label">Phone Number</div>
                <input type="tel" name="contact" placeholder="E.g.016xxxxxxxx" class="input-responsive" required>

                <div class="order-label">Email</div>
                <input type="email" name="email" placeholder="E.g. arhamkhanewu@gmail.com" class="input-responsive" required>

                <div class="order-label">Address</div>
                <textarea name="address" rows="10" placeholder="E.g. Street, City, Country" class="input-responsive" required></textarea>

                <input type="submit" name="submit" value="Confirm Order" class="btn btn-primary">
            </fieldset>

        </form>

        <?php 
            // Check whether the submit button is clicked or not
            if(isset($_POST['submit'])) {
                // Get all the details from the form
                $food = $title;
                $price = $_POST['price'];
                $qty = $_POST['qty'];
                $total = $price * $qty; // Total = price x qty
                $order_date = date("Y-m-d h:i:sa"); // Order date
                $status = "Ordered";  // Ordered, On Delivery, Delivered, Cancelled
                $customer_name = $_POST['full-name'];
                $customer_contact = $_POST['contact'];
                $customer_email = $_POST['email'];
                $customer_address = $_POST['address'];

                // Save the order in database
                // Create SQL to save the data
                $sql2 = "INSERT INTO tbl_order SET 
                    food = '$food',
                    price = $price,
                    qty = $qty,
                    total = $total,
                    order_date = '$order_date',
                    status = '$status',
                    customer_name = '$customer_name',
                    customer_contact = '$customer_contact',
                    customer_email = '$customer_email',
                    customer_address = '$customer_address'
                ";

                // Execute the query
                $res2 = mysqli_query($conn, $sql2);

                // Check whether query executed successfully or not
                if($res2 == true) {
                    // Query executed and order saved
                    $_SESSION['order'] = "<div class='success text-center'>Food Ordered Successfully.</div>";
                    header('location:'.SITEURL);
                    exit; // Stop further execution
                } else {
                    // Failed to save order
                    $_SESSION['order'] = "<div class='error text-center'>Failed to Order Food.</div>";
                    header('location:'.SITEURL);
                    exit; // Stop further execution
                }

            }
        ?>

    </div>
</section>
<!-- FOOD SEARCH Section Ends Here -->

<?php include('partials-front/footer.php'); ?>

<?php
ob_end_flush(); // End output buffering and send content to the browser
?>
