<?php
include ('../components/page.php');
?>
<?php

if (!isset($_SESSION["user"]) || $_SESSION["user"]["type"] != 1) {  // type 2 is for company users
  header("location: ../index.php");
  exit();
}
$user = $_SESSION["user"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  global $db;

  $job_name = $_POST["job_name"];
  $description = $_POST["description"];
  $salary = $_POST["salary"];
  $job_language = $_POST["job_language"];
  $job_type = $_POST["job_type"];

  if (!is_numeric($salary)) {
    echo "Salary must be a number";
    exit();
  }

  // Convert salary to integer
  $salary = intval($salary);

  // Convert job type to boolean (true for volunteer, false for job)
  $job_type = ($job_type === "volunteer") ? 1 : 0;

  // Get language_id based on selected language name
  $lang_stmt = $db->prepare("SELECT language_id FROM languages WHERE name = :lang_name");
  $lang_stmt->bindValue(':lang_name', $job_language, SQLITE3_TEXT);
  $lang_result = $lang_stmt->execute();
  $lang_row = $lang_result->fetchArray(SQLITE3_ASSOC);
  $language_id = $lang_row['language_id'];

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

  // Insert the job using prepared statement
  $stmt = $db->prepare("INSERT INTO jobs (company_id, name, description, salary, language_id, type) 
                       VALUES (:company_id, :name, :description, :salary, :language_id, :type)");

  $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
  $stmt->bindValue(':name', $job_name, SQLITE3_TEXT);
  $stmt->bindValue(':description', $description, SQLITE3_TEXT);
  $stmt->bindValue(':salary', $salary, SQLITE3_INTEGER);
  $stmt->bindValue(':language_id', $language_id, SQLITE3_INTEGER);
  $stmt->bindValue(':type', $job_type, SQLITE3_INTEGER);

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
          <input type="text" name="job_name" required>
        </div>
        <div class="field">
          <label for="description">وصف الوظيفة</label>
          <input type="text" name="description" required>
        </div>
        <div class="field">
          <label for="salary">الراتب</label>
          <input type="text" name="salary" required>
        </div>
        <select name="job_language" required>
          <option value="العربية">العربية</option>
          <option value="english">english</option>
        </select>
        <div class="field">
          <label for="job_type">نوع الوظيفة</label>
          <div>
            <p for="job_type">وظيفة موسمية</p>
            <input type="radio" name="job_type" value="job" required>
            <p for="job_type">تطوع موسمي</p>
            <input type="radio" name="job_type" value="volunteer">
          </div>
        </div>

        <button type="submit">Add</button>
    </form>

    </div>
  </section>
</body>

</html>