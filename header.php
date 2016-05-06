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
                echo "<a href='./login.php?logout=true'>logout</a>" ;
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
       <img id="headerLogo" src="Logo1.jpg" width="150px" height="103px"/>
       <p id="headerMotto">Keep track of all your Clients Today</p>
    </div>

</header>

<nav>
    <?php if ($pageTitle != "Login"): ?>
    <a href="./adopt.php" id="adoptNav">Clients</a>
    <a href="./notification.php" id="addDogNav">Notifications</a>
    <a href="./addDog.php" id="addDogNav">File</a>
    <a href="./addDog.php" id="addDogNav">Add A Client</a>
    <?php endif; ?>
</nav>
