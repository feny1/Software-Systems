<?php 

$employee = [
  [
      "name" => "ايهاب يار",
      "email" => "ehab@gmail.com",
      "start_date" => "2023-01-01",
      "end_date" => "2025-01-01",
      "job_title" => "Full Stack Dev"
  ],
  [
      "name" => "أحمد سندي",
      "email" => "ahmad@gmail.com",
      "start_date" => "2023-01-01",
      "end_date" => "2025-01-01",
      "job_title" => "Full Stack Dev"
  ],
  [
      "name" => "محمد علي",
      "email" => "mohammedali@gmail.com",
      "start_date" => "2023-01-01",
      "end_date" => "2025-01-01",
      "job_title" => "خدمة عملاء"
  ]

];
?>

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


          <table class="table">
                <thead>
                    <tr>
                        <th>الموظف</th>
                        <th>الإيميل</th>
                        <th>تاريخ البداية</th>
                        <th>تاريخ النهاية</th>
                        <th>المسمى الوظيفي</th>
                        <th>الإجراءات</th>
                    </tr>
                </thead>
                <tbody>

                <?php foreach ($employee as $emp): ?>
                <tr>
                  <td><?php echo $emp['name']; ?></td>
                  <td><?php echo $emp['email']; ?></td>
                  <td><?php echo $emp['start_date']; ?></td>
                  <td><?php echo $emp['end_date']; ?></td>
                  <td><?php echo $emp['job_title']; ?></td>
                  <td class="actions">
                    <button class="details">إظهار التفاصيل</button>
                    <button class="delete">حذف</button>
                  </td>
                </tr>
              <?php endforeach; ?>

                </tbody>
            </table>


          </div>
        </div>

      </main>
    </section>

  </section>
</body>
</html>