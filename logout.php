<?php
session_start();
session_destroy();
header("location: customer-login.php");
exit;
