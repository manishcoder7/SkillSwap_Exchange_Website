<?php
session_start();
include("config/db.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Profile</title>
    <link rel="stylesheet" href="edit_profile.css">
</head>

<body>

<div class="container">

    <h2>Profile Page Edit</h2>

    <form action="update_profile.php" method="POST" enctype="multipart/form-data">

        <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">

        <label>Full Name</label>
        <input type="text" name="full_name" value="<?php echo $user['full_name']; ?>">

        <label>Email</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>">

        <label>Location</label>
        <input type="text" name="location" value="<?php echo $user['location']; ?>">

        <label>Bio</label>
        <textarea name="bio"><?php echo $user['bio']; ?></textarea>

        <label>Profile Image</label>
        <input type="file" name="profile_image">

        <button type="submit">Update Profile</button>

    </form>

</div>

</body>
</html>
