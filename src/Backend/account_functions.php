<?php 

    function emptyInputSignup($email,$username,$password)
    {
        $result;

        if(empty($email) || empty($username) || empty($password))
            {
                 $result = true;
             }
        else
            {   
                 $result = false ;
            }
  
        return $result;
    }

    function InvalidUname($username)
    {
        $result;

        if(!preg_match("/^[a-zA-Z0-9]*$/", $username))
            {
                 $result = true;
             }
        else
            {   
                 $result = false ;
            }
  
        return $result;
    }

    Function InvalidEmail($email) 
    { 
        $result;

        if (!filter_var($email, FILTER_VALIDATE_EMAIL))
            {
                 $result = true ;
            }
        else
            {   
                 $result = false ;
            }

        return $result;
    }

    Function uidExist($conn,$username,$email) 
    {   
        //Anti SQL Injection protection//
        $sql = "SELECT * FROM users WHERE usersUname = ? or usersEmail = ?;";   //prepare the sql statement//
        $stmt = mysqli_stmt_init($conn); 

        if(!mysqli_stmt_prepare($stmt,$sql)) //check if anything fails// 

            {
                header("location: ../Account/Signup.php?error=alreadyexist");
                exit();
            }

        mysqli_stmt_bind_param($stmt, "ss", $username, $email); 
        mysqli_stmt_execute($stmt);

        $result_data = mysqli_stmt_get_result($stmt);

        if($row = mysqli_fetch_assoc($result_data))
            {
                 return $row;
            }
        else
            {
                 $result = false;
                 return $result;
            }

        mysqli_stmt_close($stmt);
    }

    Function CreateUser($conn, $email, $username, $password) 
    {   //Anti SQL Injection protection//
        $sql = "INSERT INTO users(usersEmail, usersUname, usersPassword) VALUES (?, ?, ?);";   //prepare the sql statement//
        $stmt = mysqli_stmt_init($conn); 

        if(!mysqli_stmt_prepare($stmt,$sql)) //check if anything fails// 

            {
                header("location: ../Account/Signup.php?error=stmtfailed2");
                exit();
            }

        $hashedpassword = password_hash($password, PASSWORD_DEFAULT);

        mysqli_stmt_bind_param($stmt, "sss", $email, $username, $hashedpassword); 
        mysqli_stmt_execute($stmt);
        mysqli_stmt_close($stmt);
        header("location: ../Account/Signup.php?error=none");

        exit();
    }

    function emptyInputLogin($uid, $password)
    {
        $result;

        if(empty($uid) || empty($password))
            {
                 $result = true;
             }
        else
            {   
                 $result = false ;
            }
  
        return $result;
    }

    function loginUser($conn, $username, $password){
        $uidExist = uidExist($conn,$username,$username);
        if($uidExist === false){
            header("location: ../Account/Login.php?error=wronguid");
            exit();
        }
 
    $pwdHashed = $uidExist["usersPassword"];
    $checkpassword = password_verify($password, $pwdHashed);
 
    if($checkpassword === false) {
        header("location: ../Account/Login.php?error=wrongpassword"); 
        exit();
    }

    else if($checkpassword === true) { 
        session_start();
            $_SESSION["userid"] = $uidExist["ID"];
            $_SESSION["useruid"] = $uidExist["usersUname"];
            header("location: ../Home/Home.php");
            exit(); 
        
    }
    } 