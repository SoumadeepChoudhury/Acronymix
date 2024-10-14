<?php
$user_NotFound = false;
$credentials_IsIncorrect = false;
$login_Error = false;
include("db.php");
if (isset($_COOKIE['USER'])) {
    header('Location: /');
    exit();
} else if (isset($_POST['username']) && isset($_POST['password']) && $CONN != NULL) {
    $USERNAME = htmlspecialchars($_POST['username']);
    $PASSWORD = htmlspecialchars($_POST['password']);
    $sql = "SELECT * FROM `credentials` WHERE `username`='$USERNAME';";
    $res = mysqli_query($CONN, $sql);
    if ($res->num_rows > 0) {
        $data = $res->fetch_assoc();
        if ($data['username'] == $USERNAME && $data['password'] == $PASSWORD) {
            setcookie("USER", $USERNAME, time() + (60 * 60 * 24 * 30));
            header('Location: /');
            exit();
        } else {
            $credentials_IsIncorrect = true;
        }
    } else {
        $user_NotFound = true;
    }
} else if ($CONN == NULL) {
    $login_Error = true;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acronymix - Login</title>
    <link rel="stylesheet" href="login.css">
    <link rel="icon" href="/logo.png">
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Login to Acronymix</h1>
            <form id="login-form" method="POST">
                <div class="input-group">
                    <label for="username">Username:</label>
                    <input name="username" type="text" id="username" placeholder="Enter Username" required>
                </div>
                <div class="input-group">
                    <label for="password">Password:</label>
                    <input name="password" type="password" id="password" placeholder="Enter Password" required>
                </div>
                <button id="loginBtn" type="submit" class="btn-primary">Login</button>
                <?php
                if ($user_NotFound) {
                    echo "User not found...";
                } else if ($credentials_IsIncorrect) {
                    echo "<p class='error'> Incorrect Username or Password...</p>";
                }
                ?>
            </form>
            <?php
            if ($login_Error) {
                echo '<div id="login-error" class="error">Internal Error. Please try later.</div>';
            }
            ?>
            <div class="link-container">
                <p>Don't have an account? <a href="signup.php">Sign up here</a>.</p>
            </div>
        </div>
    </div>
</body>

</html>