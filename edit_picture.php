<?php

//Will change profile picture

$response = array();

//to avoid getting into this portion without logging in
if(isset($_POST['password']) && isset($_POST['user_id']))
{
	// include db connect class
        include '../ANowPhp/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();
	
	$userId = $_POST['user_id'];
	$password = $_POST['password'];
	$picturePath = $_POST['picturePath'];
	
	$result = mysql_query("UPDATE users SET profile_image = '$picturePath' WHERE  user_id = '$userId'");
	
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
