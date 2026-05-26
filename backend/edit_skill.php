<?php
session_start();
include("../config/db.php");

if(isset($_GET['id']))
{
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM skills WHERE id='$id'";
    $result = mysqli_query($conn,$sql);
    $row = mysqli_fetch_assoc($result);
}
else
{
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Edit Skill</title>

<link rel="stylesheet" href="edit_skill.css">
<script src="https://kit.fontawesome.com/05476c3bb4.js" crossorigin="anonymous"></script>


</head>
<body>

<div class="edit_container">

<h2>Edit Your Skill <i class="fa-solid fa-user-pen"></i></h2>

<form action="update_skill.php" method="POST">

    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">

    <label>Skill Name</label>
    <input type="text" name="skill_name" 
    value="<?php echo $row['skill_name']; ?>" required>

    <label>Description</label>
    <textarea name="description" required><?php echo $row['description']; ?></textarea>

    <label>Level</label>
    <select name="level">

        <option value="Beginner"
        <?php if($row['level']=="Beginner") echo "selected"; ?>>
        Beginner
        </option>

        <option value="Intermediate"
        <?php if($row['level']=="Intermediate") echo "selected"; ?>>
        Intermediate
        </option>

        <option value="Expert"
        <?php if($row['level']=="Expert") echo "selected"; ?>>
        Expert
        </option>

    </select>

    <button type="submit" name="update" class="update_btn">
        Update Skill 
    </button>

</form>

</div>

</body>
</html>
