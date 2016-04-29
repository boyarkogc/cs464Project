<?php
	header('Content-Type: text/json'); 

	$url = "www.cs.colostate.edu/~wadesher/P3/index.php"; //Im using Curl to get the up/down status of our index to determine if the site is up or down


    $ch=curl_init();

    // sets the URL to fetch
    curl_setopt ($ch, CURLOPT_URL,$url );

    // return the transfer as a string
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);

    // disable output verbose information
    curl_setopt ($ch,CURLOPT_VERBOSE,false);

    // max number of seconds to allow cURL function to execute
    curl_setopt($ch, CURLOPT_TIMEOUT, 5);

    curl_exec($ch);

    // get HTTP response code
    $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    curl_close($ch);

    	
    if($httpcode>=200 && $httpcode<300)
        $Status = array("status" => "up");
    else if($httpcode>=400 && $httpcode<500)
        $Status = array("status" => "error");
    else
    	$Status = array("status" => "down"); //This means it timed out with no error so its down

	echo json_encode($Status);
?>