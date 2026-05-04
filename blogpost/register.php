<?php
include "db.php"; 
if(isset($_POST['submit'])){
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];
    $role = $_POST['role'];

    $sql = "INSERT INTO users (name, email, password, role) 
            VALUES ('$name', '$email', '$password', '$role')";
    
    if(mysqli_query($conn, $sql)){
        echo "<p class='success'>Registration successful! <a href='login.php'>Login now</a></p>";
    } else {
        echo "<p class='error'>Error: " . mysqli_error($conn) . "</p>";
    }
}
?>
<?php include "allheader.php"; ?>

<h2 style="text-align:center;">Create Account</h2>

<form action="register.php" method="POST">
    <input type="text" name="name" placeholder="Full Name" required><br>
    <input type="email" name="email" placeholder="Email" required><br>
    <input type="password" name="password" placeholder="Password" required><br>
    <select name="role">
        <option value="subscriber">Subscriber</option>
        <option value="author">Author</option>
    </select><br>
    <input type="submit" name="submit" value="Register">
</form>

</body>
</html>