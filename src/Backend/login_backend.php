<?php 

if(isset($_POST["submit"])){

$uid = $_POST["uid"];
$password= $_POST["password"];

require_once 'login_database.php'; 
require_once 'account_functions.php'; 

if (emptyInputLogin($uid,$password) !== false) { 
    header("location: ../Account/Login.php?error=emptyInput");
    exit();
}

loginUser($conn,$uid,$password);
 }

else {
    header("location: ../Account/Login.php?fuckdisshit");
    exit();
    }