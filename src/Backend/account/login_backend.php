<?php 

if(isset($_POST["submit"])){

    require_once(__DIR__.'/../config.php');
    require_once 'account_functions.php';

    $mysqli = DatabaseConfig::get_db_connection();
    $uid = $_POST["uid"];
    $password= $_POST["password"];

    // Always best to double-check for empty fields on the backend
    if (emptyInputLogin($uid, $password) != false) { 
        header("location: ../../Account/Login.php?error=emptyInput");
        exit();
    }

    loginUser($mysqli, $uid, $password);

// Send user right back to the page they were just at if submit not set
} else {
    header("location: ../../Account/Login.php");
    exit();
}