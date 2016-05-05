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
	    </table>
	</div>
	<hr>
	<div id="dogDescription">
	    <p><?php echo $result['longText']?></p>
	</div>
	<hr>
	
	
	<div class="digInfoTabs">
		<ul>
				<li><a href= <?php echo "dogContact.php?pet_id=".$petID ?> >Contact Info</a></li>
				<li><a href= <?php echo "dogMessages.php?pet_id=".$petID ?>  style="background-color:orange" >Messages</a></li>
				<li><a href= <?php echo "dogWorkout.php?pet_id=".$petID ?> >Workout</a></li>
				<li><a href= <?php echo "dogMedical.php?pet_id=".$petID ?> >Medical History</a></li>
		</ul>
	</div>
	
	<div>
		<p>Message: hello</p>
	</div>
    
    <?php include 'adoptComments.php'; ?>
    </div>

<?php include 'footer.php'; ?>
