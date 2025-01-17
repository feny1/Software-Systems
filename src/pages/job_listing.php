<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/job_listing.css">
  <title>Document</title>
</head>
<body>
  <section class="page-structure">
      <?php include "../components/NavBar.php" ?>
    <section class="page-content">
      <header>
        <div class="username">
          <a href="./profile.php">
            <img src="../images/profile.svg" alt="شعار المستخدم">
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
        <h1 class="heading-title">أحدث الوظائف</h1>

        <div class="content">
          <div class="filter-section">
            <h3>
              <img src="../images/cv.svg" alt="شعار تصفية">
              التصفية
            </h3>
            <div class="filter-choices">
              <p>التصفية الأولى</p>
              <p>التصفية الثانية</p>
            </div>

            <form action="post">
              <label for="company-name">البحث عن اسم شركة: </label>
              <input type="text" name="company-name">
            </form>
          </div>
          <div class="jobs-section"></div>
        </div>
      </main>
    </section>
  </section>
</body>
</html>