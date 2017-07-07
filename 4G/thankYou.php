<?php
require("ressources/dba.php");
//Registrierungs logik


if(isset($_REQUEST['vorname'])&& isset($_REQUEST['nachname'])&&isset($_REQUEST['mail']) && isset($_REQUEST['userName']) && isset($_REQUEST['password']) && isset($_REQUEST["passwordWdh"]) ){
    $vorname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['vorname']));
    $nachname = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['nachname']));
    $mail = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['mail']));
    $userName = mysqli_real_escape_string($my_db,htmlentities($_REQUEST['userName']));
    $challenge = password_hash($mail,PASSWORD_DEFAULT);
    if($_REQUEST["password"] == $_REQUEST["passwordWdh"]){
        $pas = password_hash($_REQUEST['password'],PASSWORD_DEFAULT);
        $sql= "INSERT INTO unbestaetigt (challenge, userName, vorname, nachname, mail, password) VALUES('".$challenge."','".$userName."','".$vorname."','".$nachname."','".$mail."','".$pas."')";
       // echo $sql;
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        echo"<h2>Danke Für die Registrierung bei 4G</h2>";
        echo "<p>Bitte klicke auf den Link in diesr Email, um dein Konto zu bestätigen <a href='thankYou.php?challenge=".$challenge."'>bestätigen</a></p>";
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
        $sql = "INSERT INTO benutzer (userName, vorname, nachname, email, password) VALUES ('".$res['userName']."','".$res['vorname']."','".$res['nachname']."','".$res['mail']."','".$res['password']."')";
        // echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));

        $sql = "DELETE FROM unbestaetigt WHERE challenge='".$challenge."'";
        //echo "<br>".$sql."<br>";
        $res = mysqli_query($my_db, $sql) or die (mysqli_error($my_db));
        /* Wenn Abfrage erfolgreich war: */
        echo"<p>du kannst dich jetzt <a href='index.php'> anmelden</a></p>";
    }
}
?>

