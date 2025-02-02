<?php
// sign_in.php

session_start();

// Include data.php to access the SQLite3 database connection ($db)
include 'data.php';

// Process the form when the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ensure both email and password are provided
    if (!isset($_POST['email'], $_POST['password'])) {
        echo json_encode(["error" => "Please fill in both email and password."]);
        exit;
    }
    
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    // Prepare a statement to safely query the user by email (preventing SQL injection)
    $stmt = $db->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
    $stmt->bindValue(':email', $email, SQLITE3_TEXT);
    $result = $stmt->execute();
    
    // Fetch the user record as an associative array
    $user = $result->fetchArray(SQLITE3_ASSOC);
    
    if ($user) {
        // Verify the password.
        // If you stored the password using password_hash(), use password_verify().
        // Otherwise, if passwords are stored in plain text (not recommended), use a simple comparison.
        if (password_verify($password, $user['password'])) {
            // Login successful: store user data in the session
            $_SESSION['user_id']   = $user['id'];
            $_SESSION['user_name'] = $user['name'];
            
            // Respond with a success message (or you could redirect the user)
            echo json_encode(["success" => true, "message" => "Signed in successfully."]);
            exit;
        } else {
            // Password does not match
            echo json_encode(["error" => "Invalid email or password."]);
            exit;
        }
    } else {
        // No user found with that email
        echo json_encode(["error" => "Invalid email or password."]);
        exit;
    }
} else {
    // For GET requests, display a simple sign in form
    ?>
    <!DOCTYPE html>
    <html>
    <head>
        <meta charset="UTF-8">
        <title>Sign In</title>
    </head>
    <body>
        <h1>Sign In</h1>
        <form action="sign_in.php" method="post">
            <div>
                <label for="email">Email:</label>
                <input type="email" name="email" id="email" required />
            </div>
            <div>
                <label for="password">Password:</label>
                <input type="password" name="password" id="password" required />
            </div>
            <button type="submit">Sign In</button>
        </form>
    </body>
    </html>
    <?php
}
?>
