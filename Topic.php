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
          <form action="search.php">
            <input type="text" placeholder="Search.." name="search">
            <button type="submit"><i class="fa fa-search"></i></button>
          </form>

          <a style="padding-right: 20px;" href="instellingen.php"><i class="fa fa-cog"></i></a>
          <a href="profile.php"><img class="profile-img dropbtn" src="images/bird1.jpg"></a>
        </div>
        
    </div>
    <main>
        <?php
            include "Server.php";

            $conn = mysqli_connect($servernaam, $naam, $ww, $db);

            $Topic = mysqli_real_escape_string($conn, $_GET['topic']);

            echo "<h2 class='topic-title'>  $Topic </h2>";

            $query = "SELECT * FROM posts WHERE Topic = '$Topic'";
            $resultaat = mysqli_query($conn, $query);

            while (list($Postid, $Gebruikersnaam, $Titel, $Datum, $Sticker, $Beschrijving, $Topic) = mysqli_fetch_row($resultaat)) {
                echo "<title>Dwitter - $Topic</title>";
                echo "<div class='post-search'>
                <header>
                    <h2>$Titel <a href='Topic.php?topic=$Topic' class='topic'> $Topic </a></h2>
                </header>
                
                <p>$Beschrijving</p>
                <h5>@$Gebruikersnaam - $Datum</h5>
                </div>";
            }
        ?>
    </main>
</body>
</html>