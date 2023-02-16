<?php    
    error_reporting(0);
    include "server.php";
    $conn = mysqli_connect($servernaam, $naam, $ww, $db);
    session_start(); 
    if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
        header("Location: index.php");
    }
    
    $Gebruiker = mysqli_real_escape_string($conn, $_GET['Gebruiker']);             
                
                $query = "SELECT Accountid FROM accountgegevens WHERE Gebruikersnaam='$Gebruiker'";
                
                $resultaat = mysqli_query($conn, $query);
                while(list($Accountid, $Gebruikersnaam2) = mysqli_fetch_row($resultaat)) {
                    $Accountid2 = $_SESSION["Accountid"];
                if($Accountid==$Accountid2)
                header("Location: profile.php");
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
</head>
<body>
    <div class="topnav" id="myHeader">
        <a href="home.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1>Dwitter</h1>
        </a>
        <div class="search-container">
        </form>
          <form action="search.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>

          <a style="padding-right: 20px;" href="instellingen.php"><i class="fa fa-cog"></i></a>
            <?php 
                include "Server.php";
                $conn = mysqli_connect($servernaam, $naam, $ww, $db);
                $Accountid = $_SESSION["Accountid"];
                $query2 = "SELECT * FROM fotos WHERE Accountid = '$Accountid'";
                $resultaat = mysqli_query($conn, $query2);
                list($Foto_id, $Naam_foto, $Gebruikersnaam) = mysqli_fetch_row($resultaat);
                echo "<br> <a href='profile.php'><img class='profile-img' src='uploads/$Naam_foto' alt='profiel foto'></a>";
            ?>
        </div>
    </div>
    <main>
        <center>
            <?php
                include "Server.php";
                $conn = mysqli_connect($servernaam, $naam, $ww, $db);

                if (!isset($_SESSION["Accountid"])) {
                    $_SESSION["Accountid"] = 0;
                }
                $Gebruiker = mysqli_real_escape_string($conn, $_GET['Gebruiker']); 
                $query = "SELECT * FROM fotos WHERE Accountid in (select Accountid FROM accountgegevens where Gebruikersnaam = '$Gebruiker')";
                $resultaat = mysqli_query($conn, $query);
                list($Foto_id, $Naam_foto, $Gebruikersnaam) = mysqli_fetch_row($resultaat);
                echo "<br> <img class='gebruiker-pic' src='uploads/$Naam_foto' alt='profiel foto'>";
             

                
                
                $query = "SELECT * FROM accountgegevens WHERE Gebruikersnaam='$Gebruiker'";
                $resultaat = mysqli_query($conn, $query);
                while (list($Accountid, $Gebruikersnaam, ,$Voornaam, $Tussenvoegsel, $Achternaam)= mysqli_fetch_row($resultaat)) {
                {
                    echo "<h1>$Voornaam $Tussenvoegsel $Achternaam</h1>";
                    echo "<h4>@$Gebruikersnaam</h4>";
                }
            }
            ?>
        </center>
        <?php
            include "Server.php";
            if (!isset($_SESSION["Accountid"])) {
                $_SESSION["Accountid"] = 0;
            }


            
            $conn = mysqli_connect($servernaam, $naam, $ww, $db);
            $Gebruiker = mysqli_real_escape_string($conn, $_GET['Gebruiker']); 
            $query = "SELECT * FROM posts WHERE Gebruikersnaam in (select Gebruikersnaam FROM accountgegevens where Gebruikersnaam = '$Gebruiker') ORDER BY Datum desc";
            $resultaat = mysqli_query($conn, $query);

                while (list($Postid, $Gebruikersnaam, $Titel, $Datum, $Sticker, $Beschrijving, $Topic) = mysqli_fetch_row($resultaat)) {

                            echo "<div class='post'>
                            <header>
                            <h2> <a href='Bericht.php?bericht=$Titel' class='bericht'> $Titel </a> <a href='Topic.php?topic=$Topic' class='topic'> $Topic </a></h2>
                            <a href='Topic.php?genre=$genre'> $genre </a>
                            </header>
                            <hr>
                            
                            <p>$Beschrijving</p>
                            <h5>@$Gebruikersnaam - $Datum</h5>
                            </div>";
                        }
        ?>
    </main>
</body>
</html>