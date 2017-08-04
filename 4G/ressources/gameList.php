<?php
session_start();
if(isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
}
else {
    header('Location: index.php');
}
/**
 * Created by PhpStorm.
 * User: kochdavi
 * Date: 24.06.2017
 * Time: 20:23
 */
$spielstandNeu = "o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o";
require("dba.php");
$farbe= null;
if(isset($_SESSION['login'])) {
    $user= $_SESSION['login'];
    session_regenerate_id();

    if (isset($_REQUEST['neu'])) {
        //neues Spiel hinzufügen
        $farbe = "rg";

        $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE spieler1 ='" . $user . "'") or die (mysqli_error($my_db));
        $game = mysqli_fetch_assoc($res);
        if (!isset($game['ID'])) {
            $res = mysqli_query($my_db, "INSERT INTO spielneu (spieler1, farbe) VALUES ('" . $user . "','" . $farbe . "')") or die (mysqli_error($my_db));
        }
    }
    if (isset($_REQUEST['beitreten'])) {
        echo "beitreten";
        $beitreten = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['beitreten']));
        $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE ID ='" . $beitreten . "' AND spieler1 != '" . $user . "'") or die (mysqli_error($my_db));
        $game = mysqli_fetch_assoc($res);
        if (isset($game['ID'])) {
            $sql = "SELECT farbe FROM spielneu WHERE ID='" . $game['ID'] . "'";
            $res = mysqli_query($my_db, $sql);
            $row = mysqli_fetch_array($res);
            $farbe = $row['farbe'];
            mysqli_query($my_db, "INSERT INTO spiel (spieler1, spieler2, time, spielstand, amzug, farbe) VALUES ('" . $game['spieler1'] . "','" . $user . "','" . $game['time'] . "','" . $spielstandNeu . "','" . $game['spieler1'] . "','" . $farbe . "')") or die (mysqli_error($my_db));
            mysqli_query($my_db, "DELETE FROM spielneu WHERE ID='" . $game['ID'] . "'");
        }
    }
    //Spiele ausgeben
    echo "<h2>Neues Spiel</h2>";
    echo "<div class='col-md-4 col-md-offset-4'>";
    echo "<div class=\"panel panel-default\">
                    <div class=\"panel-heading\" id=\"panel-heading\">
                        <h3 class=\"panel-title text-center\">Neues Spiel</h3>
                    </div>
                    <div class=\"panel-body\">";
     $res = mysqli_query($my_db,"SELECT * FROM spielneu WHERE spieler1 ='".$user."'")or die (mysqli_error($my_db));
     $game =  mysqli_fetch_assoc($res);
    if ($game['ID']) {
         echo"<p>Du hast schon ein neues Spiel erstellt (Spiel ".$game['ID']."). Du musst warten bis ein anderer Spieler deinem Spiel beitritt!</p>";
    } else {
        echo "<form action='start.php?neu=game' method='post'>
                Wähle eine Farbkombination:
                <select name='farbe' value='farbe' class='btn login-success'>
                    <option name='rg' value='rg' selected>Rot/Gelb</option>
                    <option name='lg' value='lg'>Lila/Grün</option>
                    <option name='og' value='og'>Orange/Grau</option>
                </select>
            <button type='submit' class='btn login-success'>Neues Spiel erstellen</button>
	    </form>";
        if($_POST['farbe']=="lg" || $_POST['farbe']=="og"){
            mysqli_query($my_db, "INSERT INTO spiel (farbe) VALUES ('" . $_POST['farbe'] . "')");
        }
    }
    echo "</div>";
    echo "</div>";
    echo "<h2>Deine Spiele</h2>";
    echo "<div class=\"panel panel-default\">
                    <div class=\"panel-heading\" id=\"panel-heading\">
                        <h3 class=\"panel-title text-center\">Deine Spiele</h3>
                    </div>
                    <div class=\"panel-body\">";
    $res = mysqli_query($my_db, "SELECT * FROM spiel WHERE spieler1='" . $user . "' OR spieler2='" . $user . "'") or die (mysqli_error($my_db));
    $game = mysqli_fetch_assoc($res);
    while ($game['ID']) {
        echo "<div class= 'gameListItem'>";
        echo "<p>Spiel " . $game['ID'] . "<br>Spieler1 " . $game['spieler1'] . "<br> Spieler2 " . $game['spieler2'] . "</p>";
        echo "<a href='start.php?game=" . $game["ID"] . "'><button class='btn login-success'>zum Spiel</button></a>";
        $game = mysqli_fetch_assoc($res);
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
    echo "<h2>Offene Spiele</h2>";
    echo "<div class=\"panel panel-default\">
                    <div class=\"panel-heading\" id=\"panel-heading\">
                        <h3 class=\"panel-title text-center\">Offene Spiele</h3>
                    </div>
                    <div class=\"panel-body\">";
    $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE spieler1 !='" . $user . "'") or die (mysqli_error($my_db));
    $game = mysqli_fetch_assoc($res);
    while ($game['ID']) {
        echo "<div class= 'gameListItem'>";
        echo "<p>Spiel " . $game['ID'] . "<br>Spieler1 " . $game['spieler1'] . "</p>";
        echo "<a href='start.php?beitreten=" . $game['ID'] . "'><button class='btn login-success'>Beitreten</button></a>";
        $game = mysqli_fetch_assoc($res);
        echo "</div>";
    }
    echo "</div>";
    echo "</div>";
} else {
    echo "<div class='error'>Du bist nicht angemeldet!</div>";
}

