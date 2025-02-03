<?php
include "../database/fetch.php";
session_start();
$id = $_GET["id"] ?? 'No id specified';
$name = "اسم الشركة" . $id;
$specialty = "التخصص";
$about = "أنا الشركة " . $id . " وأعمل في مجال " . $specialty;
$email = "company@eny.sa";
$phone = "+966 123 456 789";
$linkedin = "https://www.linkedin.com/in/username";
$jobs = [
    [
        "title" => "مطور ويب",
        "start" => "2024-12-2",
        "duration" => "4 شهور"
    ],
    [
        "title" => "مطور اندرويد",
        "start" => "2024-1-2",
        "duration" => "2 شهور"
    ]
];
$prevJobs = [
    [
        "title" => "جوازات",
        "start" => "2021-12-2",
        "duration" => "4 شهور"
    ],
    [
        "title" => "مدخل بيانات",
        "start" => "2019-1-2",
        "duration" => "2 شهور"
    ]
];

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
                                <a href="<?php echo $linkedin; ?>" target="_blank"><?php echo $name; ?></a>
                            </li>
                        </ul>
                </section>

                <section class="recent-activity">
                    <!-- here we will add previus jobs and how many monthes as "history" like this ([Company A] 4 monthes   [Company B] 2 monthes) as list then add table for "experinces" and last add "courses and certifcates" each part will be in deferent section-->
                    <!-- <div class="block history">
                        <h2>سجل</h2>
                        <ul>
                            <-- the name will be inside a green box but the monthes will be outside ->
                            <li><span class="company">شركة أ</span> 4 شهور</li>
                            <li><span class="company">شركة ب</span> 2 شهور</li>

                        </ul>
                    </div> -->
                    <div class="block experinces">
                        <h2>الوظائف المتاحة</h2>
                        <table>
                            <tr>
                                <th>المسمى الوظيفي</th>
                                <th>البداية</th>
                                <th>المدة</th>
                            </tr>
                            <?php
                            foreach ($jobs as $job) {
                            ?>
                                <tr>
                                    <td><?php echo $job["title"]; ?></td>
                                    <td><?php echo $job["start"]; ?></td>
                                    <td><?php echo $job["duration"]; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>

                    </div>
                    <div class="block experinces brown">
                        <h2>الوظائف السابقة</h2>
                        <table>
                            <tr>
                                <th>المسمى الوظيفي</th>
                                <th>البداية</th>
                                <th>المدة</th>
                            </tr>
                            <?php
                            foreach ($prevJobs as $job) {
                            ?>
                                <tr>
                                    <td><?php echo $job["title"]; ?></td>
                                    <td><?php echo $job["start"]; ?></td>
                                    <td><?php echo $job["duration"]; ?></td>
                                </tr>
                            <?php
                            }
                            ?>
                        </table>

                    </div>


                </section>
            </main>
        </section>
    </section>
</body>

</html>