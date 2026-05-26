<?php
session_start();
include("../config/db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.html");
    exit();
}

$user_id = $_SESSION['user_id'];

if(isset($_GET['id']) && isset($_GET['status']))
{
    $id = intval($_GET['id']);
    $status = $_GET['status'];

    // ✅ Allow only valid status
    if($status != 'accepted' && $status != 'rejected')
    {
        echo "Invalid status";
        exit();
    }

    // 🔒 SECURITY CHECK (VERY IMPORTANT)
    $check = "SELECT * FROM requests 
              WHERE id='$id' AND receiver_id='$user_id'";

    $res = mysqli_query($conn, $check);

    if(mysqli_num_rows($res) == 0)
    {
        echo "Unauthorized action!";
        exit();
    }

    // ✅ Update
    $sql = "UPDATE requests SET status='$status' WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        header("Location: ../Myrequests.php?updated=1");
    }
    else
    {
        echo "Update failed";
    }
}
else
{
    echo "Invalid request";
}
?>
