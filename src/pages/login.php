<?php
include('../components/page.php');

if (isset($_SESSION['user']) && isset($_SESSION["user"]["type"])) {
    header("Location: profile.php"); // Redirect if already logged in
    exit();
}

$error = $_SESSION['error'] ?? '';
$_SESSION['error'] = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (!empty($_POST['email']) && !empty($_POST['password'])) {
        $user = login($_POST['email'], $_POST['password']);

        if (isset($user['error'])) {
            $error = $user['error']; // Display error
            $_SESSION['error'] = $error;

            header("Location: login.php"); // Redirect after failed login
            exit();
        } else {
            $_SESSION['user'] = $user;
            header("Location: profile.php"); // Redirect after successful login
            exit();
        }
    } else {
        $error = "يرجى إدخال البريد الإلكتروني وكلمة المرور.";
    }
}
?>

<!DOCTYPE html>
<html lang="ar" dir="rtl">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@400;500;600;700&display=swap');

        html,
        body {
            margin: 0;
            padding: 0;
            height: 100%;
            font-family: 'IBM Plex Sans', sans-serif;
            font-size: larger;
        }

        body {
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url("../images/Rectangle\ 1.png");
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            background-attachment: fixed;
            position: relative;
            overflow: hidden;
        }

        body::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: inherit;
            filter: blur(10px);
            z-index: -1;
            transform: scale(1.1);
        }

        .login-container {
            background: rgb(218, 236, 232);
            background: -moz-linear-gradient(45deg, rgba(218, 236, 232, 1) 30%, rgba(251, 243, 230, 1) 100%);
            background: -webkit-linear-gradient(45deg, rgba(218, 236, 232, 1) 30%, rgba(251, 243, 230, 1) 100%);
            background: linear-gradient(45deg, rgba(218, 236, 232, 1) 30%, rgba(251, 243, 230, 1) 100%);
            filter: progid:DXImageTransform.Microsoft.gradient(startColorstr="#daece8", endColorstr="#fbf3e6", GradientType=1);
            position: relative;
            padding: 2.5rem;
            border-radius: 10px;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
            width: 400px;
            text-align: right;
            backdrop-filter: blur(10px);
            z-index: 1;
        }

        h1 {
            color: black;
            margin-bottom: 2rem;
            text-align: center;
            font-size: 1.8rem;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        label {
            display: block;
            margin-bottom: 0.5rem;
            color: black;
            font-size: 0.9rem;
        }

        .form-control {
            width: 100%;
            padding: 0.3rem;
            border: 1px solid rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            font-size: 1rem;
            background: rgba(255, 255, 255, 0.8);
            color: black;
        }

        .form-control::placeholder {
            color: rgba(0, 0, 0, 0.5);
        }

        .checkbox-group {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            color: black;
        }

        .social-buttons {
            display: flex;
            gap: 1rem;
            margin-bottom: 1.5rem;
        }

        .social-btn {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.5rem;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            color: white;
            cursor: pointer;
            font-size: 0.9rem;
        }

        .social-btn img {
            width: 20px;
            height: 20px;
        }

        .x-btn,
        .google-btn {
            background-color: #2B3344;
            transition: background-color 0.3s;
        }

        .x-btn:hover,
        .google-btn:hover {
            background-color: #2a2b2f;
        }

        .action-buttons {
            display: flex;
            gap: 1rem;
        }

        .back-btn,
        .login-btn,
        .signup-btn {
            flex: 1;
            padding: 0.8rem;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 0.9rem;
            transition: background-color 0.3s;
        }

        .back-btn {
            background-color: white;
            border: 1px solid rgba(0, 0, 0, 0.1);
            color: black;
        }

        .login-btn {
            background-color: #034C3C;
            color: white;
        }

        .signup-btn {
            background-color: #028482;
            /* Adjust color as needed */
            color: white;
        }

        .back-btn:hover {
            background-color: #dfdfdf;
        }

        .login-btn:hover {
            background-color: #023629;
        }

        .signup-btn:hover {
            background-color: #026e70;
        }
    </style>
</head>

<body>
    <form method="post" action="#">
        <div class="login-container">
            <?php if (!empty($error)) : ?>
                <h1><?= $error ?></h1>
            <?php endif; ?>
            <h1>تسجيل الدخول</h1>

            <div class="form-group">
                <label>الإيميل</label>
                <input name="email" type="email" class="form-control" required>
            </div>

            <div class="form-group">
                <label>كلمة المرور</label>
                <input name="password" type="password" class="form-control" required>
            </div>

            <div class="checkbox-group">
                <input type="checkbox" id="showPassword">
                <label for="showPassword">اظهار كلمة المرور</label>
            </div>

            <!-- <div class="social-buttons">
                <button class="social-btn google-btn" type="button">
                    <img src="../images/googleSVGlogo.svg" alt="Google">
                    جوجل
                </button>

                <button class="social-btn x-btn" type="button">
                    <img src="../images/xSVGlogo.svg" alt="X">
                    اكس
                </button>
            </div> -->

            <div class="action-buttons">
                <button type="submit" class="login-btn">تسجيل الدخول</button>
                <button type="button" class="signup-btn" onclick="window.location.href='signup.php'">تسجيل جديد</button>
            </div>
        </div>
    </form>

    <script>
        // Simple show/hide password functionality
        const showPasswordCheckbox = document.getElementById('showPassword');
        const passwordInput = document.querySelector('input[name="password"]');
        showPasswordCheckbox.addEventListener('change', function() {
            passwordInput.type = this.checked ? 'text' : 'password';
        });

        // valid email
    </script>
</body>

</html>