<?php
session_start();
require("dba.php");
/**
 * Überprüft, ob das Spiel gewonnen wurde
 * @param $stand aktueller Spielstand
 */
function gewonnen($stand){
    $sieger=0;
    for($a=0;$a<7;$a++){
        for($b=0;$b<6;$b++){
            $won = checkCell($a,$b,$stand);
            if($won==1 || $won==2){
                return $won;
            }
        }
    }
    return $sieger;
}
function checkCell($col,$row,$stand){

    if($stand[$col][$row] == "o"){
        return 0;
    } else{
        $gesucht = $stand[$col][$row];
    }

    //horizontal
    $anz=0;
    for($i=0;$i<4;$i++ ){
        if($gesucht == getCell(($col+$i),$row,$stand)){
            $anz++;
        }
    }
    if($anz==4){
        return $gesucht;
    }
    //vertikal
    $anz=0;
    for($i=0;$i<4;$i++ ){
        if($gesucht == getCell($col,($row+$i),$stand)){
            $anz++;
        }
    }
    if($anz==4){
        //echo"vertikal";
        return $gesucht;
    }
    //schräg rechts
    $anz=0;
    for($i=0;$i<4;$i++ ){
        if($gesucht == getCell(($col+$i),($row+$i),$stand)){
            $anz++;
        }
    }
    if($anz==4){
       // echo"schräg rechts";
        return $gesucht;
    }
    //schräg links
    $anz=0;
    for($i=0;$i<4;$i++ ){
        if($gesucht == getCell(($col-$i),($row+$i),$stand)){
            $anz++;
        }
    }
    if($anz==4){
       // echo"schräg links";
        return $gesucht;
    }
}
function getCell($col,$row,$stand){
    $answer = "o";
    if($col >=0 && $col<7 && $row>=0 && $row <6){
        $answer = $stand[$col][$row];
    }
    return $answer;
}
/**
 * Created by PhpStorm.
 * User: kochdavi
 * Date: 17.06.2017
 * Time: 22:34
 */
//Spielfeld generieren
echo "<br>";
echo "<div id=\"game\">";

if(isset($_REQUEST['game'])){
    $gameID =  mysqli_real_escape_string($my_db,htmlentities($_REQUEST['game']));
    $user = $_SESSION['userName'];
    //db Abfrage zum Spiel
    $res = mysqli_query($my_db,"SELECT * FROM spiel WHERE ID ='".$gameID."'")  or die (mysqli_error($my_db));
    $game =  mysqli_fetch_assoc($res);

    //Test ob Spiel existiert
    if(isset($game['ID'])){
        // String aus db in Array konvertieren
        $spielstand = $game['spielstand'];
        $spielstand = mb_split(";",$spielstand);
        for($i=0;$i < 7; $i++){
            $spielstand[$i] = mb_split(",",$spielstand[$i]);
        }

        //ID und Gegner festlegen
        if($game['spieler1'] != $user){
            $gegner = $game['spieler1'];
            $myID=2;
        } else{
            $gegner = $game['spieler2'];
            $myID=1;
        }
        //Zug ausführen
        if(isset($_REQUEST['column']) && $game['amzug']==$user){
            $column =  mysqli_real_escape_string($my_db,htmlentities($_REQUEST['column']));

            if($column>=0 && $column<7 && $spielstand[$column][0]=='o'){
                for($i=5;$i>=0;$i--){
                    if($spielstand[$column][$i]=="o"){
                        $spielstand[$column][$i]=$myID;
                        break;
                    }
                }
                //Spielstand Array in String für DB konvertieren
                $stringSpielstand="";
                for($a=0;$a<7;$a++){
                    $stringSpielstand = $stringSpielstand.$spielstand[$a][0];
                    for($b=1;$b<6;$b++){
                        $stringSpielstand= $stringSpielstand.",".$spielstand[$a][$b];
                    }
                    $stringSpielstand= $stringSpielstand.";";
                }
                //Datenbank aktuallisieren
                //testen ob Spieler gewonnen hat
                if(gewonnen($spielstand)==$myID){
                    mysqli_query($my_db,"UPDATE spiel SET spielstand ='".$stringSpielstand."', amzug='ENDE' WHERE ID ='".$gameID."'")  or die (mysqli_error($my_db));
                }else{
                    mysqli_query($my_db,"UPDATE spiel SET spielstand ='".$stringSpielstand."', amzug='".$gegner."' WHERE ID ='".$gameID."'")  or die (mysqli_error($my_db));

                }
                $res = mysqli_query($my_db,"SELECT * FROM spiel WHERE ID ='".$gameID."'")  or die (mysqli_error($my_db));
                $game =  mysqli_fetch_assoc($res);
            }
        }

        //Spielfeld zeichnen
        echo"<h2>Spiel ".$game['ID']." ".$user." gegen ".$gegner."</h2>";
        //Handlungsinfo
        if($game['amzug']=="ENDE"){
            if(gewonnen($spielstand)==$myID){
                echo"<div class='sieger'><p>Du hast gegen $gegner gewnonnen!</p>";
            } else {
                echo"<div class='verlierer'><p>Du hast gegen $gegner verloren!</p>";
            }

        }
        elseif($game['amzug']==$user){
           echo"<div class='message'><p>Du bist am Zug</p>";
       } else{
           echo"<div class='message'><p>Du musst auf $gegner warten</p>";

       }
       echo"</div>";
        //Eigentliches 4Gewinnt Feld
        $column = 0;
        $row =0;
        while($column <7){

            if($column == 6){
                echo "<div onclick='zug=6;' class=\"column lastColumn\" id='c".$column."'>";
            }else{
                echo "<div onclick='zug=".$column.";'class=\"column\" id='c".$column."'>";
            }

            while ($row<6){
                if($row==5){
                    echo "<div class=\"row lastRow\">";
                } else {
                    echo "<div class=\"row\">";
                }
                echo "<div class=\" ";
                if($spielstand[$column][$row]==1){
                    echo "sp1";
                } elseif($spielstand[$column][$row]==2){
                    echo "sp2";
                } else{
                    echo "cell";
                }
                echo"\" id=c".$column."_".$row.">";
                echo "<div class=\"dummy\"></div>";
                echo "</div></div>";
                $row++;
            }
            $row =0;
            echo "</div>";
            $column++;
            echo"</a>";
        }

    } else {
        echo"<div class='error'>Du bist nicht angemeldet oder das Spiel ist abgelaufen</div>";
    }
} else {
    echo"<div class='error'>Du bist nicht angemeldet oder das Spiel ist abgelaufen</div>";
}
echo"<p><a href='start.php'><button>zurück zur Übersicht</button></a></p>";
echo "</div>";