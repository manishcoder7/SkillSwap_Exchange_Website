<?php
session_start();
include("config/db.php");

$user_id = $_SESSION['user_id'];

// user data fetch
$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
// ===============================
// Dynamic Skills Offer
// ===============================
$skill_sql = "SELECT skill_name FROM skills WHERE user_id='$user_id'";
$skill_result = mysqli_query($conn, $skill_sql);

// ===============================
// Dynamic Stats
// ===============================

// Skills Added Count
$skills_count_sql = "SELECT COUNT(*) as total FROM skills WHERE user_id='$user_id'";
$skills_count_result = mysqli_query($conn, $skills_count_sql);
$skills_count_data = mysqli_fetch_assoc($skills_count_result);
$total_skills = $skills_count_data['total'];

// Requests Sent Count
$sent_sql = "SELECT COUNT(*) as total FROM requests WHERE sender_id='$user_id'";
$sent_result = mysqli_query($conn, $sent_sql);
$sent_data = mysqli_fetch_assoc($sent_result);
$total_sent = $sent_data['total'];

// Requests Received Count
$received_sql = "SELECT COUNT(*) as total FROM requests WHERE receiver_id='$user_id'";
$received_result = mysqli_query($conn, $received_sql);
$received_data = mysqli_fetch_assoc($received_result);
$total_received = $received_data['total'];

// Requests Accepted Count
$accepted_sql = "SELECT COUNT(*) as total 
FROM requests 
WHERE (sender_id='$user_id' OR receiver_id='$user_id')
AND status='accepted'";

$accepted_result = mysqli_query($conn, $accepted_sql);
$accepted_data = mysqli_fetch_assoc($accepted_result);
$total_accepted = $accepted_data['total'];



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="profile.css">
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
                <a href=""><i class="fa-solid fa-envelope"></i></a><br>
                <a href=""><i class="fa-solid fa-bell"></i></a>
            </div>
            <div class="profile">
                <a href="">
                    <img src="<?php echo !empty($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'profile.png'; ?>" alt="">
                </a>
                <span><?php echo $user['full_name']; ?></span>
                <span class="arrow"><i class="fa-solid fa-sort-down"></i></span>
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
                <a href="index.html"><i class="fa-solid fa-power-off"></i> Logout</a>
            </div>
        </div>

        <div class="right_side">
            <div class="profile_container">
                <h1>My Profile</h1>
                <?php if(empty($user['location']) || empty($user['bio']) || empty($user['profile_image'])) { ?>
    
                    <div style="background:#ffe0e0; color:red; padding:10px; border-radius:6px; margin-bottom:15px; font-weight:bold;">
                        ⚠ Please complete your profile to continue
                    </div>

                <?php } ?>


                <div class="myprofile_card">
                    <div class="profile_image">
                        <img src="<?php echo !empty($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'profile.png'; ?>" alt="">

                        <a href="edit_profile.php">
                            <button>
                                <i class="fa-solid fa-pen"></i>
                                Edit Profile
                            </button>
                        </a>
                    </div>

                    <div class="profile_detail">
                        <h3><?php echo $user['full_name']; ?></h3><br>

                        <p>
                            <i class="fa-solid fa-envelope"></i>
                            <?php echo $user['email']; ?>
                        </p>

                        <p>
                            <i class="fa-solid fa-location-dot"></i>
                            <?php echo $user['location']; ?>
                        </p><br>

                        <p>
                            <?php echo $user['bio']; ?>
                        </p>
                    </div>
                </div>

                <div class="down_profile">

                    <div class="skill_offers">
                        <h3>Skills & Offer</h3><br>
                        <?php
                        if(mysqli_num_rows($skill_result) > 0)
                        {
                            while($skill = mysqli_fetch_assoc($skill_result))
                            {
                        ?>
                                <p>
                                    <i class="fa-brands fa-codepen"></i>
                                    <?php echo $skill['skill_name']; ?>
                                </p>
                        <?php
                            }
                        }
                        else
                        {
                            echo "<p>No skills added yet</p>";
                        }
                        ?>

                    </div>

                    <div class="offer_stats">
                        <h3>Stats</h3><br>

                        <div class="first_offerrow">
                            <div class="added">
                                <p><i class="fa-solid fa-briefcase"></i> Skills Added</p>
                                <p><?php echo $total_skills; ?></p>

                            </div>

                            <div class="sent">
                                <p><i class="fa-solid fa-paper-plane"></i> Requests Sent</p>
                                <p><?php echo $total_sent; ?></p>
                            </div>
                        </div>

                        <div class="second_offerrow">
                            <div class="received">
                                <p><i class="fa-solid fa-store"></i> Requests Received</p>
                                <p><?php echo $total_received; ?></p>
                            </div>

                            <div class="accepted">
                                <p><i class="fa-solid fa-square-check"></i> Requests Accepted</p>
                                <p><?php echo $total_accepted; ?></p>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </section>

    <footer>
        <?php include "footer.php" ?>
    </footer>

</body>
</html>
