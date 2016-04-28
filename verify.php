<?php	
require "header.php";

	//printSessionInfo();
  	if(! isset($_SESSION['userName']) ){
        header("Location: " . "index.php");
        exit();
    }


    if(isset($_SESSION['question_answer'] ) ){
        header("Location: " . "profile.php?userName=".$_SESSION['userName']);
        exit();
    }


    if(isset($_POST["question_answer"])){  

        $user = $databaseObj->findAnswer(sanitize($_POST["question_answer"]) );

        if(is_null($user)){
            $errors[0] = "Answer is invalid!";
        }else {          
          $_SESSION['question_answer'] = $user->question_answer;
              header("Location: " . "profile.php?userName=".$_SESSION['userName']);
              return;   
        }
    }


    ?>

<div class="container">
  <div class="main" >
    <h1>Validate</h1>
    <div class="row">
    	 <div class="col-md-6 col-md-offset-3">
	<?php
	//Displays correct security question based off of security ID
	    if($_SESSION['question_id'] == 1){
		
		    echo "<h2>What is your favorite color? </h2>";
	
	    }else if($_SESSION['question_id'] == 2){
	
		     echo "<h2>What is your maiden name?</h2>";
	
	    }else if($_SESSION['question_id'] == 3){
	
		     echo "<h2>What is your hometown?</h2>";
	
	    }else if($_SESSION['question_id'] == 4){
	
		    echo "<h2>Who is your best friend?</h2>";
	
	    }

     	if(isset($errors)) {
     		foreach($errors as $error) {
     			echo "<div class=\"alert alert-danger\" role=\"alert\">$error</div>";
     		}
     	}
     ?>

         <form method="post" action="verify.php">
						<div class="form-group">
							<input type="text" class="form-control" name="question_answer" placeholder="Secret Question Answer" required>
						</div>
						<button type="submit" class="btn btn-primary">Submit</button>
				</form>
			</div>
		</div>
	</div>
</div>
    </body>

</html>
</div>
