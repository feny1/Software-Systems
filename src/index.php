<?php
session_start();
if (isset($_SESSION['user']) && isset($_SESSION["user"]["type"])) {
  header("Location: ./pages/profile.php");
  exit;
}

header("Location: ./pages/index.php");
exit;
