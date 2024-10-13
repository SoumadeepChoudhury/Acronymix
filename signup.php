<?php
$user_IsPresent = false;
include("db.php");
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['password'])) {
    $USERNAME = htmlspecialchars($_POST['username']);
    $EMAIL = htmlspecialchars($_POST['email']);
    $PASSWORD = htmlspecialchars($_POST['password']);
    $sql = "SELECT * FROM `credentials` WHERE `username`='$USERNAME';";
    if (mysqli_query($CONN, $sql)->num_rows > 0) {
        $user_IsPresent = true;
    } else {
        $sql = "INSERT INTO `credentials` (`username`, `email`, `password`) VALUES('$USERNAME', '$EMAIL', '$PASSWORD');";
        if (mysqli_query($CONN, $sql)) {
            setcookie("USER", $USERNAME, time() + (60 * 60 * 24 * 30), "/");
            header("Location: /");
            exit;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acronymix - Signup</title>
    <link rel="stylesheet" href="signup.css">
    <link rel="icon" href="/logo.png">
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Sign Up for Acronymix</h1>
            <form id="signup-form" method="POST">
                <div class="input-group">
                    <label for="signupUsername">Username:</label>
                    <input name="username" type="text" id="signupUsername" placeholder="Enter Username" required>
                </div>
                <div class="input-group">
                    <label for="signupEmail">Email:</label>
                    <input name="email" type="email" id="signupEmail" placeholder="Enter Email" required>
                </div>
                <div class="input-group">
                    <label for="signupPassword">Password:</label>
                    <input name="password" type="password" id="signupPassword" placeholder="Enter Password" required>
                </div>
                <button type="submit" class="btn-primary">Sign Up</button>
                <?php
                if ($user_IsPresent) {
                    echo "User Already Present...";
                }
                ?>
            </form>
            <div id="signup-error" class="error hidden">Signup failed. Please try again.</div>
            <div class="link-container">
                <p>Already have an account? <a href="login.php">Login here</a>.</p>
            </div>
        </div>
    </div>

    <script src="app.js"></script>
</body>

</html>

<?php
// if()
?>