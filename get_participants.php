<?php

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$eventId = $_POST['event_id'];
$loggedInUsername = $_POST['username_loggedin'];

// get all products from products table
$result = mysql_query("SELECT * FROM attends where event_id = '$eventId'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["participants"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $participant = array();
        
        // username of attendee
        $participantUsername = $row["username"];
        
        // query to attends table 
        $result2 = mysql_query("SELECT * from users where username = '$participantUsername'");
        
        if(mysql_num_rows($result2) == 1){
        	
        	$info = mysql_fetch_assoc($result2);
        	
        	$participant["username"] = $info["username"];
        	$participant["name"] = $info["name"];
        	$participant["birthday"] = $info["birthday"];
        	$participant["hobbies"] = $info["hobbies"];
        	$participant["event_count"] = $info["event_count"];
        	$participant["profile_image"] = $info["profile_image"];
        	if(mysql_num_rows(mysql_query("SELECT * from friends where username = '$loggedInUsername' and friend_username = '$participant[username]'")) == 1)
        		$participant["status"] = "friends";
        	else
        		$participant["status"] = "strangers";
        	if($loggedInUsername == $participant["username"])
        		$participant["status"] = "friends";

        	// push single friend into final response array
        	array_push($response["participants"], $participant);
        }
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no events found
    $response["success"] = 0;
    $response["message"] = "No participants found";

    // echo no JSON
    echo json_encode($response);
}
?>
