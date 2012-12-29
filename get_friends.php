<?php

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$username = $_POST['username'];
$loggedInUsername = $_POST['loggedInUsername'];


// get all products from products table
$result = mysql_query("SELECT * FROM friends where username = '$username'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["friends"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $friend = array();
        
        // id of traversed event
        $friendUsername = $row["friend_username"];
        
	if($friendUsername != $loggedInUsername){

        	// query to attends table 
       		$result2 = mysql_query("SELECT * from users where username = '$friendUsername'");
        	
        	if(mysql_num_rows($result2) == 1){
        	
        		$info = mysql_fetch_assoc($result2);
        	
        		$friend["username"] = $info["username"];
        		$friend["name"] = $info["name"];
        		$friend["birthday"] = $info["birthday"];
        		$friend["hobbies"] = $info["hobbies"];
        		$friend["event_count"] = $info["event_count"];
        		$friend["profile_image"] = $info["profile_image"];
        	
        		// for friend of friends
        		if(isset($_POST['loggedInUsername'])){
        			$usernameLoggedIn = $_POST['loggedInUsername'];
        			if(mysql_num_rows(mysql_query("SELECT * from friends where username = '$usernameLoggedIn' and friend_username = '$friend[username]'")) == 1)
        				$friend["status"] = "friends";
        			else
        				$friend["status"] = "strangers";
        		}

        		// push single friend into final response array
        		array_push($response["friends"], $friend);
        	}
	}
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no events found
    $response["success"] = 0;
    $response["message"] = "No friends found";

    // echo no JSON
    echo json_encode($response);
}
?>
