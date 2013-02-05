<?php

/*Following code will add a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['user_id']) && isset($_POST['event_id']) && isset($_POST['private']) && isset($_POST['attend_date']) ){

    $userId = $_POST['user_id'];
    $eventId = $_POST['event_id'];
    $private = $_POST['private'];
    $status = 'C';
    $attendDate = $_POST['attend_date'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql insert a row to Attends table
    $result = mysql_query("INSERT INTO attends(user_id, event_id, status, private, attend_date) VALUES('$userId','$eventId','$status','$private','$attendDate')");

    // check if successfully installed
    if($result) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Attendance successfully created.";
        
        // query to update username's event_count
        mysql_query("UPDATE Users SET event_count = event_count + 1 WHERE user_id ='$userId'");

        // echoing JSON response
        echo json_encode($response);
    }else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "An error occurred while creating attendance.";

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
