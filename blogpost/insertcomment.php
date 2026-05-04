<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

if(isset($_POST['submit']) && isset($_POST['post_id'])){
    $post_id = mysqli_real_escape_string($conn, $_POST['post_id']);
    $comment = mysqli_real_escape_string($conn, $_POST['comment']);
    $parent_id = isset($_POST['parent_id']) ? mysqli_real_escape_string($conn, $_POST['parent_id']) : 0;
    $user_name = $_SESSION['user_name'];
    $user_email = $_SESSION['user_email'];

    $sql = "INSERT INTO comments (post_id, parent_id, user_name, email, comment) 
            VALUES ('$post_id', '$parent_id', '$user_name', '$user_email', '$comment')";
    
    if(mysqli_query($conn, $sql)){
        header("Location: displaypost.php");
        exit();
    } else {
        echo "Error adding comment.";
    }
}
?>