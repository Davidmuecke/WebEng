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
        //weiterleitung auf log-in Seite
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
<div class='header'>
    <?php
    echo "Hallo ".$_SESSION['login']. "! ";
    //bild auslesen/ausgeben
    $sql = "select bilder.bild_daten, bilder.bild_name, bilder.bild_typ, bilder.bild_size from bilder, benutzer where bilder.ID=benutzer.bild";
    $query = mysqli_query($my_db, $sql);
    if (mysqli_num_rows($query)) {
        $ein = mysqli_fetch_object($query);
        $ctype=NULL;
        switch( $ein->bild_typ ) {
            case "gif": $ctype="image/gif"; break;
            case "png": $ctype="image/png"; break;
            case "jpeg":
            case "jpg": $ctype="image/jpeg"; break;
            default:
        }

        header('Content-type: ' . $ctype);
        echo '<img height="30" width="30" src="$ein->bild_daten">';
    }
    ?>
    <a href='logout.php'>ausloggen</a>
</div>