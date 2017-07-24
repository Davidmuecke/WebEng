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

            session_regenerate_id();
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
    $login = $_SESSION['login'];
    $sql = "SELECT bild FROM benutzer WHERE userName='" .$login. "' OR email = '".$login."' ";
    $res = mysqli_query($my_db, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['bild'];
    if($id!='0') {
        echo '<img width="4%" height="auto" src="ressources/image.php">';
    }
    ?>
    <a href='logout.php'>ausloggen</a>
</div>