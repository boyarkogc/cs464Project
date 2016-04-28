<?php
$pageTitle = "Dogs";
include 'control.php'; 
include 'top.php'; 
?>
</head>
<body id="<?php echo $pageTitle?>" class="adoptionPage">

<?php include 'header.php'; ?>

    <div id="content">
	<?php 
	$petID = SQLite3::escapeString(strip_tags($_GET['pet_id']));

	try{
	    $dbh = new PDO("sqlite:doghouse.db");
	} catch(PDOException $e) {
	    echo 'Connection failed. Error: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM Pets WHERE pet_id='$petID'";
	$result = $dbh->query($sql)->fetch();

	$picture = "SELECT pictureName FROM PetPictures WHERE pet_id='$petID' LIMIT 1";
	$headShotFileName = $dbh->query($picture)->fetchColumn();
	?>

	<h2><?php echo $result['name']?></h2>
	
	<div id="dogShortInfo">
	    <p><?php echo $result['shortText'] ?>
	</div>
    
	<div id="dogHeadshot" class="dogMain">
	    <?php
	    if($headShotFileName == ''){ echo $result['name'] . " Has No Pictures"; 
	    } else { echo "<img src='images/". $headShotFileName. "' width='500' height='500' style='max-width:300px; max-height:300px;'/>";}
	    ?>
	</div>
	
    
	<div id="dogTable" class="dogMain">
	    <table>
		<tr><td class="leftData" align="right">Age:</td><td><?php echo $result['age']; ?></td></tr>
		<tr><td class="leftData" align="right">Weight:</td><td><?php echo $result['weight']; ?></td></tr>
		<tr><td class="leftData" align="right">Spayed/Nuetered:</td><td><?php echo ($result['age']==1 ? "Yes" : "No"); ?></td></tr>
	    </table>
	</div>
	<hr>
	<div id="dogDescription">
	    <p><?php echo $result['longText']?></p>
	</div>
	<hr>
	
	<?php
	$pictures = "SELECT * FROM PetPictures WHERE pet_id='$petID'";
	echo "<div style='padding-left:50px'>";
	foreach ($dbh->query($pictures) as $row){
	    echo "<img src='images/" . $row['pictureName'] . "' width='500' height='500' style='max-width:350px; max-height:350px; padding:5px;'/>";
	}
	?>
	</div>
    
    <?php include 'adoptComments.php'; ?>
    </div>

<?php include 'footer.php'; ?>
