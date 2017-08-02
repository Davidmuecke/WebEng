<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/css/custom_styles.css">
    <title>Registrierung</title>
</head>

<?php
session_start();
//variablen leeren
$_SESSION = array();
//cookie löschen
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}
session_destroy();

echo "<div class=\"alert alert-info\">
                <strong>Info!</strong> Du wurdest ausgeloggt! <a href='index.php'>Wieder anmelden</a>
              </div>";
?>

<?php
require("ressources/footer.inc.php");
?>

</html>

