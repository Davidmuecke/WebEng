<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" >
    <title>Registrierung</title>
</head>
<body onload="mail();">
<div id="background">
    <h1>Registrierung</h1>
    <form action="thankYou.php" method="get">
        Vorame<br>
        <input type="text" name="vorname"> <br>
        Nachnname<br>
        <input type="text" name="nachname"> <br>
        E-Mail<br>
        <input type="text" name="mail"> <br>
        Benutzername<br>
        <input type="text" name="userName"> <br>
        Passwort <br>
        <input type="password" name="password"><br>
        Passwort wiederholen<br>
        <input type="password" name="passwordWdh"><br>
        Alter<br>

        Geschlecht<br>
        Profilbild<br>
        <input type="submit" value="registrieren">
    </form>
    <p>Du hast schon ein Benutzerkonto? Dann klicke <a href="index.php">hier</a> um dich anzumelden.</p>
</div>
<?php
    require("ressources/footer.inc.php");
?>
</body>
</html>