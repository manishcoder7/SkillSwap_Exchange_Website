<?php
session_start();
include("config/db.php");

$user_id = $_POST['user_id'];

$name = $_POST['full_name'];
$email = $_POST['email'];
$location = $_POST['location'];
$bio = $_POST['bio'];

// image upload
$image = $_FILES['profile_image']['name'];

if(!empty($image)){

    // ✅ unique name (important)
    $new_image_name = time() . "_" . $image;

    $target = "uploads/" . $new_image_name;

    move_uploaded_file($_FILES['profile_image']['tmp_name'], $target);

    // ✅ only filename save karo
    $sql = "UPDATE users SET 
            full_name='$name',
            email='$email',
            location='$location',
            bio='$bio',
            profile_image='$new_image_name'
            WHERE id='$user_id'";
}else{
    $sql = "UPDATE users SET 
            full_name='$name',
            email='$email',
            location='$location',
            bio='$bio'
            WHERE id='$user_id'";
}

mysqli_query($conn,$sql);

// redirect
header("Location: profilepage.php");
exit();
?>
