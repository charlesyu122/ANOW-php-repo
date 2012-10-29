<?php

/*Following code will add a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['username']) && isset($_POST['password']) && isset($_POST['name']) && isset($_POST['birthday']) && isset($_POST['hobbies']) ){

    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $birthday = $_POST['birthday'];
    $hobbies = $_POST['hobbies'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new DB_CONNECT();

    // mysql insert a row to Users table
    $result = mysql_query("INSERT INTO users(username, password, name, birthday, hobbies) VALUES('$username','$password','$name','$birthday','$hobbies')");

    // check if successfully installed
    if($result) {
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
