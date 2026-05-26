<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Page</title>
    <link rel="stylesheet" href="register.css">
    <link rel="stylesheet" href="footer.css">
    <link rel="stylesheet" href="Navbar.css">

    <script src="https://kit.fontawesome.com/05476c3bb4.js" crossorigin="anonymous"></script>
</head>
<body>
    <header>
        <?php include "onlynavbar.php"; ?>
    </header>
    <section>
        <div class="form_container">
            <h1>Create Account</h1>
            <form action="backend/register_user.php" method="POST">
                <div class="form_group">
                    <i class="fa-solid fa-user"></i>
                    <input type="text" name="fullname" required>
                    <label for="">Full Name</label>
                    

                </div>
                <div class="form_group">
                    <i class="fa-solid fa-envelope"></i>
                    <input type="email" name="email" required>
                    <label for="">Email Address</label>
                    

                </div>
                <div class="form_group">
                    <i class="fa-solid fa-lock"></i>
                    <input type="password" name="password" required>
                    <label for="">Password</label>
                    

                </div>
                <div class="form_group">
                    <i class="fa-solid fa-user-lock"></i>
                    <input type="password" name="confirm_password" required>
                    <label for="">Confirm Password</label>
                    

                </div>
                <div class="form_group">
                    <i class="fa-solid fa-bars"></i>
                    <textarea name="bio" required></textarea>
                    <label for="">Short Bio</label>
                    

                </div>
                <input id="btn" type="submit" name="register" value="Register"><br>
                <p>Already have an account? <a href="loginpage.php">Login</a></p>
            </form>
        </div>
    </section>
    <footer>
          <?php include "footer.php"; ?>
    </footer>
</body>
</html>