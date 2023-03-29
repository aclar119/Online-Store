<?php 

// Returns true if any of the signup fields are empty
function emptyInputSignup($email, $username, $password) {
    if(empty($email) || empty($username) || empty($password)) {
        return true;
    } else {   
        return false ;
    }
}

// Returns true if the username is invalid (using regex)
function invalidUname($username) {
    if(!preg_match("/^[a-zA-Z0-9]*$/", $username)) {
        return true;
    } else {   
        return false ;
    }
}

// Returns true if the email is invalid
function invalidEmail($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        return true;
    } else {   
        return false ;
    }
}

// Returns user info if a user matching the email or username exists. False otherwise
function getUser($mysqli, $username, $email) {

    // MySQLi Prepared Staments offer built-in injection protection
    $sql = "SELECT * FROM Users WHERE Username = ? OR Email = ?;";
    $stmt = mysqli_stmt_init($mysqli); 

    // Check if anything fails (this assumes that any failure is because the uid already exists)
    if(!mysqli_stmt_prepare($stmt, $sql)) {
        header("location: ../../Account/Signup.php?error=alreadyexists");
        return false;

    // Run the query and return the result
    } else {
        // "ss" indicates 2 params in the statement
        mysqli_stmt_bind_param($stmt, "ss", $username, $email); 
        mysqli_stmt_execute($stmt);

        $existing_users = mysqli_stmt_get_result($stmt);

        mysqli_stmt_close($stmt);

        if($existing_users->num_rows > 0) {
            return mysqli_fetch_assoc($existing_users);
        } else {
            return false;
        }
    }

}


// Creates a new user with the given credentials
function createUser($mysqli, $email, $username, $password) {

    // MySQLi Prepared Staments offer built-in injection protection
    $sql = "INSERT INTO Users(Email, Username, HashedPassword) VALUES (?, ?, ?);";
    $stmt = mysqli_stmt_init($mysqli); 

    if(!mysqli_stmt_prepare($stmt, $sql)){
        header("location: ../../Account/Signup.php?error=stmtfailed");
        exit();
    }

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    mysqli_stmt_bind_param($stmt, "sss", $email, $username, $hashed_password); 
    mysqli_stmt_execute($stmt);
    mysqli_stmt_close($stmt);

    header("location: ../../Account/Signup.php?error=none");
}


// Check if the user left the userID or password field empty
function emptyInputLogin($uid, $password) {
    if(empty($uid) || empty($password)) {
        return true;
    } else {   
        return false;
    }
}

// Logs the user in by setting seesion var if credentials are valid
function loginUser($mysqli, $username, $password) {

    $user = getUser($mysqli, $username, $username);

    // getUser function returns false if no user exists
    if($user == false){
        header("location: ../../Account/Login.php?error=wronguid");
        exit();
    }
    
    // Checking the password
    $pwd_hashed = $user["HashedPassword"];

    if (password_verify($password, $pwd_hashed)) { 
        session_start();
        $_SESSION["userid"] = $user["ID"];
        $_SESSION["username"] = $user["Username"];
        header("location: ../../Account/Logout.php");
        
    } else {
        header("location: ../../Account/Login.php?error=wrongpassword"); 
    }

}