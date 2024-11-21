<?php
session_start();

$con = mysqli_connect('localhost', 'root', '', 'login');
if (mysqli_connect_errno()) {
    die("Database connection failed: " . mysqli_connect_error());
}

$name = $_POST['un'];
$pass = $_POST['pwd'];

$s = "SELECT * FROM usertable WHERE name = '$name' AND pass = '$pass'";
$result = mysqli_query($con, $s);
if (!$result) {
    die("Query execution failed: " . mysqli_error($con));
}

$num = mysqli_num_rows($result);
if ($num == 1) {
    header('location: org.html');
} else {
    $error_message = "Invalid username or password";
    header('Location: login.html?error_message=' . urlencode($error_message));
    exit();
}

mysqli_close($con);
?>
