<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include('config/constants.php');

// Initialize the error message variable
$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"]; 

    // Insert contact information into the database
    $sql = "INSERT INTO tbl_contact (name, email, subject, message) VALUES ('$name', '$email', '$subject', '$message')";
    $result = mysqli_query($conn, $sql);

    if ($result) {
        $_SESSION['success'] = "Contact information saved successfully!";
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    } else {
        $error = "Error: " . mysqli_error($conn);
    }
}

// Clear the success message after displaying it
if(isset($_SESSION['success'])) {
    $success = $_SESSION['success'];
    unset($_SESSION['success']);
} else {
    $success = "";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <!-- Important to make website responsive -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <!-- Link our CSS file -->
    <link rel="stylesheet" href="css/style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .navbar {
            background-color: #70a1ff;
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
            color: #fff;
            padding: 10px;
            font-weight: bold;
        }
        .navbar .menu ul li a:hover {
            background-color: #555;
            border-radius: 5px;
        }
        .contact-container {
            max-width: 400px;
            margin: 50px auto;
            padding: 20px;
            background-color:#70a1ff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .contact-container h2 {
            text-align: center;
            color: #333;
        }
        .contact-container form {
            display: flex;
            flex-direction: column;
            padding: 20px;
        }

        .contact-container form label {
            font-weight: bold;
            margin-top: 10px;
            color: #555;
        }
        .contact-container form input[type="text"],
        .contact-container form input[type="email"],
        .contact-container form textarea {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .contact-container form input[type="submit"] {
            background-color: #333;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            margin-top: 20px;
        }
        .contact-container form input[type="submit"]:hover {
            background-color: #555;
        }
        .success,
        .error {
            text-align: center;
            margin-bottom: 15px;
            font-weight: bold;
        }
        .success {
            color: green;
        }
        .error {
            color: red;
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

    <section class="contact">
        <div class="contact-container">
            <h2>Contact Us</h2>
            <?php 
            if (!empty($success)) {
                echo "<div class='success'>$success</div>";
            }
            if (!empty($error)) {
                echo "<div class='error'>$error</div>";
            }
            ?>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" required>
                
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" required>
                
                <label for="subject">Subject:</label>
                <input type="text" id="subject" name="subject" required>
                
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="4" required></textarea>
                
                <input type="submit" value="Submit">
            </form>
        </div>
    </section>
</body>
</html>

