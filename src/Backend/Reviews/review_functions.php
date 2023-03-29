<?php 

// Returns true if the given user has ever ordered the given product, false otherwise
function userHasOrderedProduct($userid, $productid) {

    $orders = queryOrderedProduct($userid, $productid);

    if(!$orders) { // $orders will be false if there was an error
        return false;
    } else {
        return ($orders->num_rows > 0) ? true : false;
    }
}

// Returns true if the given user has ever reviewed the given product, false otherwise
function userHasReviewedProduct($userid, $productid) {

    $reviews = queryReviewedProduct($userid, $productid);

    if (!$reviews) { // $reviews will be false if there was an error
        return false; 
    } else {
        return ($reviews->num_rows > 0) ? true : false;
    }
}


// Returns true if a review is successfully created, false otherwise
function createReview($userid, $productid, $rating, $message) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // Double checking that the user has actually ordered the product before
    $orders = queryOrderedProduct($userid, $productid);
    if(!$orders or $orders->num_rows == 0) { // $orders will be false if there was an error
        return "Error in createReview(): User has never ordered this product";
    }

    // Double checking that the user has never reviewed the product before
    $reviews = queryReviewedProduct($userid, $productid);
    if(!$reviews or $reviews->num_rows > 0) { // $reviews will be false if there was an error
        return "Error in createReview(): User has already reviewed this product";
    }

    // Create the review
    $insert_review_query = "INSERT INTO Reviews(UserID, ProductID, Rating, ReviewMessage) VALUES (?, ?, ?, ?);";
    $insert_review_stmt = mysqli_stmt_init($mysqli); 

    if(!mysqli_stmt_prepare($insert_review_stmt, $insert_review_query)){
        return "Error in createReview(): Failed to assemble the insert query";
    }

    mysqli_stmt_bind_param($insert_review_stmt, "ssss", $userid, $productid, $rating, $message); 
    mysqli_stmt_execute($insert_review_stmt);
    mysqli_stmt_close($insert_review_stmt);

    return true;
}


function selectReviews($product_id) {
    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    $select_query = "SELECT * 
    FROM `Reviews` AS R
    JOIN `Users` AS U ON U.ID = R.UserID 
    JOIN `Products` AS P ON P.ID = R.ProductID 
    WHERE R.ProductID = $product_id";

    $results = $mysqli->query($select_query);
        
    $mysqli->close(); 

    return $results;
}


// ---- INTERNAL ("PRIVATE") FUNCTIONS ---- 

// Queries the database to see if the user has ordered the product before
function queryOrderedProduct($userid, $productid) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // MySQLi Prepared Staments offer built-in injection protection
    $sql = "SELECT * FROM CartItems WHERE UserID = ? AND ProductID = ? AND Ordered = 1;";
    $stmt = mysqli_stmt_init($mysqli); 

    // Check if anything fails
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // Would be better to return an error here
        return false; 

    // Run the query and return the result
    } else {
        // "ss" indicates 2 params in the statement
        mysqli_stmt_bind_param($stmt, "ss", $userid, $productid); 
        mysqli_stmt_execute($stmt);

        $orders = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        return $orders;
    }
}

// Queries the database to see if the user has reviewed the product before
function queryReviewedProduct($userid, $productid) {

    require_once(__DIR__.'/../config.php');
    $mysqli = DatabaseConfig::get_db_connection();

    // MySQLi Prepared Staments offer built-in injection protection
    $sql = "SELECT * FROM Reviews WHERE UserID = ? AND ProductID = ?;";
    $stmt = mysqli_stmt_init($mysqli); 

    // Check if anything fails
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        // Would be better to return an error here
        return false; 

    // Run the query and return the result
    } else {
        // "ss" indicates 2 params in the statement
        mysqli_stmt_bind_param($stmt, "ss", $userid, $productid); 
        mysqli_stmt_execute($stmt);

        $reviews = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        return $reviews;
    }

}