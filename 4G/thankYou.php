<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/css/custom_styles.css">
    <title>Registrierung</title>
</head>

<?php
require("ressources/dba.php");
//Registrierungs logik
if(isset($_REQUEST['vorname'])&& isset($_REQUEST['nachname'])&&isset($_REQUEST['mail']) && isset($_REQUEST['userName']) && isset($_REQUEST['password']) && isset($_REQUEST["passwordWdh"]) && isset($_REQUEST['userAlter']) && isset($_REQUEST['geschlecht'])){
    $vorname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['vorname']));
    $nachname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['nachname']));
    $mail = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['mail']));
    $userName = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['userName']));
    $userAlter = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['userAlter']));
    $geschlecht = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['geschlecht']));
    $challenge = password_hash($mail,PASSWORD_DEFAULT);
    if($_REQUEST["password"] == $_REQUEST["passwordWdh"]){
        $pas = password_hash($_REQUEST['password'],PASSWORD_DEFAULT);

        if(isset($_FILES['bild_daten'])){

            $bild_daten_tmpname = $_FILES['bild_daten']['tmp_name'];
            $bild_daten_name = $_FILES['bild_daten']['name'];
            $bild_daten_type = $_FILES['bild_daten']['type'];
            $bild_daten_size = $_FILES['bild_daten']['size'];

            //echo "<hr>$bild_daten_tmpname<HR>bild_daten_name: $bild_daten_name<HR>";

            if (!empty($bild_daten_tmpname)) {
                if (( $bild_daten_type == "image/gif" ) || ($bild_daten_type == "image/pjpeg") || ($bild_daten_type == "image/jpeg") || ($bild_daten_type == "image/png")) {
                    //bild einfügen
                    $dateihandle = fopen($bild_daten_tmpname, "r");
                    $bild_daten = mysqli_real_escape_string($my_db, fread($dateihandle, filesize($bild_daten_tmpname)));
                    $bild_name = mysqli_real_escape_string($my_db, $bild_daten_name);
                    $bild_type = mysqli_real_escape_string($my_db, $bild_daten_type);
                    $sql = "INSERT INTO bilder(bild_daten, bild_name, bild_typ, bild_size) VALUES('$bild_daten', '$bild_name', '$bild_type', $bild_daten_size)";
                    $res = mysqli_query($my_db, $sql) or die(mysqli_error($my_db));
                    //echo "<BR>Bild gespeichert<BR>";
                    //bild dem user zuweisen
                    $id = "SELECT ID FROM bilder WHERE bild_daten = '".$bild_daten."' AND bild_name = '".$bild_name."' AND bild_typ = '".$bild_type."' AND bild_size = '".$bild_daten_size."'";
                    $res = mysqli_query($my_db, $id) or die (mysqli_error($my_db));
                    $res = mysqli_fetch_assoc($res);
                    //echo $res['ID'];
                    $sql= "INSERT INTO unbestaetigt (challenge, userName, vorname, nachname, mail, password, userAlter, geschlecht, bild) VALUES('".$challenge."','".$userName."','".$vorname."','".$nachname."','".$mail."','".$pas."','".$userAlter."','".$geschlecht."','".$res['ID']."')";
                    //echo $sql;
                    $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
                    echo "<div class=\"page-header\">
                    <h2>Danke für die Registrierung bei 4G!</h2>
                    </div>";
                    echo "<div class=\"alert alert-info\">
                    <strong>Info!</strong> Bitte klicke auf den folgenden Link, um dein Konto zu <a href='thankYou.php?challenge=".$challenge."'>bestätigen</a>.
                    </div>";

                } else {
                    echo "<BR>Die übergebenen Daten waren kein Bild-Format.<BR>";
                }
            }else {
                echo "<BR>Keine Daten übergeben.<BR>";
            }
        } else{
            echo "Bild Error!";
        }

    } else{
        echo"password error!";
    }
}
if(isset($_REQUEST['challenge'])){
    $challenge = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['challenge']));
    //echo "Eingabe String".$challenge;
    $sql="SELECT * FROM unbestaetigt WHERE challenge='".$challenge."'";
    $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
    $res = mysqli_fetch_assoc($res);
    //echo "<br>res: ".$res['challenge'];
    if($res['challenge']==$challenge){
        // echo "<br>Werte sind gleich: Jetzt änderungen in Tabellen ausführen!";
        $sql = "INSERT INTO benutzer (userName, vorname, nachname, email, password, userAlter, geschlecht, bild) VALUES ('".$res['userName']."','".$res['vorname']."','".$res['nachname']."','".$res['mail']."','".$res['password']."','".$res['userAlter']."','".$res['geschlecht']."','".$res['bild']."')";
        // echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        $sql = "DELETE FROM unbestaetigt WHERE challenge='".$challenge."'";
        //echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        /* Wenn Abfrage erfolgreich war: */
        echo "<div class=\"page-header\">
                <h2>Danke für die Registrierung bei 4G!</h2>
              </div>";
        echo "<div class=\"alert alert-success\">
                <strong>Geschafft!</strong> Du kannst dich jetzt <a href='index.php'>anmelden</a>
              </div>";
    }
}
?>
</html>
