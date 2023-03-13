<?php 

// Make sure the user is logged out by destroying the session and making a fresh one
session_start();
session_unset();
session_destroy();

// Send the user to the login page after logging them out
header("location:../../Account/Login.php");