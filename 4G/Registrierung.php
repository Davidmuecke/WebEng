<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/css/custom_styles.css">
    <title>Registrierung</title>
</head>
<body onload="mail();">
<div class="container">

    <div class="page-header">
        <h1>Four in a Row</h1>
    </div>

    <div class="container">
        <div class="row vertical-offset-100">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading" id="panel-heading">
                        <h3 class="panel-title">Registrierung</h3>
                    </div>
                    <div class="panel-body">
                        <form accept-charset="UTF-8" role="form" action="thankYou.php" method="get">
                            <fieldset>
                                <div class="form-group">
                                    <label for="vorname">Vorname:</label>
                                    <input type="text" placeholder="Vorname"
                                           class="form-control"
                                           name="vorname">
                                </div>
                                <div class="form-group">
                                    <label for="nachname">Nachname:</label>
                                    <input type="text" placeholder="Nachname"
                                           class="form-control"
                                           name="nachname">
                                </div>
                                <div class="form-group">
                                    <label for="mail">E-Mail:</label>
                                    <input type="text" placeholder="E-Mail"
                                           class="form-control"
                                           name="mail">
                                </div>
                                <div class="form-group">
                                    <label for="userName">Benutzername:</label>
                                    <input type="text" placeholder="Benutzername"
                                           class="form-control"
                                           name="userName">
                                </div>
                                <div class="form-group">
                                    <label for="password">Passwort:</label>
                                    <input type="password" placeholder="Passwort eingeben" class="form-control"
                                           name="password">
                                </div>
                                <div class="form-group">
                                    <label for="passwordWdh">Passwort wiederholen:</label>
                                    <input type="password" placeholder="Passwort wiederholen" class="form-control"
                                           name="passwordWdh">
                                </div>
                                <button type="submit" class="btn login-success">Registrieren</button>
                                <div class="small register">
                                    Du hast bereits einen Account? <a href="index.php"> Anmelden</a>
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