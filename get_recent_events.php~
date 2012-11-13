<?php

/*
 * Following code will list all the products
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

//receive date today and set type to E
$today = $_POST['today'];
$type = 'E';

// get all products from products table
$result = mysql_query("SELECT * FROM events where date_start >= '$today' AND type = '$type'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
    // looping through all events
    $response["events"] = array();

    while ($row = mysql_fetch_array($result)) {
        // temp user array
        $event = array();
        $event["event_id"] = $row["event_id"];
        $event["event_name"] = $row["event_name"];
        $event["time_start"] = $row["time_start"];
        $event["date_start"] = $row["date_start"];
        $event["location"] = $row["location"];
        $event["description"] = $row["description"];
        $event["image"] = $row["image"];

        // push single event into final response array
        array_push($response["events"], $event);
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
