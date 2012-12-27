<?php

//Will update Activity(Self-made Events)

$response = array();

//to avoid getting into this portion without logging in

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$activityId = $_POST['activity_id'];
$name = $_POST['name'];
$loc = $_POST['loc'];
$desc = $_POST['desc'];

//mysql select to check if event name exists
$result = mysql_query("UPDATE events  SET event_name = '$name', location = '$loc', description = '$desc' WHERE event_id = '$activityId'");

if($result){
    $response["success"] = 1;
    $response["message"] = "Event profile successfully updated.";
}
else
{
    $response["success"] = 0;
    $response["message"] = "Event profile unsuccessfully updated.";	
}

// echoing JSON response
echo json_encode($response);
?>
