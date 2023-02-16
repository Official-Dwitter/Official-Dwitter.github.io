<?php    
    error_reporting(0);
    include "server.php";
    session_start(); 
    if (isset($_REQUEST["submit"])) {
        $Accountid = 0;
        $_SESSION["Accountid"] = $Accountid;
    }
    if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
        header("Location: index.php");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <title>Dwitter</title>
    <style><?php include "style.css" ?></style>
    <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
</head>
<body>
    <div class="topnav" id="myHeader">
        <a href="home.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1>Dwitter</h1>
        </a>
        <div class="search-container">
        </form>
          <!-- <form action="search.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>-->

          <a style="padding-right: 20px;" href="instellingen.php"><i class="fa fa-cog"></i></a>
            <?php 
                include "Server.php";
                $conn = mysqli_connect($servernaam, $naam, $ww, $db);
                $Accountid = $_SESSION["Accountid"];
                $query = "SELECT * FROM fotos WHERE Accountid = '$Accountid'";
                $resultaat = mysqli_query($conn, $query);
                list($Foto_id, $Naam_foto, $Gebruikersnaam) = mysqli_fetch_row($resultaat);
                echo "<br> <a href='profile.php'><img class='profile-img dropbtn' src='uploads/$Naam_foto' alt='profiel foto'></a>";
            ?>
        </div>
    </div>
    <main>
        <br>
        <center>
                <h1>Accountgegevens</h1>
        </center>
        <div class="instellingen center">
            <!--Gebruikersnaam, wachtwoord, email, tel. voor- en achternaam, gender, geboortedatum, abonnement -->
            <?php
                include "Server.php";
                $conn = mysqli_connect($servernaam, $naam, $ww, $db);

                $id = $_SESSION["Accountid"];
                $opacity = 0.0;

                //echo "<br>" . $_SESSION["Accountid"];

                $gegevens = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam, AES_DECRYPT(Wachtwoord, '.SALT.'), Voornaam, Tussenvoegsel, Achternaam, Email, Geboortedatum, Gender, Telefoonnummer FROM Accountgegevens WHERE Accountid = '$id'");
                    
                while (list($Acountid, $Gebruikersnaam, $Wachtwoord, $Voornaam, $Tussenvoegsel, $Achternaam, $Email, $Geboortedatum, $Gender, $Telefoonnummer) = mysqli_fetch_row($gegevens)) {
                    if ($Telefoonnummer == 0) {
                        $Telefoonnummer = '-';
                    }                
                    
                    echo "<h3>Gebruikersnaam:</h3><hr>";
                    echo "<p class='instellingen-info'>$Gebruikersnaam</p><br>";
                    echo "<h3>Wachtwoord: <a class='link' href='Wachtwoordresetten.php'>Bewerken</a></h3><hr>";
                    echo "<p class='instellingen-info'>$Wachtwoord</p><br>";
                    echo "<h3>Naam</h3><hr>";
                    echo "<p class='instellingen-info'>$Voornaam $Tussenvoegsel $Achternaam<p><br>";
                    echo "<h3>E-mail</h3><hr>";
                    echo "<p class='instellingen-info'>$Email</p><br>";
                    echo "<h3>Geboortedatum</h3><hr>";
                    echo "<p class='instellingen-info'>$Geboortedatum</p><br>";
                    echo "<h3>Gender</h3><hr>";
                    echo "<p class='instellingen-info'>$Gender</p><br>";
                    echo "<h3>Telefoonnummer</h3><hr>";
                    echo "<p class='instellingen-info'>$Telefoonnummer</p><br>";
                    echo "<br><hr>";
                }
            ?>
            <form action="">
                <input class="button2" type="submit" value="Uitloggen" name="submit">
            </form>
        </div>
    </main>
</body>
</html>