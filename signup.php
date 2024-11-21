<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $con = mysqli_connect('localhost', 'root', '', 'login');
    
    if (!$con) {
        die('Database connection error: ' . mysqli_connect_error());
    }

    $name = mysqli_real_escape_string($con, $_POST['Username']);
    $pass = mysqli_real_escape_string($con, $_POST['password']);

    $query = "SELECT * FROM usertable WHERE name ='$name';
    $result = mysqli_query($con, $query);

    if (!$result) {
        die('Query error: ' . mysqli_error($con));
    }

    if (mysqli_num_rows($result) > 0) {
        $error_message = "Username Already Taken!";
        header('Location: signup.html?error_message=' . urlencode($error_message));
        exit();
    } else {
        $insertQuery = "INSERT INTO usertable (name, pass) VALUES ('$name', '$pass')";
        if (mysqli_query($con, $insertQuery)) {
            $error_message = "Registration Successful!";
            header('Location: signup.html?error_message=' . urlencode($error_message));
            exit();
        } else {
            die('Insert error: ' . mysqli_error($con));
        }
    }

    mysqli_close($con);
}
?>
