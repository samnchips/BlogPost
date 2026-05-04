<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] == "subscriber"){
    header("Location: dashboard.php");
    exit();
}

$post_id = $_GET['post_id'] ?? $_POST['post_id'] ?? 0;

if(isset($_POST['submit'])){
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $content = mysqli_real_escape_string($conn, $_POST['content']);
    $category_name = mysqli_real_escape_string($conn, $_POST['category_name']);

    $image_query = "";
    if(!empty($_FILES['image']['name'])){
        $image_name = time() . "_" . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], "image/" . $image_name);
        $image_query = ", image = '$image_name'";
    }

    $cat_result = mysqli_query($conn, "SELECT id FROM categories WHERE name='$category_name'");
    $cat_id = mysqli_fetch_assoc($cat_result)['id'] ?? 1;

    $sql = "UPDATE posts SET title='$title', content='$content', category_id='$cat_id' $image_query WHERE id='$post_id'";
    mysqli_query($conn, $sql);
    echo "<p class='success'>Post updated successfully!</p>";
}

$post = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM posts WHERE id='$post_id'"));
$categories = mysqli_query($conn, "SELECT * FROM categories");
include "allheader.php";
?>

<h2 style="text-align:center;">Edit Post</h2>

<form action="updatepost.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="post_id" value="<?= $post_id ?>">
    <input type="text" name="title" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required><br><br>
    <textarea name="content" rows="12" required><?= htmlspecialchars($post['content'] ?? '') ?></textarea><br><br>
    
    <select name="category_name">
        <?php while($row = mysqli_fetch_assoc($categories)): ?>
            <option value="<?= htmlspecialchars($row['name']) ?>" <?= ($row['id'] == $post['category_id']) ? 'selected' : '' ?>>
                <?= htmlspecialchars($row['name']) ?>
            </option>
        <?php endwhile; ?>
    </select><br><br>

    <input type="file" name="image"><br><br>
    <input type="submit" name="submit" value="Update Post">
</form>

<a href="dashboard.php" class="btn">← Back to Dashboard</a>

</body>
</html>