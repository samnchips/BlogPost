<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] == "subscriber"){
    header("Location: dashboard.php");
    exit();
}

if(isset($_GET['post_id'])){
    $id = mysqli_real_escape_string($conn, $_GET['post_id']);
    mysqli_query($conn, "DELETE FROM posts WHERE id = '$id'");
}

header("Location: displaypost.php");
?>