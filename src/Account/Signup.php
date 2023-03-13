<!-- Ensure the database exists. Create it if it doesn't exist -->
<?php
    require_once(__DIR__.'/../Backend/create_database.php');
    createDatabase();
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="./Signup.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>

    <body>
        <navbar-component page="Account" style="position: sticky; top: 0; z-index: 1;"> </navbar-component>
    
        <div class="main-container">

            <div class="login-container">

                <div class="login-header">
                    <h1>Create your account</h1>
                </div>

                <!-- This div defines the dark area -->
                <div class="login-subcontainer">

                    <!-- The main form content is all in this div -->
                    <div class="form-group">
                        <form action="../Backend/account/signup_backend.php" method="post" id="create-form">

                        <label for="username">Username</label>
                        <input class ="form-input" type="text" id="username" name="username" placeholder="Username" required>
                        <label for="email">Email</label>
                        <input class ="form-input" type="email" id="email" name="email" placeholder="Email" required>
                        <label for="password">Password</label>
                        <input class="form-input" type="password" id="password" name="password" placeholder="Password" required>

                            <div class="buttons-div">
                            <button class= "button" type="submit" name="submit">Create Account</button>
                            </div>
                            <p class="already-member"><a href="login.php">Already a member ?</a></p>                   

                        </form>

                    </div>

                </div>

                <?php 

                // This is where the user feedback is provided
                if(isset($_GET["error"])) {
                    if($_GET["error"] == "already_taken"){
                        echo "<p style='text-align: center; color: red;'>Username or Email already taken<p>"; 
                    } else if($_GET["error"] == "empty_input"){
                        echo "<p style='text-align: center; color: red;'>All fields must be filled!<p>"; 
                    } else if($_GET["error"] == "invalid_username"){
                        echo "<p style='text-align: center; color: red;'>The provided username is invalid!<p>"; 
                    } else if($_GET["error"] == "invalid_email"){
                        echo "<p style='text-align: center; color: red;'>The provided email is invalid!<p>"; 
                    } else if($_GET["error"] == "none"){
                        echo "<p style='text-align: center; color: green;'>You have succesfully signed up!<p>"; 
                    }    
                }

                ?> 

            </div>
       </div>
        <footer-component></footer-component>
   </body>
</html>