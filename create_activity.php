<?php

/*Following code will add a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['eventName']) && isset($_POST['timeStart']) && isset($_POST['dateStart']) && isset($_POST['dateEnd']) && isset($_POST['location']) && isset($_POST['description']) && isset($_POST['private'])){

    $eventName = $_POST['eventName'];
    $timeStart = $_POST['timeStart'];
    $dateStart = $_POST['dateStart'];
    $dateEnd = $_POST['dateEnd'];
    $location = $_POST['location'];
    $description = $_POST['description'];
    $type = "A"; // for activity
    $private = $_POST['private'];
    $username = $_POST['username'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql insert a row to Users table
    $result = mysql_query("INSERT INTO events(event_name, time_start, date_start, date_end, location, description, type, private) VALUES('$eventName','$timeStart','$dateStart','$dateEnd','$location','$description','$type','$private')");
    $eventid = mysql_insert_id();
    $astat = "S"; // for self made
    // mysql insert a row to Attends table
    $result2 = mysql_query("INSERT INTO attends(username, event_id, status) VALUES('$username','$eventid','$astat')");
    
    
    // check if successfully installed
    if($result2) {
        // successfully inserted into database
        $response["success"] = 1;
        $response["message"] = "Account successfully created.";

        // echoing JSON response
        echo json_encode($response);
    }else {
        // failed to insert row
        $response["success"] = 0;
        $response["message"] = "An error occurred while creating account.";

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
