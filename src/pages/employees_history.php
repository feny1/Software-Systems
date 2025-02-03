<?php
include ('../components/page.php');
?>

<?php

/**
 * now we need exception handling
 * 1- if there's no parameters in the url 
 * 2- if the company id is wrong
 * 3- if i want to search by job id rather than comapny id
 * 4- if job id is wrong
 */
$company_id = $_GET['coid'] ?? '';
if ($company_id === '') {
  header("Loaction /index.php");
}
$result = fetchAllEmployeesByCompanyID($company_id);
$employee = $result['emplyees'];
// echo '<h1>'.$result['success'].'</h1>';
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

          if (filterType === "name") {
            searchInput.setAttribute("placeholder", "ابحث بالاسم");
          } else if (filterType === "email") {
            searchInput.setAttribute("placeholder", "ابحث بالإيميل");
          }

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
            <h2>اسم المستخدم</h2>
          </a>
        </div>
        <div class="options">
          <a href="#">
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
              <input type="text" id="search" placeholder="<?php echo count($employee) === 0 ? "لا يوجد موظفين للبحث" : "ابحث بالاسم" ?>" disabled=<?php if (count($employee) === 0): ?> disabled <?php endif; ?>">
              <
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
                    <td class="employee-name"><?= $emp['user_name'] ?></td>
                    <td class="employee-email"><?= $emp['email'] ?></td>
                    <td><?= $emp['start'] ?></td>
                    <td><?= $emp['end'] ?? 'لا زال على رأس العمل' ?></td>
                    <td><?= $emp['name'] ?></td>
                    <td class="actions">
                      <button class="details">إظهار التفاصيل</button>
                      <button class="delete">حذف</button>
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