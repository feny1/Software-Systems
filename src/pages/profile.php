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
                        <h2>اسم المستخدم</h2>
                        <h3>التخصص</h3>
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
                        <p>أنا مطور ويب محترف، أعمل في مجال تطوير الويب منذ 5 سنوات.</p>
                    </div>
                    <div class="block skills">
                        <h2>المهارات</h2>
                        <ul>
                            <li>HTML</li>
                            <li>CSS</li>
                            <li>JavaScript</li>
                            <li>PHP</li>
                        </ul>
                    </div>
                    <div class="block contacts">
                        <h2>معلومات الاتصال</h2>
                        <ul>
                            <li>البريد الإلكتروني:
                                <a href="mailto:feny@eny.sa">feny@eny.sa</a>
                            </li>
                            <li>رقم الهاتف:
                                <a href="tel:+966123456789">+966 123 456 789</a>
                            </li>
                            <!-- linkedin -->
                            <li>لينكد إن:
                                <a href="https://www.linkedin.com/in/username" target="_blank">Feny</a>
                             </li>
                        </ul>
                </section>

                <section class="recent-activity">
                    <!-- here we will add previus jobs and how many monthes as "history" like this ([Company A] 4 monthes   [Company B] 2 monthes) as list then add table for "experinces" and last add "courses and certifcates" each part will be in deferent section-->
                    <div class="block history">
                        <h2>السجل</h2>
                        <ul>
                            <!-- the name will be inside a green box but the monthes will be outside -->
                            <li><span class="company">شركة أ</span> 4 شهور</li>
                            <li><span class="company">شركة ب</span> 2 شهور</li>
                             
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
                            <tr>
                                <td>مطور ويب</td>
                                <td>شركة أ</td>
                                <td>4 شهور</td>
                            </tr>
                            <tr>
                                <td>مطور ويب</td>
                                <td>شركة ب</td>
                                <td>2 شهور</td>
                            </tr>
                        </table>
                    </div>
                    <div class="block courses">
                        <h2>الدورات والشهادات</h2>
                        <ul>
                            <li>دورة تطوير الويب</li>
                            <li>دورة تصميم الواجهات</li>
                        </ul>
                    </div>

                     
                </section>
            </main>
        </section>
    </section>
</body>

</html>