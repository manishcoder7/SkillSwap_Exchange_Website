<?php
session_start();

$stored_hash = '$2y$10$o8.AeZHue9fEEdo5rRDZ3enPj54J1qX8k/iJTv6jgOE87CaN/qZrq';

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

if ($_SESSION['attempts'] >= 5) {
    die("Too many failed attempts. Please try again later.");
}

if (isset($_POST['admin_login'])) {
    $password = $_POST['password'];

    if (password_verify($password, $stored_hash)) {
        session_regenerate_id(true);
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['attempts'] = 0;

        header("Location: adminpage.php");
        exit();
    } else {
        $_SESSION['attempts']++;
        $error = "Wrong Password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="adminlogin.css">
</head>
<body>

<div class="admin_login_container">
    <h2>Admin Login</h2>

    <?php if (isset($error)) { ?>
        <p class="error_message"><?php echo $error; ?></p>
    <?php } ?>

    <form method="POST">
        <input 
            type="password" 
            name="password" 
            placeholder="Enter Admin Password" 
            required
        >

        <button type="submit" name="admin_login">
            Login
        </button>
    </form>
</div>

</body>
</html>
