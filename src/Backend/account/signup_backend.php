<?php 

if (isset($_POST["submit"])) {

    require_once(__DIR__.'/../config.php');

    $mysqli = DatabaseConfig::get_db_connection();
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    
    require_once 'account_functions.php';

    if (emptyInputSignup($email,$username,$password)) { 
        header("location: ../../Account/Signup.php?error=empty_input");
        exit();
    }
    
    if (invalidUname($username)) {
        header("location: ../../Account/Signup.php?error=invalid_username");
        exit();
    }

    if (invalidEmail($email)) { 
        header("location: ../../Account/Signup.php?error=invalid_email");
        exit();
    }

    if (getUser($mysqli, $username, $email) != false) { 
        header("location: ../../Account/Signup.php?error=already_taken");
        exit();
    }

    createUser($mysqli, $email, $username, $password); 

// Submit superglobal not set
} else {
    header("location: ../../Account/Signup.php");
    exit();
}
