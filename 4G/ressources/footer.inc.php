<?php
/**
 * Created by PhpStorm.
 * User: kochdavi
 * Date: 18.06.2017
 * Time: 16:20
 */
?>

    <footer class="footer navbar-fixed-bottom">
        <div id="mail" >
        4Games Studio (c) 2017 Rotebühlplatz 41 70176 Stuttgart Email:
        </div>
    </footer>
    <script type="application/javascript" >
        function mail() {
            var  eins = "kontakt";
            var  zwei ="4GStudio";
            var mail = document.createElement("a");
            mail.appendChild(document.createTextNode(eins+"@"+zwei+".de"));
            mail.setAttribute("href","mailto:"+eins+"@"+zwei+".de");
            document.getElementById("mail").appendChild(mail);
        }
    </script>
