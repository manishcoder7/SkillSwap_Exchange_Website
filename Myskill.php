<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION['user_id'];


// ✅ Skills fetch
$skill_sql = "SELECT * FROM skills WHERE user_id='$user_id'";
$skill_result = mysqli_query($conn, $skill_sql);


// ✅ User profile fetch
$user_sql = "SELECT * FROM users WHERE id='$user_id'";
$user_result = mysqli_query($conn, $user_sql);
$user = mysqli_fetch_assoc($user_result);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Skills</title>

    <link rel="stylesheet" href="myskill.css">
    <link rel="stylesheet" href="footer.css">

    <script src="https://kit.fontawesome.com/05476c3bb4.js" crossorigin="anonymous"></script>
</head>
<body>

<header class="top_navbar">
    <div class="logo">
        <img src="skillswap.png" alt="img">
        <h1>SkillSwap</h1>
    </div>

    <div class="right_nav">

        <div class="search_bar">
            <input type="text" placeholder="search....">
            <i class="fa-brands fa-sistrix"></i>
        </div>

        <div class="profile_icons">
            <a href="">
                <i class="fa-solid fa-envelope"></i>
            </a>

            <a href="">
                <i class="fa-solid fa-bell"></i>
            </a>
        </div>

        <div class="profile">
            <a href="">
                <img src="<?php echo !empty($user['profile_image']) ? $user['profile_image'] : 'profile.png'; ?>" alt="">
            </a>

            <span><?php echo $user['full_name']; ?></span>

            <span class="arrow">
                <i class="fa-solid fa-sort-down"></i>
            </span>
        </div>

    </div>
</header>


<section>

    <div class="left_side">

        <div class="leftside_logo">
            <img src="skillswap.png" alt="">
            <h2>SkillSwap</h2>
        </div>

        <div class="left_icons">
            <a href="dashboard.php"><i class="fa-solid fa-house"></i> Dashboard</a>
            <a href="Browsepage.php"><i class="fa-brands fa-sistrix"></i> Browse Users</a>
            <a href="AddSkill.php"><i class="fa-solid fa-plus"></i> Add Skill</a>
            <a href="Myskill.php"><i class="fa-solid fa-address-book"></i> My Skills</a>
            <a href="Myrequests.php"><i class="fa-solid fa-envelope"></i> Requests</a>
            <a href="Profilepage.php"><i class="fa-solid fa-user"></i> Profile</a>
            <a href="index.html"><i class="fa-solid fa-power-off"></i> Logout</a>
        </div>

        <div class="left_logout">
            <a href="index.html">
                <i class="fa-solid fa-power-off"></i> Logout
            </a>
        </div>

    </div>


    <div class="right_div">

        <div class="skillcards_container">

            <?php while($row = mysqli_fetch_assoc($skill_result)) { ?>

                <div class="skill_cards">

                    <h3><?php echo $row['skill_name']; ?></h3>

                    <p class="cards_p">
                        <i class="fa-solid fa-code"></i>
                        <?php echo $row['category']; ?>
                    </p>

                    <br>

                    <p>
                        <?php echo $row['description']; ?>
                    </p>

                    <br>

                    <p class="calender_p">
                        <i class="fa-solid fa-calendar-days"></i>
                        Level: <?php echo $row['level']; ?>
                    </p>

                    <br>

                    <div class="skill_btn">

                        <a href="backend/edit_skill.php?id=<?php echo $row['id']; ?>">
                            <button class="edit_btn">
                                <i class="fa-solid fa-pen"></i> Edit
                            </button>
                        </a>

                        <a href="backend/delete_skill.php?id=<?php echo $row['id']; ?>">
                            <button class="delete_btn">
                                <i class="fa-solid fa-square"></i> Delete
                            </button>
                        </a>

                    </div>

                </div>

            <?php } ?>

        </div>

    </div>

</section>


<footer>
    <?php include "footer.php"; ?>
</footer>

</body>
</html>
