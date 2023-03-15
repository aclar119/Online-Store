<?php 

// Adds a product to a user's cart
// Returns true if successful, false otherwise
function addToCart($user_id, $product_id, $quantity, $size) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // First need to check if this produt is already in this user's cart
    $select_query = "SELECT * FROM CartItems 
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size';";

    $select_results = $mysqli->query($select_query);

    // Add to the count of an existing cart entry
    if ($select_results->num_rows > 0) {
        $select_result = $select_results->fetch_assoc();
        $new_quatity = $select_result["Quantity"] + $quantity;

        $update_query = "UPDATE CartItems SET Quantity=$new_quatity 
        WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size';";

        $result = $mysqli->query($update_query);

    // Create a new cart entry
    } else {
        $insert_query = "INSERT INTO CartItems (UserID, ProductID, Quantity, Size)
        VALUES ($user_id, $product_id, $quantity, '$size');";

        $result = $mysqli->query($insert_query);
    }

    return ($result) ? true : false;

}

// Returns all cart items associated with the provided user ID
function selectCartItems($user_id) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    $select_query = "SELECT * 
    FROM `CartItems` AS I
    JOIN `Products` AS P ON P.ID = I.ProductID 
    WHERE UserID = $user_id";

    $results = $mysqli->query($select_query);
        
    $mysqli->close(); 

    return $results;
}


// Updates the quantity of a product in a user's cart
// Returns true if successful, false otherwise
function updateCartItemQuantity($user_id, $product_id, $quantity_difference, $size) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // First need to figure out the current quantity in the cart
    $select_query = "SELECT * FROM CartItems 
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size';";

    $select_results = $mysqli->query($select_query);

    // Add to the count of an existing cart entry
    if ($select_results->num_rows > 0) {
        $select_result = $select_results->fetch_assoc();
        $new_quatity = $select_result["Quantity"] + $quantity_difference;

        $update_query = "UPDATE CartItems SET Quantity=$new_quatity 
        WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size';";

        $result = $mysqli->query($update_query);

    // Cart item not found
    } else {
        return false;
    }

    return ($result) ? true : false;

}

// Removes an item from a user's cart
// Returns true if successful, false otherwise
function deleteCartItem($user_id, $product_id, $size) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    $delete_query = "DELETE FROM CartItems 
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size';";

    $result = $mysqli->query($delete_query);

    return ($result) ? true : false;

}