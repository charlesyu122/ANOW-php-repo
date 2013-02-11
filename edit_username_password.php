<?php

//Will update Username and Password

$response = array();

//to avoid getting into this portion without logging in
if(isset($_POST['password']) && isset($_POST['user_id']))
{
	// include db connect class
	include '../ANowPhp/db_connect.php';

	// connecting to db
	$db = new DB_CONNECT();
	
	$password = $_POST['password'];
	$userId = $_POST['user_id'];
	
	//mysql select to check if the current username and the recently inputted confirm password match
	$result = mysql_query("SELECT * FROM users WHERE user_id = '$userId'");
	
	if(mysql_num_rows($result)==1){
	
		$row = mysql_fetch_assoc($result);
		if($row["password"] == $password){ 
			
			// user is verified
			
			//edit username
			if(isset($_POST['new_username'])){
			
				$new_username = $_POST['new_username'];
			
				// mysql update row with matched id and password
				mysql_query("UPDATE users SET username = '$new_username' WHERE user_id = '$userId'");
							
				$response["success"] = 1;
				$response["message"] = "Username successfully updated.";
	
				// echoing JSON response
				echo json_encode($response);
			}
			else if(isset($_POST['new_password'])){ // edit password
			
				$new_password = $_POST['new_password'];
							
				// mysql update row with matched id and password
				mysql_query("UPDATE users SET password = '$new_password' WHERE user_id = '$userId'");
				$response["success"] = 1;
				$response["message"] = "Password successfully updated.";
		
				// echoing JSON response
				echo json_encode($response);
			}
			
		}else{
			// confirm password is incorrect
			$response["success"] = 0;
			$response["message"] = "Invalid username/password";
			
			// echoing JSON response
			echo json_encode($response);
			
		}
	}
		
}else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}

?>
