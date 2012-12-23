<?php

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$username = $_POST['username'];
$invite = 'I';

// get all invitations from attends table
$result = mysql_query("SELECT * FROM attends where username = '$username' and status = '$invite'");

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["invitations"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp invite array
        $invitation = array();
        
        // get neccessary info from attends query
        $invitation["attend_id"] = $row["attend_id"];
        $inviteeUsername = $row["invitee_username"];
        $eventId = $row["event_id"];
        
        // query to events table 
        $result2 = mysql_query("SELECT * from events where event_id = '$eventId'");
        $row2 = mysql_fetch_assoc($result2);
        
        $invitation["event_name"] = $row2["event_name"];
        $invitation["event_image"] = $row2["image"];
        
        // query to users table
        $result3 = mysql_query("SELECT * from users where username = '$inviteeUsername'");
        $row3 = mysql_fetch_assoc($result3);
        
        $invitation["invitee_name"] = $row3["name"];
        
        // push single invite into final response array
        array_push($response["invitations"], $invitation);
        
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no invites found
    $response["success"] = 0;
    $response["message"] = "No invites found";

    // echo no JSON
    echo json_encode($response);
}
?>
