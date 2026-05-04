<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}
include "allheader.php";
?>

<div class="welcome" style="max-width:800px; margin:30px auto;">
    <h2>Welcome back, <?= htmlspecialchars($_SESSION['user_name']) ?>!</h2>
    <p>Your role: <strong><?= ucfirst($_SESSION['user_role']) ?></strong></p>
</div>

<div style="text-align:center; margin:40px 0;">
    <?php if($_SESSION['user_role'] == "admin"): ?>
        <a href="addcategory.php" class="btn">Add Category</a>
    <?php endif; ?>

    <?php if($_SESSION['user_role'] != "subscriber"): ?>
        <a href="insertpost.php" class="btn">Create New Post</a>
    <?php endif; ?>

    <a href="displaypost.php" class="btn">View All Posts</a>
</div>

</body>
</html>