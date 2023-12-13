<?php
    session_start();
    require_once "bootstrap.php";

$salt = 'XyZzy12*_';
$stored_hash = '1a52e17fa899cf40fb04cfc42e6352f1';  // Pw is php123

if ( isset($_POST['email']) && isset($_POST['pass']) ) {
    if ( strlen($_POST['email']) < 1 || strlen($_POST['pass']) < 1 ) {
        $_SESSION["error"] = "Email and password are required";
        header('Location: login.php');
        return;
    } elseif(strpos($_POST['email'], '@') === false) {
        $_SESSION["error"] = "Email must have an at-sign (@)";
        header('Location: login.php');
        return;
    } else {
        $check = hash('md5', $salt.$_POST['pass']);
        if ( $check == $stored_hash ) {
            $_SESSION["email"] = $_POST['email'];
            $_SESSION["success"] = "Logged in.";
            header('Location: index.php');
            error_log("Login success ".$_POST['email']);
            return;
        } else {
            $_SESSION["error"] = "Incorrect password";
            header('Location: login.php');
            error_log("Login fail ".$_POST['email']." $check");
            return;
        }
    }
}

?>
<html>
<head>
    <title>Christian Virgüez 3ac1ebdc</title>
</head>
<div class="container">
<h1>Please Log In</h1>
<?php
    if ( isset($_SESSION["error"]) ) {
        echo('<p style="color:red">'.$_SESSION["error"]."</p>\n");
        unset($_SESSION["error"]);
    }
?>
<form method="post">
<p>Account: <input type="text" name="email" value=""></p>
<p>Password: <input type="password" name="pass" value=""></p>
<!-- password is php123 -->
<p><input type="submit" value="Log In">
<a href="index.php">Cancel</a></p>
</form>
</body>
