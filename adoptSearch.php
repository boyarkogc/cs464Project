<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
    $term = $_REQUEST['term'];
    try{
	    $dbh = new PDO("sqlite:doghouse.db");
    } catch(PDOException $e) {
	    echo 'Connection failed. Error: ' . $e->getMessage();
    }

    $sql = "SELECT name,age,pet_id FROM Pets WHERE ( name LIKE '%$term%' OR weight LIKE '%$term%' OR age LIKE '%$term%')";

    echo "<table>";
    $td_count = 0;
    foreach ($dbh->query($sql) as $row){
	$petName = $row['name'];
	$petID = $row['pet_id'];
	$picture = "SELECT pictureName FROM PetPictures WHERE pet_id='$petID' LIMIT 1";
	$pictureFileName = $dbh->query($picture)->fetchColumn();
	if(($td_count % 3)==0){ echo "<tr>";}
	echo "<td style='vertical-align:bottom;'>";
    
	if($pictureFileName==''){
	    echo "<h3>" . $petName . " Has No Pictures </h3>";
	    echo "</br>";
	    echo "<a href='dogs.php?pet_id=$petID'>" . $petName . "</a>";
	} else {
	    echo "<img class='thumbnails' src='images/" . $pictureFileName . "' width='300' height='300'/>";
	    echo "</br>";
	    echo "<a href='dogs.php?pet_id=$petID'>" . $petName . "</a>";
    }
    echo "</td>";

    if(($td_count % 3)==2){ echo "</tr>";}
    $td_count++;
    
    }
    if(($td_count % 3)!=2){ echo "</tr>";}
    echo "</table>";
?>
</body>
</html>
