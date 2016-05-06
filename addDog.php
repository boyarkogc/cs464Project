<?php
$pageTitle = "Add_A_Dog";
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
		$phoneNum = SQLite3::escapeString($_POST["phoneNum"]);
		$carrier = SQLite3::escapeString($_POST["carrier"]);
		$workout = SQLite3::escapeString($_POST["workout"]);
		$medical = SQLite3::escapeString($_POST["medical"]);
                
                try {
                    $dbh = new PDO("sqlite:doghouse.db");
                } catch(PDOException $e) {
                    echo 'Connection failed. Error: ' . $e->getMessage();
                }
        

                $sql = "INSERT INTO Pets (name, weight, age, neutered, shortText, longText, phoneNumber, medicalHistory, workout) VALUES (:name,:weight,:age,:neutered,:shortText,:longText,:phoneNumber,:medicalHistory,:workout)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute( array( ":name" => $petName, ":weight" => $petWeight, ":age" => $petAge, ":neutered" => $petNeutered, ":shortText" => $petSD, ":longText" => $petLD, ":phoneNumber" => $phoneNum . "@" . $carrier, ":medicalHistory" => $medical, ":workout" => $workout));
	       
                $dogID = $dbh->lastInsertID("pet_id");
                
                header("Location: addDogPictures.php?pet_id=$dogID");
	    

            } else { //propose form or validation
		if (isset($_POST['petName'])) {  //form is filled, strip tags and validate
		    
                    $petName = strip_tags($_POST["petName"]);
                    $petWeight = strip_tags($_POST["petWeight"]);
                    $petAge = strip_tags($_POST["petAge"]);
                    $petNeutered =  (isset($_POST["petNeutered"]) ? 1 : 0);
                    $petSD = strip_tags($_POST["petSD"]);
                    $petLD = strip_tags($_POST["petLD"]);
		    $phoneNum = strip_tags($_POST["phoneNum"]);
		    $carrier = strip_tags($_POST["carrier"]);
		    $workout = strip_tags($_POST["workout"]);
		    $medical = strip_tags($_POST["medical"]);

		    

		    echo "<h3>Is this correct?</h3>";
		    echo "<p>Name: " . $petName . "</p>";
		    echo "<p>Weight: " . $petWeight . "</p>";
		    echo "<p>Age: " . $petAge . "</p>";
		   # echo "<p>Neuteured: " . ($petNeutered==0 ? "No" : "Yes") . "</p>";
		    echo "<p>Short Description: " . $petSD . "</p>";
		    echo "<p>Long Description: " . $petLD . "</p>";
		    echo "<p>Phone Number: " . $phoneNum . "</p>";
		    echo "<p>Phone Carrier: " . $carrier . "</p>";
		    echo "<p>Workout info: " . $workout . "</p>";
		    echo "<p>Medical History: " . $medical . "</p>";
		    ?>

		    <form style="display:inline" method="post" >
			<input type="hidden" name="petName" value="<?php echo $petName ?>">
			<input type="hidden" name="petWeight" value="<?php echo $petWeight ?>">
			<input type="hidden" name="petAge" value="<?php echo $petAge ?>">
			<input type="hidden" name="petSD" value="<?php echo $petSD ?>">
			<input type="hidden" name="petLD" value="<?php echo $petLD ?>">
			<input type="hidden" name="phoneNum" value="<?php echo $phoneNum ?>">
			<input type="hidden" name="carrier" value="<?php echo $carrier ?>">
			<input type="hidden" name="workout" value="<?php echo $workout ?>">
			<input type="hidden" name="medical" value="<?php echo $medical ?>">
			<input type="hidden" name="setInfo">
			<input type="submit" value="Yes">
		    </form>
		    <form style="display:inline" method="post">
			<input type="submit" value="No">
		    </form>

		<?php
		} else { //Form has not been filled out
		?>
		    <h2>Add a Client</h2>
		    <form method="post" >
			Client Name<br/> <input type="text" name="petName" size="30" required><br/><br/>
			Weight <br/><input type="number" name="petWeight"   min="0" max="999" size="3" required> lbs.<br/><br/>
			Age<br/> <input type="number" name="petAge"    size="3" min="0" max="999" required><br/><br/>
			Short Description (50 characters)<br/> <input type="text" name="petSD" maxlength="50" size="50" required><br/><br/>
			Long Description (50-250 characters)<br/> <textarea rows="3" name="petLD" maxlength="250" style="width:40em" required></textarea><br/><br/>
			Phone number<br/> <input type="text" name="phoneNum"    size="3" min="0" max="999" required><br/><br/>
			Phone carrier(eg. Verizon, AT&T, etc.)<br/> <input type="text" name="carrier"    size="3" min="0" max="999" required><br/><br/>
			Workout information<br/> <input type="text" name="workout"    size="3" min="0" max="999" required><br/><br/>
			Medical History<br/> <input type="text" name="medical"    size="3" min="0" max="999" required><br/><br/>
			<input type="submit" value="Submit">
		    </form>




		<?php
		} 
	    }
		?>

        </div>

    
    </div>

<?php include 'footer.php'; ?>
