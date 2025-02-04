<?php
include('../components/page.php');
include('../database/data.php');

// Get company_id from GET parameter or from the session (if available)
$company_id = isset($_GET["id"]) ? intval($_GET["id"]) : ($_SESSION['user']['company_id'] ?? 0);

// Fetch company data
$stmt = $db->prepare("SELECT * FROM company WHERE company_id = :company_id");
$stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);

// Determine if the logged-in user is the owner of this company profile
$isOwner = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $result['owner_id']);

// --- PROCESS INLINE UPDATES FOR COMPANY PROFILE ---
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $isOwner && isset($_POST['update_company'])) {
    $updateType = $_POST['update_company'];
    if ($updateType === 'name') {
        $newName = trim($_POST['name'] ?? '');
        if (!empty($newName)) {
            $stmt = $db->prepare("UPDATE company SET name = :name WHERE company_id = :company_id");
            $stmt->bindValue(':name', $newName, SQLITE3_TEXT);
            $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
            $stmt->execute();
        }
    } elseif ($updateType === 'about') {
        $newBio = $_POST['bio'] ?? '';
        $stmt = $db->prepare("UPDATE company SET bio = :bio WHERE company_id = :company_id");
        $stmt->bindValue(':bio', $newBio, SQLITE3_TEXT);
        $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
        $stmt->execute();
    } elseif ($updateType === 'contact') {
        $newEmail = isset($_POST['email']) && trim($_POST['email']) !== '' ? trim($_POST['email']) : 'لا يوجد';
        $newPhone = isset($_POST['phone']) && trim($_POST['phone']) !== '' ? trim($_POST['phone']) : 'لا يوجد';
        $newLinkedin = isset($_POST['linkedin']) && trim($_POST['linkedin']) !== '' ? trim($_POST['linkedin']) : 'لا يوجد';
        $stmt = $db->prepare("UPDATE company SET email = :email, phone = :phone, linkedin = :linkedin WHERE company_id = :company_id");
        $stmt->bindValue(':email', $newEmail, SQLITE3_TEXT);
        $stmt->bindValue(':phone', $newPhone, SQLITE3_TEXT);
        $stmt->bindValue(':linkedin', $newLinkedin, SQLITE3_TEXT);
        $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
        $stmt->execute();
    }
    // Refresh company data after update
    $stmt = $db->prepare("SELECT * FROM company WHERE company_id = :company_id");
    $stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
    $result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);
}

// Assign company data to variables
$name = $result['name'] ?? 'غير معروف';
$bio = $result['bio'] ?? 'لا توجد معلومات';
$email = $result['email'] ?? 'غير متوفر';
$phone = $result['phone'] ?? 'غير متوفر';
$linkedin = $result['linkedin'] ?? '#';

// Fetch additional company-related data (jobs, applications, etc.)
$jobs = fetchAllCompanyJobs($company_id);
$applications = fetchAllApplicationsForCompany($company_id);

// Split jobs into "available" and "previous" based on the end date.
$today = date("Y-m-d");
$availableJobs = [];
$previousJobs = [];
foreach ($jobs as $job) {
    // If the 'end' date is empty (NULL) or is greater than or equal to today, it is available.
    if (empty($job["end"]) || $job["end"] >= $today) {
        $availableJobs[] = $job;
    } else {
        $previousJobs[] = $job;
    }
}
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../styles/profile.css">
  <title><?php echo htmlspecialchars($name); ?></title>
  <style>
    /* Optional inline styles for the edit forms */
    .edit-form {
      border: 1px solid #ccc;
      padding: 10px;
      margin-top: 10px;
      background-color: #fefefe;
    }
    .edit-btn, .cancel-btn {
      cursor: pointer;
      color: blue;
      text-decoration: underline;
      margin-left: 5px;
    }
  </style>
