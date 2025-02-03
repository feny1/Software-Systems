<?php
$user = $_SESSION["user"] ?? null;
$navList = $navList ?? [

];

// if user is employee or company owner
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
  </nav>
<?php else: ?>
  <nav class="main-navigation">
    <p>Navigation list is not defined.</p>
  </nav>
<?php endif; ?>