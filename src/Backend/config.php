<?php

    class DatabaseConfig {
        
        // Set to true if using WAMP (Windows), false if using MAMP (Mac)
        private static $USING_WINDOWS = true;
        

        private static $DB_NAME = "onlinestore";
        private static $DB_HOST = 'localhost';
        private static $DB_USER = 'root';

        private static $WINDOWS_PASSWORD = '';
        private static $WINDOWS_PORT = 3306; 

        private static $MAC_PASSWORD = 'root';
        private static $MAC_PORT = 8889; 

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
            if (self::$USING_WINDOWS) {
                return self::$WINDOWS_PASSWORD;
            } else {
                return self::$MAC_PASSWORD;
            }
        }

        public static function get_port() {
            if (self::$USING_WINDOWS) {
                return self::$WINDOWS_PORT;
            } else {
                return self::$MAC_PORT;
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
    