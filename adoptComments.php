<?php
if(isset($_SESSION['username'])){
    if(isset($_POST['comment'])){
        $comments = strip_tags($_POST['comment']);
?>
	<br>
        <p style="color:red; text-align:center;">Thank you for your comments. We will definitely hold on to them and contemplate their great meaning.</p>
        <br>

<?php 
    }else {
    ?>
	<br>
	<form method="post" action="">
	    <p>Comments:</p>  
            <textarea rows="10" name="comment" style="width:100%" placeholder="Comment on client..."></textarea>
            <input type="submit" value="Add Comment">
        </form>
	<br>
    <?php
        }
    }
?>

