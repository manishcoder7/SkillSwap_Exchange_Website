<?php
session_start();
include("../config/db.php");

if(isset($_GET['id']))
{
    $id = $_GET['id'];

    $sql = "DELETE FROM skills WHERE id='$id'";
    $result = mysqli_query($conn,$sql);

    if($result)
    {
        header("Location: ../MySkill.php");
    }
    else
    {
        echo "Error deleting skill";
    }
}
?>
