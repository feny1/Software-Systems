<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  <link rel="stylesheet" href="../styles/employees_history.css">
  <title>الموظفين السابقين</title>


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
        <h1 class="heading-title">الموظفين السابقين : </h1>

        <div class="content">
          <div class="filter-section">
            <h3>
              <img src="../images/cv.svg" alt="شعار تصفية">
              التصفية
            </h3>
            <div class="filter-choices">
              <p>الاسم</p>
              <p>الايميل</p>
            </div>

            <form action="post">
              <label for="company-name">البحث : </label>
              <input type="text" name="company-name" placeholder="البحث  بأسم الموظف">
            </form>

          </div>
          <div class="jobs-section">
            <div class="job">
              <img src="../images/sampleJob.png" alt="job image">
              <div class="content">
                <div class="titles">
                  <h2 class="job-title">اسم الوظيفة</h2>
                  <h3 class="company-title">اسم الشركة</h3>
                  <div class="keywords">
                    <span class="keyword">الكلمة المفتاحية 1</span>
                    <span class="keyword">الكلمة المفتاحية 2</span>
                  </div>
                </div>
                <p class="description">وظيفة موسمية براتب مجزي وبدلات و بيئة متطورة و الخ... </p>
              </div>
              <a href="#"></a>
            </div>

            <div class="job">
              <img src="../images/sampleJob.png" alt="job image">
              <div class="content">
                <div class="titles">
                  <h2 class="job-title">اسم الوظيفة</h2>
                  <h3 class="company-title">اسم الشركة</h3>
                  <div class="keywords">
                    <span class="keyword">الكلمة المفتاحية 1</span>
                    <span class="keyword">الكلمة المفتاحية 2</span>
                  </div>

                </div>
                <p class="description">وظيفة موسمية براتب مجزي وبدلات و بيئة متطورة و الخ... </p>
              </div>
              <a href="#"></a>
            </div>
            <div class="job">
              <img src="../images/sampleJob.png" alt="job image">
              <div class="content">
                <div class="titles">
                  <h2 class="job-title">اسم الوظيفة</h2>
                  <h3 class="company-title">اسم الشركة</h3>
                  <div class="keywords">
                    <span class="keyword">الكلمة المفتاحية 1</span>
                    <span class="keyword">الكلمة المفتاحية 2</span>
                  </div>
                </div>
                <p class="description">وظيفة موسمية براتب مجزي وبدلات و بيئة متطورة و الخ... </p>
              </div>
              <a href="#"></a>
            </div>
            <div class="job">
              <img src="../images/sampleJob.png" alt="job image">
              <div class="content">
                <div class="titles">
                  <h2 class="job-title">اسم الوظيفة</h2>
                  <h3 class="company-title">اسم الشركة</h3>
                  <div class="keywords">
                    <span class="keyword">الكلمة المفتاحية 1</span>
                    <span class="keyword">الكلمة المفتاحية 2</span>
                  </div>
                </div>
                <p class="description">وظيفة موسمية براتب مجزي وبدلات و بيئة متطورة و الخ... </p>
              </div>
              <a href="#"></a>
            </div>
            <div class="job">
              <img src="../images/sampleJob.png" alt="job image">
              <div class="content">
                <div class="titles">
                  <h2 class="job-title">اسم الوظيفة</h2>
                  <h3 class="company-title">اسم الشركة</h3>
                  <div class="keywords">
                    <span class="keyword">الكلمة المفتاحية 1</span>
                    <span class="keyword">الكلمة المفتاحية 2</span>
                  </div>
                </div>
                <p class="description">وظيفة موسمية براتب مجزي وبدلات و بيئة متطورة و الخ... </p>
              </div>
              <a href="#"></a>
            </div>
          </div>
        </div>
      </main>
    </section>

  </section>
</body>
</html>