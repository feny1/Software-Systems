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
      display: block;
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
      font-size: 36px;
    }

    .hero p {
      font-size: 20px;
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
      font-size: 18px;
    }

    .register-company:hover {
      background-color: #02632A;
      transform: translateY(-3px);
    }

    .login {
      background-color: #2B3344;
      color: #D2B48C;
      padding: 10px 30px;
      border: none;
      border-radius: 10px;
      cursor: pointer;
      transition: background-color 0.3s ease, transform 0.3s ease;
      font-size: 18px;
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
    <button class="register-individual" onclick="location.href='./signup.php'">تسجيل الأفراد</button>
  </div>

  <div class="hero">
    <h1>مرحبًا بك إلى موسمي</h1>
    <h3>نعمل على توفير الوظائف و العروض المتميزة بسهولة.</h3>

    <div class="links">
      <button class="register-company" onclick="location.href='./signup.php'">تسجيل الشركات<span class="arrow">→</span></button>
      <button class="login" onclick="location.href='./login.php'">تسجيل الدخول<span class="arrow">&LeftArrowBar;</span></button>
    </div>
  </div>

</body>

</html>