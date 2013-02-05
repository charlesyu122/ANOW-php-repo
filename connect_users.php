<?php

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['logged_in']) && isset($_POST['user_id']) ){

    $loggedInUserId = $_POST['logged_in'];
    $userId = $_POST['user_id'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql insert a row to Attends table
    $result = mysql_query("INSERT INTO friends(user_id, friend_user_id) VALUES('$loggedInUserId','$userId')");

    // check if successfully installed
    if($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Users successfully connected.";        

        // echoing JSON response
        echo json_encode($response);
    }else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "An error occurred while connecting users.";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>
