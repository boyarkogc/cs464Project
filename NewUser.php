<?php
$pageTitle = "New_User";
include 'control.php'; 
include 'top.php'; 
require_once 'lib/passwordLib.php';


/*if(!isset($_SESSION['White'])){
	header('Location: /index.php');
}*/
?>

	<style>
	
	.Float{
	width: 300px;
	margin-top: 10px;
	padding: 0 30px 30px 30px;
	float: left;
	}
	.Err{
		color:red;
		font-size: 1.5em;
	}
	</style>


	</head>
	<body id="<?php echo $pageTitle?>">

	<?php include 'header.php'; ?>

    	<div id="content">
    	<div id="loginForm">
            <?php
            try {
                $dbh = new PDO("sqlite:doghouse.db");
            } catch(PDOException $e) {
                echo "Couldnt open the database Error " .  $e->getMessage();
            }
                
            if (isset($_POST['setInfo'])) { //Need to enter the strings into the database.
		
                    $FName = SQLite3::escapeString ($_POST["FName"]);
                    $MName = SQLite3::escapeString ($_POST["MName"]);
                    $LName = SQLite3::escapeString ($_POST["LName"]);
                    $UName = SQLite3::escapeString ($_POST["UName"]);
                    $Email = SQLite3::escapeString ($_POST["Email"]);
                    $Pass = SQLite3::escapeString ($_POST["Pass"]);
                    $Dog = SQLite3::escapeString ($_POST["Dog"]);
                    $Cat = SQLite3::escapeString ($_POST["Cat"]);
                    $Turt = SQLite3::escapeString ($_POST["Turt"]);
                    $Prev = SQLite3::escapeString ($_POST["Prev"]);
                    $MoPrev = SQLite3::escapeString ($_POST["MoPrev"]);
    

                    $sql = "INSERT INTO Person (firstName, middleName, lastName, email, username, password, priorDog, priorCat, priorTurtle, havePet, havePetExplain) 
                    VALUES (:Fname,:Mname,:Lname,:Email,:Uname,:Pass,:Dog,:Cat,:Turt,:Prev,:MoPrev)";
                    $stmt = $dbh->prepare($sql);
            
                    $stmt->execute( array( ":Fname" => $FName, ":Mname" => $MName, ":Lname" => $LName, ":Email" => $Email, 
                    ":Uname" => $UName, ":Pass" => $Pass, ":Dog" => $Dog, ":Cat" => $Cat, ":Turt" => $Turt, ":Prev" => $Prev, ":MoPrev" => $MoPrev));
            
                    echo "<h1>New Account made!</h1>";
                    echo "<h3>Login to it <a href = 'login.php'>here </a> </h3>";
            } else { //propose form or validation
                    if (isset($_POST['FName'])) {  //form is filled, strip tags and validate

                    $Valid = 1;
                    $FName = filter_var($_POST["FName"], FILTER_SANITIZE_STRING);
                    $Mname = ' ';
                    if(isset($_POST["MName"])){ $MName = filter_var($_POST["MName"], FILTER_SANITIZE_STRING);}
                    $LName = filter_var($_POST["LName"], FILTER_SANITIZE_STRING);
                    $Email = filter_var($_POST["Email"],FILTER_SANITIZE_EMAIL);
                    if(!filter_var($Email, FILTER_VALIDATE_EMAIL)){
                        $Valid=0;
                        echo "<p class='Err'>Email address ". $Email . " Isnt Vaild</p> </br>";
                    }
                    $UName = filter_var($_POST["UName"], FILTER_SANITIZE_STRING);
                    $Pass = filter_var($_POST["Pass"],FILTER_SANITIZE_STRING);
                    $Pass = password_hash($Pass,PASSWORD_DEFAULT);
                    if(isset($_POST["Dog"])){ $Dog =1;
                    }
                            else{
                            $Dog =0;
                    }
                            if(isset($_POST["Cat"])){
                            $Cat =1;
                    }
                    else{
                            $Cat =0;
                    }if(isset($_POST["Turt"])){
                            $Turt =1;
                    }
                    else{
                            $Turt =0;
                    }
                    $Prev = filter_var($_POST["Prev"],FILTER_SANITIZE_STRING);
                    $MoPrev = filter_var($_POST["MoPrev"],FILTER_SANITIZE_STRING);


                    $stmt = $dbh->query('SELECT  username, email FROM Person');
                    $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    $unique = 1;

                    foreach ($Users as $User) {
                        if ($User['username'] == $UName) {
                                echo "<p class='Err'>The username " .$UName ." has been taken </p><br/>";
                                $unique = 0;
                        }

                        if($User['email'] == $Email){
                                echo "<p class='Err'>The Email adress " . $Email . " Is already in use</p> <br/>";
                                $unique = 0;
                        }
                    }

                
                    if($unique == 1 && $Valid == 1){
                        echo "<div class='Float'>";
                        echo "<h3>Is this correct?</h3>";
                    
                        echo "<p>Name: " . $FName . " " .$MName . " " . $LName . "</p>";
                        echo "<p>Email: " . $Email . "</p>";
                        echo "<p>Username: " . $UName . "</p>";
                        echo "<p>Prev Dog: " . ($Dog==0 ? "No" : "Yes") . "</p>";
                                echo "<p>Prev Cat: " . ($Cat==0 ? "No" : "Yes") . "</p>";
                        echo "<p>Prev Turtle " . ($Turt==0 ? "No" : "Yes") . "</p>";
                        echo "<p>Do you have a pet needing a home?: " . $Prev . "</p>";
                        echo "<p>Explain why it needs a home or why youre looking: " . $MoPrev . "</p>";
                    ?>
                    
                        <form style="display:inline" method="post" >
                                <input type="hidden" name="FName" value="<?php echo $FName ?>">
                                <input type="hidden" name="MName" value="<?php echo $MName ?>">
                                <input type="hidden" name="LName" value="<?php echo $LName ?>">
                                <input type="hidden" name="UName" value="<?php echo $UName ?>">
                                <input type="hidden" name="Pass" value="<?php echo $Pass?>">
                                <input type="hidden" name="Email" value="<?php echo $Email ?>">
                                <input type="hidden" name="Dog" value="<?php echo $Dog ?>">
                                <input type="hidden" name="Cat" value="<?php echo $Cat ?>">
                                <input type="hidden" name="Turt" value="<?php echo $Turt?>">
                                <input type="hidden" name="Prev" value="<?php echo $Prev ?>">
                                <input type="hidden" name="MoPrev" value="<?php echo $MoPrev ?>">
                                <input type="hidden" name="setInfo">
                                <input type="submit" value="Yes">
                        </form>
                        </div>
                        <h3>If Not Enter The Information Again and Resubmit</h3>

                    <?php 
                    }?>
                        <div class="Float">
                        <h2>Make New User</h2>
                        <form method="post" >
                            First Name<br/> <input type="text" name="FName" size="30" value="<?php echo $FName ?>" required><br/><br/>
                            Mid Name<br/> <input type="text" name="MName" size="30" value="<?php echo $MName ?>" ><br/><br/>
                            Last Name<br/> <input type="text" name="LName" size="30" value="<?php echo $LName ?>" required><br/><br/>
                            Email <br/><input type="email" name="Email"  size="30" value="<?php echo $Email ?>" required><br/><br/>
                            Username<br/> <input type="text" name="UName"  size="30" value="<?php echo $UName ?>" required><br/><br/>
                            Password<br/> <input type="password" name="Pass"  size="30" required><br/><br/>
                            Prior Dog?<br/> <input type="checkbox" name="Dog" ><br/><br/>
                            Prior Cat?<br/> <input type="checkbox" name="Cat" ><br/><br/>
                            Prior Turtle?<br/> <input type="checkbox" name="Turt" ><br/><br/>
                            Do you have a pet needing a home?<br/> <input type="text" name="Prev" maxlength="50" size="50" value="<?php echo $Prev ?>" required><br/><br/>
                            Explain why it needs a home or why youre looking<br/> <textarea rows="3" name="MoPrev" maxlength="300" style="width:40em"  required> <?php echo $MoPrev ?> </textarea><br/><br/>
                            <input type="submit" value="Submit">
                        </form>
                    </div>
                    <?php
		} 
		else { //Form has not been filled out
			?>

		    <h2>Make New User</h2>
		    <form method="post" id="Float">
			First Name<br/> <input type="text" name="FName" size="30" required><br/><br/>
			Mid Name<br/> <input type="text" name="MName" size="30" ><br/><br/>
			Last Name<br/> <input type="text" name="LName" size="30" required><br/><br/>
			Email <br/><input type="email" name="Email"  size="30" required><br/><br/>
			Username<br/> <input type="text" name="UName"  size="30" required><br/><br/>
			Password<br/> <input type="password" name="Pass"  size="30" required><br/><br/>
			Prior Dog?<br/> <input type="checkbox" name="Dog" ><br/><br/>
			Prior Cat?<br/> <input type="checkbox" name="Cat" ><br/><br/>
			Prior Turtle?<br/> <input type="checkbox" name="Turt" ><br/><br/>
			Do you have a pet needing a home?<br/> <input type="text" name="Prev" maxlength="50" size="50" required><br/><br/>
			Explain why it needs a home or why youre looking<br/> <textarea rows="3" name="MoPrev" maxlength="300" style="width:40em" required></textarea><br/><br/>
			<input type="submit" value="Submit">
		    </form>

			<?php
		} 
	}
			?>

		</div>

    
	</div>



<?php include 'footer.php'; ?>
