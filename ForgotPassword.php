<?php
$pageTitle = "Forgot_Password";
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

    	try {
            $dbh = new PDO ( "sqlite:./doghouse.db" );
        } catch ( PDOException $e ) {
            echo "Couldnt open the database Error " .  $e->getMessage();
        }
        
        $stmt = $dbh->query('SELECT  username, email FROM Person');
        $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if(isset($_POST ['mail'] )){

            $subject = "Password reset";

            $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = 'key=';
            $length = 32;
            
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            
            $_SESSION["reset"] = $randomString;
            $_SESSION['Guy'] = $_POST ['mail'];
            $content = "https://www.cs.colostate.edu/~jeffpenn/project2/PasswordReset.php?".$randomString; //This will need to be changed to where ever we end up hosting this.
            
            foreach ($Users as $User) {
                if ($User['username'] == $_POST['mail']) {
                        $res = $User['email'];
                }
            }
            
            error_reporting(0);
            
            if(mail($res, $subject, $content)) {
                echo "The email has been sent!";	
            }
            else {echo "Error sending the email to ". $res;}
        }

        
        ?>
        <p>Send the email to which user?</p>
        <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
            <select name="mail">	
            <?php 
            echo "\n";
            foreach ($Users as $User) {
                $flag = ($User['username'] == $_SESSION['userName']) ? 'selected' : '';
                echo "\t\t\t\t<option value=\"$User[username]\" $flag > $User[username] </option>\n";
            }
            ?>
            </select> 
            <input type="submit" />
        </form>
    
    </div> 
<?php include 'footer.php'; ?>
