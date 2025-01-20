<?php
$navList = [
  [
    "title" => "سيرتي",
    "icon" => "cv.svg",
    "alt" => "شعار السيرة الذاتية",
    "link" => "./profile.php"
  ],
  [
    "title" => "الشركات",
    "icon" => "company.svg",
    "alt" => "شعار الشركات",
    "link" => "./company.php"
  ]
];

if (isset($customNavList)) {
  $navList = array_merge($navList, $customNavList);
}
?>

<?php if (isset($navList) && is_array($navList)): ?>
  <nav class="main-navigation">
    <a href="./index.php" class="logo-link">
      <img src="Logo.png" alt="موسمي">
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