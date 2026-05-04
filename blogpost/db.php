<?php
$server = "localhost";
$user = "root";
$pass = "";
$dbname = "blogpostdb";

$conn = new mysqli($server, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$conn->set_charset("utf8mb4");
?>