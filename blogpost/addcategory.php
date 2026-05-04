<?php
session_start();
include "db.php";

if(!isset($_SESSION['user_id']) || $_SESSION['user_role'] != "admin"){
    header("Location: dashboard.php");
    exit();
}

if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, trim($_POST['name']));
    if(!empty($name)){
        $check = mysqli_query($conn, "SELECT * FROM categories WHERE name='$name'");
        if(mysqli_num_rows($check) == 0){
            mysqli_query($conn, "INSERT INTO categories (name) VALUES ('$name')");
            $msg = "<p class='success'>Category added!</p>";
        } else {
            $msg = "<p class='error'>Category already exists!</p>";
        }
    }
}
include "allheader.php";
?>

<h2 style="text-align:center;">Add New Category (Admin Only)</h2>
<?php if(isset($msg)) echo $msg; ?>

<form action="addcategory.php" method="POST">
    <input type="text" name="name" placeholder="Category Name" required>
    <input type="submit" name="submit" value="Add Category">
</form>

<a href="dashboard.php" class="btn">← Back to Dashboard</a>

</body>
</html>