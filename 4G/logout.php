<?php
session_start();
session_destroy();
 echo"Du wurdest ausgelogt!";
 echo "<a href='index.php'>wieder anmelden</a>";