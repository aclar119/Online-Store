<?php

    function createDatabase() {
        require('config.php');

        // View config.php to change the port/password

        $mysqli = new mysqli(
            DatabaseConfig::get_host(),
            DatabaseConfig::get_user(),
            DatabaseConfig::get_password()
        );
                
        if ($mysqli->connect_error) {
            echo 'Errno: '.$mysqli->connect_errno;
            echo '<br>';
            echo 'Error: '.$mysqli->connect_error;
            exit();
        }

        // Attempt to create the database
        $create_db = "CREATE DATABASE " . DatabaseConfig::get_name();

        // If the database didn't already exist, we need to populate it
        try {
            $success = $mysqli->query($create_db);
        } catch (Exception $e) {
            $success = false;
        }

        if($success) {
            
            // Need to refresh our connection with a proper link to the actual db
            $mysqli = new mysqli(
                DatabaseConfig::get_host(),
                DatabaseConfig::get_user(),
                DatabaseConfig::get_password(),
                DatabaseConfig::get_name(),
            );

            createTables($mysqli);
            populateColours($mysqli);
            populateCategories($mysqli);
            populateProducts($mysqli);
            
        }
        
        $mysqli->close(); 
    }

    function createTables($mysqli) {

        // Defining the structure of all our tables
        $create_table_colours = "CREATE TABLE Colours (
            ID INT UNSIGNED PRIMARY KEY,
            DisplayName VARCHAR(40) NOT NULL,
            InternalName VARCHAR(40) NOT NULL
        )";

        $create_table_categories = "CREATE TABLE Categories (
            ID INT UNSIGNED PRIMARY KEY,
            DisplayName VARCHAR(40) NOT NULL,
            InternalName VARCHAR(40) NOT NULL
        )";
        
        $create_table_products = "CREATE TABLE Products (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Price FLOAT NOT NULL,
            Description TEXT NOT NULL,
            ColourID INT UNSIGNED NOT NULL,
            FOREIGN KEY (ColourID) REFERENCES Colours(ID),
            ImageFile VARCHAR(255) NOT NULL,
            CategoryID INT UNSIGNED NOT NULL,
            FOREIGN KEY (CategoryID) REFERENCES Categories(ID)
        )";

        $create_table_users = "CREATE TABLE Users (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Email VARCHAR(80) UNIQUE NOT NULL,
            Username VARCHAR(128) UNIQUE NOT NULL,
            HashedPassword VARCHAR(255) NOT NULL
        )";

        $create_table_cart_items = "CREATE TABLE CartItems (
            UserID INT UNSIGNED NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT UNSIGNED NOT NULL,
            FOREIGN KEY (ProductID) REFERENCES Products(ID),
            Quantity INT NOT NULL
        )";

        $create_table_reviews = "CREATE TABLE Reviews (
            UserID INT UNSIGNED NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT UNSIGNED NOT NULL,
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
            Users (Email, Username, HashedPassword)
            VALUES ('root', 'root', '$root_password')
        ";

        $mysqli->query($insert_user_root);

    }

    // Add all colours to the database
    function populateColours($mysqli) {
        $colours = array(
            array("id" => 1, "displayName" => "Black", "internalName" => "black"),
            array("id" => 2, "displayName" => "Blue", "internalName" => "blue"),
            array("id" => 3, "displayName" => "Brown", "internalName" => "brown"),
            array("id" => 4, "displayName" => "Green", "internalName" => "green"),
            array("id" => 5, "displayName" => "Grey", "internalName" => "grey"),
            array("id" => 6, "displayName" => "White", "internalName" => "white"),
            array("id" => 7, "displayName" => "Yellow", "internalName" => "yellow")
        );

        for ($i = 0; $i < count($colours); $i++) {
            $id = $colours[$i]["id"];
            $display_name = $colours[$i]["displayName"];
            $internal_name = $colours[$i]["internalName"];


            $insert_colour = "INSERT INTO 
                Colours (ID, DisplayName, InternalName)
                VALUES ($id, '$display_name', '$internal_name')
            ";

            $mysqli->query($insert_colour);
        }
    }

    // Add all categories to the database
    function populateCategories($mysqli) {
        $categories = array(
            array("id" => 1, "displayName" => "T-Shirts", "internalName" => "tshirts"),
            array("id" => 2, "displayName" => "Jackets", "internalName" => "jackets"),
            array("id" => 3, "displayName" => "Sweaters", "internalName" => "sweaters")
        );

        for ($i = 0; $i < count($categories); $i++) {
            $id = $categories[$i]["id"];
            $display_name = $categories[$i]["displayName"];
            $internal_name = $categories[$i]["internalName"];

            $insert_category = "INSERT INTO 
                Categories (ID, DisplayName, InternalName)
                VALUES ($id, '$display_name', '$internal_name')
            ";
            
            $mysqli->query($insert_category);
        }
    }

    function populateProducts($mysqli) {
        $products = array(
            array(
                "name" => "Generic Blue T",
                "price" => 20.00,
                "description" => "This is a placeholder description",
                "colourId" => 2, // Blue
                "imageFile" => "Generic Blue T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Black T",
                "price" => 20.00,
                "description" => "This is a placeholder description",
                "colourId" => 1, // Black
                "imageFile" => "Generic Black T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Brown T",
                "price" => 20.00,
                "description" => "This is a placeholder description",
                "colourId" => 3, // Brown
                "imageFile" => "Generic Brown T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Yellow T",
                "price" => 20.00,
                "description" => "This is a placeholder description",
                "colourId" => 7, // Yellow
                "imageFile" => "Generic Yellow T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic White T",
                "price" => 20.00,
                "description" => "This is a placeholder description",
                "colourId" => 6, // White
                "imageFile" => "Generic White T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Green Jacket",
                "price" => 40.00,
                "description" => "This is a placeholder description",
                "colourId" => 4, // Green
                "imageFile" => "Green Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Blue Denim Jacket",
                "price" => 40.00,
                "description" => "This is a placeholder description",
                "colourId" => 2, // Blue
                "imageFile" => "Blue Denim Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "White Jacket",
                "price" => 40.00,
                "description" => "This is a placeholder description",
                "colourId" => 6, // White
                "imageFile" => "White Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Grey Jacket",
                "price" => 40.00,
                "description" => "This is a placeholder description",
                "colourId" => 5, // Grey
                "imageFile" => "Grey Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Black Jacket",
                "price" => 40.00,
                "description" => "This is a placeholder description",
                "colourId" => 1, // Black
                "imageFile" => "Black Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Black Sweater",
                "price" => 25.00,
                "description" => "This is a placeholder description",
                "colourId" => 1, // Black
                "imageFile" => "Black Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "White Sweater",
                "price" => 25.00,
                "description" => "This is a placeholder description",
                "colourId" => 6, // White
                "imageFile" => "White Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Blue Sweater",
                "price" => 25.00,
                "description" => "This is a placeholder description",
                "colourId" => 2, // Blue
                "imageFile" => "Blue Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Grey Sweater",
                "price" => 25.00,
                "description" => "This is a placeholder description",
                "colourId" => 5, // Grey
                "imageFile" => "Grey Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Yellow Sweater",
                "price" => 25.00,
                "description" => "This is a placeholder description",
                "colourId" => 7, // Yellow
                "imageFile" => "Yellow Sweater.png",
                "categoryId" => 3, // Sweaters
            )
        );
            
        for ($i = 0; $i < count($products); $i++) {
            $name = $products[$i]["name"];
            $price = $products[$i]["price"];
            $description = $products[$i]["description"];
            $colour_id = $products[$i]["colourId"];
            $image_file = $products[$i]["imageFile"];
            $category_id = $products[$i]["categoryId"];

            $insert_product = "INSERT INTO 
                Products (Name, Price, Description, ColourID, ImageFile, CategoryID)
                VALUES ('$name', $price, '$description', $colour_id, '$image_file', $category_id)
            ";
            
            $mysqli->query($insert_product);
        }
    }

?>