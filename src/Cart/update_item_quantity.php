<?php

session_start();

if(isset($_SESSION["userid"])) {
    if (isset($_POST["product"]) and isset($_POST["quantityDifference"]) and isset($_POST["size"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Cart/cart_functions.php');
        if (updateCartItemQuantity($_SESSION["userid"], $_POST["product"], $_POST["quantityDifference"], $_POST["size"])) {
            echo "Success!";
        } else {
            echo "Error! Failed to update quantity";
        }
        
    // One or more POST parameters not set
    } else {
        echo "Error! Try refreshiung the page";
    }

// Not logged in
} else {
    echo "Error! User session not found. Make sure you are still logged in";
}