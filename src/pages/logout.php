<?php
session_start();
unset($_SESSION["user"]);
header("Location: login.php"); // Redirect if already logged in
exit;
