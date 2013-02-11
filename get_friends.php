<?php

// array for JSON response
$response = array();

// include db connect class
include '../ANowPhp/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$userId = $_POST['user_id'];
$loggedInUserId = $_POST['loggedInUserId'];


// get all products from products table
$result = mysql_query("SELECT * FROM friends where user_id = '$userId'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["friends"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $friend = array();
        
        // id of traversed event
        $friendUserId = $row["friend_user_id"];
        
	if($friendUserId != $loggedInUserId){

        	// query to attends table 
       		$result2 = mysql_query("SELECT * from users where user_id = '$friendUserId'");
        	
        	if(mysql_num_rows($result2) == 1){
        	
        		$info = mysql_fetch_assoc($result2);
        	
			$friend["user_id"] = $info["user_id"];
        		$friend["username"] = $info["username"];
        		$friend["name"] = $info["name"];
        		$friend["birthday"] = $info["birthday"];
        		$friend["hobbies"] = $info["hobbies"];
        		$friend["event_count"] = $info["event_count"];
        		$friend["profile_image"] = $info["profile_image"];
        	
        		// for friend of friends
        		if(isset($_POST['loggedInUserId'])){
        			$userIdLoggedIn = $_POST['loggedInUserId'];
        			if(mysql_num_rows(mysql_query("SELECT * from friends where user_id = '$userIdLoggedIn' and friend_user_id = '$friend[user_id]'")) == 1)
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
