<?php
session_start();

if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}

if (isset($_SESSION['login_success'])) {
    $login_success = $_SESSION['login_success'];
    unset($_SESSION['login_success']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login page</title>

    <link rel="stylesheet" href="Navbar.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="login.css">

    <script src="https://kit.fontawesome.com/05476c3bb4.js" crossorigin="anonymous"></script>
</head>
<body>

<header>
    <?php include "onlynavbar.php"; ?>
</header>

<section>
    <div class="form_container">

        <h1>
            Welcome Back
            <i class="fa-solid fa-handshake"></i>
        </h1>

        <?php if (isset($login_error)) { ?>
            <p style="color:red; font-weight:bold; margin-bottom:15px;">
                <?php echo $login_error; ?>
            </p>
        <?php } ?>

        <?php if (isset($login_success)) { ?>
            <p style="color:green; font-weight:bold; margin-bottom:15px;">
                <?php echo $login_success; ?>
            </p>
        <?php } ?>

        <form action="backend/login_user.php" method="POST">

            <div class="form_group">
                <input 
                    type="email" 
                    name="email" 
                    required
                >
                <i class="fa-solid fa-envelope"></i>
                <label>Email Address</label>
            </div>

            <div class="form_group">
                <input 
                    type="password" 
                    name="password" 
                    required
                >
                <i class="fa-solid fa-lock"></i>
                <label>Password</label>
            </div>

            <input 
                id="btn" 
                type="submit" 
                name="login" 
                value="Login"
            >

            <p>
                Don't have an account?
                <a href="registerform.php">Register</a>
            </p>

        </form>
    </div>
</section>

<footer>
    <?php include "footer.php"; ?>
</footer>

</body>
</html>
