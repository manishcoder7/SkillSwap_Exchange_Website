<?php
session_start();
include("config/db.php");

$user_id = $_SESSION['user_id'];

$sql = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);


$sql = "SELECT requests.id,
        users.full_name,
        skills.skill_name,
        requests.status
        FROM requests
        JOIN users ON requests.sender_id = users.id
        JOIN skills ON requests.skill_id = skills.id
        WHERE requests.receiver_id = '$user_id'";

$result = mysqli_query($conn,$sql);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Request Page</title>
    <link rel="stylesheet" href="requests.css">
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
                <input type="text" id="globalSearch" placeholder="Search here...">
                <button onclick="searchContent()" id="searchBtn">
                    <i class="fa-solid fa-magnifying-glass"></i>
                </button>
            </div>

            <div class="profile_icons">
                <a href=""><i class="fa-solid fa-envelope"></i></a><br>
                <a href=""><i class="fa-solid fa-bell"></i></a>
            </div>
            <div class="profile">
                <a href="">
                    <img src="<?php echo $user['profile_image'] ? $user['profile_image'] : 'profile.png'; ?>" alt="">
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
                <a href="profilepage.php"><i class="fa-solid fa-user"></i> Profile</a>
                <a href="index.html"><i class="fa-solid fa-power-off"></i> Logout</a>
            </div>
            <div class="left_logout">
            <a href="index.html"><i class="fa-solid fa-power-off"></i> Logout</a>
            </div>
    </div>
    <div class="right_div">
        <div class="user_container">
            <h1>Skill Requests</h1>
            <div class="top_right">
                <div class="user_search">
                    <input type="text" placeholder="Search skills.....">
                    <i class="fa-brands fa-sistrix"></i>
                </div>
            </div>
            <div class="user_layout">

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<div class="user_cards">

    <div class="profile_part">
        <img src="profile.png" alt="">
        <div class="profile_text">
            <h2><?php echo $row['full_name']; ?></h2>
            <p><i class="fa-solid fa-code"></i> <?php echo $row['skill_name']; ?></p>
        </div>
    </div>    

    <p> I Wants to learn your skill</p>

    <div class="request_btn">
        <p>Status: <?php echo $row['status']; ?></p>

        <div class="button">

            <?php if($row['status'] == 'pending') { ?>

                <a href="backend/update_request.php?id=<?php echo $row['id']; ?>&status=accepted">
                    <button class="sendrequest">Accept</button>
                </a>

                <a href="backend/update_request.php?id=<?php echo $row['id']; ?>&status=rejected">
                    <button class="reject">Reject</button>
                </a>

            <?php } else { ?>

                <button disabled><?php echo $row['status']; ?></button>

            <?php } ?>

        </div>
    </div>

</div>

<?php } ?>

</div>

        </div>
    </div>

    </section>
    <footer>
        <?php include "footer.php" ?>
    </footer>
    
<script>
function removeHighlights() {
    document.querySelectorAll(".search-highlight").forEach(el => {
        const parent = el.parentNode;
        parent.replaceChild(
            document.createTextNode(el.textContent),
            el
        );
        parent.normalize();
    });
}

function searchContent() {
    let keyword = document.getElementById("globalSearch").value.trim();

    removeHighlights();

    if (keyword === "") {
        alert("Please enter something to search");
        return;
    }

    let found = false;

    const contentArea = document.querySelector(".right_div");

    const walker = document.createTreeWalker(
        contentArea,
        NodeFilter.SHOW_TEXT,
        null,
        false
    );

    let nodes = [];

    while (walker.nextNode()) {
        nodes.push(walker.currentNode);
    }

    nodes.forEach(node => {
        if (
            node.nodeValue.toLowerCase().includes(keyword.toLowerCase())
        ) {
            const span = document.createElement("span");
            span.className = "search-highlight";

            const regex = new RegExp(`(${keyword})`, "gi");

            const tempDiv = document.createElement("div");
            tempDiv.innerHTML = node.nodeValue.replace(
                regex,
                `<span class="search-highlight">$1</span>`
            );

            const fragment = document.createDocumentFragment();

            while (tempDiv.firstChild) {
                fragment.appendChild(tempDiv.firstChild);
            }

            node.parentNode.replaceChild(fragment, node);
            found = true;
        }
    });

    if (!found) {
        alert("No result found");
    }
}
</script>


</body>
</html>