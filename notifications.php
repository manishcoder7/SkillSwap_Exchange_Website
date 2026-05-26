<?php
session_start();
include("config/db.php");

$user_id = $_SESSION['user_id'];

// mark all as seen
mysqli_query($conn, "UPDATE requests SET seen=1 WHERE receiver_id='$user_id'");

// ab yaha tum notifications show kar sakte ho
?>
