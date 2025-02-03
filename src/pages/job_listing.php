<?php
include ('../components/page.php');
?>
<?php
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
</head>

<body>
  <section class="page-structure">
    <?php include "../components/NavBar.php" ?>
    <section class="page-content">
      <header>
        <div class="username">
          <a href="./profile.php">
            <img class="nav-icon" src="../images/profile.svg" alt="شعار المستخدم">
            <h2>اسم المستخدم</h2>
          </a>
        </div>
        <div class="options">
          <a href="#">
            <img class="nav-icon" src="../images/settings.svg" alt="شعار الإعدادت">
          </a>
          <a href="#">
            <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل">
          </a>
        </div>
      </header>

      <main>
        <h1 class="heading-title">أحدث الوظائف : </h1>

        <div class="content">
          <div class="filter-section">
            <h3>
              <img src="../images/cv.svg" alt="شعار تصفية">
              التصفية
            </h3>
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
            <?php foreach ($jobs as $job): ?>
              <div class="job">
                <img src="../images/sampleJob.png" alt="job image">
                <div class="content">
                  <div class="titles">
                    <h2 class="job-title"><?php echo $job["name"] ?></h2>
                    <h3 class="company-title"><?php $job["company_id"] ?></h3>
                    <h3 class="job-type"><?php echo $job["type"] ?></h3>
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