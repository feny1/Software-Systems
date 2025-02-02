<!DOCTYPE html>
<html lang="en" style="direction: rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/signup.css" />
</head>

<body>
  <div class="container">
    <!--container-->
    <!-----------------right-side----------------->
    <div class="heading">
      <h1>موسمي</h1>
      <h2>
        <img
          src="icons\search-check.svg"
          alt="Icon"
          style="width: 20%; height: 20%; margin-right: 1%" />
        نسهل عليك عملية البحث عن فرص تطوعية
      </h2>
      <h2>
        <img
          src="icons\heart.svg"
          alt="Icon"
          style="width: 20%; height: 20%; margin-right: 1%" />
        ونساعدك في الوصول إلى الجمعيات والمؤسسات الخيرية
      </h2>
    </div>
    <!-----------------left-side----------------->
    <div class="sign-up">
      <h1>تسجيل جديد</h1>

      <div id="websites">
        <a href="sign up.html">
          <img src="icons/google.svg" alt="google" />
          جوجل
        </a>
        <a href="sign up.html">
          <img src="icons/X.svg" alt="google" />
          اكس
        </a>
      </div>

      <div class="or-line">
        <hr />
        <h2>أو</h2>
        <hr />
      </div>

      <h1 style="margin-top: 0%">تعبئة البيانات</h1>
      <form class="form">
        <!-- Username Field -->
        <label for="username">اسم المستخدم</label>
        <input type="text" id="username" name="username" required />
        <p id="username-error" style="display: none; color: red">
          اسم المستخدم مطلوب!
        </p>

        <!-- Email Field -->
        <label for="email">الإيميل</label>
        <input type="text" id="email" name="email" required />
        <p id="error-message" style="color: red; display: none">
          البريد الإلكتروني غير صالح!
        </p>

        <!-- Password Field -->
        <label for="password">الرمز السري</label>
        <input type="password" id="password" name="password" required />

        <!-- Confirm Password Field -->
        <label for="confirm-password">تأكيد الرمز السري:</label>
        <input
          type="password"
          id="confirm-password"
          name="confirm-password"
          required />
        <p id="password-error" style="color: red; display: none">
          كلمة المرور غير متطابقة!
        </p>
      </form>

      <button id="submitBtn">تسجيل الدخول</button>
    </div>
  </div>

  <script>
    document
      .getElementById("submitBtn")
      .addEventListener("click", function(event) {
        let usernameInput = document.getElementById("username").value.trim();
        let emailInput = document.getElementById("email").value;
        let errorMessage = document.getElementById("error-message");
        let password = document.getElementById("password").value;
        let confirmPassword =
          document.getElementById("confirm-password").value;
        let passwordError = document.getElementById("password-error");
        let usernameError = document.getElementById("username-error");

        // Regular expression for a valid email format
        let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        let isValid = true; // Track validation state

        // Username validation (Should not be empty)
        if (usernameInput === "") {
          usernameError.style.display = "block"; // Show username error
          isValid = false;
        } else {
          usernameError.style.display = "none"; // Hide username error
        }

        // Email validation
        if (!emailRegex.test(emailInput)) {
          errorMessage.style.display = "block"; // Show error message
          isValid = false;
        } else {
          errorMessage.style.display = "none"; // Hide error message
        }

        // Password matching validation
        if (password !== confirmPassword) {
          passwordError.style.display = "block"; // Show password error
          isValid = false;
        } else {
          passwordError.style.display = "none"; // Hide password error
        }

        // Success message if all inputs are valid
        if (isValid) {
          alert("Form submitted successfully!");
        }
      });
  </script>
</body>

</html>