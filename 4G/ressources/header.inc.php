<?php
session_start();
// übernahmesicherung

// 1. Browser

$_SESSION['browserOne'] = $_SERVER['HTTP_USER_AGENT'];
$_SESSION['browserTwo'] = get_browser(null, true);


// 2. Ip Adresse
function getUserIP() {
    if( array_key_exists('HTTP_X_FORWARDED_FOR', $_SERVER) && !empty($_SERVER['HTTP_X_FORWARDED_FOR']) ) {
        if (strpos($_SERVER['HTTP_X_FORWARDED_FOR'], ',')>0) {
            $addr = explode(",",$_SERVER['HTTP_X_FORWARDED_FOR']);
            return trim($addr[0]);
        } else {
            return $_SERVER['HTTP_X_FORWARDED_FOR'];
        }
    }
    else {
        return $_SERVER['REMOTE_ADDR'];
    }
}


$user_ip = getUserIP();
$_SESSION['ipAdresse'] = $user_ip;


if($_SESSION['ipAdresse'] == getUserIP()) {
    //echo $_SESSION['ipAdresse'];

    if($_SESSION['browserOne'] == $_SERVER['HTTP_USER_AGENT'] && $_SESSION['browserTwo'] == get_browser(null, true)) {
        // Forward to Lobby...

        if(isset($_SESSION['login'])) {
            $login = $_SESSION['login'];
            //header('Location: start.php');
            //exit();
        }
    }
} else {
    echo "SESSION WIRD MIT ÜBERNAHME BEDROHT ----------- ALARM!!!";
}
require("dba.php");
//login check

if(!isset($_SESSION['login'])){
        if (isset($_REQUEST['login']) && isset($_REQUEST['password'])) {
            //Benutzer verifikation
            $login = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['login']));
            $pas = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['password']));
            $sql = "SELECT * FROM benutzer WHERE userName='" . $login . "' OR email='" . $login . "'";
            $res = mysqli_query($my_db, $sql);
            $res = mysqli_fetch_assoc($res);

            if (password_verify($pas, $res['password'])) {
                // login erfolgreich
                $sql = "SELECT userName FROM benutzer WHERE userName='" . $login . "' OR email='" . $login . "'";
                $res = mysqli_query($my_db, $sql);
                $row = mysqli_fetch_array($res);
                $_SESSION['login'] = $row['userName'];

                session_regenerate_id();
            } else {
                echo "Fehler";
                header("Location: index.php?error=login");
                die();
            }
        } else {
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
    <meta http-equiv="refresh" content="60" src="logout.php">
    <title>4 Gewinnt</title>
</head>

<body onload="mail()">
  
<nav class="navbar navbar-static-top">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <?php
                if(isset($_SESSION['login'])) {
                    echo "Hallo " . $_SESSION['login'] . "! ";
                }
                ?>
            </a>

            <?php
            if(isset($_SESSION['login'])) {
                //bild ausgabe
                $login = $_SESSION['login'];
                $sql = "SELECT bild FROM benutzer WHERE userName='" . $login . "' OR email = '" . $login . "' ";
                $res = mysqli_query($my_db, $sql);
                $row = mysqli_fetch_array($res);
                $id = $row['bild'];
                if ($id != '0') {
                    echo '<img width="20%" height="auto" src="ressources/image.php">';
                }
            }


            ?>

            <ul class="nav navbar-nav">
                <li class="active"><a href='logout.php'>Ausloggen</a></li>
            </ul>
        </div>
    </div>
</nav>

</body>
</html>