<?php

// product : productID,
// size : size,

session_start();

if(isset($_SESSION["userid"])) {
    if (isset($_POST["product"]) and isset($_POST["size"])) {

        // This is where the magic happens
        require_once(__DIR__.'/../Backend/Cart/cart_functions.php');
        if (deleteCartItem($_SESSION["userid"], $_POST["product"], $_POST["size"])) {
            echo "Success!";
        } else {
            echo "Error! Failed to delete cart item";
        }
        
    // One or more POST parameters not set
    } else {
        echo "Error! Try refreshiung the page";
    }

// Not logged in
} else {
    echo "Error! User session not found. Make sure you are still logged in";
}