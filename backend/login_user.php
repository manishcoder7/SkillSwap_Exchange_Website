<?php
session_start();
include("../config/db.php");

if (!isset($_POST['login'])) {
    header("Location: ../loginpage.php");
    exit();
}

$email = trim($_POST['email']);
$password = trim($_POST['password']);

/* Empty field validation */
if (empty($email) || empty($password)) {
    $_SESSION['login_error'] = "All fields are required.";
    header("Location: ../loginpage.php");
    exit();
}

/* Email format validation */
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $_SESSION['login_error'] = "Invalid email format.";
    header("Location: ../loginpage.php");
    exit();
}

/* Prepared statement for SQL injection protection */
$stmt = mysqli_prepare($conn, "SELECT * FROM users WHERE email = ?");

if (!$stmt) {
    $_SESSION['login_error'] = "Database error.";
    header("Location: ../loginpage.php");
    exit();
}

mysqli_stmt_bind_param($stmt, "s", $email);
mysqli_stmt_execute($stmt);

$result = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($result) == 1) {
    $row = mysqli_fetch_assoc($result);

    /* Secure password verification */
    if (password_verify($password, $row['password'])) {

        session_regenerate_id(true);

        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['full_name'];

        /* Profile completion check */
        if (
            empty($row['location']) ||
            empty($row['bio']) ||
            empty($row['profile_image'])
        ) {
            header("Location: ../profilepage.php");
            exit();
        } else {
            header("Location: ../dashboard.php");
            exit();
        }

    } else {
        $_SESSION['login_error'] = "Incorrect Password.";
        header("Location: ../loginpage.php");
        exit();
    }

} else {
    $_SESSION['login_error'] = "User not found.";
    header("Location: ../loginpage.php");
    exit();
}

mysqli_stmt_close($stmt);
?>
