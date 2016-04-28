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
                
                try {
                    $dbh = new PDO("sqlite:doghouse.db");
                } catch(PDOException $e) {
                    echo 'Connection failed. Error: ' . $e->getMessage();
                }
        

                $sql = "INSERT INTO Pets (name, weight, age, neutered, shortText, longText) VALUES (:name,:weight,:age,:neutered,:shortText,:longText)";
                $stmt = $dbh->prepare($sql);
                $stmt->execute( array( ":name" => $petName, ":weight" => $petWeight, ":age" => $petAge, ":neutered" => $petNeutered, ":shortText" => $petSD, ":longText" => $petLD));
	       
                $dogID = $dbh->lastInsertID("id");
                
                header("Location: addDogPictures.php?pet_id=$dogID");
	    

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
		    echo "<p>Neuteured: " . ($petNeutered==0 ? "No" : "Yes") . "</p>";
		    echo "<p>Short Description: " . $petSD . "</p>";
		    echo "<p>Long Description: " . $petLD . "</p>";
		    ?>

		    <form style="display:inline" method="post" >
			<input type="hidden" name="petName" value="<?php echo $petName ?>">
			<input type="hidden" name="petWeight" value="<?php echo $petWeight ?>">
			<input type="hidden" name="petAge" value="<?php echo $petAge ?>">
			<input type="hidden" name="petNeutered" value="<?php echo $petNeutered ?>">
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
		    <h2>Add a Dog</h2>
		    <form method="post" >
			Pet Name<br/> <input type="text" name="petName" size="30" required><br/><br/>
			Weight <br/><input type="number" name="petWeight"   min="0" max="999" size="3" required> lbs.<br/><br/>
			Age<br/> <input type="number" name="petAge"    size="3" min="0" max="999" required><br/><br/>
			Neutered?<br/> <input type="checkbox" name="petNeutered" ><br/><br/>
			Short Description (50 characters)<br/> <input type="text" name="petSD" maxlength="50" size="50" required><br/><br/>
			Long Description (50-250 characters)<br/> <textarea rows="3" name="petLD" maxlength="250" style="width:40em" required></textarea><br/><br/>
			<input type="submit" value="Submit">
		    </form>




		<?php
		} 
	    }
		?>

        </div>

    
    </div>

<?php include 'footer.php'; ?>
