<?php
session_start();


include ('../database/fetch.php');

if (isset($_SESSION["user"]) && isset($_SESSION["user"]["id"])) {
    // If the user is not found in the database, remove the session user.
    if (!getUserById($_SESSION["user"]["id"])) {
        unset($_SESSION["user"]);
    }
}
?>
