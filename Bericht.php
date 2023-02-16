<?php    
        error_reporting(0);
        include "server.php";
        session_start(); 
        if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
            header("Location: index.php");
        }
        ?>
        <?php 
            include "server.php";
                    if (!isset($_SESSION["Accountid"])) {
                        $_SESSION["Accountid"] = 0;
                    }
    
                    $id = $_SESSION["Accountid"];
    
                    $gegevens2 = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam, Voornaam, Tussenvoegsel, Achternaam FROM Accountgegevens WHERE Accountid = '$id'");
                    $t=time();
                    
                    $datumtoevoegen = date("Y-m-d",$t);
                    if(isset($_POST["Topic"]) AND isset($_POST["Titel"]) AND isset($_POST["beschrijving"])) {   
                            $conn = mysqli_connect($servernaam, $naam, $ww, $db) or die("ga dood");
                            $gegevens = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam FROM Accountgegevens WHERE Accountid = '$id'"); 
                        while (list($Accountid) = mysqli_fetch_row($gegevens)) {    
                            $Titel = mysqli_real_escape_string($conn, $_POST["Titel"]);
                            $beschrijving = mysqli_real_escape_string($conn, $_POST["beschrijving"]);           
                            $Topic = mysqli_real_escape_string($conn, $_POST["Topic"]);        
                            $query2 = "insert into posts(Gebruikersnaam, Titel, Datum, Sticker, Beschrijving, Topic) values ('$Accountid', '$Titel', '$datumtoevoegen', NULL , '$beschrijving', '$Topic')";
                            //echo $query2;
                            $result = mysqli_query($conn, $query2);
                            header("Location: home.php");
                        }
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
    <style><?php include "style.css"; ?></style>
    <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
    <!--<meta http-equiv="refresh" content="1" >-->
    
    
</head>
<body>
    <main>
        <div class="topnav" id="myHeader">
            <a href="home.php" class="icon">
                <img src="images/Logo.png" alt="Logo" width="35px">
                <h1>Dwitter</h1>
            </a>
            <div class="search-container">
                <form action="Search.php">
                    <input type="text" placeholder="Search.." name="search">
                    <button type="submit"><i class="fa fa-search"></i></button>
                </form>

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
        <?php
            include "Server.php";
            if (!isset($_SESSION["Accountid"])) {
                $_SESSION["Accountid"] = 0;
            }

            $conn = mysqli_connect($servernaam, $naam, $ww, $db);
            $Gebruiker = mysqli_real_escape_string($conn, $_GET['bericht']); 
            $query = "SELECT * FROM posts WHERE Titel = '$Gebruiker'";
            $resultaat = mysqli_query($conn, $query);

            while (list($Postid, $Gebruikersnaam, $Titel, $Datum, $Sticker, $Beschrijving, $Topic) = mysqli_fetch_row($resultaat)) {
                
                        echo "<div class='post2'>
                        <header>
                        <h2> <a> $Titel </a> <a href='Topic.php?topic=$Topic' class='topic'> $Topic </a></h2>
                        <a href='Topic.php?genre=$genre'> $genre </a>
                        </header>
                        <hr>
                        <p>$Beschrijving</p>
                        <h5>@<a href='Gebruiker.php?Gebruiker=$Gebruikersnaam' class='gebruiker'>$Gebruikersnaam</a> - $Datum</h5>
                        </div>";
                    }
        ?>
    </main>
</body>
</html>