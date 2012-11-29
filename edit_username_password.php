<?php

//Will update Username and Password

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
	
	//mysql select to check if the current username and the recently inputted confirm password match
	$result = mysql_query("SELECT username, password FROM users WHERE username = '$username' AND password = '$password'");
	
	//edit username
	if(isset($_POST['new_username']))
	{
		$new_username = $_POST['new_username'];
		
		if (mysql_num_rows($result) > 0) {
		
			// mysql update row with matched id and password
			mysql_query("UPDATE users SET username = '$new_username' WHERE username = '$username' AND password = '$password'");
			$response["success"] = 1;
			$response["message"] = "Username successfully updated.";

		} else {
			// confirm password is incorrect
			$response["success"] = 0;
			$response["message"] = "Password is incorrect.";
		}
		
		// echoing JSON response
		echo json_encode($response);
	}
	else if(isset($_POST['new_password']))
	{
		$new_password = $_POST['new_password'];
		
		if (mysql_num_rows($result) > 0) {
		
			// mysql update row with matched id and password
			$result = mysql_query("UPDATE users SET password = '$new_password' WHERE username = '$username' AND password = '$password'");
			$response["success"] = 1;
			$response["message"] = "Password successfully updated.";

		} else {
			// confirm password is incorrect
			$response["success"] = 0;
			$response["message"] = "Password is incorrect.";
		}
		
		// echoing JSON response
		echo json_encode($response);
	}
		
}else {

	//loading into this page without logging in
}

?>