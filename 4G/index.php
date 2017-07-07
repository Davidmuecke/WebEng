<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css" >
    <title>Login -4G</title>
</head>
<body onload="mail()">
<div id="background">
    <?php
    if(isset($_REQUEST['error'])){
        if($_REQUEST['error']=='login'){
            echo "<div class='error'>Du hast deinen Benutzername oder dein Passwort falsch eingegeben</div>";
        }
    }
    ?>
    <h1>Anmeldung</h1>
    <form action="start.php" method="post">
        Benutzername oder E-Mail<br>
        <input type="text" name="userName"> <br>
        Passwort <br>
        <input type="password" name="password"><br>
        <input type="submit" value="anmelden" onclick="">
    </form>
    <a href="Registrierung.php">
        <button>Jetzt Registrieren</button>
    </a>
    <a href="Registrierung.php">
        <button>Jetzt Registrieren</button>
    </a>
</div>
<?php
    require("ressources/footer.inc.php");
?>
</body>
</html>