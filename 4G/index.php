<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/css/custom_styles.css">
    <title>Login</title>
</head>
<body onload="mail();">
<div class="container">

    <div class="page-header">
        <h1>Four in a Row</h1>
    </div>

    <?php
    if (isset($_REQUEST['error'])) {
        if ($_REQUEST['error'] == 'login') {
            echo "<div class='error'>Du hast deinen Benutzername oder dein Passwort falsch eingegeben</div>";
        }
    }
    ?>


    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h3 class="panel-title">Anmelden</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" action="start.php" method="post">
                            <fieldset>
                                <div class="form-group">
                                    <label for="userName">Email oder Nutzername:</label>
                                    <input type="text" placeholder="E-Mail oder Nutzername eingeben"
                                           class="form-control"
                                           name="login">
                                </div>
                                <div class="form-group">
                                    <label for="password">Passwort:</label>
                                    <input type="password" placeholder="Passwort eingeben" class="form-control"
                                           name="password">
                                </div>
                                <button type="submit" class="btn login-success">Anmelden</button>
                                <div class="small register">
                                    Noch keinen Account? <a href="Registrierung.php"> Jetzt Registrieren</a>
                                </div>
                            </fieldset>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
require("ressources/footer.inc.php");
?>
</body>
</html>