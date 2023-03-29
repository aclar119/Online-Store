<?php 

// Anything echoed here goes into the request response and redirects don't work

session_start();
if(isset($_SESSION["userid"])) {
    if (isset($_POST["productid"]) and isset($_POST["rating"]) and isset($_POST["message"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Reviews/review_functions.php');
        $result = createReview($_SESSION["userid"], $_POST["productid"], $_POST["rating"], $_POST["message"]);
        if ($result == true) {
            echo "Success!";
        } else {
            echo $result;
        }
        
    // One or more POST parameters not set
    } else {
        echo "Error: One or more POST parameters not set. Try refreshiung the page";
    }

// Not logged in
} else {
    echo "You must be logged in to create a review!";
}