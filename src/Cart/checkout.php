<?php 

// Anything echoed here goes into the request response and redirects don't work

session_start();
if(isset($_SESSION["userid"])) {
    if (isset($_POST["subtotal"]) and isset($_POST["taxes"]) and isset($_POST["shipping"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Cart/cart_functions.php');
        if (selectCartItems($_SESSION["userid"])->num_rows > 0) {
            if (checkout($_SESSION["userid"], $_POST["subtotal"], $_POST["taxes"], $_POST["shipping"])) {
                echo "Success!";
            } else {
                echo "Error: Failed to checkout!";
            }
        } else {
            echo "You must have at least one item in your cart to checkout!";
        }
        
    // One or more POST parameters not set
    } else {
        echo "Error! Try refreshiung the page";
    }

// Not logged in
} else {
    echo "You must be logged in to checkout!";
}