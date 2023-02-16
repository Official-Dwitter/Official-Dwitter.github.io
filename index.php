<?php
        error_reporting(0);
        include "server.php";
        session_start();

        if (isset($_SESSION["Accountid"]) and $_SESSION["Accountid"] != 0) {
            header("Location: home.php");
        }

        if (isset($_SESSION["fout"])) {
            $fout = $_SESSION["fout"];
        }

        if (!isset($_SESSION["Accountid"])) {
            $_SESSION["Accountid"] = 0;
        }

        $fout = $_SESSION["fout"];
        $id = $_SESSION["Accountid"];

        $conn = mysqli_connect($servernaam, $naam, $ww, $db);
        $gn = mysqli_real_escape_string($conn, $_REQUEST["uname"]);
        $ww2 = mysqli_real_escape_string($conn, $_REQUEST["psw"]);

        $gegevens = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam, AES_DECRYPT(Wachtwoord, '.SALT.') FROM accountgegevens WHERE Gebruikersnaam = '$gn'");
        mysqli_close($conn);


        while (list($Accountid, $Gebruikersnaam, $Wachtwoord, $Email) = mysqli_fetch_row($gegevens)) {
            if ($Gebruikersnaam === $gn and $Wachtwoord === $ww2){
                $fout = 0;
                $_SESSION["fout"] = $fout;
                
                $id = $Accountid;
                $_SESSION["Accountid"] = $id;

                header("Location: home.php");
            } else { if (isset($_REQUEST["submit"])) {
                    $fout = 1;
                    $_SESSION["fout"] = $fout;
                    header("Location: index.php");
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
    <title>Dwitter - Inloggen</title>
    <style><?php include "style.css"; ?></style>
    <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
</head>
<body>
    <div class="topnav" id="myHeader">
        <a href="index.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1> Dwitter</h1>
        </a>
        <a href="Aanmeldpagina.php" class="Aanmelden right">Aanmelden</a>
    </div><br>
    <main class="width-100">
        <div class="center">
            <form class="login-form" method="post/get">
                <?php 
                    if ($fout == 1) {
                        echo "<p style='color: white; background-color: red; border: solid; border-color: rgb(190, 2, 2); margin: 2%; text-align: center; border-radius: 25px; padding: 10px 0 10px 0;'> Onjuiste gebruikersnaam of wachtwoord... <br> Wachtwoord vergeten en wilt u uw wachtwoord resetten? <a href='Wachtwoordvergeten.php' style='color: white;'> KLIK HIER! </a> </p>";
                    }
                ?>
                <div class="imgcontainer">
                    <img src="uploads/bird1.jpg" alt="Avatar" class="avatar">
                </div>
                <div class="inlog-container">
                    <label for="uname"><b>Gebruikersnaam</b></label>
                    <input class="input" type="text" placeholder="Vul je gebruikersnaam in ..." name="uname" required>

                    <label for="psw"><b>Wachtwoord</b></label>
                    <input class="input" type="password" placeholder="Vul je wachtwoord in ..." name="psw" required>

                    <input class="button1" type="submit" value="Inloggen" name="submit">
                    <label>
                        <input type="checkbox" checked="checked" name="remember"> <label class="om">Onthoud mij</label>
                    </label>
                </div>
            </form> 
        </div>
    </main>
</body>
</html>