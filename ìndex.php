<?php 
/**
 * This page handles user login.
 * It includes `footer.php` and `usercontroller.php` for handling user operations.
 * The `Users` class is accessed through `$check` to validate the user upon login submission.
 */

// Display PHP errors for debugging during development
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Include necessary files
include_once 'controller/usercontroller.php';
include_once 'model/config.php';

// Start the session
session_start();

// Redirect to home.php if the user is already logged in
if (isset($_SESSION['username'])) {
    header("Location: home.php");
    exit();
}

// Initialize the Users class
$check = new Users();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <main>
        <div class="login-container">
            <!-- Success or error message display -->
            <span class="success-mes">
                <?php
                    if (isset($_GET['message'])) {
                        $message = htmlspecialchars(urldecode($_GET['message'])); // Sanitize message
                        echo $message;
                    }
                ?>
            </span>
            <h2>Administration Login</h2>
            <form action="index.php" method="post">
                <span>
                    <p>
                        <?php
                        // Handle form submission and validate the user
                        if (isset($_POST['submit'])) { 
                            $response = $check->validateUser($_POST);
                            if ($response) {
                                echo htmlspecialchars($response); // Sanitize output
                            }
                        }
                        ?>
                    </p>
                </span>
                <label for="mail">E-Mail</label> <br>
                <input type="email" id="email" name="email" placeholder="Email" required> <br>
                <label for="password">Password</label> <br>
                <input type="password" id="password" name="password" placeholder="Password" required>
                <input type="submit" name="submit" class="submit" value="Login"> <br>
                <p style="text-align:center; font-size:14px;">
                    <a href="forget-password.php">Forget Password?</a>
                </p>
                <p>Not yet registered? <a href="register.php">Sign up!</a></p>
            </form>
        </div>
    </main>
</body>
</html>

