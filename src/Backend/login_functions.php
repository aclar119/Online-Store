<?php

    function connectDatabase() {
        $DB_NAME = "onlinestore";

        $db_host = '127.0.0.1';
        $db_user = 'root';
        $db_password = ''; // (if not working, try 'root')
        $db_port = 3306; // (3306 for WAMP; 8889 for MAMP)

        $mysqli = new mysqli(
            $db_host,
            $db_user,
            $db_password,
        );
                
        if ($mysqli->connect_error) {
            echo 'Errno: '.$mysqli->connect_errno;
            echo '<br>';
            echo 'Error: '.$mysqli->connect_error;
            exit();
        }

        if (!$mysqli->select_db($DB_NAME)) {
            echo "Error - Coould not find database: $DB_NAME";
            exit();
        }  

        return $mysqli; 
    }

    function getUserID($email, $password) {
        $mysqli = connectDatabase();

        // $get_user_query

        // $mysqli->query($get_user_query);

        $mysqli->close();
        
        return 'Everything worked :D';
    }


