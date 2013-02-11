<?php

/*Following code will add a new user row
 * All user details are read from HTTP Post Request
 */

// array for JSON response
$response = array();

// check for required fields
if( isset($_POST['username']) && isset($_POST['password'])){

  $username = $_POST['username'];
  $password = $_POST['password'];
  
  // include db connect class
  include '../ANowPhp/db_connect.php';
 
  // connecting to db
  $db = new DB_CONNECT();

  // mysql select to find username
  $result = mysql_query("SELECT * from users WHERE username = '$username' and type = 'M'");

  if($result){
    // mysql get password of result
    $row = mysql_fetch_assoc($result);
    if($row['password'] == $password){
       // passwords match
       $response["user_id"] = $row["user_id"];
       $response["success"] = 1;
       $response["message"] = "Successfully logged in.";
       
       // echoing JSON response
        echo json_encode($response);
    }else {
       // invalid password	  
       $response["success"] = 0;
       $response["message"] = "Invalid password";
       $response["password"] = $password;
       
       // echoing JSON response
        echo json_encode($response);
    }	  
  } else {
     // invalid username
     $response["success"] = 0;
     $response["message"] = "Invalid username";

     // echoing JSON response
     echo json_encode($response);
  }
} else {
  //required field is missing
  $response["success"] = 0;
  $response["message"] = "Required field(s) is missing";
  
  // echoing JSON response
  echo json_encode($response);
}
?>
