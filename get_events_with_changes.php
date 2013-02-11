<?php

// array for JSON response
$response = array();

// include db connect class
include '../ANowPhp/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
$today = $_POST['today'];
$userId = $_POST['user_id'];
$check = "false";

// get all attendance starting today
$result = mysql_query("SELECT * FROM attends where user_id = '$userId' AND attend_date >= '$today'");

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // looping through all events
    $response["events"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $event = array();
        
        // get necessary columns
        $eventId = $row["event_id"];
	$attendDate = $row["attend_date"];
	$attendId = $row["attend_id"];
        
        // query to events table 
        $result2 = mysql_query("SELECT * from events where event_id = '$eventId'");
        
        if(mysql_num_rows($result2) == 1){

		$row2 = mysql_fetch_assoc($result2);

		if($attendDate < $row2["date_start"] || $attendDate > $row2["date_end"]){ // There are changes

        	   $event["event_id"] = $row2["event_id"];

        	   // push single event into final response array
        	   array_push($response["events"], $event);

		   $check = "true";

		   // delete attendance
		   mysql_query("DELETE FROM attends WHERE attend_id = '$attendId'");
		   // query to update user's event_count
        	   mysql_query("UPDATE Users SET event_count = event_count - 1 WHERE user_id ='$userId'");
		}
        }
    }

    if($check == "true"){
       // success
       $response["success"] = 1;
       $response["message"] = "There are changes in event dates";

    } else{
        // no events found
       $response["success"] = 0;
       $response["message"] = "No changes found";
    }
    // echoing JSON response
    echo json_encode($response);
} else {
    // no events found
    $response["success"] = 0;
    $response["message"] = "No changes found";

    // echo no JSON
    echo json_encode($response);
}
?>
