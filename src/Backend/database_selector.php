<?php

    // Select all products from the database and return the results object
    function selectProducts($search, $categories, $colours) {
        $mysqli = DatabaseConfig::get_db_connection();

        $select_query = "SELECT P.ID, P.Name, P.Price, P.Description, P.ImageFile 
            FROM `Products` AS P 
            JOIN `Categories` AS CT ON P.CategoryID = CT.ID
            JOIN `Colours` AS CL ON P.ColourID = CL.ID";

        if (strlen($categories) > 0 or strlen($colours)) {
            $select_query = $select_query . " WHERE";

            if (strlen($categories) > 0) {
                $select_query = $select_query . " (";
                $categories_array = explode("_", $categories);
                foreach ($categories_array as $category) {
                    $select_query = $select_query . " CT.InternalName='$category' OR";
                }
                $select_query = substr($select_query, 0, strlen($select_query) - strlen(" OR"));
                $select_query = $select_query . ")";
                $select_query = $select_query . " AND";
            }

            if (strlen($colours) > 0) {
                $select_query = $select_query . " (";
                $colours_array = explode("_", $colours);
                foreach ($colours_array as $colour) {
                    $select_query = $select_query . " CL.InternalName='$colour' OR";
                }
                $select_query = substr($select_query, 0, strlen($select_query) - strlen(" OR"));
                $select_query = $select_query . ")";
                $select_query = $select_query . " AND";
            }

            $select_query = substr($select_query, 0, strlen($select_query) - strlen(" AND"));

        } elseif (strlen($search) > 0) {
            $select_query = $select_query . " WHERE P.Name LIKE '%$search%'";
        }

        // echo $select_query;
        

        $results = $mysqli->query($select_query . ";");
        
        $mysqli->close(); 

        return $results;
    }

    function selectProduct($id) {
        $mysqli = DatabaseConfig::get_db_connection();

        $select_query = "SELECT * FROM `Products` WHERE ID = $id";
        $results = $mysqli->query($select_query);
        
        $mysqli->close(); 

        $result = $results->fetch_assoc();

        return $result;
    }

    // Select all categories from the database and return the results object
    function selectColours() {
        $mysqli = DatabaseConfig::get_db_connection();

        $select_query = "SELECT * FROM `Colours`";
        $results = $mysqli->query($select_query);
        
        $mysqli->close(); 

        return $results;
    }

    // Select all categories from the database and return the results object
    function selectCategories() {
        $mysqli = DatabaseConfig::get_db_connection();

        $select_query = "SELECT * FROM `Categories`";
        $results = $mysqli->query($select_query);
        
        $mysqli->close(); 

        return $results;
    }

    