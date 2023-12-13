<?php
require_once "pdo.php";
require_once "bootstrap.php";
session_start();
?>
<!DOCTYPE html>
<html>
<head>
<title>Christian Virgüez 3ac1ebdc</title>
</head>
<body>
<div class="container">
<h1>Welcome to Autos Database</h1>
<?php
// Verifica si el nombre de usuario no está establecido en la sesión
if (!isset($_SESSION['email'])) {
    // Si el nombre de usuario no está establecido, muestra el mensaje y el enlace de inicio de sesión
    ?>
    <p>
        <a href="login.php">Please log in</a>
    </p>
    <?php
    // Detiene la ejecución del resto del código
    exit;
}
// Resto del código aquí, que solo se ejecutará si el usuario ha iniciado sesión
if ( isset($_SESSION['error']) ) {
    echo '<p style="color:red">'.$_SESSION['error']."</p>\n";
    unset($_SESSION['error']);
}
if ( isset($_SESSION['success']) ) {
    echo '<p style="color:green">'.$_SESSION['success']."</p>\n";
    unset($_SESSION['success']);
}

echo('<table border="1">'."\n");
$stmt = $pdo->query("SELECT make, model, year, mileage, autos_id FROM autos");
if ($stmt->rowCount() === 0) {
    echo "No rows found";
} else {
    // Agrega el encabezado de la tabla
    echo "<tr><th>Make</th><th>Model</th><th>Year</th><th>Mileage</th><th>Action</th></tr>";

    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        echo "<tr><td>";
        echo(htmlentities($row['make']));
        echo("</td><td>");
        echo(htmlentities($row['model']));
        echo("</td><td>");
        echo(htmlentities($row['year']));
        echo("</td><td>");
        echo(htmlentities($row['mileage']));
        echo("</td><td>");
        echo('<a href="edit.php?autos_id=' . $row['autos_id'] . '">Edit</a> / ');
        echo('<a href="delete.php?autos_id=' . $row['autos_id'] . '">Delete</a>');
        echo("</td></tr>\n");
    }
}
echo("</table>");
?>
</table>
<a href="add.php">Add New Entry</a> | <a href="logout.php">Logout</a>