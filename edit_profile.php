<?php


// Following code will update the user profile information

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['hobbies'])) {

    $userId = $_POST['user_id'];
    $name = $_POST['name'];
    $hobbies = $_POST['hobbies'];

    // include db connect class
    include '../ANowPhp/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql update row with matched pid
    $result = mysql_query("UPDATE users SET name = '$name', hobbies = '$hobbies' WHERE user_id = '$userId'");

    // check if row inserted or not
    if ($result) {
        // successfully updated
        $response["success"] = 1;
        $response["message"] = "Profile successfully updated.";

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
