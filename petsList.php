<?php
    header('Content-Type: text/json'); 

    $host = $_SERVER['HTTP_HOST'];
    $uri = rtrim (dirname($_SERVER['PHP_SELF']), '/\\');
    $base_url = "https://$host$uri";

    try{
        $dbh = new PDO("sqlite:doghouse.db");
    } catch(PDOException $e) {
        echo 'Connection failed. Error: ' . $e->getMessage();
    }

    $sql = "SELECT name,age,pet_id FROM Pets";

    foreach ($dbh->query($sql) as $row){
        $petName = $row['name'];
        $petKind = "Dog";//hardcoded in temporarily
        $breed = "Boxer";//hardcoded in temporarily
        $datePosted = "1/1/1900";//hardcoded in temporarily
        $petID = $row['pet_id'];

        $pictureSQL = "SELECT pictureName FROM PetPictures WHERE pet_id='$petID' LIMIT 1";
        $pictureFileName = $dbh->query($pictureSQL)->fetchColumn();
        $imageURL = $base_url . "/getImage.php/?image=" . $pictureFileName; 

        $descURL = $base_url . "/dogs.php?pet_id=" . $petID;

        $status = Array("petName" => "$petName", 
                        "petKind" => "$petKind", 
                        "breed" => "$breed",
                        "datePosted" => "$datePosted",
                        "imageURL" => "$imageURL",
                        "petID" => "$petID",
                        "descURL" => "$descURL");

        echo json_encode($status);
    }    
?>