    <?php    
        error_reporting(0);
        include "server.php";
        session_start(); 
        if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
            header("Location: index.php");
        }
    
        $id = $_SESSION["Accountid"];
    
        // ? Waar is dit voor $gegevens2 = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam, Voornaam, Tussenvoegsel, Achternaam FROM Accountgegevens WHERE Accountid = '$id'");
        $t=time();
                    
        $datumtoevoegen = date("Y-m-d",$t);
        if (isset($_POST["Topic"]) AND isset($_POST["Titel"]) AND isset($_POST["beschrijving"])) {   
            $conn = mysqli_connect($servernaam, $naam, $ww, $db) or die("ga dood");
            $gegevens = mysqli_query($conn, "SELECT Gebruikersnaam FROM Accountgegevens WHERE Accountid = '$id'"); 

            while (list($Gebruikersnaam) = mysqli_fetch_row($gegevens)) {    
                $Titel = mysqli_real_escape_string($conn, $_POST["Titel"]);
                $beschrijving = mysqli_real_escape_string($conn, $_POST["beschrijving"]);           
                $Topic = mysqli_real_escape_string($conn, $_POST["Topic"]);        

                $query = "insert into posts(Gebruikersnaam, Titel, Datum, Sticker, Beschrijving, Topic) values ('$Gebruikersnaam', '$Titel', '$datumtoevoegen', NULL , '$beschrijving', '$Topic')";
                echo $query2;
                $result = mysqli_query($conn, $query);
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
    <div class="topnav">
        <a href="home.php" class="icon">
            <img src="images/Logo.png" alt="Logo" width="35px">
            <h1>Dwitter</h1>
        </a>
        <div class="search-container">
            <form method="post">
                <input class="newpost" type="submit" value="Nieuwe Post" name="submit">
                <?php
                $postmaken = 0;
                if (isset($_REQUEST["submit"])) {
                    $postmaken = 1;
                }
                ?>
            </form>
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
    <main>
        <?php 
            if ($postmaken == 1) {
                $conn = mysqli_connect($servernaam, $naam, $ww, $db);
            if (!isset($_SESSION["Accountid"])) {
                $_SESSION["Accountid"] = 0;
            }
            $id = $_SESSION["Accountid"];
            $gegevens = mysqli_query($conn, "SELECT Accountid, Gebruikersnaam, Voornaam, Tussenvoegsel, Achternaam FROM Accountgegevens WHERE Accountid = '$id'");
            while (list($Acountid, $Gebruikersnaam, $Voornaam, $Tussenvoegsel, $Achternaam) = mysqli_fetch_row($gegevens)) {
                    $datenu=getdate(date("U"));
                    
                    echo "<div class='postmaken'>
                    
                    <form method='post'>

                        <header><h2> <input class='inputpost' type='text' placeholder='Titel' name='Titel'required></h2> </header>
                        <hr>
                        <input class='topic-input' type='text' placeholder='Vul hier uw Topic in...' name='Topic' required>
                        <input class='inputpostbeschrijving' placeholder='Type hier de beschrijving van uw bericht.' type='text' name='beschrijving' required>
                        <input  class='verzenden' type='submit' value='Verzenden' name='submit'>
                    </form>
                    <form>
                        <input  class='annuleren' type='submit' value='Annuleren' name='Annuleren'>
                    </form>
                    </div>";
                }
            }

            $query = "SELECT * FROM posts ORDER BY Datum desc";
            $resultaat = mysqli_query($conn, $query);

            while (list($Postid, $Gebruikersnaam, $Titel, $Datum, $Sticker, $Beschrijving, $Topic) = mysqli_fetch_row($resultaat)) {
                echo "<div class='post profile'>
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