<?php
session_start();
include("config/db.php");

if(!isset($_SESSION['user_id']))
{
    header("Location: loginpage.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$check = "SELECT * FROM users WHERE id='$user_id'";
$result = mysqli_query($conn, $check);
$data = mysqli_fetch_assoc($result);
// ✅ Skills count
$skill_query = "SELECT COUNT(*) as total FROM skills WHERE user_id='$user_id'";
$skill_result = mysqli_query($conn, $skill_query);
$skill_data = mysqli_fetch_assoc($skill_result);
$total_skills = $skill_data['total'];

// ✅ Requests count (sent)
$request_query = "SELECT COUNT(*) as total FROM requests WHERE sender_id='$user_id'";
$request_result = mysqli_query($conn, $request_query);
$request_data = mysqli_fetch_assoc($request_result);
$total_requests = $request_data['total'];

// ✅ Exchanges (accepted requests)
$exchange_query = "SELECT COUNT(*) as total FROM requests 
                   WHERE (sender_id='$user_id' OR receiver_id='$user_id') 
                   AND status='accepted'";
$exchange_result = mysqli_query($conn, $exchange_query);
$exchange_data = mysqli_fetch_assoc($exchange_result);
$total_exchanges = $exchange_data['total'];


if(empty($data['location']) || empty($data['bio']) || empty($data['profile_image']))
{
    header("Location: profilepage.php");
    exit();
}
// ✅ Activity Query (IMPORTANT)
$activity_query = "SELECT requests.*, 
sender.full_name AS sender_name,
receiver.full_name AS receiver_name
FROM requests
JOIN users sender ON requests.sender_id = sender.id
JOIN users receiver ON requests.receiver_id = receiver.id
WHERE requests.sender_id='$user_id' 
   OR requests.receiver_id='$user_id'
ORDER BY requests.id DESC LIMIT 5";


$activity_result = mysqli_query($conn, $activity_query);

// ❗ Debug (temporary)
if(!$activity_result){
    die("Query Error: " . mysqli_error($conn));
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Page</title>
    <link rel="stylesheet" href="dash.css">
    <link rel="stylesheet" href="footer.css">
    <script src="https://kit.fontawesome.com/05476c3bb4.js"></script>
</head>
<body>

<header class="top_navbar">
    <div class="logo">
        <img src="skillswap.png">
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
            <a href=""><i class="fa-solid fa-envelope"></i></a>
            <a href=""><i class="fa-solid fa-bell"></i></a>
        </div>

        <div class="profile">
            <!-- ✅ Dynamic image -->
            <a href="">
                <img src="<?php echo !empty($data['profile_image']) ? $data['profile_image'] : 'profile.png'; ?>">

            </a>


            <!-- ✅ Dynamic name -->
            <span><?php echo $data['full_name']; ?></span>
            <span class="arrow"><i class="fa-solid fa-sort-down"></i></span>
        </div>
    </div>
</header>

<section>
<div class="left_side">
    <div class="leftside_logo">
        <img src="skillswap.png">
        <h2>SkillSwap</h2>
    </div>

    <div class="left_icons">
        <a href=""><i class="fa-solid fa-house"></i> Dashboard</a>
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

    <!-- ✅ Dynamic welcome -->
    <h1>
        Welcome back, <?php echo $data['full_name']; ?>
        <i class="fa-solid fa-pen-to-square"></i>
    </h1>

    <div class="right_cards">
    <div class="cards">
        <i class="fa-solid fa-book-open" id="first"></i>
        <div class="cards_text">
            <h2><?php echo $total_skills; ?></h2>
            <h3>Skills</h3>
        </div>
    </div>

    <div class="cards">
        <i class="fa-solid fa-envelope-circle-check" id="second"></i>
        <div class="cards_text">
            <h2><?php echo $total_requests; ?></h2>
            <h3>Requests</h3>
        </div>
    </div>

    <div class="cards">
        <i class="fa-solid fa-meteor" id="third"></i>
        <div class="cards_text">
            <h2><?php echo $total_exchanges; ?></h2>
            <h3>Exchanges</h3>
        </div>
    </div>
</div>

    <!-- अभी ये static रहने दो -->
    <div class="right_recent">
        <div class="start_recent">
            <h2>Recent Activity</h2>
            <i class="fa-solid fa-ellipsis"></i>
        </div>

    <?php while($row = mysqli_fetch_assoc($activity_result)) { ?>

    <div class="activity_row">

        <!-- ✅ ICON -->
        <i class="fa-solid fa-handshake"></i>

        <div class="request_text">

            <h3>
            <?php
            if($row['sender_id'] == $user_id){
                echo "You sent a request to " . $row['receiver_name'];
            } else {
                echo $row['sender_name'] . " sent you a request";
            }
            ?>
            </h3>


        </div>

        <div class="request_time">
            <p><?php echo $row['created_at']; ?></p>
        </div>

    </div>

<?php } ?>



    </div>

</div>
</section>

<footer>
<?php include "footer.php"; ?>
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

    const contentArea = document.querySelector(".right_side");


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
