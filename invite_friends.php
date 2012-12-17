<?php

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['event_id']) && isset($_POST['username']) ){

    $username = $_POST['username'];
    $eventId = $_POST['event_id'];
    $invited = json_decode($_POST['invited']);

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // get attend date first
    $result = mysql_query("SELECT * FROM attends where username = '$username' and event_id = '$eventId'");
    if($result){
       $row = mysql_fetch_assoc($result);
       $attendDate = $row['attend_date'];
       $privacy = "N";
       $status = "I";
    	    
       // mysql insert a row to Attends table. Loop thru the array of invited people
       for($i=0; $i < count($invited); $i++)
          $result2 = mysql_query("INSERT INTO attends(username, event_id, status, private, attend_date, invitee_username) VALUES('$invited[$i]','$eventId','$status','$privacy','$attendDate','$username')");
       
       // successfully inserted into database
       $response["success"] = 1;
       $response["message"] = "Attendance successfully created.";
       
       // echoing JSON response
       echo json_encode($response);
       		
    } else {
       // failed to insert row
       $response["success"] = 0;
       $response["message"] = "An error occurred while creating attendance.";

       // echoing JSON response
       echo json_encode($response);	
    }

}else {
   // required field is missing
   $response["success"] = 0;
   $response["message"] = "Required field(s) is missing";

   // echoing JSON response
   echo json_encode($response);
}
?>
