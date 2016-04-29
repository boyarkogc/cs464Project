<?php
$pageTitle = "About_Us";
include 'control.php'; 
include 'top.php'; 
?>

<style>
table{
    margin-top: 1em;
    margin-right:auto;
    margin-left:auto;
}
td{
    padding:.5em;
    text-align:center;
}
</style>

</head>
<body id="<?php echo $pageTitle?>">

<?php include 'header.php'; ?>

    <div id="content">
    <h3>About Us</h3>
    <hr>
    	
    <h2>Our Organization</h2>
    
    <p>The Doghouse is a tax-exempt, 501(c)3 non-profit, volunteer-operated organization co-founded
    in 2016 by Jeff Penn and Wade Sherwood as part of Colorado State University's CT310 course requirements. 
    Our mission is to, among other things, create "a set of requirements to maintain a meaningful web presence."
    In coordination with these assignment requirements, we also hope to further our knowledge of web developement, 
    as well as get some of these super cute dogs adopted!</p>
		
    <p></p>
    
    <p>Since this website was created exclusively for an assignment, neither Jeff nor Wade actually have any
    experience with animal adoptions or the adoption process. Typically, this section of the "About Us" would 
    explain to the reader "who we are" as an organization. In order to fill space on this page, some general
    information about our website, and this assignment, will be given.</p>
    
    <p></p>
    
    <h2>Assignment</h2>
    
    <p>CT310 is a web development course offered at Colorado State University. At this point in the course,
    students are expected to understand HTML, CSS, and PHP, and Database management. This assignment is the second
    phase in a semester-long project which will be completed in stages by randomly selected pairs of students,
    in order to facilitate "real-world" project expectations.</p>
    
    <p></p>
    
    <p>In order to fill some space on the page, a list is provided below covering a few
    of the requirements of our assignment:
    <ul>
        <li>Create users and Create pets</li>
        <li>Dynamically loaded Pets page</li>
        <li>A Database</li>
        <li>Password Reset Capability</li>
        <li>Image uploading of pets</li>
        <li>AJAX Searching of Pets</li>
    </ul>		
    List is referenced from 
    <a href= "https://www.cs.colostate.edu/~ct310/yr2016sp/more_assignments/project02.php">CT310 Project 2.</a>		
    </p>
    
    <p>The website we were give to reference, <a href="http://colliesheltierescue.org">Rocky Mountain Collie Sheltie
    Rescue</a>, is a beautifully made website
    complete with aspects of javascript and other web development practices that we have not yet covered in
    class, such as their pleasing visual effects on their home page. Due to our lack of knowledge, our site 
    will consist primarily of blocks of text and static photos.</p>
    
    <p></p>
    
    <h2>Disclaimer</h2>
    
    <p>Currently, all of our dogs have loving homes and are not actually in need of adoption. As this website
    is for an assignment for one of our classes, we are not actually running an adoption agency through our site, nor
    are we planning on giving up any of our much-loved pets.</p>  
    
    </div>

<?php include 'footer.php'; ?>
