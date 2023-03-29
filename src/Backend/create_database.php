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
            Username VARCHAR(80) UNIQUE NOT NULL,
            HashedPassword VARCHAR(255) NOT NULL
        )";

        $create_table_orders = "CREATE TABLE Orders (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            UserID INT UNSIGNED NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            OrderedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            SubtotalPrice FLOAT NOT NULL,
            TaxesPrice FLOAT NOT NULL,
            ShippingPrice FLOAT NOT NULL,
            TotalPrice FLOAT NOT NULL
        )";

        $create_table_cart_items = "CREATE TABLE CartItems (
            UserID INT UNSIGNED NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT UNSIGNED NOT NULL,
            FOREIGN KEY (ProductID) REFERENCES Products(ID),
            Quantity INT NOT NULL,
            Size VARCHAR(5) NOT NULL,
            Ordered BINARY,
            OrderID INT UNSIGNED,
            FOREIGN KEY (OrderID) REFERENCES Orders(ID)
        )";

        $create_table_reviews = "CREATE TABLE Reviews (
            ID INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            UserID INT UNSIGNED NOT NULL,
            FOREIGN KEY (UserID) REFERENCES Users(ID),
            ProductID INT UNSIGNED NOT NULL,
            FOREIGN KEY (ProductID) REFERENCES Products(ID),
            Rating INT NOT NULL,
            ReviewMessage TEXT,
            CreatedAt TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )";

        // Execute all the database table creation queries
        $mysqli->query($create_table_colours);
        $mysqli->query($create_table_categories);
        $mysqli->query($create_table_products);
        $mysqli->query($create_table_users);
        $mysqli->query($create_table_orders);
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
            array("id" => 1, "displayName" => "Beige", "internalName" => "beige"),
            array("id" => 2, "displayName" => "Black", "internalName" => "black"),
            array("id" => 3, "displayName" => "Blue", "internalName" => "blue"),
            array("id" => 4, "displayName" => "Brown", "internalName" => "brown"),
            array("id" => 5, "displayName" => "Green", "internalName" => "green"),
            array("id" => 6, "displayName" => "Grey", "internalName" => "grey"),
            array("id" => 7, "displayName" => "Pink", "internalName" => "pink"),
            array("id" => 8, "displayName" => "White", "internalName" => "white"),
            array("id" => 9, "displayName" => "Yellow", "internalName" => "yellow")   
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
                "description" => "Made from soft, breathable cotton, this tee is both comfortable and stylish, and comes in at an incredibly affordable price of just $20. The timeless blue shirt makes this tee a versatile choice for any occasion, whether it''s a casual night out or a night in with friends. Great quality, timeless design and affordability make this shirt the right choice for those who want to be fashionable without spending a fortune.",
                "colourId" => 3, // Blue
                "imageFile" => "Generic Blue T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Black T",
                "price" => 20.00,
                "description" => "This black t-shirt from our collection is essential for those looking for a simple yet stylish basic. With a classic fit and a color that works for any occasion, this shirt is a versatile and stylish choice that can be worn any time of the year, alone or under a jacket. The exceptional quality of this shirt is reflected in every detail, it''s simple yet carefully crafted at the seams. And thanks to its affordable price, you can add this shirt to your wardrobe without breaking the bank. What are you waiting for?",
                "colourId" => 2, // Black
                "imageFile" => "Generic Black T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Brown T",
                "price" => 20.00,
                "description" => "Crafted from a soft cotton and high-quality polyester blend, this T-shirt offers exceptional comfort, retaining its shape and quality even after repeated washings. Its beautiful subtle brown color adds sophistication to any outfit, making it a must-have. The classic fit and availability of multiple sizes offer a flattering silhouette for all body types. With exceptional quality and a versatile design, this brown T-shirt is an essential for any wardrobe. Add a touch of casual sophistication to your wardrobe with this exceptional quality brown tee.",
                "colourId" => 4, // Brown
                "imageFile" => "Generic Brown T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic Yellow T",
                "price" => 20.00,
                "description" => "The yellow t-shirt from our collection is a bold choice for those who want to add a bright color to their wardrobe. The bright yellow shade of this t-shirt is a great choice for adding a vibrant and cheerful touch to any outfit, whether it''s on a sunny day or to brighten up a rainy one. With great quality and bright colors, this yellow t-shirt is an essential for those looking for a cheap t-shirt to add some sparkle to their wardrobe.",
                "colourId" => 9, // Yellow
                "imageFile" => "Generic Yellow T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Generic White T",
                "price" => 20.00,
                "description" => "The white T-shirt is a timeless classic that never goes out of style. Made from premium cotton, the T-shirt offers exceptional comfort and long-lasting wear, making it an essential piece for any wardrobe. The bright hues give a fresh, clean look to any outfit, whether it''s a casual day or a formal occasion. In addition to being economical, the neat seams and perfect finish are a testament to its superior quality.",
                "colourId" => 8, // White
                "imageFile" => "Generic White T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Green Jacket",
                "price" => 40.00,
                "description" => "From high-quality materials, this jacket has a modern and stylish look. The green color is perfect for adding a vibrant touch to any outfit, while the slim fit offers a flattering silhouette for any body type. Convenient pockets and a solid zipper and button closure make this versatile jacket a practical piece that can be worn for any occasion. It can be worn at any time of the year, whether it''s in the spring for protection from the wind or in the cold of winter.",
                "colourId" => 5, // Green
                "imageFile" => "Green Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Blue Denim Jacket",
                "price" => 40.00,
                "description" => "Our denim blue jacket is crafted from sturdy and high-quality denim material, which not only provides a fashionable appearance but also adds practicality to the design. Denim is a durable and long-lasting fabric, making this jacket a wise investment for anyone looking for an outerwear piece that can withstand regular use. The classic blue color of this jacket is a versatile shade that pairs well with a variety of outfits, while the timeless design ensures that it will never go out of style. Whether you''re dressing up for a semi-formal event or running errands on the weekend, our denim blue jacket is the perfect choice.",
                "colourId" => 3, // Blue
                "imageFile" => "Blue Denim Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "White Jacket",
                "price" => 40.00,
                "description" => "Add a touch of sophistication to your outfit with our elegant white jacket. Made from high-quality materials, it''s designed to last and has a flattering cut that accentuates your figure. Perfect for both formal events and everyday wear, this versatile jacket is available in various sizes and styles. Shop now for fast and easy online ordering and elevate your wardrobe today.",
                "colourId" => 8, // White
                "imageFile" => "White Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Grey Jacket",
                "price" => 40.00,
                "description" => "Introducing our stylish grey jacket, a wardrobe staple that effortlessly combines fashion and functionality. Made from high-quality materials, this jacket is both durable and comfortable, making it a versatile piece that''s perfect for any occasion. The neutral grey color of the jacket adds a touch of sophistication to any outfit, while the sleek and modern design ensures that you always look your best. Whether you''re dressing up for a night out or keeping it casual on the weekend, this grey jacket is a must-have addition to your wardrobe.",
                "colourId" => 6, // Grey
                "imageFile" => "Grey Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Black Jacket",
                "price" => 40.00,
                "description" => "Introducing our sleek black jacket, a versatile and stylish piece that''s perfect for any occasion. Made from high-quality materials, this jacket is designed to last and provide comfort and functionality for everyday wear. The classic black color of the jacket adds a touch of sophistication to any outfit, while the modern and flattering design ensures that you look your best. Whether you''re dressing up for a formal event or keeping it casual on the weekend, this black jacket is a must-have addition to your wardrobe.",
                "colourId" => 2, // Black
                "imageFile" => "Black Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Black Sweater",
                "price" => 25.00,
                "description" => "Introducing our cozy and stylish black sweater, a must-have addition to your winter wardrobe. Made from high-quality materials, this sweater is both comfortable and durable, ensuring that you stay warm and fashionable throughout the season. The classic black color of the sweater is versatile and can be easily paired with a variety of outfits, while the cozy and comfortable design makes it perfect for layering. Whether you''re snuggled up at home or out running errands, this black sweater is a great choice for both comfort and style.",
                "colourId" => 2, // Black
                "imageFile" => "Black Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "White Sweater",
                "price" => 25.00,
                "description" => "From its versatility, as white is a neutral color that can be easily combined with other colors; from its freshness, as this color is often associated with cleanliness and freshness, which can make an outfit look cleaner and neater; from its comfort and style: our white cotton sweaters, are soft and comfortable, which makes them nice to wear on cooler days and adds an elegant and sophisticated touch to an outfit.",
                "colourId" => 8, // White
                "imageFile" => "White Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Blue Sweater",
                "price" => 25.00,
                "description" => "This sweater is designed to provide an extra layer of warmth, which can be especially helpful during the colder months of the year. Our hoodies are made of real cotton, which makes them soft to the touch and durable, as they can be worn for a long time. The blue color adds a stylish and sophisticated touch to an outfit, especially when paired with neutral tones like white, gray or black.",
                "colourId" => 3, // Blue
                "imageFile" => "Blue Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Grey Sweater",
                "price" => 25.00,
                "description" => "Introducing our cozy and stylish grey sweater, a must-have addition to your winter wardrobe. Made from high-quality materials, this sweater is both comfortable and durable, ensuring that you stay warm and fashionable throughout the season. The neutral grey color of the sweater is versatile and can be easily paired with a variety of outfits, while the cozy and comfortable design makes it perfect for layering. Whether you''re snuggled up at home or out running.",
                "colourId" => 6, // Grey
                "imageFile" => "Grey Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Yellow Sweater",
                "price" => 25.00,
                "description" => "Our yellow sweater designed with durable and stylish material is the perfect outfit to add a bright color to your wardrobe. Yellow is a versatile color that works well for all seasons and pairs well with a variety of colors. With its easy, casual fit, this sweater is easy to pair with your favorite pants, jeans or skirt. The hood is adjustable and the sweater has pockets to keep your small items in case you need to wear it.  And all at an affordable price, what are you waiting for?",
                "colourId" => 9, // Yellow
                "imageFile" => "Yellow Sweater.png",
                "categoryId" => 3, // Sweaters
            ),
            array(
                "name" => "Leather Jacket",
                "price" => 100.00,
                "description" => "Get ready to make a statement with this leather jacket! Perfect for any season and any occasion, you''ll love how versatile and stylish it is. Crafted from the finest materials and designed to fit comfortably, this jacket will keep you warm and fashionable every time you wear it. Make a bold fashion statement with Leather jacket today!",
                "colourId" => 2, // Black
                "imageFile" => "Leather Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Beige Jacket",
                "price" => 50.00,
                "description" => "Ready to upgrade your wardrobe? Look no further than Beige''s jacket! Our classic and stylish design offers maximum comfort and flexibility for any occasion. You''ll stay warm and cozy on cool days, and look great with its timeless silhouette. Get ready to feel confident in your look with Beige''s quality jacket that fits all your outfits!",
                "colourId" => 1, // Beige
                "imageFile" => "Beige Jacket.png",
                "categoryId" => 2, // Jackets
            ),
            array(
                "name" => "Your Logo T",
                "price" => 20.00,
                "description" => "Show off your unique style with Your Logo T! Our high-quality, lightweight t-shirt is comfortable and stylish, making it perfect for any occasion. With our custom printing technology, you can easily design and create personalized clothing that expresses your creativity and never fades. Make a statement with Your Logo T - the perfect way to express yourself!",
                "colourId" => 8, // White
                "imageFile" => "Your Logo T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Free Mockup T",
                "price" => 15.00,
                "description" => "Feeling creative? Get inspired and make a statement with Free Mockup T! This comfy and stylish piece of clothing will let you express yourself in a unique way. With its soft fabric and classic design, your outfit will be complete in no time. So go ahead, unleash your creativity and show the world your true colors with Free Mockup T!",
                "colourId" => 7, // Pink
                "imageFile" => "Free Mockup T.png",
                "categoryId" => 1, // T-Shirts
            ),
            array(
                "name" => "Brown Jacket",
                "price" => 50.00,
                "description" => "Get ready to stay warm and stylish this season with the Brown Jacket! This comfortable, lightweight jacket is perfect for any occasion. Whether you''re heading to the park or out on a chilly night, you can trust that Brown Jacket will keep you warm and cozy without breaking the bank. Get ready to layer up in style with Brown Jacket!",
                "colourId" => 4, // Brown
                "imageFile" => "Brown Jacket.png",
                "categoryId" => 2, // Jackets
            ), 
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