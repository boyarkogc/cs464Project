<?php
$pageTitle = "Password_Reset";
include 'control.php'; 
include 'top.php'; 
require_once 'lib/passwordLib.php'; 
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

        $stmt = $dbh->query('SELECT  username FROM Person');
        $Users = $stmt->fetchAll(PDO::FETCH_ASSOC);


        if(isset($_POST['Once']) && isset($_POST['Twice'])){
            if($_POST['Once'] == $_POST['Twice']){

                $pass = password_hash($_POST['Once'],PASSWORD_DEFAULT);

                foreach ($Users as $User) {
                        
                    if($User['username'] == $_SESSION['Guy'] ){

                        $sql ="UPDATE Person SET password= :pass WHERE username = :username ";
                        $dbh->prepare($sql)->execute( array( ":pass" => $pass, ":username" => $_SESSION['Guy']));
                        echo "SUCCESS Password changed! <br/>";
                    }
                }					
        }
        else{
            echo "Entered passwords do not match!";}
        }

        if(isset($_SERVER['QUERY_STRING']) && isset($_SESSION["reset"])){
            $key = $_SERVER['QUERY_STRING'];
            if($key == $_SESSION["reset"]){
            
                echo "Hello ". $_SESSION['Guy']. " You can reset your password! <br/>";
                ?>

                <form action=<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> method="post">
                    <p>New Password:<input type="Password" name="Once" /></p>
                    <p>Repeat Password:<input type="Password" name="Twice" /></p>
                    <input type="Submit" />
                </form>

                <?php
            }
        }
        else{

            echo "You cant do anything here you dont have the right key";
        }
        ?>

    </div>

<?php include 'footer.php'; ?>
