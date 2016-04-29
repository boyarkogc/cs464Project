<!-- start of header/banner to include on every page -->
<header>
    <div id="topBar">
        <div style="display:inline; padding-right: 3em;">
            <?php
            if(isset($_SESSION["username"])){
                echo "<p style='color:white; display:inline;'> / </p> ";
                echo $_SESSION['username'];
                echo "<p style='color:white; display:inline;'> / </p> ";
                $currentPage = $_SERVER['PHP_SELF'];
                echo "<a href='$currentPage?logout=true'>logout</a>" ;
                echo "<p style='color:white; display:inline;'> / </p> ";
	     } else {
                echo "<p style='color:white; display:inline;'> / </p> ";
                echo "<a href='./login.php'>login</a>" ;
                echo "<p style='color:white; display:inline;'> / </p> ";
            }
            ?>
        </div>
    </div>

    <div id="mainHeader">
       <img id="headerLogo" src="Logo.png" width="150px" height="103px"/>
       <p id="headerMotto">Keep track of all your </p>
    </div>

</header>

<nav>
    <a href="./index.php" id="homeNav">Home</a>
    <a href="./aboutus.php" id="aboutusNav">About Us</a>
    <a href="./adopt.php" id="adoptNav">Adopt</a>
    <a href="./addDog.php" id="addDogNav">Add A Dog</a>
</nav>
