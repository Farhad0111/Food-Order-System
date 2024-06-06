<?php include('../config/constants.php'); ?>


<html>
<head>
    <title>Login - Food Order System</title>
    <link rel="stylesheet" href="../css/admin.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f7f9fc;
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        .login {
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            width: 300px;
            margin: 100px auto;
            padding: 30px;
        }
        .login h1 {
            text-align: center;
            color: #333;
        }
        .login form {
            margin-top: 20px;
        }
        .login input[type="text"],
        .login input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login input[type="submit"] {
            width: 100%;
            padding: 10px;
            margin-top: 20px;
            border: none;
            border-radius: 5px;
            background-color: #333;
            color: #fff;
            cursor: pointer;
        }
        .login input[type="submit"]:hover {
            background-color: #555;
        }
        .error {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
        .success {
            color: green;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>

<body>
    <div class="login">
        <h1>Login</h1>
        <?php
            if(isset($_SESSION['login'])) {
                echo $_SESSION['login'];
                unset($_SESSION['login']);
            }
            if(isset($_SESSION['no-login-message'])) {
                echo $_SESSION['no-login-message'];
                unset($_SESSION['no-login-message']);
            }
        ?>
        <form action="" method="POST">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" placeholder="Enter Username">

            <label for="password">Password:</label>
            <input type="password" id="password" name="password" placeholder="Enter Password">

            <input type="submit" name="submit" value="Login">
        </form>
    </div>
</body>
</html>

<?php
    
    if(isset($_POST['submit'])) {
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $password = mysqli_real_escape_string($conn, md5($_POST['password']));

        $sql = "SELECT * FROM tbl_admin WHERE username = '$username' AND password = '$password'";
        $res = mysqli_query($conn, $sql);

        $count = mysqli_num_rows($res);
        if($count == 1) {
            $_SESSION['login'] = "<div class='success'>Login Successful.</div>";
            $_SESSION['user'] = $username;
            header('location:'.SITEURL.'admin/');
        }
        else {
            $_SESSION['login'] = "<div class='error'>Incorrect Username or Password.</div>";
            header('location:'.SITEURL.'admin/login.php');
        }
    }
?>
