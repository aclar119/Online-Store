<?php

    function createDatabase() {
        $DB_NAME = "onlinestore";

        $db_host = '127.0.0.1';
        $db_user = 'root';
        $db_password = ''; // (if not working, try 'root')

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
        if($mysqli->query($create_db)) {
            
            // Need to refresh our connection with a proper link to the actual db
            $mysqli = new mysqli(
                $db_host,
                $db_user,
                $db_password,
                $DB_NAME
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
            Name VARCHAR(40) NOT NULL
        )";

        $create_table_categories = "CREATE TABLE Categories (
            ID INT UNSIGNED PRIMARY KEY,
            Name VARCHAR(40) NOT NULL
        )";
        
        $create_table_products = "CREATE TABLE Products (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            Name VARCHAR(255) NOT NULL,
            Price FLOAT NOT NULL,
            Description TEXT NOT NULL,
            ColourID INT NOT NULL,
            FOREIGN KEY (ColourID) REFERENCES Colours(ID),
            ImageFile VARCHAR(255) NOT NULL,
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

    // Add all colours to the database
    function populateColours($mysqli) {
        $colours = array(
            array("id" => 1, "name" => "Black"),
            array("id" => 2, "name" => "Blue"),
            array("id" => 3, "name" => "Brown"),
            array("id" => 4, "name" => "Green"),
            array("id" => 5, "name" => "Grey"),
            array("id" => 6, "name" => "White"),
            array("id" => 7, "name" => "Yellow")
        );

        for ($i = 0; $i < count($colours); $i++) {
            $id = $colours[$i]["id"];
            $name = $colours[$i]["name"];

            $insert_colour = "INSERT INTO 
                Colours (ID, Name)
                VALUES ($id, '$name')
            ";

            $mysqli->query($insert_colour);
        }
    }

    // Add all categories to the database
    function populateCategories($mysqli) {
        $categories = array(
            array("id" => 1, "name" => "T-Shirts"),
            array("id" => 2, "name" => "Jackets"),
            array("id" => 3, "name" => "Sweaters")
        );

        for ($i = 0; $i < count($categories); $i++) {
            $id = $categories[$i]["id"];
            $name = $categories[$i]["name"];

            $insert_category = "INSERT INTO 
                Categories (ID, Name)
                VALUES ($id, '$name')
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
                "colourId" => 3, // White
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