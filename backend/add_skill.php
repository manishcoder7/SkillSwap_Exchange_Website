<?php
session_start();
include("../config/db.php");

if(isset($_POST['addskill']))
{
    $user_id = $_SESSION['user_id'];
    $skill = $_POST['skill_name'];
    $category = $_POST['category'];
    $level = $_POST['level'];
    $description = $_POST['description'];

    $sql = "INSERT INTO skills(user_id,skill_name,category,level,description)
            VALUES('$user_id','$skill','$category','$level','$description')";

    if(mysqli_query($conn,$sql))
    {
        header("Location: ../AddSkill.php?success=1");
    }
    else
    {
        echo "Skill not added";
    }
}
?>
