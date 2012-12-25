<?php

//Will update Activity(Self-made Events)

$response = array();

//to avoid getting into this portion without logging in

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

$name = $_POST['name'];
$loc = $_POST['loc'];
$desc = $_POST['desc'];

//mysql select to check if event name exists
$result = mysql_query("SELECT event_name FROM events WHERE event_name = '$name'") or die(mysql_error());

if(mysql_num_rows($result) == 1){

	// mysql update in table events
	mysql_query("DELETE FROM events WHERE event_name = '$name' AND location = '$loc' AND description = '$desc' AND type = 'A'");
			
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