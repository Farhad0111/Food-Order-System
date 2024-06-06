<?php include('config/constants.php'); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Food Order Website</title>

    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #dfe4ea;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            background-color: #ffffff;
            color: #fff;
            padding: 2px 0;
        }
        .navbar .container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .navbar .logo img {
            max-height: 50px;
            width: auto;
        }
        .navbar .menu ul {
            list-style: none;
            margin: 0;
            padding: 0;
            display: flex;
        }
        .navbar .menu ul li {
            margin-left: 20px;
        }
        .navbar .menu ul li a {
            text-decoration: none;
            color: #ff7f50;
            padding: 10px;
            font-weight: bold;
        }
        .navbar .menu ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        }
    </style>
</head>

<body>
    <!-- Navbar Section Starts Here -->
    <section class="navbar">
        <div class="container">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>" title="Logo">
                    <img src="images/logo3.png" alt="Restaurant Logo" class="img-responsive">
                </a>
            </div>
            <div class="menu">
                <ul>
                    <li><a href="<?php echo SITEURL; ?>">Home</a></li>
                    <li><a href="<?php echo SITEURL; ?>categories.php">Categories</a></li>
                    <li><a href="<?php echo SITEURL; ?>foods.php">Foods</a></li>
                    <li><a href="<?php echo SITEURL; ?>contact.php">Contact</a></li>
                    <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
                        <li><a href="<?php echo SITEURL; ?>logout.php">Logout</a></li>
                    <?php } ?>
                </ul>
            </div>
        </div>
    </section>
    <!-- Navbar Section Ends Here -->
    
    <!-- Your remaining HTML content goes here -->

</body>
</html>
