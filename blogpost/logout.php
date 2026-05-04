<?php
session_start();
include "allheader.php";
session_destroy();
header("Location: login.php");
?>