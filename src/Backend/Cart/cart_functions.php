<?php 

// Adds a product to a user's cart
// Returns true if successful, false otherwise
function addToCart($user_id, $product_id, $quantity, $size) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // First need to check if this produt is already in this user's cart
    $select_query = "SELECT * FROM CartItems 
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size' AND Ordered=0;";

    $select_results = $mysqli->query($select_query);

    // Add to the count of an existing cart entry
    if ($select_results->num_rows > 0) {
        $select_result = $select_results->fetch_assoc();
        $new_quatity = $select_result["Quantity"] + $quantity;

        $update_query = "UPDATE CartItems SET Quantity=$new_quatity 
        WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size' AND Ordered=0;";

        $result = $mysqli->query($update_query);

    // Create a new cart entry
    } else {
        $insert_query = "INSERT INTO CartItems (UserID, ProductID, Quantity, Size, Ordered)
        VALUES ($user_id, $product_id, $quantity, '$size', FALSE);";

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
    WHERE UserID = $user_id AND Ordered=0";

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
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size' AND Ordered=0;";

    $select_results = $mysqli->query($select_query);

    // Add to the count of an existing cart entry
    if ($select_results->num_rows > 0) {
        $select_result = $select_results->fetch_assoc();
        $new_quatity = $select_result["Quantity"] + $quantity_difference;

        $update_query = "UPDATE CartItems SET Quantity=$new_quatity 
        WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size' AND Ordered=0;";

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
    WHERE UserID=$user_id AND ProductID=$product_id AND Size='$size' AND Ordered=0;";

    $result = $mysqli->query($delete_query);

    return ($result) ? true : false;

}

// Updates all the items currently in the cart as ordered
// Returns true if successful, false otherwise
function checkout($user_id, $subtotal_price, $taxes_price, $shipping_price) {

    $total_price = $subtotal_price + $taxes_price + $shipping_price;

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // Create the new order
    $insert_query = "INSERT INTO Orders (UserID, SubtotalPrice, TaxesPrice, ShippingPrice, TotalPrice)
    VALUES ($user_id, $subtotal_price, $taxes_price, $shipping_price, $total_price);";

    $insert_result = $mysqli->query($insert_query);
    if (!$insert_result) {return false;}

    // Get the new order's ID
    $select_query = "SELECT * FROM Orders WHERE UserID=$user_id ORDER BY id DESC LIMIT 1;";
    $select_results = $mysqli->query($select_query);
    $order_id = 0;
    
    if ($select_results->num_rows > 0) {
        $select_result = $select_results->fetch_assoc();
        $order_id = $select_result["ID"];
    } else {return false;}

    // Update the items that are currently in the cart
    $update_query = "UPDATE CartItems SET Ordered=1, OrderID=$order_id 
    WHERE UserID=$user_id AND Ordered=0;";

    $update_result = $mysqli->query($update_query);

    return ($update_result) ? true : false;
}