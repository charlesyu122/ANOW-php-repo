<?php

//Will change profile picture

$response = array();

//to avoid getting into this portion without logging in
if(isset($_POST['password']) && isset($_POST['username']))
{
	// include db connect class
	require_once __DIR__ . '/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();
	
	$username = $_POST['username'];
	$password = $_POST['password'];
	$picturePath = $_POST['picturePath'];
	
	$result = mysql_query("UPDATE users SET profile_image = '$picturePath' WHERE  username = '$username'");
	
	//Check if query was successful or not
	if($result)
	{
		$response["success"] = 1;
		$response["message"] = "Username successfully updated.";
	}
	else
	{
		$response["success"] = 0;
		$response["message"] = "Cannot upload your photo.";
	}
	
	// echoing JSON response
	echo json_encode($response);
}

?>
