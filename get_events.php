<?php

// array for JSON response
$response = array();

// include db connect class
include '../ANowPhp/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive POSTS
//$eventIds = json_decode($_POST['event_ids']);

if( get_magic_quotes_gpc() ) {
    $_POST['event_ids'] = stripslashes( $_POST['event_ids'] );
}
$eventIds = json_decode( $_POST['event_ids'] );

// looping through all events
$response["events"] = array();

if(count($eventIds)>0){

    // traverse through event ids 
    for($i=0; $i<count($eventIds); $i++){

        // query to events table
        $result = mysql_query("SELECT * FROM events WHERE event_id = '$eventIds[$i]'");

        while ($row = mysql_fetch_array($result)) {
            // temp user array
            $event = array();
                        
            $event["event_id"] = $row["event_id"];
            $event["event_name"] = $row["event_name"];
            $event["time_start"] = $row["time_start"];
            $event["date_start"] = $row["date_start"];
            $event["date_end"] = $row["date_end"];
            $event["location"] = $row["location"];
            $event["description"] = $row["description"];
	    $event["type"] = $row["type"];
            $event["image"] = $row["image"];

            // push single event into final response array
            array_push($response["events"], $event);
        }
    }
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);

} else {
    // no events found
    $response["success"] = 0;
    $response["message"] = "No events found";

    // echo no JSON
    echo json_encode($response);
}
?>
