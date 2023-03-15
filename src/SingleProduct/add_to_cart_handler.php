<?php 

// Anything echoed here goes into the request response and redirects don't work

session_start();
if(isset($_SESSION["userid"])) {
    if (isset($_POST["product"]) and isset($_POST["quantity"]) and isset($_POST["size"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Cart/cart_functions.php');
        if (addToCart($_SESSION["userid"], $_POST["product"], $_POST["quantity"], $_POST["size"])) {
            echo "Success!";
        } else {
            echo "Error: Failed to add items to cart!";
        }
        
    // One or more POST parameters not set
    } else {
        echo "Error! Try refreshiung the page";
    }

// Not logged in
} else {
    echo "You must be logged in to add an item to your cart!";
}

