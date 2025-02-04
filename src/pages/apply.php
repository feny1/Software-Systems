<?php
session_start();
include('../database/data.php');

// ✅ Ensure user is logged in
if (!isset($_SESSION['user']['id'])) {
    die("⚠ يجب تسجيل الدخول للتقديم على الوظيفة.");
}

$user_id = $_SESSION['user']['id'];
$job_id = $_POST['job_id'] ?? 0; // ✅ FIXED: Read job_id from POST, not GET

if ($job_id == 0) {
    die("⚠ حدث خطأ: لا يمكن التقديم بدون معرف الوظيفة.");
}

// ✅ Check if the user has already applied for this job
$stmt = $db->prepare("SELECT * FROM applications WHERE job_id = :job_id AND user_id = :user_id");
$stmt->bindValue(':job_id', $job_id, SQLITE3_INTEGER);
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$existing = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

if ($existing) {
    die("⚠ لقد قدمت بالفعل على هذه الوظيفة.");
}

// ✅ Insert the application into the database
$stmt = $db->prepare("INSERT INTO applications (job_id, user_id, status) VALUES (:job_id, :user_id, :status)");
$stmt->bindValue(':job_id', $job_id, SQLITE3_INTEGER);
$stmt->bindValue(':user_id', $user_id, SQLITE3_INTEGER);
$stmt->execute();

// ✅ Redirect user back to job listings with success message
header("Location: job_listing.php?success=1");
exit;
