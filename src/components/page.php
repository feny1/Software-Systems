<?php
session_start();
$Logged = isset($_SESSION['user']) && isset($_SESSION["user"]["type"]);
if(!$Logged){
    header("Location: login.php"); // Redirect if already logged in
    exit();
}

include ('../database/fetch.php');

if (isset($_SESSION["user"])) {
    // If the user is not found in the database, remove the session user.
    if (!getUserById($_SESSION["user"]["id"])) {
        unset($_SESSION["user"]);
    }
}
?>
