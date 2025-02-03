<?php
include ('../components/page.php');
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>موسمي</title>
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      text-decoration: none;
    }

    a {
      display: block;
    }

    body {
      font-family: Arial, sans-serif;
      margin: 0;
      padding: 0;
      color: #fff;
      background-image: url('../images/Rectangle\ 1.png');
      background-repeat: no-repeat;
      background-size: cover;
      background-position: center;
      display: flex;
      flex-direction: column;
      height: 100vh;
    }

    body::before {
      content: "";
      position: absolute;
      width: 100%;
      height: 100%;
      background-color: rgba(20, 49, 43, 0.3);
      filter: blur(10px);
      z-index: -1;
    }

    .header {
      display: flex;
      justify-content: space-between;
      background-color: rgba(3, 76, 60, 1);
      padding: 0 32px;
      text-align: right;
      position: relative;
    }

    .header h1 {
      padding: 12px 0;
    }

    .register-individual {
      display: flex;
      align-items: center;
      background-color: #D2B48C;
      color: #ffffff;
      border: none;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      padding: 5px 15px;
      font-size: 18px;
    }

    .register-individual:hover {
      background-color: #C2A57A;
    }

    .hero {
      flex: 1;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      text-align: center;
      padding: 20px;
    }

    .hero h1 {
      font-size: 64px;
    }

    .hero p {
      font-size: 40px;
    }

    .links {
      display: flex;
      justify-content: center;
      gap: 20px;
      margin-top: 20px;
    }


    .register-company {
      background-color: #034C3C;
      color: #ffffff;
      padding: 10px 30px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 24px;
    }

    .register-company:hover {
      background-color: #02632A;
      transform: translateY(-3px);
    }

    .login {
      background-color: #2B3344;
      color: var(--white-color);
      padding: 10px 30px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 24px;
    }

    .login:hover {
      background-color: #1D222D;
      transform: translateY(-3px);
    }

    .arrow {
      margin-left: 8px;
    }

    @media (max-width: 600px) {
      .header {
        text-align: center;
      }

      .register-individual {
        margin: 10px 0;
      }

      .links {
        flex-direction: column;
        gap: 10px;
      }

      .hero h1 {
        font-size: 28px;
      }

      .hero p {
        font-size: 18px;
      }

      .register-individual {
        display: none;
      }
    }
  </style>
</head>

<body>

  <div class="header">
    <h1>موسمي</h1>
    <a href="../pages/signup.php" class="register-individual">تسجيل الأفراد</a>
  </div>

  <div class="hero">
    <h1>مرحبًا بك إلى موسمي</h1>
    <h3>نعمل على توفير الوظائف و العروض المتميزة بسهولة.</h3>

    <div class="links">
      <a href="../pages/signup.php" class="register-company">تسجيل الشركات</a>
      <a href="../pages/login.php" class="login">تسجيل الدخول</a>
    </div>
  </div>

</body>

</html>