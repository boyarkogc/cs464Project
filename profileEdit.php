<?php
$pageTitle = "Edit Profile";
include 'control.php'; 
include 'top.php'; 
?>

<style>
</style>

</head>
<body id="<?php echo $pageTitle?>">

<?php include 'header.php'; ?>

    <div id="content">

        <?php
            if(!isset($_SESSION["username"])){
                header("Location:login.php");
            }

    $petID = SQLite3::escapeString(strip_tags($_GET['pet_id']));

	try{
	    $dbh = new PDO("sqlite:doghouse.db");
	} catch(PDOException $e) {
	    echo 'Connection failed. Error: ' . $e->getMessage();
	}

	$sql = "SELECT * FROM Pets WHERE pet_id='$petID'";
	$result = $dbh->query($sql)->fetch();

        ?>

    	<div id="loginForm">
        <?php
            if (isset($_POST['setInfo'])) { //Need to enter the strings into the database.
		
                $petName = SQLite3::escapeString ($_POST["petName"]);
                $petWeight = SQLite3::escapeString ($_POST["petWeight"]);
                $petAge = SQLite3::escapeString ($_POST["petAge"]);
                $petNeutered = SQLite3::escapeString ($_POST["petNeutered"]);
                $petSD = SQLite3::escapeString ($_POST["petSD"]);
                $petLD = SQLite3::escapeString ($_POST["petLD"]);
                
                try {
                    $dbh = new PDO("sqlite:doghouse.db");
                } catch(PDOException $e) {
                    echo 'Connection failed. Error: ' . $e->getMessage();
                }
        
                $sql = "UPDATE Pets SET name=:name, weight=:weight, age=:age, neutered=:neutered, shortText=:shortText, longText=:longText WHERE pet_id=$petID";
                $stmt = $dbh->prepare($sql);
                $stmt->execute( array( ":name" => $petName, ":weight" => $petWeight, ":age" => $petAge, ":neutered" => $petNeutered, ":shortText" => $petSD, ":longText" => $petLD));
	       
                
                header("Location: dogs.php?pet_id=$petID");
	    

            } else { //propose form or validation
		if (isset($_POST['petName'])) {  //form is filled, strip tags and validate
		    
                    $petName = strip_tags($_POST["petName"]);
                    $petWeight = strip_tags($_POST["petWeight"]);
                    $petAge = strip_tags($_POST["petAge"]);
                    $petNeutered =  (isset($_POST["petNeutered"]) ? 1 : 0);
                    $petSD = strip_tags($_POST["petSD"]);
                    $petLD = strip_tags($_POST["petLD"]);

		    

		    echo "<h3>Is this correct?</h3>";
		    echo "<p>Name: " . $petName . "</p>";
		    echo "<p>Weight: " . $petWeight . "</p>";
		    echo "<p>Age: " . $petAge . "</p>";
		    #echo "<p>Neuteured: " . ($petNeutered==0 ? "No" : "Yes") . "</p>";
		    echo "<p>Short Description: " . $petSD . "</p>";
		    echo "<p>Long Description: " . $petLD . "</p>";
		    ?>

		    <form style="display:inline" method="post" >
			<input type="hidden" name="petName" value="<?php echo $petName ?>">
			<input type="hidden" name="petWeight" value="<?php echo $petWeight ?>">
			<input type="hidden" name="petAge" value="<?php echo $petAge ?>">
			<input type="hidden" name="petSD" value="<?php echo $petSD ?>">
			<input type="hidden" name="petLD" value="<?php echo $petLD ?>">
			<input type="hidden" name="setInfo">
			<input type="submit" value="Yes">
		    </form>
		    <form style="display:inline" method="post">
			<input type="submit" value="No">
		    </form>

		<?php
		} else { //Form has not been filled out
		?>
		    <h2>Edit Profile</h2>
		    <form method="post" >
			Client Name<br/> <input type="text" name="petName" value="<?php echo$result['name']?>" size="30" required><br/><br/>
			Weight <br/><input type="number" name="petWeight"   min="0" max="999" size="3"  value="<?php echo$result['weight']?>"required> lbs.<br/><br/>
			Age<br/> <input type="number" name="petAge"    size="3" min="0" max="999"  value="<?php echo$result['age']?>" required><br/><br/>
			Contact Information <br/> <input type="text" name="petSD" maxlength="100" size="50"  value="<?php echo$result['shortText']?>" required><br/><br/>
			Long Description <br/> <input type="text" name="petLD" maxlength="250" style="width:40em" value="<?php echo$result['longText']?>" required><br/><br/>
			<input type="submit" value="Submit">
		    </form>




		<?php
		} 
	    }
		?>

        </div>

    
    </div>

<?php include 'footer.php'; ?>
