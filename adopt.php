<?php
$pageTitle = "Adopt";
include 'control.php'; 
include 'top.php'; 
?>

<style>
table{
    margin-top: 1em;
    margin-right:auto;
    margin-left:auto;
}
td{
    padding:.5em;
    text-align:center;
}
</style>
<script type="text/javascript">
	var http = new XMLHttpRequest();
	
	function search(term) {
		http.abort();
		http.open("GET", "adoptSearch.php?term="+term, true);
		http.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
		http.onreadystatechange = function() {
			if (http.readyState == 4) {
				document.getElementById('dogResults').innerHTML = http.responseText;
			}
		}
		http.send();
	}

</script>

</head>
<body id="<?php echo $pageTitle?>">

<?php include 'header.php'; ?>

    <div id="content">
	<h3>My Clients</h3>
	<form>
        
		Search: <input type="text" onkeyup="search(this.value)" />
	</form>

	<hr>

	<div id="dogResults">
	<?php
	///////////////////////////////////  This will be replaced by search //////////////////////////////
	try{
		$dbh = new PDO("sqlite:doghouse.db");
	} catch(PDOException $e) {
		echo 'Connection failed. Error: ' . $e->getMessage();
	}

	$sql = "SELECT name,age,pet_id,person_id FROM Pets";

	echo "<table>";
	$td_count = 0;

	foreach ($dbh->query($sql) as $row){
		if ($row['person_id']== $_SESSION['PID']){

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
	}
	if(($td_count % 3)!=2){ echo "</tr>";}
	echo "</table>";
    ////////////////////////////////////////////////////////////////////////////////////////////////////////////
	?>
        
	</div>
    </div>

<?php include 'footer.php'; ?>
