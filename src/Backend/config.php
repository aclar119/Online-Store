<?php

    class DatabaseConfig {
        
        // Set to true if using WAMP (Windows), false if using MAMP (Mac)
        private static $OS;

        private static $DB_NAME = "onlinestore";
        private static $DB_HOST = 'localhost';
        private static $DB_USER = 'root';

        private static $WINDOWS_PASSWORD = '';
        private static $WINDOWS_PORT = 3306; 

        private static $MAC_PASSWORD = 'root';
        private static $MAC_PORT = 8889; 

        // Constructor determines if the user is on Windows or Mac
        function __construct() {
            $user_agent = getenv("HTTP_USER_AGENT");

            if(strpos($user_agent, "Win") !== FALSE) {
                $OS = "Windows";

            } elseif(strpos($user_agent, "Mac") !== FALSE) {
                $OS = "Mac";

            } else {
                $OS = "Unknown";
            }
        }


        // Do not change anything below this line
        public static function get_name() {
            return self::$DB_NAME;
        }

        public static function get_host() {
            return self::$DB_HOST;
        }

        public static function get_user() {
            return self::$DB_USER;
        }

        public static function get_password() {
            if (self::$OS === "Mac") {
                return self::$MAC_PASSWORD;
            } else {
                return self::$WINDOWS_PASSWORD;
            }
        }

        public static function get_port() {
            if (self::$OS === "Mac") {
                return self::$MAC_PORT;
            } else {
                return self::$WINDOWS_PORT;
            }
        }

        // Return a database connection for other php files to use
        public static function get_db_connection() {
            $mysqli = new mysqli(
                self::get_host(),
                self::get_user(),
                self::get_password(),
                self::get_name(),
                self::get_port()
            );
                    
            if ($mysqli->connect_error) {
                echo 'Errno: '.$mysqli->connect_errno;
                echo '<br>';
                echo 'Error: '.$mysqli->connect_error;
                exit();
            }
            
            return $mysqli;
        }

    }
    