</head>
<body>
  <section class="page-structure">
    <?php 
      // Optionally define a custom navigation list for companies.
      $customNavList = [
          [
              "title" => "الموظفين",
              "icon" => "profile.svg",
              "alt" => "الموظفين",
              "link" => "./employees_history.php"
          ]
      ];
      include "../components/NavBar.php";
    ?>
    <section class="page-content">
      <!-- Company Header -->
      <div class="username">
        <img class="profile-pic" src="../images/company.svg" alt="صورة الشركة">
        <div class="user">
          <h2 id="companyNameDisplay"><?php echo htmlspecialchars($name); ?></h2>
          <?php if ($isOwner): ?>
            <span class="edit-btn" onclick="toggleEdit('companyName')">[تعديل]</span>
          <?php endif; ?>
        </div>
      </div>
      <?php if ($isOwner): ?>
      <div id="companyNameEdit" class="edit-form" style="display: none;">
        <form method="POST" action="">
          <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
          <input type="hidden" name="update_company" value="name">
          <button type="submit">حفظ</button>
          <button type="button" onclick="toggleEdit('companyName')">إلغاء</button>
        </form>
      </div>
      <?php endif; ?>

      <!-- Options (e.g., logout) -->
      <div class="options">
        <a href="../pages/logout.php">
          <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل الخروج">
        </a>
      </div>
      <header></header>
      <main>
        <section class="profile-details">
          <!-- About Section -->
          <div class="block about">
            <h2>نبذة</h2>
            <div id="companyAboutDisplay">
              <p><?php echo htmlspecialchars($bio); ?></p>
              <?php if ($isOwner): ?>
                <span class="edit-btn" onclick="toggleEdit('companyAbout')">[تعديل]</span>
              <?php endif; ?>
            </div>
            <?php if ($isOwner): ?>
            <div id="companyAboutEdit" class="edit-form" style="display: none;">
              <form method="POST" action="">
                <textarea name="bio" rows="4"><?php echo htmlspecialchars($bio); ?></textarea>
                <input type="hidden" name="update_company" value="about">
                <button type="submit">حفظ</button>
                <button type="button" onclick="toggleEdit('companyAbout')">إلغاء</button>
              </form>
            </div>
            <?php endif; ?>
          </div>
          
          <!-- Contacts Section -->
          <div class="block contacts">
            <h2>معلومات الاتصال</h2>
            <div id="companyContactDisplay">
              <ul>
                <li>البريد الإلكتروني:
                  <a href="mailto:<?php echo htmlspecialchars($email); ?>"><?php echo htmlspecialchars($email?? 'لا يوجد'); ?></a>
                </li>
                <li>رقم الهاتف:
                  <a href="tel:<?php echo htmlspecialchars($phone); ?>"><?php echo htmlspecialchars($phone?? 'لا يوجد'); ?></a>
                </li>
                <li>لينكد إن:
                  <a href="<?php echo htmlspecialchars($linkedin); ?>" target="_blank"><?php echo htmlspecialchars($linkedin ?? 'لا يوجد'); ?></a>
                </li>
              </ul>
              <?php if ($isOwner): ?>
                <span class="edit-btn" onclick="toggleEdit('companyContact')">[تعديل]</span>
              <?php endif; ?>
            </div>
            <?php if ($isOwner): ?>
            <div id="companyContactEdit" class="edit-form" style="display: none;">
              <form method="POST" action="">
                <label>البريد الإلكتروني:
                  <input type="text" name="email" value="<?php echo htmlspecialchars($email); ?>">
                </label>
                <br>
                <label>رقم الهاتف:
                  <input type="text" name="phone" value="<?php echo htmlspecialchars($phone); ?>">
                </label>
                <br>
                <label>لينكد إن:
                  <input type="text" name="linkedin" value="<?php echo htmlspecialchars($linkedin); ?>">
                </label>
                <br>
                <input type="hidden" name="update_company" value="contact">
                <button type="submit">حفظ</button>
                <button type="button" onclick="toggleEdit('companyContact')">إلغاء</button>
              </form>
            </div>
            <?php endif; ?>
        </section>

        <section class="recent-activity">
          <!-- الوظائف المتاحة Section -->
          <div class="block experinces">
            <h2>الوظائف المتاحة</h2>
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:right;">
              <tr>
                <th>المسمى الوظيفي</th>
                <th>الوصف</th>
                <th>الراتب</th>
                <th>الفترة</th>
              </tr>
              <?php if (!empty($availableJobs)): ?>
                <?php foreach ($availableJobs as $job): ?>
                  <tr>
                    <td><?= htmlspecialchars($job["name"]) ?></td>
                    <td><?= htmlspecialchars($job["description"]) ?></td>
                    <td><?= htmlspecialchars($job["salary"]) ?> ريال</td>
                    <td>
                      من <?= htmlspecialchars($job["start"]) ?>
                      <?php if (!empty($job["end"])): ?>
                        إلى <?= htmlspecialchars($job["end"]) ?>
                      <?php else: ?>
                        (مستمر)
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" style="text-align: center;">لا توجد وظائف متاحة</td>
                </tr>
              <?php endif; ?>
            </table>
          </div>

          <!-- الوظائف السابقة Section -->
          <div class="block experinces">
            <h2>الوظائف السابقة</h2>
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:right;">
              <tr>
                <th>المسمى الوظيفي</th>
                <th>الوصف</th>
                <th>الراتب</th>
                <th>الفترة</th>
              </tr>
              <?php if (!empty($previousJobs)): ?>
                <?php foreach ($previousJobs as $job): ?>
                  <tr>
                    <td><?= htmlspecialchars($job["name"]) ?></td>
                    <td><?= htmlspecialchars($job["description"]) ?></td>
                    <td><?= htmlspecialchars($job["salary"]) ?> ريال</td>
                    <td>
                      من <?= htmlspecialchars($job["start"]) ?>
                      إلى <?= htmlspecialchars($job["end"]) ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="4" style="text-align: center;">لا توجد وظائف سابقة</td>
                </tr>
              <?php endif; ?>
            </table>
          </div>

          <!-- Applications Section (Only for company owner) -->
          <?php if($isOwner): ?>
          <div class="block experinces">
            <h2>الطلبات المقدمة</h2>
            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:right;">
              <tr>
                <th>المسمى الوظيفي</th>
                <th>المتقدم</th>
                <th>الراتب</th>
                <th>تاريخ التقديم</th>
                <th>الإجراء</th>
              </tr>
              <?php if (!empty($applications)): ?>
                <?php foreach ($applications as $application): ?>
                  <tr>
                    <td><?= htmlspecialchars($application["job_title"]) ?></td>
                    <td><?= htmlspecialchars($application["applicant_name"]) ?></td>
                    <td><?= htmlspecialchars($application["salary"]) ?> ريال</td>
                    <td><?= htmlspecialchars($application["applied_at"]) ?></td>
                    <td>
                      <?php if ($application["status"] === "pending"): ?>
                        <form action="update_application_status.php" method="POST" style="display:inline;">
                          <input type="hidden" name="application_id" value="<?= $application['id']; ?>">
                          <input type="hidden" name="status" value="accepted">
                          <button type="submit" class="accept-btn">قبول</button>
                        </form>
                        <form action="update_application_status.php" method="POST" style="display:inline;">
                          <input type="hidden" name="application_id" value="<?= $application['id']; ?>">
                          <input type="hidden" name="status" value="rejected">
                          <button type="submit" class="reject-btn">رفض</button>
                        </form>
                      <?php else: ?>
                        <span class="<?= $application["status"] === 'accepted' ? 'accepted' : 'rejected'; ?>">
                          <?= $application["status"] === "accepted" ? "✔ مقبول" : "✖ مرفوض"; ?>
                        </span>
                      <?php endif; ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="5" style="text-align: center;">لا توجد طلبات حتى الآن</td>
                </tr>
              <?php endif; ?>
            </table>
          </div>
          <?php endif; ?>
        </section>
      </main>
    </section>
  </section>

  <!-- JavaScript to toggle inline edit forms -->
  <script>
    function toggleEdit(section) {
      var displayDiv, editDiv;
      
      if (section === 'companyName') {
        displayDiv = document.getElementById('companyNameDisplay');
        editDiv = document.getElementById('companyNameEdit');
      } else if (section === 'companyAbout') {
        displayDiv = document.getElementById('companyAboutDisplay');
        editDiv = document.getElementById('companyAboutEdit');
      } else if (section === 'companyContact') {
        displayDiv = document.getElementById('companyContactDisplay');
        editDiv = document.getElementById('companyContactEdit');
      } else if (section === 'new_certificate') {
        editDiv = document.getElementById('certEdit-new_certificate');
      } else if (section.indexOf('cert-') === 0) {
        editDiv = document.getElementById('certEdit-' + section.split('-')[1]);
      }
      
      if (editDiv) {
        if (editDiv.style.display === 'none' || editDiv.style.display === '') {
          editDiv.style.display = 'block';
          if (displayDiv) displayDiv.style.display = 'none';
        } else {
          editDiv.style.display = 'none';
          if (displayDiv) displayDiv.style.display = 'block';
        }
      }
    }
    
    function toggleExpEdit(expId) {
      var expRow = document.getElementById('expEdit-' + expId);
      if (expRow.style.display === 'none' || expRow.style.display === '') {
        expRow.style.display = 'table-row';
      } else {
        expRow.style.display = 'none';
      }
    }
  </script>
</body>
</html>
