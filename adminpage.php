<?php
session_start();
include("config/db.php");

if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: adminlogin.php");
    exit();
}

/* Total Counts */
$user_query = mysqli_query($conn, "SELECT COUNT(*) as total_users FROM users");
$user_data = mysqli_fetch_assoc($user_query);
$total_users = $user_data['total_users'];

$skill_query = mysqli_query($conn, "SELECT COUNT(*) as total_skills FROM skills");
$skill_data = mysqli_fetch_assoc($skill_query);
$total_skills = $skill_data['total_skills'];

$request_query = mysqli_query($conn, "SELECT COUNT(*) as total_requests FROM requests");
$request_data = mysqli_fetch_assoc($request_query);
$total_requests = $request_data['total_requests'];

$message_query = mysqli_query($conn, "SELECT COUNT(*) as total_messages FROM messages");
$message_data = mysqli_fetch_assoc($message_query);
$total_messages = $message_data['total_messages'];

/* Recent Users */
$recent_users = mysqli_query($conn, "SELECT id, full_name, created_at FROM users ORDER BY id DESC LIMIT 5");

/* Recent Requests */
$recent_requests = mysqli_query($conn, "
    SELECT 
        requests.id,
        requests.status,
        sender.full_name AS sender_name,
        receiver.full_name AS receiver_name
    FROM requests
    JOIN users AS sender ON requests.sender_id = sender.id
    JOIN users AS receiver ON requests.receiver_id = receiver.id
    ORDER BY requests.id DESC
    LIMIT 5
");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkillSwap Admin Panel</title>
    <link rel="stylesheet" href="admin.css">
    <script src="https://kit.fontawesome.com/05476c3bb4.js" crossorigin="anonymous"></script>
</head>
<body>

<!-- Sidebar -->
<div class="sidebar">
    <div class="logo">
        <img src="skillswap.png" alt="">
        <h2>SkillSwap</h2>
        <p>Admin Panel</p>
    </div>

    <div class="menu">
        <a href="#" class="active"><i class="fa-solid fa-house"></i> Dashboard</a>
        
    </div>

    <div class="logout">
        <a href="logout.php">
            <i class="fa-solid fa-power-off"></i> Logout
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main">

    <!-- Topbar -->
    <div class="topbar">
        <h1>Admin Dashboard</h1>

        <div class="admin_profile">
            <img src="profile.png" alt="">
            <div>
                <h3>Admin</h3>
                <p>Super Administrator</p>
            </div>
        </div>
    </div>

    <!-- Cards -->
    <div class="cards">

        <div class="card">
            <i class="fa-solid fa-users"></i>
            <h2><?php echo $total_users; ?></h2>
            <p>Total Users</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-book"></i>
            <h2><?php echo $total_skills; ?></h2>
            <p>Total Skills</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-envelope"></i>
            <h2><?php echo $total_requests; ?></h2>
            <p>Total Requests</p>
        </div>

        <div class="card">
            <i class="fa-solid fa-comments"></i>
            <h2><?php echo $total_messages; ?></h2>
            <p>Total Messages</p>
        </div>

    </div>

    <!-- Tables -->
    <div class="tables">

        <!-- Recent Users -->
        <div class="table_box">
            <h2>Recent Users</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Joined</th>
                </tr>

                <?php while($user = mysqli_fetch_assoc($recent_users)) { ?>
                    <tr>
                        <td><?php echo $user['id']; ?></td>
                        <td><?php echo $user['full_name']; ?></td>
                        <td><?php echo date("d M Y", strtotime($user['created_at'])); ?></td>
                    </tr>
                <?php } ?>

            </table>
        </div>

        <!-- Recent Requests -->
        <div class="table_box">
            <h2>Recent Requests</h2>

            <table>
                <tr>
                    <th>ID</th>
                    <th>From → To</th>
                    <th>Status</th>
                </tr>

                <?php while($request = mysqli_fetch_assoc($recent_requests)) { ?>
                    <tr>
                        <td><?php echo $request['id']; ?></td>
                        <td>
                            <?php echo $request['sender_name']; ?>
                            →
                            <?php echo $request['receiver_name']; ?>
                        </td>
                        <td><?php echo ucfirst($request['status']); ?></td>
                    </tr>
                <?php } ?>

            </table>
        </div>

    </div>

</div>

</body>
</html>
