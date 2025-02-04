<?php
session_start();
include ('../database/data.php');

// ✅ Ensure user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("⚠ يجب تسجيل الدخول لإدارة الطلبات.");
}

// ✅ Validate input
$application_id = $_POST['application_id'] ?? null;
$status = $_POST['status'] ?? null;

if (!$application_id || !in_array($status, ['accepted', 'rejected'])) {
    die("⚠ بيانات غير صالحة.");
}

// ✅ Update the application status in the database
$stmt = $db->prepare("UPDATE applications SET status = :status WHERE id = :application_id");
$stmt->bindValue(':status', $status, SQLITE3_TEXT);
$stmt->bindValue(':application_id', $application_id, SQLITE3_INTEGER);
$stmt->execute();

// ✅ Redirect back to the company page with success message
header("Location: company.php?success=1");
exit;
?>