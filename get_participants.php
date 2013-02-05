<?php

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$eventId = $_POST['event_id'];
$loggedInUserId = $_POST['user_id_loggedin'];
$status = 'C';

// get all products from products table
$result = mysql_query("SELECT * FROM attends where event_id = '$eventId' and status = '$status'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["participants"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $participant = array();
        
        // user id of attendee
        $participantUserId = $row["user_id"];
        
        // query to attends table 
        $result2 = mysql_query("SELECT * from users where user_id = '$participantUserId'");
        
        if(mysql_num_rows($result2) == 1){
        	
        	$info = mysql_fetch_assoc($result2);
        	
		$participant["user_id"] = $info["user_id"];
        	$participant["username"] = $info["username"];
        	$participant["name"] = $info["name"];
        	$participant["birthday"] = $info["birthday"];
        	$participant["hobbies"] = $info["hobbies"];
        	$participant["event_count"] = $info["event_count"];
        	$participant["profile_image"] = $info["profile_image"];
        	if(mysql_num_rows(mysql_query("SELECT * from friends where user_id = '$loggedInUserId' and friend_user_id = '$participant[user_id]'")) == 1)
        		$participant["status"] = "friends";
        	else
        		$participant["status"] = "strangers";
        	if($loggedInUserId == $participant["user_id"])
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
