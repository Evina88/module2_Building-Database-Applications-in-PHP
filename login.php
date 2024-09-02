<?php // Do not put any HTML above this line
require_once "pdo.php";
session_start();

if (isset($_POST['cancel'])) {
    // Redirect the browser to game.php
    header("Location: index.php");
    return;
}

if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
    unset($_SESSION['success']);
}

$salt = 'XyZzy12*_';
$stored_hash = 'a8609e8d62c043243c4e201cbb342862';  // Pw is meow123

$failure = false;  // If we have no POST data

if (isset($_POST['who']) && isset($_POST['pass'])) {
    $at = '@';
    $check = hash('md5', $salt . $_POST['pass']);

    if (strlen($_POST['who']) < 1 || strlen($_POST['pass']) < 1) {
        $_SESSION['error'] = 'Missing data';
        header("Location: login.php");
        error_log("Login fail " . $_POST['who'] . " $check");
        return;
    }


    if (strpos($_POST['who'], $at) == false) {
        $_SESSION['error'] = "Email must have an at-sign (@)";
        header("Location: login.php");
        error_log("Wrong email");
        return;
    }
    if ($check !== $stored_hash) {
        $_SESSION['error'] = "Incorrect password";
        header("Location: login.php");
        error_log("Incorrect password" . $_POST['who'] . " $check");
        return;
    }
    if ($check == $stored_hash) {
        error_log("Login success " . $_POST['who']);
        header("Location: autos.php?name=" . urlencode($_POST['who']));
        return;
    }

}


// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Evina Mouselimi - Login Page</title>
</head>

<body>
    <div class="container">
        <h1>Please Log In</h1>

        <form method="POST">
            <label for="who">User Name</label>
            <input type="text" name="who" id="who"><br />
            <label for="pass">Password</label>
            <input type="text" name="pass" id="pass"><br />
            <input type="submit" value="Log In" name="Log In">
            <input type="submit" name="cancel" value="Cancel">
        </form>

    </div>
</body>

</html>