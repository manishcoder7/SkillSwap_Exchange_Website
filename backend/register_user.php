<?php
include("../config/db.php");

if(isset($_POST['register']))
{
    $name = $_POST['fullname'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $bio = $_POST['bio'];

    // Check password match
    if($password !== $confirm_password)
    {
        echo "Passwords do not match";
        exit();
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Check if email exists
    $check = "SELECT * FROM users WHERE email='$email'";
    $result = mysqli_query($conn, $check);

    if(mysqli_num_rows($result) > 0)
    {
        echo "Email already registered";
        exit();
    }

    // Insert user
    $sql = "INSERT INTO users(full_name,email,password,bio)
            VALUES('$name','$email','$hashed_password','$bio')";

    if(mysqli_query($conn,$sql))
    {
        header("Location: ../loginpage.php");
        exit();
    }
    else
    {
        echo "Registration Failed";
    }
}
?>
