<?php
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BlogPost</title>
    <link rel="stylesheet" href="allstyle.css">
</head>
<body>

<header>
    <h1>My Blog</h1>       
    <p>Welcome</p>
</header>

<nav>
    <a href="index.php">Home</a>
    <a href="displaypost.php">All Posts</a>
    
    <?php if(isset($_SESSION['user_id'])): ?>
        <a href="dashboard.php">Dashboard</a>
        <a href="logout.php">Logout</a>
    <?php else: ?>
        <a href="login.php">Login</a>
        <a href="register.php">Sign Up</a>
    <?php endif; ?>
</nav>