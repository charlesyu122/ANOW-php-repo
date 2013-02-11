<?php

// Following code will get all attended events for selected month

// array for JSON response
$response = array();
$eventIds = array();    
$response["events"] = array();
$response["attends"] = array();

// include db connect clas
include '../ANowPhp/db_connect.php';

// connect to db
$db = new DB_CONNECT();

// received POSTS
$userId = $_POST['user_id'];
$beginDate = $_POST['begin_date'];
$endDate = $_POST['end_date'];
$status = 'I';

// get all event_id fomr attendance table
$result = mysql_query("SELECT * FROM attends where user_id = '$userId' AND status <> '$status' AND attend_date >= '$beginDate' AND attend_date <= '$endDate'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0){
	
	// transfer to event ids to array
	while( $row = mysql_fetch_array($result)){
		array_push($eventIds, $row["event_id"]);
		array_push($response["attends"], $row["attend_date"]);
	}
	
	// temp user array
        $event = array();
	
	// loop thru event ids array
	for($i = 0; $i < count($eventIds); $i++){
		$result2 = mysql_query("SELECT * FROM events where event_id = '$eventIds[$i]'");
		if(mysql_num_rows($result2) > 0){
			$row2 = mysql_fetch_assoc($result2);
			$event["event_id"] = $row2["event_id"];
			$event["event_name"] = $row2["event_name"];
			$event["time_start"] = $row2["time_start"];
			$event["date_start"] = $row2["date_start"];
			$event["date_end"] = $row2["date_end"];
			$event["location"] = $row2["location"];
			$event["description"] = $row2["description"];
			$event["type"] = $row2["type"];
			$event["image"] = $row2["image"];

			// push single event into final response array
			array_push($response["events"], $event);
        	}
        }
	    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
}else {
    // no events found
    $response["success"] = 0;
    $response["message"] = "No events found";

    // echo no JSON
    echo json_encode($response);
}


?>
