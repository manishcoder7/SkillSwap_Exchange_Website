<?php
session_start();
include("../config/db.php");

$sender = $_SESSION['user_id'];
$receiver = $_GET['user'];

$sql = "SELECT * FROM messages
        WHERE (sender_id='$sender' AND receiver_id='$receiver')
        OR (sender_id='$receiver' AND receiver_id='$sender')
        ORDER BY id ASC";

$result = mysqli_query($conn,$sql);

while($row = mysqli_fetch_assoc($result)){

    if($row['sender_id'] == $sender){
        echo '
        <div class="user_two">
            <div class="chat_content">
                <p class="second_name">You</p>
                <p class="second_message">'.$row['message'].'</p>
                <p class="second_time">'.$row['created_at'].'</p>
            </div>
            <div class="second_profile">
                <img src="profile.png">
            </div>
        </div>';
    } else {
        echo '
        <div class="user_one">
            <div class="chat_profile">
                <img src="profile.png">
            </div>
            <div class="chat_content">
                <p class="name">User</p>
                <p class="message">'.$row['message'].'</p>
                <p class="time">'.$row['created_at'].'</p>
            </div>
        </div>';
    }
}
?>
