<?php
include('../components/page.php');

$user = $_SESSION["user"];
$jobs = fetchAllJobs();
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/job_listing.css">
  <title>عرض الوظائف</title>
  <script src="../javascript/jobListing.js" defer></script>

  <style>
    /* Add job button */
    .add-job-container {
      text-align: right;
      margin-bottom: 15px;
    }

    .add-job-btn {
      display: inline-block;
      padding: 12px 24px;
      background-color: #034C3C; 
      color: white;
      text-decoration: none;
      border-radius: 25px; 
      font-weight: bold;
      font-size: 16px;
      transition: background 0.3s ease-in-out;
    }

    .add-job-btn:hover {
      background-color: #026C56; 
    }
    /* End of "add job button" */
  </style>
</head>

<body>
  <section class="page-structure">
    <?php include "../components/NavBar.php" ?>
    <section class="page-content">
      <header>
        <div class="username">
          <a href="./profile.php">
            <img class="nav-icon" src="../images/profile.svg" alt="شعار المستخدم">
            <h2><?php echo $user["name"] ?></h2>
          </a>
        </div>
        <div class="options">
          <a href="#">
            <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل">
          </a>
        </div>
      </header>

      <?php
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        $user_type = ($_SESSION['user']['type'] == 1) ? 'company' : 'individual';
      ?>

      <main>
        <h1 class="heading-title">أحدث الوظائف : </h1>

        <div class="content">


          

          <div class="filter-section">
            <h3>
              <img src="../images/cv.svg" alt="شعار تصفية">
              التصفية
            </h3>
          
            <!-- A button for "adding a job" -->
          <?php if (strtolower($user_type) === 'company'): ?>
              <div class="add-job-container">
                  <a href="add_job.php" class="add-job-btn">إضافة وظيفة جديدة</a>
              </div>
          <?php endif; ?>
          
          <div class="filter-choices">
              <p>تطوع موسمي</p>
              <p>وظيفة موسمية</p>
          </div>

            <form action="post">
              <label for="company-name">البحث عن اسم شركة: </label>
              <input id="search" type="text" name="company-name">
            </form>
          </div>

          <div class="jobs-section">
            <?php if (count($jobs) === 0): ?>
              <h3 class="no-jobs">لا يوجد وظائف</h3>
            <?php endif; ?>
            <?php foreach ($jobs as $job): ?>
              <div class="job">
                <img src="../images/sampleJob.png" alt="job image">
                <div class="content">
                  <div class="titles">
                    <h2 class="job-title"><?php echo $job["name"] ?></h2>
                    <h3 class="company-title"><?php $job["company_id"] ?></h3>
                    <h3 class="salary"><?= $job["salary"] ?></h3>
                    <h3 class="job-type"><?php
                    if($job["type"] == 0) {
                      echo "وظيفة موسمية";
                    } else {
                      echo "تطوع موسمي";
                    }
                    ?></h3>
                  </div>
                  <p class="description"><?php echo $job["description"] ?> </p>
                </div>
                <a href="#"></a>
              </div>
            <?php endforeach ?>
          </div>
        </div>
      </main>
    </section>
  </section>
</body>

</html>