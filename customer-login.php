<?php
session_start(); // Start the session
include('config/constants.php'); // Include the file that establishes database connection

$error = ""; // Initialize error variable

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (empty($_POST["username"]) || empty($_POST["password"])) {
        $_SESSION['error'] = "Please fill up the form completely.";
        header("location: customer-login.php");
        exit();
    }
    
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $password = $_POST["password"];

    $sql = "SELECT * FROM tbl_users WHERE username='$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);
        if (password_verify($password, $row['password'])) {
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $username;
            header("location: index.php");
            exit();
        } else {
            $_SESSION['error'] = "Incorrect username or password";
            header("location: customer-login.php"); // Redirect back to login page
            exit();
        }
    } else {
        $_SESSION['error'] = "Incorrect username or password";
        header("location: customer-login.php"); // Redirect back to login page
        exit();
    }
}

// Clear error message after displaying it
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']);
} else {
    $error = ""; // Initialize error variable
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        /* Add your custom styles here */
        body {
            font-family: Arial, sans-serif;
            background-color: #70a1ff;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
        }
        nav ul {
            list-style: none;
            margin: 0;
            padding: 0;
        }
        nav ul li {
            display: inline;
            margin-right: 20px;
        }
        nav ul li a {
            text-decoration: none;
            color: #fff;
        }
        .container {
            max-width: 300px;
            margin: 50px auto 0;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1, h2 {
            text-align: center;
        }
        h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 10px;
        }
        h2 {
            font-size: 20px;
            color: #70a1ff;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"],
        input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        input[type="submit"] {
            background-color: #70a1ff;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #3742fa;
        }
        .signup-link {
            text-align: center;
            margin-top: 20px;
        }
        .signup-link a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
        }
        .error {
            color: red;
            margin-bottom: 10px;
        }
        .fill-form-msg {
            color: red;
            margin-top: 5px;
        }
    </style>
</head>
<body>

    <!-- Navbar Section -->
    <nav>
        <ul>
            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
                <li><a href="<?php echo SITEURL; ?>">Home</a></li>
            <?php } ?>
            <li><a href="<?php echo SITEURL; ?>signup.php">Sign Up</a></li>
            <?php if(isset($_SESSION['loggedin']) && $_SESSION['loggedin']) { ?>
                <li><a href="logout.php">Logout</a></li>
            <?php } ?>
        </ul>
    </nav>

    <div class="container">
        <h1>Welcome to our website</h1>
        <h2>Login - Food Ordering System</h2>
        <?php if (!empty($error)) echo "<div class='error'>$error</div>"; ?>
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" name="username" id="username" required>
            </div>
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required>
            </div>
            <input type="submit" value="Login">
        </form>
        <div class="signup-link">
            <p>Don't have an account? <a href="signup.php">Sign Up</a></p>
        </div>
    </div>

</body>
</html>




