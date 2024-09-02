<?php
require "pdo.php";

if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}
if (isset($_SESSION['success'])) {
    echo '<p style="color:green">' . $_SESSION['success'] . "</p>\n";
    unset($_SESSION['success']);
}
if (isset($_POST['logout'])) {
    header('Location: index.php');
    return;
}
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1) {
        $_SESSION['error'] = "Make is required";
        error_log("Make and year must be numeric");
    } else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        error_log("Mileage and year must be numeric");
        $_SESSION['error'] = "Mileage and year must be numeric";
    } else {
        $stmt = $pdo->prepare('INSERT INTO autos
  (make, year, mileage) VALUES ( :mk, :yr, :mi)');
        $stmt->execute(
            array(
                ':mk' => $_POST['make'],
                ':yr' => $_POST['year'],
                ':mi' => $_POST['mileage']
            )
        );
    }
}
$stmt = $pdo->query("SELECT make, year, mileage FROM autos");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Flash pattern
if (isset($_SESSION['error'])) {
    echo '<p style="color:red">' . $_SESSION['error'] . "</p>\n";
    unset($_SESSION['error']);
}
?>


<!DOCTYPE html>
<html>

<head>
    <title>Evina Mouselimi - Autos </title>
</head>

<body>
    <h1>Evina's Autos Page</h1>
    <div class="container" style="margin-bottom:30px;">
        <form method="post">
            <label for="make">Make</label>
            <input type="text" name="make" id="make"><br />
            <label for="year">Year</label>
            <input type="text" name="year" id="year"><br />
            <label for="mileage">Mileage</label>
            <input type="text" name="mileage" id="mileage"><br />
            <input type="submit" name="logout" value="Logout" style="margin-top:20px;">
            <input type="submit" name="add" value="Add">
        </form>
    </div>
    <div>
        <table border="1">
            <?php
            foreach ($rows as $row) {
                echo "<tr><td>";
                echo ($row['make']);
                echo ("</td><td>");
                echo ($row['year']);
                echo ("</td><td>");
                echo ($row['mileage']);
                echo ("</td></tr>\n");
            }
            ?>
        </table>

    </div>

</body>

</html>