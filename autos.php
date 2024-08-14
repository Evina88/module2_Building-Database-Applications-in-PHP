<?php
require "pdo.php";
// Demand a GET parameter
if (!isset($_GET['name']) || strlen($_GET['name']) < 1) {
    die('Name parameter missing');
}
$failure = false;  // If we have no POST data
// If the user requested logout go back to index.php
if (isset($_POST['logout'])) {
    header('Location: index.php');
    return;
}
if (isset($_POST['make']) && isset($_POST['year']) && isset($_POST['mileage'])) {
    if (strlen($_POST['make']) < 1) {
        $failure = "Make is required";
        error_log("Make and year must be numeric");
    } else if (!is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        error_log("Mileage and year must be numeric");
        $failure = "Mileage and year must be numeric";
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
?>

<style>
    th,
    td {
        padding: 15px;
    }

    label {
        margin-right: 10px;
        margin-bottom: 5px;
        width: 50px;
        display: inline-flex;

    }
</style>

<!DOCTYPE html>
<html>

<head>
    <title>Evina's Autos Page</title>
</head>

<body>
    <h1>Evina's Autos Page</h1>
    <div class="container" style="margin-bottom:30px;">
        <form method="post">
            <?php
            if ($failure !== false) {
                // Look closely at the use of single and double quotes
                echo ('<p style="color: red;">' . htmlentities($failure) . "</p>\n");
            } else {
                echo ("<p>Record inserted.</p>");
            }
            ?>
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