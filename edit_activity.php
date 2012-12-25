<?php

//Will update Activity(Self-made Events)

$response = array();

//to avoid getting into this portion without logging in

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$old_name = $_POST['old_name'];
$name = $_POST['name'];
$loc = $_POST['loc'];
$desc = $_POST['desc'];

//mysql select to check if event name exists
$result = mysql_query("SELECT event_name FROM events WHERE event_name = '$old_name'") or die(mysql_error());

if(mysql_num_rows($result) == 1){

	// mysql update in table events
	mysql_query("UPDATE events SET event_name = '$name', location = '$loc', description = '$desc' WHERE event_name = '$old_name'");
			
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