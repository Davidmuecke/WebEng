<?php
session.start();
require("dba.php");
if(isset($_SESSION['login'])){
    $sql = "SELECT bild FROM benutzer WHERE userName='".$login."'";
    $res = mysqli_query($my_db,$sql);
    $res = mysqli_fetch_assoc($res);
}

//bild auslesen/ausgeben
$sql = "select bilder.bild_daten, bilder.bild_name, bilder.bild_typ, bilder.bild_size from bilder, benutzer where bilder.ID=$res";
$query = mysqli_query($my_db, $sql);
if (mysqli_num_rows($query)) {
    $ein = mysqli_fetch_object($query);
    $ctype = NULL;
    switch ($ein->bild_typ) {
        case "gif":
            $ctype = "image/gif";
            break;
        case "png":
            $ctype = "image/png";
            break;
        case "jpeg":
        case "jpg":
            $ctype = "image/jpeg";
            break;
        default:
    }


    header('Content-type: ' . $ctype);
    echo $ein->bild_daten;
}
?>
