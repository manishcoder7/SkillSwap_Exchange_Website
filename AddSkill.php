<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id'])){
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION['user_id'];


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
    <title>Add Skill Page</title>

    <link rel="stylesheet" href="addskill.css">
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


    <div class="right_side">

        <div class="form_container">

            <h2>
                <i class="fa-solid fa-angle-left"></i>
                Add New Skill
            </h2>

            <form action="backend/add_skill.php" method="POST">

                <h3>Add New Skill</h3>
                <br>

                <div class="form_group">
                    <label>Skill Name</label>

                    <div class="input_box">
                        <i class="fa-solid fa-square-pen"></i>
                        <input 
                            type="text" 
                            placeholder="Enter skill name" 
                            name="skill_name" 
                            required
                        >
                    </div>
                </div>


                <div class="form_group">
                    <label>Category</label>

                    <div class="input_box">
                        <i class="fa-solid fa-layer-group"></i>

                        <select name="category" required>
                            <option value="">Select category</option>
                            <option value="Programming">Programming</option>
                            <option value="Design">Design</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Others">Others</option>
                        </select>
                    </div>
                </div>


                <div class="form_group">
                    <label>Skill Level</label>

                    <div class="input_box">
                        <i class="fa-solid fa-square-poll-vertical"></i>

                        <select name="level" required>
                            <option value="">Select Skill Level</option>
                            <option value="Beginner">Beginner</option>
                            <option value="Intermediate">Intermediate</option>
                            <option value="Expert">Expert</option>
                        </select>
                    </div>
                </div>


                <div class="form_group">
                    <label>Description</label>

                    <textarea 
                        name="description" 
                        rows="4" 
                        placeholder="Describe your skill"
                        required
                    ></textarea>
                </div>


                <div class="form_group">
                    <label>Availability (Optional)</label>

                    <div class="input_box">
                        <i class="fa-solid fa-warehouse"></i>

                        <select name="Availability">
                            <option value="">Select Availability</option>
                            <option value="Weekdays">Weekdays</option>
                            <option value="Weekends">Weekends</option>
                            <option value="Anytime">Anytime</option>
                        </select>
                    </div>
                </div>


                <input 
                    id="btn" 
                    type="submit" 
                    name="addskill" 
                    value="Add Skill"
                >

            </form>

        </div>

    </div>

</section>


<footer>
    <?php include "footer.php"; ?>
</footer>

</body>
</html>
