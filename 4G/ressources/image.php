<?php
session_start();
if(isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
}
else {
    header('Location: index.php');
}
require("dba.php");
if(isset($_SESSION['login'])) {
    $login = $_SESSION['login'];
    $sql = "SELECT bild FROM benutzer WHERE userName='" .$login. "' OR email = '".$login."' ";
    $res = mysqli_query($my_db, $sql);
    $row = mysqli_fetch_array($res);
    $id = $row['bild'];
    //bild auslesen/ausgeben
    $sql = "SELECT bilder.bild_daten, bilder.bild_name, bilder.bild_typ, bilder.bild_size FROM bilder WHERE ID='$id'";
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
}
?>
