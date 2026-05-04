<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] == "subscriber"){
    header("Location: dashboard.php");
    exit();
}

$categories = mysqli_query($conn, "SELECT * FROM categories");

if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);
    $user_id = $_SESSION['user_id'];

    $image_name = "";
    if(!empty($_FILES['image']['name'])){
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "image/" . $image_name);
    }

    $cat_result = mysqli_query($conn, "SELECT id FROM categories WHERE name = '$category_name'");
    $category_id = mysqli_fetch_assoc($cat_result)['id'] ?? 1;

    $sql = "INSERT INTO posts(title, content, author_id, category_id, image) 
            VALUES('$title', '$content', '$user_id', '$category_id', '$image_name')";

    if(mysqli_query($conn, $sql)){
        echo "<p class='success'>Post published successfully!</p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    }
}
include "allheader.php";
?>

<h2 style="text-align:center;">Create New Post</h2>

<form action="insertpost.php" method="post" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Post Title" required><br><br>
    <textarea name="content" rows="12" placeholder="Write your post here..." required></textarea><br><br>
    
    <select name="category_name" required>
        <?php while($row = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= htmlspecialchars($row['name']) ?>"><?= htmlspecialchars($row['name']) ?></option>
        <?php endwhile; ?>
    </select><br><br>

    <input type="file" name="image"><br><br>
    <input type="submit" name="submit" value="Publish Post">
</form>

<a href="dashboard.php" class="btn">← Back to Dashboard</a>

</body>
</html>