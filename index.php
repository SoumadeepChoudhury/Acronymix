<?php
$data_IsInserted = false;
$data_IsExists = false;
$outputData = "";
if (!isset($_COOKIE['USER'])) {
    header('Location: /login.php');
    exit;
} else {
    include("db.php");
    $DB_TABLE_NAME = $_COOKIE['USER'];
    $sql = "CREATE TABLE IF NOT EXISTS $DB_TABLE_NAME (shortform VARCHAR(255) NOT NULL UNIQUE, fullform VARCHAR(255) NOT NULL);";
    mysqli_query($CONN, $sql);
    if (isset($_POST['shortform']) && isset($_POST['fullform'])) {
        $shortform = htmlspecialchars($_POST['shortform']);
        $fullform = htmlspecialchars($_POST['fullform']);
        $sql = "SELECT * FROM $DB_TABLE_NAME WHERE `shortform`='$shortform';";
        if (!mysqli_query($CONN, $sql)->num_rows > 0) {
            $sql = "INSERT INTO $DB_TABLE_NAME VALUES('$shortform','$fullform');";
            $data_IsInserted = mysqli_query($CONN, $sql);
        } else {
            $data_IsExists = true;
        }
    } else if (isset($_POST['searchText'])) {
        $shortform = htmlspecialchars($_POST['searchText']);
        $sql = "SELECT * FROM $DB_TABLE_NAME WHERE `shortform`='$shortform';";
        $res = mysqli_query($CONN, $sql);
        if ($res->num_rows > 0) {
            $data = mysqli_query($CONN, $sql)->fetch_assoc();
            $outputData = $data['fullform'];
            setcookie("isSearching", $shortform, time() + 10);
        } else {
            $outputData = "";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acronymix</title>
    <link rel="stylesheet" href="style.css">
    <link rel="icon" href="/logo.png">
</head>

<body>
    <div class="container">
        <div class="card">
            <h1>Acronymix</h1>
            <!-- Navigation Button -->
            <div class="nav-buttons">
                <button id="addFormBtn" class="btn-secondary">Add Short Form</button>
                <button id="searchFormBtn" class="btn-secondary">Search Full Form</button>
            </div>
            <div id="add-form-section" class="form-section">
                <form id="add-form" method="POST">
                    <div class="input-group">
                        <label for="shortForm">Short Form:</label>
                        <input name="shortform" type="text" id="shortForm" placeholder="Enter Short Form" required>
                    </div>
                    <div class="input-group">
                        <label for="fullForm">Full Form:</label>
                        <input name="fullform" type="text" id="fullForm" placeholder="Enter Full Form" required>
                    </div>
                    <button type="submit" class="btn-primary">Add to Database</button>
                </form>
                <?php
                if ($data_IsInserted) {
                    echo "Data sucessfully inserted...";
                } else if ($data_IsExists) {
                    echo "Data existed...";
                }
                ?>
            </div>
            <div id="search-form-section" class="form-section">
                <form id="search-form" method="POST">
                    <div class="input-group">
                        <label for="searchShortForm">Short Form:</label>
                        <input name="searchText" type="text" id="searchShortForm" placeholder="Enter Short Form to Search" required>
                    </div>
                    <button type="submit" class="btn-primary">Search</button>
                </form>
                <div id="search-result"><?php echo $outputData ?></div>
            </div>
            <div class="logout">
                <label for="logout" id="logout">Logout</label>
            </div>
        </div>
        <script src="app.js"></script>
</body>

</html>