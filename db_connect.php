<?php

/* Class to connect to database */

class DB_CONNECT {

    // Constructor
    function __construct() {
        // connecting to database
        $this->connect();
    }

    // Destructor
    function __destruct() {
        // closing db connection
        $this->close();
    }

     // Function to connect with database
    function connect() {
        // import database connection variables
        include '../ANowPhp/db_config.php';

        // Connecting to mysql database
        $con = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die(mysql_error());

        // Selecting database
        $db = mysql_select_db(DB_DATABASE) or die(mysql_error()) or die(mysql_error());

        // returing connection cursor
        return $con;
    }

    // Function to close db connection
    function close() {
        // closing db connection
        mysql_close();
    }

}
?>
