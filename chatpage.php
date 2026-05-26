<?php
session_start();
include("config/db.php");

$receiver = $_GET['user'];
$sender = $_SESSION['user_id'];


// Receiver user name ke liye
$userQuery = "SELECT full_name FROM users WHERE id='$receiver'";
$userResult = mysqli_query($conn, $userQuery);
$userData = mysqli_fetch_assoc($userResult);
$receiver_name = $userData['full_name'];


// Top header profile dynamic karne ke liye (logged-in user)
$profileQuery = "SELECT * FROM users WHERE id='$sender'";
$profileResult = mysqli_query($conn, $profileQuery);
$user = mysqli_fetch_assoc($profileResult);


// Chat messages fetch karne ke liye
$sql = "SELECT messages.*, users.full_name 
        FROM messages
        JOIN users ON messages.sender_id = users.id
        WHERE (sender_id='$sender' AND receiver_id='$receiver')
        OR (sender_id='$receiver' AND receiver_id='$sender')
        ORDER BY id ASC";

$result = mysqli_query($conn, $sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>chat page</title>
    <link rel="stylesheet" href="chat.css">
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
        <div class="maindiv">

            <div class="chat_header">
                <i class="fa-solid fa-angle-left" id="arrow"></i>

                <div class="chats_profile">
                    <img src="profile.png" alt="">
                </div>

                <div class="profile_content">
                    <p id="title"><?php echo $receiver_name; ?></p>
                    <p><i class="fa-solid fa-circle"></i> Online</p>
                </div>

                <div class="chat_lasticon">
                    <i class="fa-solid fa-ellipsis-vertical" id="dot"></i>
                </div>
            </div>

            <div class="chat_section" id="chatbox">

                <?php while($row = mysqli_fetch_assoc($result)) { ?>

                    <?php if($row['sender_id'] == $sender) { ?>

                        <div class="user_two">
                            <div class="chat_content">
                                <p class="second_name"><?php echo $row['full_name']; ?></p>
                                <p class="second_message"><?php echo $row['message']; ?></p>
                                <p class="second_time"><?php echo $row['created_at']; ?></p>
                            </div>
                            <div class="second_profile">
                                <img src="<?php echo !empty($user['profile_image']) ? 'uploads/' . $user['profile_image'] : 'profile.png'; ?>" alt="">

                            </div>
                        </div>

                    <?php } else { ?>

                        <div class="user_one">
                            <div class="chat_profile">
                                <img src="profile.png" alt="">
                            </div>
                            <div class="chat_content">
                                <p class="name"><?php echo $row['full_name']; ?></p>
                                <p class="message"><?php echo $row['message']; ?></p>
                                <p class="time"><?php echo $row['created_at']; ?></p>
                            </div>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>

            <div class="chat_footer">
                <form action="backend/send_message.php" method="POST" style="display:flex; width:100%;" autocomplete="off">
                    <input type="hidden" name="receiver" value="<?php echo $receiver; ?>">

                    <input type="text" name="message" placeholder="Type a message..." required style="flex:1;" autocomplete="off">

                    <button type="submit" id="sendbutton">Send</button>

                    <button type="button" id="micbutton" onclick="startVoice()">
                        <i class="fa-solid fa-microphone"></i>
                    </button>
                </form>
            </div>

        </div>
    </section>

    <footer>
        <?php include "footer.php" ?>
    </footer>

    <!-- AUTO LOAD MESSAGES -->
    <script>
    function loadMessages(){
        var xhr = new XMLHttpRequest();
        xhr.open("GET", "backend/fetch_messages.php?user=<?php echo $receiver; ?>", true);

        xhr.onload = function(){
            if(this.status == 200){
                document.getElementById("chatbox").innerHTML = this.responseText;
            }
        }

        xhr.send();
    }

    setInterval(loadMessages, 3000);
    </script>

    <!-- VOICE INPUT -->
    <script>
    function startVoice(){
        var recognition = new (window.SpeechRecognition || window.webkitSpeechRecognition)();
        recognition.lang = "en-IN";
        recognition.start();

        recognition.onresult = function(event){
            document.querySelector('input[name="message"]').value = event.results[0][0].transcript;
        }
    }
    </script>

    <!-- CLEAR INPUT AFTER SEND -->
    <script>
    document.querySelector("form").addEventListener("submit", function(){
        setTimeout(() => {
            document.querySelector('input[name="message"]').value = "";
        }, 100);
    });
    </script>

</body>
</html>
