<?php
session_start();
include("../config/db.php");

// ✅ Check login
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$sender = $_SESSION['user_id'];
$receiver = intval($_GET['receiver']);
$skill_id = intval($_GET['skill']);

// ❌ Prevent self request
if ($sender == $receiver) {
    header("Location: ../Browsepage.php?self=1");
    exit();
}

// ❌ Check duplicate request
$check = "SELECT * FROM requests 
          WHERE sender_id='$sender' 
          AND receiver_id='$receiver' 
          AND skill_id='$skill_id'";

$res = mysqli_query($conn, $check);

if (mysqli_num_rows($res) > 0) {
    header("Location: ../Browsepage.php?already=1");
    exit();
}

// ✅ Insert with status + date
$sql = "INSERT INTO requests (sender_id, receiver_id, skill_id, status, created_at)
        VALUES ('$sender', '$receiver', '$skill_id', 'pending', NOW())";

if (mysqli_query($conn, $sql)) {
    header("Location: ../Browsepage.php?sent=1");
    exit();
} else {
    echo "Request failed: " . mysqli_error($conn);
}
?>
