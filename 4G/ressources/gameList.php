<?php
session_start();
/**
 * Created by PhpStorm.
 * User: kochdavi
 * Date: 24.06.2017
 * Time: 20:23
 */
$spielstandNeu = "o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o;o,o,o,o,o,o";
require("dba.php");
if (isset($_SESSION['userName'])) {
    $user = $_SESSION['userName'];
    if (isset($_REQUEST['neu'])) {
        //neues Spiel hinzufügen
        $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE spieler1 ='" . $user . "'") or die (mysqli_error($my_db));
        $game = mysqli_fetch_assoc($res);
        if (!isset($game['ID'])) {
            $res = mysqli_query($my_db, "INSERT INTO spielneu (spieler1) VALUES ('" . $user . "')") or die (mysqli_error($my_db));
        }
    }
    if (isset($_REQUEST['beitreten'])) {
        echo "beitreten";
        $beitreten = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['beitreten']));
        $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE ID ='" . $beitreten . "' AND spieler1 != '" . $user . "'") or die (mysqli_error($my_db));
        $game = mysqli_fetch_assoc($res);
        if (isset($game['ID'])) {
            mysqli_query($my_db, "INSERT INTO spiel (spieler1, spieler2, time, spielstand, amzug) VALUES ('" . $game['spieler1'] . "','" . $_SESSION['userName'] . "','" . $game['time'] . "','" . $spielstandNeu . "','" . $game['spieler1'] . "')") or die (mysqli_error($my_db));
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
    $res = mysqli_query($my_db, "SELECT * FROM spielneu WHERE spieler1 ='" . $user . "'") or die (mysqli_error($my_db));
    $game = mysqli_fetch_assoc($res);
    if ($game['ID']) {
        echo "<p>Du hast schon ein neues Spiel erstellt( Spiel " . $game['ID'] . "). Du musst warten bis ein anderer Spieler deinem Spiel beitritt</p>";
    } else {
        echo "<a href='start.php?neu=game'><button>Neues Spiel erstellen</button></a>";
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
