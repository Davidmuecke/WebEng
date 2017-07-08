<?php
session_start();

require("dba.php");

//login check
if(!isset($_SESSION['userName'])){
    if(isset($_REQUEST['userName']) && isset($_REQUEST['password'])){
        //Benutzer verifikation
        $username = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['userName']));
        $pas = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['password']));

        $sql = "SELECT * FROM benutzer WHERE userName='".$username."'";
        $res = mysqli_query($my_db,$sql);
        $res = mysqli_fetch_assoc($res);

        if(password_verify($pas,$res['password'])){
            // login erfolgreich
            $_SESSION['userName'] = $username;
        } else {
            echo "Fehler";
            header("Location: index.php?error=login");
            die();
        }

    }else {
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
 echo "Hallo: ".$_SESSION['userName'];
?>
     <a href='logout.php'>ausloggen</a>
 </div>
