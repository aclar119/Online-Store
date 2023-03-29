<?php

session_start();

if(isset($_SESSION["username"])) {

    echo $_SESSION["username"];

// Not logged in
} else {
    echo "Not logged in!";
}