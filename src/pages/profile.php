<?php
include('../components/page.php');
// No need for session_start(); as requested

// If neither a GET id nor a logged-in user exists, redirect to login.
if (!isset($_GET['id']) && !isset($_SESSION['user'])) {
    header("Location: ./login.php");
    exit;
}

// Retrieve the user: either from the session or via GET id.
$user = isset($_GET['id'])?getUserById($_GET['id']) : $_SESSION['user'];
$name = $user['name'];

// Determine if the logged-in user is the owner of this profile.
$isOwner = (isset($_SESSION['user']) && $_SESSION['user']['id'] == $user['id']);

// --- PROCESS INLINE UPDATES ---
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Process About (bio) update
    if ($isOwner && isset($_POST['update_about'])) {
        $newBio = $_POST['bio'] ?? '';
        $stmt = $db->prepare("UPDATE users SET bio = :bio WHERE id = :id");
        $stmt->bindValue(':bio', $newBio, SQLITE3_TEXT);
        $stmt->bindValue(':id', $user['id'], SQLITE3_INTEGER);
        $stmt->execute();
        $user = getUserById($user['id']);
    }
    // Process Contact update (phone and linkedin)
    if ($isOwner && isset($_POST['update_contact'])) {
        $newPhone = isset($_POST['phone']) && trim($_POST['phone']) !== '' ? trim($_POST['phone']) : 'لا يوجد';
        $newLinkedin = isset($_POST['linkedin']) && trim($_POST['linkedin']) !== '' ? trim($_POST['linkedin']) : 'لا يوجد';
        $stmt = $db->prepare("UPDATE users SET phone = :phone, linkedin = :linkedin WHERE id = :id");
        $stmt->bindValue(':phone', $newPhone, SQLITE3_TEXT);
        $stmt->bindValue(':linkedin', $newLinkedin, SQLITE3_TEXT);
        $stmt->bindValue(':id', $user['id'], SQLITE3_INTEGER);
        $stmt->execute();
        $user = getUserById($user['id']);
    }
    // Process Skills update
    if ($isOwner && isset($_POST['update_skills'])) {
        $newSkills = trim($_POST['skills'] ?? '');
        $db->exec("DELETE FROM skills WHERE user_id = {$user['id']}");
        $lines = preg_split('/\r\n|\r|\n/', $newSkills);
        foreach ($lines as $skill) {
            $skill = trim($skill);
            if ($skill !== '') {
                $stmt = $db->prepare("INSERT INTO skills (user_id, name, soft) VALUES (:user_id, :name, 0)");
                $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
                $stmt->bindValue(':name', $skill, SQLITE3_TEXT);
                $stmt->execute();
            }
        }
    }
    // Process Certificate addition
    if ($isOwner && isset($_POST['add_certificate'])) {
        $certName = trim($_POST['cert_name'] ?? '');
        $certDesc = trim($_POST['cert_desc'] ?? '');
        $certCompany = trim($_POST['cert_company'] ?? '');
        if ($certName !== '') {
            $stmt = $db->prepare("INSERT INTO certificates (user_id, name, description, company) VALUES (:user_id, :name, :description, :company)");
            $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
            $stmt->bindValue(':name', $certName, SQLITE3_TEXT);
            $stmt->bindValue(':description', $certDesc, SQLITE3_TEXT);
            $stmt->bindValue(':company', $certCompany, SQLITE3_TEXT);
            $stmt->execute();
            header("Location: ./profile.php");
            exit;
        }
    }
    // Process Certificate update (edit existing certificate)
    if ($isOwner && isset($_POST['update_certificate'])) {
        $certId = $_POST['cert_id'] ?? 0;
        $certName = trim($_POST['cert_name'] ?? '');
        $certDesc = trim($_POST['cert_desc'] ?? '');
        $certCompany = trim($_POST['cert_company'] ?? '');
        if ($certId && $certName !== '') {
            $stmt = $db->prepare("UPDATE certificates SET name = :name, description = :description, company = :company WHERE certificate_id = :cert_id AND user_id = :user_id");
            $stmt->bindValue(':name', $certName, SQLITE3_TEXT);
            $stmt->bindValue(':description', $certDesc, SQLITE3_TEXT);
            $stmt->bindValue(':company', $certCompany, SQLITE3_TEXT);
            $stmt->bindValue(':cert_id', $certId, SQLITE3_INTEGER);
            $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
            $stmt->execute();
        }
    }
    // Process Certificate deletion
    if ($isOwner && isset($_POST['delete_certificate'])) {
        $certId = $_POST['cert_id'] ?? 0;
        if ($certId) {
            $stmt = $db->prepare("DELETE FROM certificates WHERE certificate_id = :cert_id AND user_id = :user_id");
            $stmt->bindValue(':cert_id', $certId, SQLITE3_INTEGER);
            $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
            $stmt->execute();
        }
    }
    // --- EXPERIENCE INLINE PROCESSING ---
    // Process Experience update (edit existing experience)
    if ($isOwner && isset($_POST['update_experience'])) {
        $expId = $_POST['exp_id'] ?? 0;
        $expName = trim($_POST['exp_name'] ?? '');
        $expCompany = trim($_POST['exp_company'] ?? '');
        $expYears = trim($_POST['exp_years'] ?? '');
        if ($expId && $expName !== '') {
            $stmt = $db->prepare("UPDATE experience SET name = :name, company = :company, years = :years WHERE experience_id = :exp_id AND user_id = :user_id");
            $stmt->bindValue(':name', $expName, SQLITE3_TEXT);
            $stmt->bindValue(':company', $expCompany, SQLITE3_TEXT);
            $stmt->bindValue(':years', $expYears, SQLITE3_INTEGER);
            $stmt->bindValue(':exp_id', $expId, SQLITE3_INTEGER);
            $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
            $stmt->execute();
        }
    }
    // Process Experience deletion
    if ($isOwner && isset($_POST['delete_experience'])) {
        $expId = $_POST['exp_id'] ?? 0;
        if ($expId) {
            $stmt = $db->prepare("DELETE FROM experience WHERE experience_id = :exp_id AND user_id = :user_id");
            $stmt->bindValue(':exp_id', $expId, SQLITE3_INTEGER);
            $stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
            $stmt->execute();
        }
    }
}

