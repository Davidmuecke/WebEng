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


if(isset($_REQUEST['vorname'])&& isset($_REQUEST['nachname'])&&isset($_REQUEST['mail']) && isset($_REQUEST['userName']) && isset($_REQUEST['password']) && isset($_REQUEST["passwordWdh"]) && isset($_REQUEST['alter']) && isset($_REQUEST['geschlecht']) ){
    $vorname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['vorname']));
    $nachname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['nachname']));
    $mail = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['mail']));
    $userName = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['userName']));
    $alter = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['alter']));
    $geschlecht = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['geschlecht']));
    $challenge = password_hash($mail,PASSWORD_DEFAULT);
    if($_REQUEST["password"] == $_REQUEST["passwordWdh"]){
        $pas = password_hash($_REQUEST['password'],PASSWORD_DEFAULT);
        $sql= "INSERT INTO unbestaetigt (challenge, userName, vorname, nachname, mail, password, alter, geschlecht) VALUES('".$challenge."','".$userName."','".$vorname."','".$nachname."','".$mail."','".$pas." ','".$alter." ',' ".$geschlecht."')";
       // echo $sql;
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        echo "<div class=\"page-header\">
                <h2>Danke für die Registrierung bei 4G</h2>
              </div>";
        echo "<div class=\"alert alert-info\">
                <strong>Info!</strong> Bitte klicke auf den folgenden Link, um dein Konto zu <a href='thankYou.php?challenge=".$challenge."'>bestätigen</a>.
              </div>";
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
        $sql = "INSERT INTO benutzer (userName, vorname, nachname, email, password, alter, geschlecht) VALUES ('".$res['userName']."','".$res['vorname']."','".$res['nachname']."','".$res['mail']."','".$res['password']." ','".$res['alter']." ',' ".$res['geschlecht']." ')";
        // echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));

        $sql = "DELETE FROM unbestaetigt WHERE challenge='".$challenge."'";
        //echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        /* Wenn Abfrage erfolgreich war: */
        echo "<div class=\"page-header\">
                <h2>Danke für die Registrierung bei 4G</h2>
              </div>";
        echo "<div class=\"alert alert-success\">
                <strong>Geschafft!</strong> Du kannst dich jetzt <a href='index.php'>anmelden</a>
              </div>";
    }
}
?>
</html>

