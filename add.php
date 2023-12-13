
<title>Christian Virgüez Autos Database</title>
<?php
    require_once "pdo.php";
    require_once "bootstrap.php";
    session_start();
    if ( ! isset($_SESSION['email']) ) {
        $_SESSION["error"] = "ACCESS DENIED";
        echo '<h1 style="color:red">'.$_SESSION['error']."</h1>\n";
        unset($_SESSION['error']);
        exit;
    }
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Data validation
    if (strlen($_POST['make']) < 1 || strlen($_POST['model']) < 1 || strlen($_POST['year']) < 1 || strlen($_POST['mileage']) < 1) {
    $_SESSION['error'] = 'All fields are required';
    header("Location: add.php");
    return;
    }

    if ( !is_numeric($_POST['year']) || !is_numeric($_POST['mileage'])) {
        $_SESSION['error'] = ' Year and Mileage must be an integer';
        header("Location: add.php");
        return;
    }

    $sql = "INSERT INTO autos (make, model, year, mileage)
              VALUES (:make, :model, :year, :mileage)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
        ':make' => $_POST['make'],
        ':model' => $_POST['model'],
        ':year' => $_POST['year'],
        ':mileage' => $_POST['mileage']));
    $_SESSION['success'] = 'Record Added';
    header( 'Location: index.php' ) ;
    return;
}
?>
<div class="container">
<h1>Add A New Auto</h1>
<?php
// Flash pattern
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
?>
<form method="post">
<p>Make:
<input type="text" name="make"></p>
<p>Model:
<input type="text" name="model"></p>
<p>Year:
<input type="text" name="year"></p>
<p>Mileage:
<input type="text" name="mileage"></p>
<p><input type="submit" name="add new" value="Add New"/>
<a href="index.php">Cancel</a></p>
</form>
