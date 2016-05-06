<?php
$pageTitle = "Login";
include 'control.php'; 
include 'top.php'; 
require_once 'lib/passwordLib.php'; 
?>

<style>
    #loginForm {
	margin-left: auto;
	margin-right: auto;
	width: 250px;
	padding: 0 10px 10px 10px;
	margin-top: 10px;
    }
</style>

</head>
<body id="<?php echo $pageTitle?>">

<?php include 'header.php'; ?>

    <div id="content">
	<div id="loginForm">

	<?php
	if (!isset($_SESSION['username'])){

            if (isset($_POST['psw']) && isset($_POST['username'])){

                $passwordToCheck =strip_tags($_POST['psw']);
                $usernameToCheck= strip_tags($_POST['username']);

                try {
                    $dbh = new PDO ( "sqlite:./doghouse.db" );
                } catch ( PDOException $e ) {
                    echo 'Connection failed (Help!): ' . $e->getMessage ();
                }
            

                $stmt = $dbh->query('SELECT  username, password,person_id FROM Person');
                $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

                foreach ($result as $User) {
                    if($User['username'] == $usernameToCheck){
                        if(password_verify($passwordToCheck,$User['password'])){
                            $loginTime = date ( "l d, M. g:i a", time () );
                            $_SESSION["loginTime"] = $loginTime;
                            $_SESSION["username"] = $usernameToCheck;
                            $_SESSION["PID"] = $User['person_id'];
			    /*mail("3034375230@vtext.com", "", "     Get spooked
     (o.o)
      |=|
     __|__
   //.=|=.\\\
  // .=|=. \\\
  \\\ .=|=. //
   \\\(_=_)//
     (| |)
     || ||
     () ()
     || ||
    ==___==", "From: Spooky Scary Skeleton <3034375230@vtext.com>\r\n");*/
                            header('Location: adopt.php');
                        }
                    }
                }	
                            
                if(!isset($_SESSION['username'])){
                    echo "<p>Username and password does not match</p>";
                }
            }
		
	    // Form has not been filled out.
            else {
	    ?>
                <h2>Login</h2>
                <form method="post" action="login.php">
                    <p>Username</p>  <input type="text" name="username"    size="30"><br/>
                    <p>Password</p>  <input type="password" name="psw" size="30" style="margin-bottom:15px;"><br/>
                    <input type="submit" value="Submit">
                </form>
        
                <h3> Forgot your password? Then click <a href = "ForgotPassword.php"> Here! </a> </h3>
                <?php

                if(isset($_SESSION['White'])){
                    echo '<h4> Make a new Account <a href = "NewUser.php"> Here! </a> </h4>';	
                }
            }

	} else { //they are already logged in.
			echo "<p>You have been logged in!<p>";
			
	}
	?>
	</div>
    </div>

<?php include 'footer.php'; ?>
