
<?php
/*
    1. Kies een locatie waar de foto's naar toe kunnen worden upgeload. 
    2. Krijg de naam van de foto.
    3. Maak verbinding met de database.
    4. Upload de naam van de foto in de database.
*/
        error_reporting(0);
        include "server.php";
        session_start(); 

        if (!isset($_SESSION["Accountid"]) OR $_SESSION["Accountid"] == 0) {
            header("Location: index.php");
        }

        // De locatie voor de profiel fotos.
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));        

        // * De foto uploaden naar de database.
        if ($uploadOk == 1 and isset($_POST["submit"])) {
            // De naam van de foto opvragen.
            $fnaam = basename($_FILES["fileToUpload"]["name"]);
            // Accountid opvragen.
            $Accountid = $_SESSION["Accountid"];

            $conn = mysqli_connect($servernaam, $naam, $ww, $db);
            // * Verwijder eerst de bestaand opgeslagen foto.
            $query = "UPDATE fotos SET Naam_foto='$fnaam' WHERE Accountid='$Accountid'";
            $result = mysqli_query($conn, $query);
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
          <form action="search.php">
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
        <br>
        <center><h1>Profiel foto uploaden</h1></center>
        <div class="center upload">
            <form action="" method="post" enctype="multipart/form-data">
                <h2> Select image to upload:</h2>
                <input type="file" name="fileToUpload" class="fileToUpload input4">
                <input type="submit" value="Upload Image" name="submit" class="input5">
            </form>
            <?php
                // Check if image file is a actual image or fake image
            if(isset($_POST["submit"])) {
                $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
                if($check !== false) {
                    $uploadOk = 1;
                } else {
                    echo "File is not an image. <br>";
                    $uploadOk = 0;
                }
                
        
                /* Check if file already exists
                if (file_exists($target_file)) {
                    echo "Sorry, file already exists.<br>";
                    $uploadOk = 0;
                }*/
        
                // Check file size
                if ($_FILES["fileToUpload"]["size"] > 500000) {
                    echo "Sorry, your file is too large.<br>";
                    $uploadOk = 0;
                }
        
                // Allow certain file formats
                if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
                && $imageFileType != "gif" ) {
                    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.<br>";
                    $uploadOk = 0;
                }
        
                // Check if $uploadOk is set to 0 by an error
                if ($uploadOk == 0) {
                    echo "Sorry, your file was not uploaded.<br>";
                // if everything is ok, try to upload file
                } else {
                if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
                } else {
                    echo "Sorry er was een fout met het uploaden van uw foto.<br>";
                }
                }
                if ($uploadOk == 1) {
                    echo "Uw profielfoto is aangepast!";
                }
            }
            ?>
        </div>
    </main>
</body>
</html>