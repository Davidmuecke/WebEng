<?php
session_start();
session_destroy();
 echo"Du wurdest ausgeloggt!";
 echo "<a href='index.php'>wieder anmelden</a>";