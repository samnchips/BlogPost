<?php
session_start();
include "db.php";

if(isset($_POST['submit'])){
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);

    if($result && $result->num_rows > 0){
        $row = mysqli_fetch_assoc($result);
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['name'];
        $_SESSION['user_role'] = $row['role'];
        $_SESSION['user_email'] = $row['email'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<?php include "allheader.php"; ?>

<h2 style="text-align:center;">Login</h2>

<?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>

<form action="login.php" method="POST">
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <input type="submit" name="submit" value="Login">
</form>

<p style="text-align:center;">Don't have an account? <a href="register.php">Register here</a></p>

</body>
</html>