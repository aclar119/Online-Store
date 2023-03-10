<?php 

if (isset($_POST["submit"]))
     { 
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        require_once 'login_database.php';
        require_once 'account_functions.php';

        if (emptyInputSignup($email,$username,$password) !== false) { 
            header("location: ../Account/Signup.php?error=emptyInput");
            exit();
        }
        
        if (InvalidUname($username) !== false) { 
            header("location: ../Account/Signup.php?error=invaliduname");
            exit();
        }

        if (InvalidEmail($email) !== false) { 
            header("location: ../Account/Signup.php?error=invalidEmail");
            exit();
        }

        if (uidExist($conn, $username, $email) !== false) { 
            header("location: ../Account/Signup.php?error=alreadytaken");
            exit();
        }

        createUser($conn, $email, $username, $password); 
     }

else 
    {
    header("location: ../Account/Signup.php?wtfisdisshit");
    exit();
    }
