<?php

// Following code will accept invitation

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['attend_id']) ) {

    $attendId = $_POST['attend_id'];
    $status = 'C'; // set to confirmed

    // include db connect class
    include '../ANowPhp/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql update row with matched pid
    $result = mysql_query("UPDATE attends SET status = '$status' WHERE attend_id = '$attendId'");

    // check if row updated or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Invite successfully confirmed.";

        // echoing JSON response
        echo json_encode($response);
    } else {

    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field(s) is missing";

    // echoing JSON response
    echo json_encode($response);
}
?>
