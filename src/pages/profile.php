<?php
session_start();
include '../database/fetch.php';
$user = $_SESSION['user'];
$skills = fetchAllSkillsNameByUserID($user['id']);
$about = $user['bio'];
$email = $user['email'];
$phone = $user['phone'];
$linkedin = "https://www.linkedin.com/in/username";
$jobs = [
    [
        "title" => "مطور ويب",
        "company" => "شركة أ",
        "duration" => "4 شهور"
    ],
    [
        "title" => "مطور ويب",
        "company" => "شركة ب",
        "duration" => "2 شهور"
    ]
];
$prevJobs = [
    [
        "title" => "مطور ويب",
        "company" => "شركة أ",
        "duration" => "4 شهور",
        "company_id" => 1
    ],
    [
        "title" => "مطور ويب",
        "company" => "شركة ب",
        "duration" => "2 شهور",
        "company_id" => 2
    ]
];
$corses = ["دورة تطوير الويب", "دورة تصميم الواجهات"];
?>
<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles/profile.css">
    <title>الملف الشخصي</title>
</head>

<body>
    <section class="page-structure">
        <?php include "../components/NavBar.php" ?>
        <section class="page-content">
            <div class="username">
                <img class="profile-pic" src="../images/profile.svg" alt="صورة المستخدم">
                <div class="user">
                    <h2><?= $user['name'] ?></h2>
                </div>
            </div>
            <div class="options">
                <a href="#">
                    <img class="nav-icon" src="../images/settings.svg" alt="شعار الإعدادت">
                </a>
                <a href="#">
                    <img class="nav-icon" style="--color: #DF4F4F" src="../images/logout.svg" alt="شعار تسجيل الخروج">
                </a>
            </div>
            <header>
            </header>

            <main>
                <section class="profile-details">
                    <!-- we have here three sections
                     about
                     skills
                     contacts -->
                    <div class="block about">
                        <h2>نبذة</h2>
                        <p><?php echo $about; ?></p>
                    </div>
                    <div class="block skills">
                        <h2>المهارات</h2>
                        <ul>
                            <?php
                            foreach ($skills as $skill) {
                                echo "<li>$skill</li>";
                            }
                            ?>
                        </ul>
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
                            <!-- linkedin -->
                            <li>لينكد إن:
                                <a href="<?php echo $linkedin; ?>"><?php echo $linkedin; ?></a>
                            </li>
                        </ul>
                </section>

                <section class="recent-activity">
                    <!-- here we will add previus jobs and how many monthes as "history" like this ([Company A] 4 monthes   [Company B] 2 monthes) as list then add table for "experinces" and last add "courses and certifcates" each part will be in deferent section-->
                    <div class="block history">
                        <h2>السجل</h2>
                        <ul>
                            <?php
                            foreach ($prevJobs as $job) {
                                echo "<li><span class='company'><a href='./company.php?id={$job["company_id"]}'>{$job["company"]}</a></span> {$job["duration"]}</li>";
                            }
                            ?>

                        </ul>
                    </div>
                    <div class="block experinces">
                        <h2>الخبرات</h2>
                        <table>
                            <tr>
                                <th>المسمى الوظيفي</th>
                                <th>الشركة</th>
                                <th>المدة</th>
                            </tr>
                            <?php
                            foreach ($jobs as $job) {
                            ?>
                                <tr>
                                    <td><?php echo $job["title"]; ?></td>
                                    <td><?php echo $job["company"]; ?></td>
                                    <td><?php echo $job["duration"]; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>
                    </div>
                    <div class="block courses">
                        <h2>الدورات والشهادات</h2>
                        <ul>
                            <?php
                            foreach ($corses as $cours) {
                                echo "<li>$cours</li>";
                            }
                            ?>
                        </ul>
                    </div>


                </section>
            </main>
        </section>
    </section>
</body>

</html>