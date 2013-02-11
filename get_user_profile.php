<?php

/*
 * Following code will get the profile of specific user
 */

// array for JSON response
$response = array();

// include db connect class
include '../ANowPhp/db_connect.php';

// connecting to db
$db = new DB_CONNECT();

// get user from Users table
$userId = $_POST['user_id'];
$result = mysql_query("SELECT * FROM users where user_id = '$userId'") or die(mysql_error());

// check for empty result
if (mysql_num_rows($result) > 0) {
	
    // user node
    $response["user"] = array();
    $row = mysql_fetch_array($result);
    
    // temp user array
    $user = array();
    $user["name"] = $row["name"];
    $user["username"] = $row["username"];
    $user["birthday"] = $row["birthday"];
    $user["hobbies"] = $row["hobbies"];
    $user["event_count"] = $row["event_count"];
    $user["profile_image"] = $row["profile_image"]; 
    
    // push single product into final response array
    array_push($response["user"], $user);
    
    // success
    $response["success"] = 1;

    // echoing JSON response
    echo json_encode($response);
} else {
    // no products found
    $response["success"] = 0;
    $response["message"] = "No user found";

    // echo no users JSON
    echo json_encode($response);
}
?>

