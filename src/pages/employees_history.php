<?php
include('../components/page.php');

  if (isset($_GET['job_id'])) {
    $employee = fetchAllEmployeesByJobID($_GET['job_id'])['employees'];
  } elseif (isset($_GET['company_id'])) {
    $employee = fetchAllEmployeesByCompanyID($_GET['company_id'])['employees'];
  } else {
    $employee = fetchAllEmployeesByCompanyID($_SESSION['user']['company_id'])['employees'];
  }
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/employees_history.css">
  <title>الموظفين السابقين</title>
  <script>
    document.addEventListener("DOMContentLoaded", () => {
      const filterChoices = document.querySelectorAll(".filter-choices p");
      const searchInput = document.getElementById("search");
      const employees = document.querySelectorAll(".employee-row");

      let filterType = "name";

      filterChoices.forEach((choice) => {
        choice.addEventListener("click", function() {
          filterChoices.forEach((choice) => choice.classList.remove("active"));
          this.classList.add("active");
          filterType = this.dataset.filter;
          searchInput.setAttribute("placeholder", filterType === "name" ? "ابحث بالاسم" : "ابحث بالإيميل");
          searchInput.value = "";
          employees.forEach((employee) => {
            employee.style.display = "table-row";
          });
        });
      });

      searchInput.addEventListener("input", function() {
        const search = searchInput.value.toLowerCase();
        employees.forEach((employee) => {
          const name = employee.querySelector(".employee-name").innerText.toLowerCase();
          const email = employee.querySelector(".employee-email").innerText.toLowerCase();
          if (
            (filterType === "name" && name.includes(search)) ||
            (filterType === "email" && email.includes(search))
          ) {
            employee.style.display = "table-row";
          } else {
            employee.style.display = "none";
          }
        });
      });
    });
  </script>
</head>
<body>
  <section class="page-structure">
    <?php include "../components/NavBar.php"; ?>
    <section class="page-content">
      <header>
        <div class="username">
          <a href="./profile.php">
            <img class="nav-icon" src="../images/profile.svg" alt="شعار المستخدم">
            <h2><?php echo $user['name']; ?></h2>
          </a>
        </div>
        <div class="options">
          <a href="./logout.php">
            <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل">
          </a>
        </div>
      </header>
      <main>
        <h1 class="heading-title">الموظفين السابقين :</h1>
        <div class="content">
          <div class="filter-section">
            <h3>
              <img src="../images/cv.svg" alt="شعار تصفية">
              التصفية
            </h3>
            <div class="filter-choices">
              <p data-filter="name" class="active">الاسم</p>
              <p data-filter="email">الإيميل</p>
            </div>
            <form>
              <label for="search">البحث :</label>
              <input type="text" id="search" placeholder="<?php echo count($employee) === 0 ? 'لا يوجد موظفين للبحث' : 'ابحث بالاسم'; ?>" <?php if (count($employee) === 0) echo 'disabled'; ?>>
            </form>
          </div>
          <?php if (count($employee)  === 0): ?>
            <h3 class="prev">لا يوجد موظفين سابقين</h3>
          <?php else: ?>
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
                  <tr class="employee-row">
                    <td class="employee-name"><?= htmlspecialchars($emp['user_name']); ?></td>
                    <td class="employee-email"><?= htmlspecialchars($emp['email']); ?></td>
                    <td><?= htmlspecialchars($emp['start']); ?></td>
                    <td><?= isset($emp['end']) && $emp['end'] ? htmlspecialchars($emp['end']) : 'لا زال على رأس العمل'; ?></td>
                    <td><?= htmlspecialchars($emp['job_title'] ?? $emp['name']); ?></td>
                    <td class="actions">
                      <a class="details" href="./profile.php?id=<?= $emp['user_id']?>">إظهار التفاصيل</a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          <?php endif; ?>
        </div>
      </main>
    </section>
  </section>
</body>
</html>
