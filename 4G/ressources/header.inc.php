<?php
session_start();
require("dba.php");
//login check

if(!isset($_SESSION['login'])){
    if(isset($_REQUEST['login']) && isset($_REQUEST['password'])){
        //Benutzer verifikation
        $login = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['login']));
        $pas = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['password']));
        $sql = "SELECT * FROM benutzer WHERE userName='".$login."' OR email='".$login."'";
        $res = mysqli_query($my_db,$sql);
        $res = mysqli_fetch_assoc($res);
      
        if(password_verify($pas,$res['password'])){
            // login erfolgreich
            $sql = "SELECT userName FROM benutzer WHERE userName='".$login."' OR email='".$login."'";
            $res = mysqli_query($my_db,$sql);
            $row= mysqli_fetch_array($res);
            $_SESSION['login'] = $row['userName'];
        } else {
            echo "Fehler";
            header("Location: index.php?error=login");
            die();
        }
    }
    else {
        //Weiterleitung auf log-in Seite
        header("Location: index.php");
        die();
    }
}

?>
<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <title>4 Gewinnt</title>
</head>

<body onload="mail()">

<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <?php
                echo "Hallo: " . $_SESSION['userName'];
                echo '<img height="30" width="30" src="ressources/image.php">';
                ?></a>
            <ul class="nav navbar-nav">
                <li class="active"><a href='logout.php'>Ausloggen</a></li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>

