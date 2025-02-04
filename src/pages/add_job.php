<?php
include('../components/page.php');

if (!isset($_SESSION["user"]) || $_SESSION["user"]["type"] != 1) {  // Only company users allowed
  header("location: ../index.php");
  exit();
}
$user = $_SESSION["user"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  global $db;

  // Retrieve form inputs
  $job_name       = $_POST["job_name"];
  $description    = $_POST["description"];
  $salary         = $_POST["salary"];
  $job_language   = $_POST["job_language"];
  $job_type       = $_POST["job_type"];
  $start_date     = $_POST["start_date"]; // New field for start date
  $end_date       = $_POST["end_date"];   // New field for end date (can be empty)

  // Basic validation
  if (!is_numeric($salary)) {
    echo "Salary must be a number";
    exit();
  }
  $salary = intval($salary);

  // Convert job type to boolean (1 for volunteer, 0 for regular job)
  // (Adjust as needed; here, if "volunteer" is selected we set type to 1)
  $job_type = ($job_type === "volunteer") ? 1 : 0;

  // Retrieve language_id based on the selected language name
  $lang_stmt = $db->prepare("SELECT language_id FROM languages WHERE name = :lang_name");
  $lang_stmt->bindValue(':lang_name', $job_language, SQLITE3_TEXT);
  $lang_result = $lang_stmt->execute();
  $lang_row = $lang_result->fetchArray(SQLITE3_ASSOC);
  $language_id = $lang_row['language_id'] ?? 0;

  // Get the company_id for the current user
  $company_stmt = $db->prepare("SELECT company_id FROM company WHERE owner_id = :user_id OR hr_id = :user_id");
  $company_stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
  $company_result = $company_stmt->execute();
  $company_row = $company_result->fetchArray(SQLITE3_ASSOC);

  if (!$company_row) {
    echo "You don't have permission to add jobs";
    exit();
  }
  $company_id = $company_row['company_id'];

  // Prepare the INSERT statement including start and end date fields.
  $stmt = $db->prepare("INSERT INTO jobs (company_id, name, description, salary, language_id, type, start, end) 
                        VALUES (:company_id, :name, :description, :salary, :language_id, :type, :start, :end)");
  $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
  $stmt->bindValue(':name', $job_name, SQLITE3_TEXT);
  $stmt->bindValue(':description', $description, SQLITE3_TEXT);
  $stmt->bindValue(':salary', $salary, SQLITE3_INTEGER);
  $stmt->bindValue(':language_id', $language_id, SQLITE3_INTEGER);
  $stmt->bindValue(':type', $job_type, SQLITE3_INTEGER);
  $stmt->bindValue(':start', $start_date, SQLITE3_TEXT);
  // If end_date is empty, bind NULL; otherwise, bind the date.
  if (empty($end_date)) {
    $stmt->bindValue(':end', null, SQLITE3_NULL);
  } else {
    $stmt->bindValue(':end', $end_date, SQLITE3_TEXT);
  }
  
  $result = $stmt->execute();

  if ($result) {
    header("location: ../pages/job_listing.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/globals.css">
  <link rel="stylesheet" href="../styles/add_job.css">
  <title>إضافة وظيفة</title>
</head>
<body>
  <section class="page-structure">
    <?php include "../components/NavBar.php" ?>
    <form action="" method="POST">
      <h2>إضافة وظيفة</h2>
      <div class="content">
        <div class="field">
          <label for="job_name">اسم الوظيفة</label>
          <input type="text" name="job_name" id="job_name" required>
        </div>
        <div class="field">
          <label for="description">وصف الوظيفة</label>
          <input type="text" name="description" id="description" required>
        </div>
        <div class="field">
          <label for="salary">الراتب</label>
          <input type="text" name="salary" id="salary" required>
        </div>
        <!-- New fields for start and end date -->
        <div class="field">
          <label for="start_date">تاريخ البدء</label>
          <input type="date" name="start_date" id="start_date" required>
        </div>
        <div class="field">
          <label for="end_date">تاريخ الانتهاء (اختياري)</label>
          <input type="date" name="end_date" id="end_date">
        </div>
        <div class="field">
          <label for="job_language">اللغة</label>
          <select name="job_language" id="job_language" required>
            <option value="العربية">العربية</option>
            <option value="English">English</option>
          </select>
        </div>
        <div class="field">
          <label for="job_type">نوع الوظيفة</label>
          <div>
            <label>
              وظيفة موسمية
              <input type="radio" name="job_type" value="job" required>
            </label>
            <label>
              تطوع موسمي
              <input type="radio" name="job_type" value="volunteer">
            </label>
          </div>
        </div>

        <button type="submit">أضف الوظيفة</button>
      </div>
    </form>
  </section>
</body>
</html>
