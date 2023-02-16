<?php
    error_reporting(0);
    include "server.php";

    $fout_un = 0;
    $fout_em = 0;
    $fout_psw = 0;
    $datenu=getdate(date("U"));

    $conn = mysqli_connect($servernaam, $naam, $ww, $db) or die("ga dood");
    $query = "SELECT Gebruikersnaam, Email FROM accountgegevens";
    $resultaat = mysqli_query($conn, $query);

    if(isset($_POST["uname"]) and isset($_POST["email"]) AND isset($_POST["psw1"]) AND isset($_POST["psw2"]) AND isset($_POST["gwnvname"]) AND isset($_POST["gwnaname"]) AND isset($_POST["date"])){
        $uname = mysqli_real_escape_string($conn, $_POST["uname"]);
        $email = mysqli_real_escape_string($conn, $_POST["email"]);
        $psw1 = mysqli_real_escape_string($conn, $_POST["psw1"]);
        $psw2 = mysqli_real_escape_string($conn, $_POST["psw2"]);
        $gwnvname = mysqli_real_escape_string($conn, $_POST["gwnvname"]);
        $gwntussen = mysqli_real_escape_string($conn, $_POST["gwntussen"]);
        $gwnaname = mysqli_real_escape_string($conn, $_POST["gwnaname"]);
        $date = mysqli_real_escape_string($conn, $_POST["date"]);
        $gender = mysqli_real_escape_string($conn, $_POST["gender"]);
        $number = mysqli_real_escape_string($conn, $_POST["number"]);
        
       
        if ($psw1 == $psw2) {
            while (list($Gebruikersnaam, $Mail) = mysqli_fetch_row($resultaat)) {
                if ($uname == $Gebruikersnaam) {
                    $fout_un = 1;
                }
                if ($email == $Mail) {
                    $fout_em = 1;
                }
                if ($uname != $Gebruikersnaam and $email != $Mail) {
                    $fout_un = 0;
                    $fout_em = 0;

                    $query = "INSERT INTO accountgegevens(Gebruikersnaam, Wachtwoord, Voornaam, Tussenvoegsel, Achternaam, Email, Geboortedatum, Gender, Telefoonnummer) values ('$uname', AES_ENCRYPT('$psw1', '.SALT.'), '$gwnvname', '$gwntussen', '$gwnaname', '$email', '$date', '$gender', '$number')";
                    $result = mysqli_query($conn, $query);
                    $last_id = $conn->insert_id;
                    $query = "INSERT INTO fotos(Naam_foto, Accountid) VALUES ('bird1.jpg', '$last_id')";
                    $result = mysqli_query($conn, $query);
                    header("Location: index.php");
                }
            }
        } else {
            $fout_psw = 1;
        }
    }
?>                    

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dwitter - Aanmelden</title>
    <style><?php include "style.css"; ?></style>
    <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
</head>
<body>
    <div class="topnav">
        <a href="index.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1> Dwitter</h1>
        </a>
        <a href="index.php" class="Aanmelden right">Inloggen</a>
    </div> <br>
    <main class="width-100">
        <div class="center">
            <form class="login-form" action="" method="post">
                <div class="inlog-container">

                    <label for="uname"><b>Gebruikersnaam</b></label>
                    <input class="input-uname" id="uname" type="text" placeholder="Vul een nieuwe gebruikersnaam in ..." name="uname" required>
                    <?php 
                        if ($fout_un == 1) {
                            echo "<p class='error'>Deze gebruikersnaam is al in gebruik!<p> <br>"; 
                            echo "<style> .input-uname { border: 1px solid #e21b1b; } </style>";
                        } 
                    ?>

                    <label for="email"><b>E-mailadress</b></label>
                    <input class="input-email" id="email" type="email" placeholder="Vul uw email adres in ..." name="email" required>
                    <?php 
                        if ($fout_em == 1) {
                            echo "<p class='error'>Er bestaat al een account met dit email adres!<p> <br>"; 
                            echo "<style> .input-email { border: 1px solid #e21b1b; } </style>";
                        } 
                    ?>

                    <label for="psw"><b>Wachtwoord</b></label>
                    <input class="input4"  type="password" placeholder="Vul een wachtwoord in ..." name="psw1" required>
                    <input class="input5" type="password" placeholder="Bevestig uw wachtwoord ..." name="psw2" required>
                    <?php 
                        if ($fout_psw == 1) {
                            echo "<p class='error'>De wachtwoorden komen niet overeen!<p> <br>"; 
                            echo "<style> .input4 { border: 1px solid #e21b1b; } .input5 { border: 1px solid #e21b1b; } </style>";
                        } 
                    ?>

                    <label for="gwnname"><b>Voor- en achternaam in</b><br></label>
                    <input class="input2" id="gwnvname" type="text" placeholder="Voornaam" name="gwnvname" required>
                    <input class="input3" id="gwntussen" type="text" placeholder="Tussenvoegel" name="gwntussen">
                    <input class="input2" id="gwnaname" type="text" placeholder="Achternaam" name="gwnaname" required>

                    <label for="date"><b>Geboortedatum</b></label>
                    <input class="input"  id="date" type="date" name="date">

                    <label for="gender"><b>Gender</b></label> <br>
                    <input class= "voren" type="radio" name="gender" value="Man">
                    <label for="Man">Man</label><br>
                    <input class= "voren" type="radio" name="gender" value="Vrouw">
                    <label for="Vrouw">Vrouw</label><br>
                    <input class= "voren" type="radio" name="gender" value="Anders" checked>
                    <label for="Anders">Anders</label> <br><br>

                    <label for="number"><b>Telefoonnummer (bv. 06 13990925)</b></label>
                    <input class="input" id="number" type="tel" placeholder="Vul uw telefoonnummer in ..." name="number">

                    <input class="button1" type="submit" value="Aanmelden" name="submit">

                </div>
            </form> 
        </div>
    </main>
</body>
</html>