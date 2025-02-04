<?php
$user = $_SESSION["user"] ?? null;
$navList = $navList ?? [];

$current_page = basename($_SERVER['PHP_SELF']);

if (isset($user) && isset($user["type"])) {
    array_push(
        $navList,
        [
            "title" => "الملف",
            "icon" => "cv.svg",
            "alt" => "شعار السيرة الذاتية",
            "link" => "./profile.php"
        ]
    );
    if ($user["type"] == 0) {
        array_push($navList, [
            "title" => "الوظائف",
            "icon" => "jobs.svg",
            "alt" => "شعار الوظائف",
            "link" => "./job_listing.php"
        ]);
    } else {
        array_push($navList, [
            "title" => "الشركة",
            "icon" => "company.svg",
            "alt" => "شعار الشركات",
            "link" => "./company.php"
        ]);
    }
}

if (isset($customNavList)) {
    $navList = array_merge($navList, $customNavList);
}
?>

<?php if (isset($navList) && is_array($navList)): ?>
  <nav class="main-navigation">
    <a href="./index.php" class="logo-link">
      موسمي
    </a>

    <ul>
      <?php foreach ($navList as $nav): ?>
        <li>
          <a href="<?= $nav['link']; ?>" class="nav-path">
            <span><?= $nav['title']; ?></span>
            <img src="../images/<?= $nav['icon']; ?>" alt="<?= $nav['alt']; ?>">
          </a>
        </li>
      <?php endforeach; ?>
    </ul>

    <?php if ($current_page !== "job_listing.php"): ?>  
        <div class="view-jobs-container">
            <a href="./job_listing.php" class="view-jobs-btn">عرض الوظائف</a>
        </div>
    <?php endif; ?>

  </nav>
<?php else: ?>
  <nav class="main-navigation">
    <p>Navigation list is not defined.</p>
  </nav>
<?php endif; ?>