// Refresh basic data after updates.
$about    = $user['bio'];
$email    = $user['email'];
$phone    = $user['phone'];
$linkedin = !empty($user['linkedin']) ? $user['linkedin'] : ("https://www.linkedin.com/in/" . urlencode(str_replace(' ', '', strtolower($user['name']))));

// Fetch skills.
$skills = fetchAllSkillsNameByUserID($user['id']);

// Fetch experiences (jobs) from the database.
$jobs = fetchAllExperienceByUserID($user['id']);
$prevJobs = [];
foreach ($jobs as $job) {
    // Format the duration as "X سنة"
    $job['duration'] = $job['years'] . " سنة";
    $prevJobs[] = $job;
}

// Fetch certificates.
$stmt = $db->prepare("SELECT * FROM certificates WHERE user_id = :user_id");
$stmt->bindValue(':user_id', $user['id'], SQLITE3_INTEGER);
$result = $stmt->execute();
$certificates = [];
while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
    $certificates[] = $row;
}
?>

<?php
$user_id = $user['id'];
$responses = fetchResponseByUserID($user_id);
?>


<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/profile.css">
    <title>الملف الشخصي</title>
    <style>
        /* Optional inline styles for the edit forms */
        .edit-form,
        .cert-edit-form {
            border: 1px solid #ccc;
            padding: 10px;
            margin-top: 10px;
            background-color: #fefefe;
        }

        .edit-btn,
        .cancel-btn,
        .delete-btn {
            cursor: pointer;
            text-decoration: underline;
            margin-left: 5px;
        }

        .edit-btn {
            color: blue;
        }

        .delete-btn {
            color: red;
        }

        /* Experience inline edit row styling */
        .exp-edit-row {
            background-color: #fafafa;
        }

        .block .applications {
            background-color: #fff;
            padding: 1.5rem;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
        }

        tbody tr:first-of-type {
            background-color: var(--main-color);
            color: var(--white-color);
            border: 0;
        }

        tbody tr:first-of-type th {
            padding: .5rem;
            text-align: center;
            color: var(--white-color)
        }
    </style>
</head>

