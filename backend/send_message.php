<?php
session_start();
include("../config/db.php");

// ✅ Login check
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$sender = $_SESSION['user_id'];
$receiver = intval($_POST['receiver']);
$message = trim($_POST['message']);

// ❌ Empty message block
if (empty($message)) {
    header("Location: ../chatpage.php?user=$receiver");
    exit();
}

// ✅ SQL injection safe
$message = mysqli_real_escape_string($conn, $message);

// ✅ Insert message
$sql = "INSERT INTO messages (sender_id, receiver_id, message)
        VALUES ('$sender', '$receiver', '$message')";

if (mysqli_query($conn, $sql)) {
    // ✅ Redirect back to chat
    header("Location: ../chatpage.php?user=$receiver");
} else {
    echo "Message failed";
}
?>
