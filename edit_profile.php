<?php


// Following code will update the user profile information

// array for JSON response
$response = array();

// check for required fields
if (isset($_POST['username']) && isset($_POST['name']) && isset($_POST['birthday']) && isset($_POST['hobbies'])) {

    $username = $_POST['username'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $hobbies = $_POST['hobbies'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql update row with matched pid
    $result = mysql_query("UPDATE users SET name = '$name', birthday = '$birthday', hobbies = '$hobbies' WHERE username = '$username'");

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
