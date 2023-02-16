<?php    
    error_reporting(0);
    include "server.php";
    session_start(); 
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
    <style><?php include "style.css"; ?></style>
    <link rel="shortcut icon" href="images/Logo.png" type="image/x-icon">
    <!--<meta http-equiv="refresh" content="1" >-->
</head>
<body>
<div class="topnav" id="myHeader">
        <a href="home.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1>Dwitter</h1>
        </a>
        <div class="search-container">
        <form action="">
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
    <main>
        <?php
            include "Server.php";

            $conn = mysqli_connect($servernaam, $naam, $ww, $db);

            $Search = mysqli_real_escape_string($conn, $_GET['search']);

            if (isset($_POST["filter1"])) {
                $filter1 = "Gebruikersnaam,";
            } else {
                $filter1 = '';
            }
            if (isset($_POST["filter2"])) {
                $filter2 = "Topic asc,";
            }else {
                $filter2 = '';
            } 
            if (isset($_POST["filter3"])) {
                $filter3 = "Datum desc";
            } else {
                $filter3 = 'Datum asc';
            }
                    
            $query = "SELECT * FROM posts WHERE topic like '%$Search%' OR beschrijving like '%$Search%' OR titel like '%$Search%' OR Gebruikersnaam like '%$Search%' ORDER BY $filter1 $filter2 $filter3";
            //echo $query;
            $resultaat = mysqli_query($conn, $query);

            $filter1 = '';    
            $filter2 = '';    
            $filter3 = '';    

            echo "<h2 class='topic-title'>U heeft gezocht naar '$Search' </h2>";

            // ! Er moet nog een derde filter komen.
            echo "<div class='filters'>
                <form action='Search.php?search=$Search' method='post'>
                    <label><b>Filteren op:</b></label>
                    <input class='filter' type='checkbox' name='filter1' value='Gebruikersnaam' > 
                    <label for='Gebruikersnaam'>Gebruiker</label>
                    <input class='filter' type='checkbox' name='filter2' value='Topic'> 
                    <label for='Topic'>Topic</label>
                    <input class='filter' type='checkbox' name='filter3' value='Datum'> 
                    <label for='Datum'>Datum</label>
                    <input class='filter' type='submit' name='submit' value='Filteren'>
                </form>
                <br>
            </div> ";

            while (list($Postid, $Gebruikersnaam, $Titel, $Datum, $Sticker, $Beschrijving, $Topic) = mysqli_fetch_row($resultaat)) {
                echo "<div class='post-search'>
                        <header>
                        <h2> <a href='Bericht.php?bericht=$Titel' class='bericht'> $Titel </a> <a href='Topic.php?topic=$Topic' class='topic'> $Topic </a></h2>
                        <a href='Topic.php?genre=$genre'> $genre </a>
                    </header>
                    <hr>
                    <!--<a class='topic'> $Topic </a>-->
                    <p>$Beschrijving</p>
                    <h5>@<a href='Gebruiker.php?Gebruiker=$Gebruikersnaam' class='gebruiker'>$Gebruikersnaam</a> - $Datum</h5>
                    </div>";
            }
        ?>
    </main>
</body>
</html>