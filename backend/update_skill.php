<?php
session_start();
include("../config/db.php");

if(isset($_POST['update']))
{
    $id = intval($_POST['id']);
    $skill_name = $_POST['skill_name'];
    $description = $_POST['description'];
    $level = $_POST['level'];

    $sql = "UPDATE skills 
            SET skill_name='$skill_name',
                description='$description',
                level='$level'
            WHERE id='$id'";

    if(mysqli_query($conn,$sql))
    {
        header("Location: ../Myskill.php?updated=1");
        exit();
    }
    else
    {
        echo "Skill update failed";
    }
}
?>
