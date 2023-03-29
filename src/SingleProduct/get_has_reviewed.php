<?php 

// Anything echoed here goes into the request response and redirects don't work

session_start();
if(isset($_SESSION["userid"])) {
    if (isset($_GET["productid"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Reviews/review_functions.php');
        if (userHasReviewedProduct($_SESSION["userid"], $_GET["productid"])) {
            echo "true";
        } else {
            echo "false";
        }
        
    // One or more GET parameters not set
    } else {
        echo "Error in get_has_reviewed.php: Product ID not found!";
    }

// Not logged in
} else {
    echo "Error in get_has_reviewed.php: Not logged in!";
}