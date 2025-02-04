<?php
// signup.php

include('../components/page.php');

// Process form submission if the request method is POST.
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  // Retrieve and trim form inputs
  $username        = trim($_POST['username'] ?? '');
  $email           = trim($_POST['email'] ?? '');
  $password        = $_POST['password'] ?? '';
  $confirmPassword = $_POST['confirm-password'] ?? '';
  // Retrieve the account type (0 for individual, 1 for company)
  $type            = $_POST['type'] ?? '0';

  // Basic server-side validation
  $errors = [];

  if (empty($username)) {
    $errors[] = "اسم المستخدم مطلوب.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "البريد الإلكتروني غير صالح.";
  }
  if ($password !== $confirmPassword) {
    $errors[] = "كلمة المرور غير متطابقة.";
  }
  // (Add any additional validations as needed.)

  if (empty($errors)) {
    // Call the signup function.
    // Adjust the parameters according to your signup function signature.
    // For example, if your signup() accepts: signup($name, $email, $password, $bio, $type, $phone)
    $newUserId = signup($username, $email, $password, null, $type);
    if ($newUserId) {
      $_SESSION['user'] = getUserById($newUserId);
      
      $_SESSION['user']['company_id'] = fetchUserCompany($_SESSION['user']['id']);

      // If the user signed up as a company (type 1), create a new company record
      if ($type == '1') {
        // Prepare a statement to insert into the company table.
        // In this example, we use the username as the company name.
        // You can customize the location and bio as needed.
        $stmt = $db->prepare("INSERT INTO company (owner_id, hr_id, name, location, bio) VALUES (:owner_id, NULL, :name, '', '')");
        $stmt->bindValue(':owner_id', $newUserId, SQLITE3_INTEGER);
        $stmt->bindValue(':name', $username, SQLITE3_TEXT);
        $stmt->execute();
      }

      // Signup succeeded. Redirect to the profile page.
      header("Location: profile.php");
      exit;
    } else {
      // Signup failed, likely due to duplicate email.
      $errors[] = "فشل التسجيل. البريد الإلكتروني ربما يكون مستخدم بالفعل.";
    }
  }
}
?>

<!DOCTYPE html>
<html lang="en" style="direction: rtl">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <link rel="stylesheet" href="../styles/signup.css" />
  <title>تسجيل جديد</title>
</head>

<body>
  <div class="container">
    <!-- Right-side content -->
    <?php include("../components/NavBar.php") ?>

    <!-- Left-side sign up form -->
    <div class="sign-up">
      <h1>تسجيل جديد</h1>

      <div id="websites">
        <!-- <a href="sign up.html">
          <img src="../images/googleSVGlogo.svg" alt="google" />
          جوجل
        </a>
        <a href="sign up.html">
          <img src="../images/xSVGlogo.svg" alt="X" />
          اكس
        </a> -->
        <a href="../pages/login.php">لديك حساب من قبل؟</a>
      </div>

      <div class="or-line">
        <hr />
        <h2>أو</h2>
        <hr />
      </div>

      <h1 style="margin-top: 0%">تعبئة البيانات</h1>

      <!-- Display server-side errors if they exist -->
      <?php if (!empty($errors)): ?>
        <div class="errors" style="color:red;">
          <?php foreach ($errors as $error): ?>
            <p><?php echo htmlspecialchars($error); ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>

      <!-- Form with method POST and action pointing to this same file -->
      <form class="form" method="POST" action="signup.php">
        <!-- Username Field -->
        <label for="username">اسم المستخدم</label>
        <input type="text" id="username" name="username" value="<?php echo htmlspecialchars($username ?? ''); ?>" required />
        <p id="username-error" style="display: none; color: red">اسم المستخدم مطلوب!</p>

        <!-- Email Field -->
        <label for="email">الإيميل</label>
        <input type="text" id="email" name="email" value="<?php echo htmlspecialchars($email ?? ''); ?>" required />
        <p id="error-message" style="color: red; display: none">البريد الإلكتروني غير صالح!</p>

        <!-- Password Field -->
        <label for="password">الرمز السري</label>
        <input type="password" id="password" name="password" required />

        <!-- Confirm Password Field -->
        <label for="confirm-password">تأكيد الرمز السري:</label>
        <input type="password" id="confirm-password" name="confirm-password" required />
        <p id="password-error" style="color: red; display: none">كلمة المرور غير متطابقة!</p>

        <!-- Account Type Selection -->
        <label>نوع الحساب:</label>
        <label>
          <input type="radio" name="type" value="0" <?php if (isset($type) && $type == '0') echo 'checked'; ?> required>
          فردي
        </label>
        <label>
          <input type="radio" name="type" value="1" <?php if (isset($type) && $type == '1') echo 'checked'; ?> required>
          شركة
        </label>

        <!-- Submit Button -->
        <button type="submit" id="submitBtn">تسجيل الدخول</button>
      </form>
    </div>
  </div>

  <!-- Client-side validation script -->
  <script>
    document.getElementById("submitBtn").addEventListener("click", function(event) {
      // Prevent the default form submission to allow client-side validation
      event.preventDefault();

      let usernameInput = document.getElementById("username").value.trim();
      let emailInput = document.getElementById("email").value;
      let errorMessage = document.getElementById("error-message");
      let password = document.getElementById("password").value;
      let confirmPassword = document.getElementById("confirm-password").value;
      let passwordError = document.getElementById("password-error");
      let usernameError = document.getElementById("username-error");

      // Regular expression for a valid email format
      let emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{1,}$/;

      let isValid = true; // Track validation state

      // Username validation
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

      // If validation passes, submit the form
      if (isValid) {
        event.target.closest("form").submit();
      }
    });
  </script>
</body>

</html>