<body>
    <section class="page-structure">
        <?php include "../components/NavBar.php"; ?>
        <section class="page-content">
            <div class="username">
                <img class="profile-pic" src="../images/profile.svg" alt="صورة المستخدم">
                <div class="user">
                    <h2><?= htmlspecialchars($name) ?></h2>
                </div>
            </div>
            <div class="options">
                <a href="./logout.php">
                    <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل الخروج">
                </a>
            </div>
            <header></header>

            <main>
                <section class="profile-details">
                    <!-- About Section -->
                    <div class="block about">
                        <h2>نبذة</h2>
                        <div id="aboutDisplay">
                            <p><?= $about ?></p>
                            <?php if ($isOwner): ?>
                                <span class="edit-btn" onclick="toggleEdit('about')">[تعديل]</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($isOwner): ?>
                            <div id="aboutEdit" class="edit-form" style="display: none;">
                                <form method="POST" action="">
                                    <textarea name="bio" rows="4"><?= $about ?></textarea>
                                    <input type="hidden" name="update_about" value="1">
                                    <br>
                                    <button type="submit">حفظ</button>
                                    <button type="button" onclick="toggleEdit('about')">إلغاء</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Skills Section -->
                    <div class="block skills">
                        <h2>المهارات</h2>
                        <div id="skillsDisplay">
                            <ul>
                                <?php foreach ($skills as $skill): ?>
                                    <li><?= $skill ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <?php if ($isOwner): ?>
                                <span class="edit-btn" onclick="toggleEdit('skills')">[تعديل المهارات]</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($isOwner): ?>
                            <div id="skillsEdit" class="edit-form" style="display: none;">
                                <form method="POST" action="">
                                    <textarea name="skills" rows="4" placeholder="اكتب كل مهارة في سطر منفصل"><?php echo implode("\n", $skills); ?></textarea>
                                    <input type="hidden" name="update_skills" value="1">
                                    <br>
                                    <button type="submit">حفظ</button>
                                    <button type="button" onclick="toggleEdit('skills')">إلغاء</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>

                    <!-- Contacts Section -->
                    <div class="block contacts">
                        <h2>معلومات الاتصال</h2>
                        <div id="contactDisplay">
                            <ul>
                                <li>البريد الإلكتروني:
                                    <a href="mailto:<?= $email ?>"><?= $email ?? 'لا يوجد' ?></a>
                                </li>
                                <li>رقم الهاتف:
                                    <a href="tel:<?= $phone ?>"><?= $phone ?? 'لا يوجد' ?></a>
                                </li>
                                <li>لينكد إن:
                                    <a href="<?= $linkedin ?>"><?= $linkedin ?? 'لا يوجد' ?></a>
                                </li>
                            </ul>
                            <?php if ($isOwner): ?>
                                <span class="edit-btn" onclick="toggleEdit('contact')">[تعديل]</span>
                            <?php endif; ?>
                        </div>
                        <?php if ($isOwner): ?>
                            <div id="contactEdit" class="edit-form" style="display: none;">
                                <form method="POST" action="">
                                    <label>رقم الهاتف:
                                        <input type="text" name="phone" value="<?= htmlspecialchars($phone) ?>">
                                    </label>
                                    <br>
                                    <label>لينكد إن:
                                        <input type="text" name="linkedin" value="<?= htmlspecialchars($linkedin) ?>">
                                    </label>
                                    <br>
                                    <input type="hidden" name="update_contact" value="1">
                                    <button type="submit">حفظ</button>
                                    <button type="button" onclick="toggleEdit('contact')">إلغاء</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>

                <section class="recent-activity">

                        <?php if($isOwner){ ?>
                    <div class="block applications">
                        <h2>طلبات الوظائف المقدمة</h2>
                        <table cellpadding="5" cellspacing="0" style="width:100%; text-align:right;">
                            <tr>
                                <th>المسمى الوظيفي</th>
                                <th>الشركة</th>
                                <th>تاريخ التقديم</th>
                                <th>الحالة</th>
                            </tr>
                            <?php if (!empty($responses)): ?>
                                <?php foreach ($responses as $response): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($response["job_title"]) ?></td>
                                        <td><?= htmlspecialchars($response["company_name"]) ?></td>
                                        <td><?= htmlspecialchars($response["applied_at"]) ?></td>
                                        <td class="<?= $response["status"] === "accepted" ? "accepted" : ($response["status"] === "rejected" ? "rejected" : "pending") ?>">
                                            <?php
                                            if ($response["status"] === "accepted") {
                                                echo "✔ مقبول";
                                            } elseif ($response["status"] === "rejected") {
                                                echo "✖ مرفوض";
                                            } else {
                                                echo "⏳ قيد المراجعة";
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="4" style="text-align: center;">لم يتم التقديم على أي وظيفة بعد</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                    <?php } ?>


                    <!-- History Section (السجل) - Display Only -->
                    <div class="block history">
                        <h2>السجل</h2>
                        <?php if (count($prevJobs) === 0): ?>
                            <h3 class="no-jobs">لا يوجد سجل سابقة</h3>
                        <?php endif ?>
                        <ul>
                            <?php foreach ($prevJobs as $job): ?>
                                <li>
                                    <span class="company">
                                        <?php if (!empty($job['company_id'])): ?>
                                            <a href="./company.php?id=<?= htmlspecialchars($job['company_id']) ?>">
                                                <?= htmlspecialchars($job['company']) ?>
                                            </a>
                                        <?php else: ?>
                                            <?= htmlspecialchars($job['company']) ?>
                                        <?php endif; ?>
                                    </span>
                                    <?= htmlspecialchars($job['duration']) ?>
                                    <!-- No edit/delete options for السجل -->
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    </div>

                    <!-- Experiences Section with inline editing for each experience -->
                    <div class="block experinces">
                        <h2>الخبرات</h2>
                        <?php if (count($jobs) === 0): ?>
                            <h3 class="no-jobs">لا يوجد خبرات سابقة</h3>
                        <?php else: ?>
                            <table border="1" cellpadding="5" cellspacing="0" style="width:100%; text-align:right;">
                                <tr>
                                    <th>المسمى الوظيفي</th>
                                    <th>الشركة</th>
                                    <th>المدة</th>
                                    <?php if ($isOwner): ?>
                                        <th>الإجراءات</th>
                                    <?php endif; ?>
                                </tr>
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($job['name']) ?></td>
                                        <td><?= htmlspecialchars($job['company']) ?></td>
                                        <td><?= htmlspecialchars($job['years']) ?> سنة</td>
                                        <?php if ($isOwner): ?>
                                            <td>
                                                <button type="button" onclick="toggleExpEdit(<?= $job['experience_id'] ?>)">تعديل</button>
                                                <form method="POST" action="" class="delete-form" style="display:inline;" onsubmit="return confirm('هل أنت متأكد من حذف الخبرة؟');">
                                                    <input type="hidden" name="exp_id" value="<?= $job['experience_id'] ?>">
                                                    <input type="hidden" name="delete_experience" value="1">
                                                    <button type="submit" class="delete-btn">حذف</button>
                                                </form>
                                            </td>
                                        <?php endif; ?>
                                    </tr>
                                    <?php if ($isOwner): ?>
                                        <!-- Inline Experience Edit Row (hidden by default) -->
                                        <tr id="expEdit-<?= $job['experience_id'] ?>" class="exp-edit-row" style="display:none;">
                                            <td colspan="4">
                                                <form method="POST" action="">
                                                    <input type="hidden" name="exp_id" value="<?= $job['experience_id'] ?>">
                                                    <label>المسمى الوظيفي:</label>
                                                    <input type="text" name="exp_name" value="<?= htmlspecialchars($job['name']) ?>" required>
                                                    <label>الشركة:</label>
                                                    <input type="text" name="exp_company" value="<?= htmlspecialchars($job['company']) ?>">
                                                    <label>عدد السنوات:</label>
                                                    <input type="number" name="exp_years" value="<?= htmlspecialchars($job['years']) ?>" min="0" required>
                                                    <input type="hidden" name="update_experience" value="1">
                                                    <button type="submit">حفظ</button>
                                                    <button type="button" onclick="toggleExpEdit(<?= $job['experience_id'] ?>)">إلغاء</button>
                                                </form>
                                            </td>
                                        </tr>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </table>
                        <?php endif ?>
                    </div>

                    <!-- Certificates / Courses Section with inline add, edit, and delete forms -->
                    <div class="block courses">
                        <h2>الدورات والشهادات</h2>
                        <ul id="certificatesList">
                            <?php if (count($certificates) === 0): ?>
                                <li>لا توجد بيانات</li>
                            <?php else: ?>
                                <?php foreach ($certificates as $cert): ?>
                                    <li id="cert-<?= $cert['certificate_id'] ?>">
                                        <strong><?= htmlspecialchars($cert['name']) ?></strong>
                                        <?php if (!empty($cert['description'])): ?>
                                            - <?= htmlspecialchars($cert['description']) ?>
                                        <?php endif; ?>
                                        <?php if (!empty($cert['company'])): ?>
                                            (<?= htmlspecialchars($cert['company']) ?>)
                                        <?php endif; ?>
                                        <?php if ($isOwner): ?>
                                            <span class="edit-btn" onclick="toggleEdit('cert-<?= $cert['certificate_id'] ?>')">[تعديل]</span>
                                            <div id="certEdit-<?= $cert['certificate_id'] ?>" class="cert-edit-form" style="display: none;">
                                                <form method="POST" action="">
                                                    <input type="hidden" name="cert_id" value="<?= $cert['certificate_id'] ?>">
                                                    <label>اسم الشهادة / الدورة:</label>
                                                    <input type="text" name="cert_name" value="<?= htmlspecialchars($cert['name']) ?>" required>
                                                    <br>
                                                    <label>الوصف:</label>
                                                    <textarea name="cert_desc" rows="3"><?= htmlspecialchars($cert['description']) ?></textarea>
                                                    <br>
                                                    <label>الشركة (إن وجدت):</label>
                                                    <input type="text" name="cert_company" value="<?= htmlspecialchars($cert['company']) ?>">
                                                    <br>
                                                    <input type="hidden" name="update_certificate" value="1">
                                                    <button type="submit">حفظ</button>
                                                    <button type="button" onclick="toggleEdit('cert-<?= $cert['certificate_id'] ?>')">إلغاء</button>
                                                </form>
                                            </div>
                                            <form method="POST" action="" class="delete-form" onsubmit="return confirm('هل أنت متأكد من حذف الشهادة؟');">
                                                <input type="hidden" name="cert_id" value="<?= $cert['certificate_id'] ?>">
                                                <input type="hidden" name="delete_certificate" value="1">
                                                <button type="submit" class="delete-btn">[حذف]</button>
                                            </form>
                                        <?php endif; ?>
                                    </li>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </ul>
                        <?php if ($isOwner): ?>
                            <span class="edit-btn" onclick="toggleEdit('new_certificate')">[إضافة شهادة/دورة جديدة]</span>
                            <div id="certEdit-new_certificate" class="edit-form" style="display: none;">
                                <form method="POST" action="">
                                    <label>اسم الشهادة / الدورة:</label>
                                    <input type="text" name="cert_name" required>
                                    <br>
                                    <label>الوصف:</label>
                                    <textarea name="cert_desc" rows="3"></textarea>
                                    <br>
                                    <label>الشركة (إن وجدت):</label>
                                    <input type="text" name="cert_company">
                                    <br>
                                    <input type="hidden" name="add_certificate" value="1">
                                    <button type="submit">حفظ</button>
                                    <button type="button" onclick="toggleEdit('new_certificate')">إلغاء</button>
                                </form>
                            </div>
                        <?php endif; ?>
                    </div>
                </section>
            </main>
        </section>
    </section>

    <!-- JavaScript to toggle inline edit forms -->
    <script>
        // Generic toggle for sections like about, contact, skills, and certificates.
        function toggleEdit(section) {
            var displayDiv, editDiv;

            if (section === 'about') {
                displayDiv = document.getElementById('aboutDisplay');
                editDiv = document.getElementById('aboutEdit');
            } else if (section === 'contact') {
                displayDiv = document.getElementById('contactDisplay');
                editDiv = document.getElementById('contactEdit');
            } else if (section === 'skills') {
                displayDiv = document.getElementById('skillsDisplay');
                editDiv = document.getElementById('skillsEdit');
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

        // Toggle function for experience inline edit rows.
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