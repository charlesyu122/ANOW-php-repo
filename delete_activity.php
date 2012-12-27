<?php

//Will update Activity(Self-made Events)

$response = array();

//to avoid getting into this portion without logging in

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$activityId = $_POST['activity_id'];

//mysql select to check if event name exists
$result = mysql_query("DELETE FROM events WHERE event_id = '$activityId'");
$result2 = mysql_query("DELETE FROM attends WHERE event_id = '$activityId'");

if($result && $result2){			
   $response["success"] = 1;
   $response["message"] = "Event profile successfully deleted.";
}
else
{
   $response["success"] = 0;
   $response["message"] = "Event profile unsuccessfully deleted.";	
}

// echoing JSON response
echo json_encode($response);
?>
