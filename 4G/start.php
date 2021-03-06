<!DOCTYPE html>
<html lang="de">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="ressources/css/bootstrap.min.css">
    <link rel="stylesheet" href="ressources/css/custom_styles.css">
    <link rel="stylesheet" href="style.css">
    <title>Login 4G</title>
</head>

<body>

<div class="page-header">
    <h1>Four in a Row</h1>
</div>

<?php
require("ressources/header.inc.php");
?>
<script language="javascript">
    <!--
    var zug = -1;
    var req = null;
    var READY_STATE_COMPLETE = 4;

    function sendRequest(url, params, HTTPMethod) {
        if (!HTTPMethod) {
            HTTPMethod = "GET";
        }
        if (window.XMLHttpRequest) {
            req = new XMLHttpRequest();
        }
        if (req) {
            req.onreadystatechange = onReadyState;
            req.open(HTTPMethod, url, true);
            req.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            req.send(params);
        }
    }

    function onReadyState() {
        var ready = req.readyState;
        if (ready == READY_STATE_COMPLETE) {
            if (req.responseText) {
                var refZiel = document.getElementById("background");
                refZiel.innerHTML = req.responseText;
            }
        }
    }

    function getGame(id) {
        var strURL = "ressources/spielfeld.php";
        params = "game=" + id ;
        if (zug != -1) {
            params += "&column=" + zug;
            zug = -1;
        }
        sendRequest(strURL, params, "POST");
        window.setTimeout("getGame(" + id + ")", 500);
    }

    function getListNeuesSpiel() {
        var strURL = "ressources/gameList.php";
        <?php
        $farbe="rg";
        if (isset($_REQUEST['neu'])) {
            //neues Spiel hinzufügen
            if($_REQUEST['neu']=="lg"){
                $farbe = "lg";
            }
            if($_REQUEST['neu']=="og"){
                $farbe = "og";
            }
           echo"params = \"neu=".$farbe."\";";
        }
        ?>
        sendRequest(strURL, params, "POST");
        window.setTimeout("getList()", 500);
    }
    function getListBeitreten(id) {
        var strURL = "ressources/gameList.php";
        params = "beitreten=" + id;
        sendRequest(strURL, params, "POST");
        window.setTimeout("getList()", 500);
    }
    function getList(params) {
        var strURL = "ressources/gameList.php";
        sendRequest(strURL, params, "POST");
        window.setTimeout("getList()", 10000);
    }



</script>

<div id="background">
                <?php
                date_default_timezone_set('Europe/Berlin');
                $current_date = date('d/m/Y == H:i:s');

                echo $current_date;
                if (isset($_REQUEST['game'])) {
                    $id = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['game']));
                    echo "<script>getGame(" . $id . ");</script>";

                } else {
                    // require("ressources/gameList.php");

                    if (isset($_REQUEST['neu'])) {
                        $neu = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['neu']));
                        echo "<script>getListNeuesSpiel();</script>";
                        if($_POST['farbe']=="lg" || $_POST['farbe']=="og"){
                            mysqli_query($my_db, "INSERT INTO spiel (farbe) VALUES ('" . $_POST['farbe'] . "')");
                        }
                    } elseif (isset($_REQUEST['beitreten'])) {
                        $beitreten = mysqli_real_escape_string($my_db, htmlentities($_REQUEST['beitreten']));
                        echo "<script>getListBeitreten(" . $beitreten . ");</script>";
                    } else {
                        echo "<script>getList();</script>";
                    }

                }
                ?>
            </div>
            <?php
            require("ressources/footer.inc.php");
            ?>
</body>
</html>