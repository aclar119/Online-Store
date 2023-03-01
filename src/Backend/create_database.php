<?php

    function createDatabase() {
        $DB_NAME = "onlinestore";

        $db_host = '127.0.0.1';
        $db_user = 'root';
        $db_password = ''; // (if not working, try 'root')
        $db_port = 3306; // (3306 for WAMP; 8889 for MAMP)

        $mysqli = new mysqli(
            $db_host,
            $db_user,
            $db_password
        );
                
        if ($mysqli->connect_error) {
            echo 'Errno: '.$mysqli->connect_errno;
            echo '<br>';
            echo 'Error: '.$mysqli->connect_error;
            exit();
        }

        // Attempt to create the database
        $create_db = "CREATE DATABASE " . $DB_NAME;

        // If the database didn't already exist, we need to populate it
        if (!$mysqli->select_db($DB_NAME)) {
            // The database does not exist, create it
            if($mysqli->query($create_db)) {
                // Need to refresh our connection with a proper link to the actual db
                $mysqli = new mysqli(
                    $db_host,
                    $db_user,
                    $db_password,
                    $DB_NAME
                );
                createTables($mysqli);
            }
        } 
        $mysqli->close(); 
    }

    function createTables($mysqli) {

        // Defining the structure of all our tables
        $create_table_colours = "CREATE TABLE Colours (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(40) NOT NULL,
            HexCode VARCHAR(7) NOT NULL
        )";

        $create_table_categories = "CREATE TABLE Categories (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(40) NOT NULL
        )";
        
        $create_table_products = "CREATE TABLE Products (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Price FLOAT NOT NULL,
            Description TEXT NOT NULL,
            ColourID INT NOT NULL,
            FOREIGN KEY (ColourID) REFERENCES Colours(ID),
            ImagePath VARCHAR(255) NOT NULL,
            CategoryID INT NOT NULL,
            FOREIGN KEY (CategoryID) REFERENCES Categories(ID)
        )";

        $create_table_users = "CREATE TABLE Users (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Email VARCHAR(80) NOT NULL,
            HashedPassword VARCHAR(255) NOT NULL,
            FirstName VARCHAR(40) NOT NULL,
            LastName VARCHAR(40) NOT NULL
        )";

        $create_table_cart_items = "CREATE TABLE CartItems (
            UserID INT NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT NOT NULL,
            FOREIGN KEY (ProductID) REFERENCES Products(ID),
            Quantity INT NOT NULL
        )";

        $create_table_reviews = "CREATE TABLE Reviews (
            UserID INT NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT NOT NULL,
            FOREIGN KEY (ProductID) REFERENCES Products(ID),
            Rating INT NOT NULL,
            Review TEXT,
            CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        // Execute all the database table creation queries
        $mysqli->query($create_table_colours);
        $mysqli->query($create_table_categories);
        $mysqli->query($create_table_products);
        $mysqli->query($create_table_users);
        $mysqli->query($create_table_cart_items);
        $mysqli->query($create_table_reviews);

        // Create the root superuser for development purposes
        $root_password = password_hash("root", PASSWORD_DEFAULT);

        $insert_user_root = "INSERT INTO 
            Users (Email, HashedPassword, FirstName, LastName)
            VALUES ('root', '$root_password', 'Rootfirst', 'Rootlast')
        ";

        $mysqli->query($insert_user_root);

    }

?>