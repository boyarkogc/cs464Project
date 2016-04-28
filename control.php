<?php 

/****************************************************************************/
/*****		    site variables here for easy changing		*****/
/****************************************************************************/

$siteDescription = "1st project for CT310 at CSU";
$siteKeywords = "CT310";
$siteAuthors = "Wade, Jeff";
$siteStylesheet = "projectstyle.css";
$whitelist = array("129.82.44.","129.82.45.","129.82.46.","127.0.0.1");

$sessionName = "NoCoDoghouse";



/****************************************************************************/
/*****			    Site wide functions	           		*****/
/****************************************************************************/

function logout(){
        print_r($_SESSION);
        session_unset();
        session_destroy();
        $currentPage = $_SERVER['PHP_SELF'];
        header("Location: $currentPage");
}

/****************************************************************************/
/*****			    Site wide Objects	           		*****/
/****************************************************************************/



/****************************************************************************/
/*****		 Session start and begining php for each page		*****/
/****************************************************************************/

session_name ( $sessionName );
session_start ();


if(isset($_GET['logout'])) {
        logout();
}

date_default_timezone_set ( 'America/Denver' ); 

include 'database.php';

if(!(file_exists("doghouse.db"))){
    createDatabase();
}

if(!(file_exists("images"))){ 
	if (! mkdir ("images",0775)) {
		$error_msg = "Failed to make images folder failed";
	}
}
chmod("images",0755);
foreach ($whitelist as $query) {
    if(substr($_SERVER['REMOTE_ADDR'], 0, strlen($query)) === $query){
	    $_SESSION['White'] = "True";
    }
}

?>
