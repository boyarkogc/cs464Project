<?php
$pageTitle = "Client";
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
	    <?php
							echo "<a href=\"profileEdit.php?pet_id=$petID\" class=\"btn btn-primary\" style=\"margin:5px;\"><button type='button'>Edit Profile</button></a>";
	?>	
		<tr><td class="leftData" align="right">Age:</td><td><?php echo $result['age']; ?></td></tr>
		<tr><td class="leftData" align="right">Weight:</td><td><?php echo $result['weight']; ?></td></tr>
	    </table>

	    <div class="sesh">			
		    <a href="sessionstub.txt" download><button type="button">Download</button></a>
		    <br>

		<script>
			function printDiv(divName) {
				var printContents = document.getElementById(divName).innerHTML;
			     var originalContents = document.body.innerHTML;

			     document.body.innerHTML = printContents;

			     window.print();

			     document.body.innerHTML = originalContents;
			 }
		</script>
		<br>
		<iframe src="sessionstub.txt" style="width:0;height:0;border:0; border:none;"name="frame"></iframe>

		<input type="button" onclick="frames['frame'].print()" value="Print Stub">
		</div>
	</div>
	<hr>
	<div id="dogDescription">
	    <p><?php echo $result['longText']?></p>
	</div>
	<hr>
	

	<div class="digInfoTabs">
		<ul>
			<li><a href= <?php echo "dogContact.php?pet_id=".$petID ?> >Contact Info</a></li>
			<li><a href= <?php echo "dogMessages.php?pet_id=".$petID ?> >Messages</a></li>
			<li><a href= <?php echo "dogWorkout.php?pet_id=".$petID ?> >Workout</a></li>
			<li><a href= <?php echo "dogMedical.php?pet_id=".$petID ?> >Medical History</a></li>
		</ul>
	</div>
	</div>
	
	
    
    </div>

<?php include 'footer.php'; ?>
