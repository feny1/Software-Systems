<?php
include ('../components/page.php');
include ('../database/data.php'); 

$company_id = isset($_GET["id"]) ? intval($_GET["id"]) : ($_SESSION['user']['company_id'] ?? 0);

$stmt = $db->prepare("SELECT * FROM company WHERE company_id = :company_id");
$stmt->bindValue(':company_id', $company_id, SQLITE3_INTEGER);
$result = $stmt->execute()->fetchArray(SQLITE3_ASSOC);


$name = $result['name'] ?? 'غير معروف';
$specialty = $result['bio'] ?? 'لا توجد معلومات';
$email = $result['email'] ?? 'غير متوفر';
$phone = $result['phone'] ?? 'غير متوفر';
$linkedin = $result['linkedin'] ?? '#';

$jobs = fetchAllCompanyJobs($company_id);
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/profile.css">
    <title><?php echo $name; ?></title>
</head>

<body>
    <section class="page-structure">

        <?php
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
            <div class="username">
                <img class="profile-pic" src="../images/company.svg" alt="صورة المستخدم">
                <div class="user">
                    <h2><?php echo $name; ?></h2>
                    <h3><?php echo $specialty; ?></h3>
                </div>
            </div>
            <div class="options">
                <a href="../pages/logout.php">
                    <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل الخروج">
                </a>
            </div>
            <header></header>

            <main>
                <section class="profile-details">
                    <div class="block about">
                        <h2>نبذة</h2>
                        <p><?php echo $specialty; ?></p>
                    </div>
                    <div class="block contacts">
                        <h2>معلومات الاتصال</h2>
                        <ul>
                            <li>البريد الإلكتروني:
                                <a href="mailto:<?php echo $email; ?>"><?php echo $email; ?></a>
                            </li>
                            <li>رقم الهاتف:
                                <a href="tel:<?php echo $phone; ?>"><?php echo $phone; ?></a>
                            </li>
                            <li>لينكد إن:
                                <a href="<?php echo $linkedin; ?>" target="_blank"><?php echo $name; ?></a>
                            </li>
                        </ul>
                    </div>
                </section>

                <section class="recent-activity">
                    <div class="block experinces">
                        <h2>الوظائف المتاحة</h2>
                        <table>
                            <tr>
                                <th>المسمى الوظيفي</th>
                                <th>الوصف</th>
                                <th>الراتب</th>
                            </tr>
                            <?php if (!empty($jobs)): ?>
                                <?php foreach ($jobs as $job): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($job["name"]); ?></td>
                                        <td><?php echo htmlspecialchars($job["description"]); ?></td>
                                        <td><?php echo htmlspecialchars($job["salary"]); ?> ريال</td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="3" style="text-align: center;">لا توجد وظائف متاحة</td>
                                </tr>
                            <?php endif; ?>
                        </table>
                    </div>
                </section>
            </main>
        </section>
    </section>
</body>

</html>
