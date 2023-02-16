<?php
        error_reporting(0);
        include "server.php";
        session_start(); 
        /*if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
            $fout = 0;
            header("Location: index.php");
        }*/

        $fout = 0;

        /* 
        1. Wachtwoorden ophalen van pagina.
        2. Accountgegevens ophalen van database.
        3. Nieuw wachtwoord vervangen voor oud wachtwoord.
        */

        $Accountid = 10;

        $conn = mysqli_connect($servernaam, $naam, $ww, $db);        
        $gegevens = "SELECT Accountid, Gebruikersnaam, AES_DECRYPT(Wachtwoord, '.SALT.') FROM accountgegevens WHERE Accountid = '$Accountid'";
        $resultaat = mysqli_query($conn, $gegevens);

        if (isset($_REQUEST["submit"])) {

            $ww1 = mysqli_real_escape_string($conn, $_REQUEST["ww1"]);
            $ww2 = mysqli_real_escape_string($conn, $_REQUEST["ww2"]);

            while (list($Acountid) = mysqli_fetch_row($resultaat)) {
                if ($ww1 != $ww2) {
                    $fout = 1;
                }
                if ($ww1 == $ww2) {
                    $update = "UPDATE accountgegevens SET Wachtwoord = AES_ENCRYPT('$ww1', '.SALT.') WHERE Accountid = '$Accountid'";
                    $resultaat = mysqli_query($conn, $update);
                    $fout = 2;
                    $_SESSION["Accountid"] = 0;
                }
            }
        }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style><?php include "style.css"; ?></style>
        <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
        <title>Dwitter - Wachtwoord resetten</title>
    </head>
    <body>
        <div class="topnav">
            <a href="index.php" class="icon">
                <img src="images/Logo.png" alt="Logo" width="35px">
                <h1> Dwitter</h1>
            </a>
            <div class="search-container">
                <a href="index.php" class="Aanmelden right">Inloggen </a>
            </div>
        </div>
        <main class="width-100">
            <div class="ww-reset center">
                <form class="login-form" method="post/get">
                    <?php 
                        if ($fout == 1) {
                            // Laat een error zien wanneer de wachtwoorden zien.
                            echo "<p style='color: white; background-color: red; border: solid; border-color: rgb(190, 2, 2); margin: 2%; text-align: center; border-radius: 25px; padding: 10px 0 10px 0;'> De wachtwoorden komen niet overeen. <br> Zorg dat u hetzelfde wachtwoord invoert.</p>";
                        }
                        if ($fout == 2) {
                            // Laat een bericht zien als het wachtwoord is veranderd.
                            echo "<p style='color: white; background-color: rgb(0, 200, 18); border: solid; border-color: rgb(0, 160, 18); margin: 2%; text-align: center; border-radius: 25px; padding: 10px 0 10px 0;'> Uw wachtwoord is gereset. <br> U moet nu dit wachtwoord gebruiken om in te loggen. </p>";
                        }
                    ?>
                <div class="inlog-container">
                    <label for="uname"><b>Reset uw wachtwoord:</b></label>
                    <input class="input" type="password" placeholder="Vul hier een nieuw wachtwoord in..." name="ww1" required>
                    <input class="input" type="password" placeholder="Vul hier nogmaals het wachtwoord in..." name="ww2" required>
                    <input class="button1" type="submit" value="Reset wachtwoord" name="submit">
                </div>
            </div>
    </body>
</html>