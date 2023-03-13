<!-- Ensure the database exists. Create it if it doesn't exist -->
<?php
    require_once(__DIR__.'/../Backend/create_database.php');
    createDatabase();

    // Send the user to the logout page if they are logged in
    session_start();
    if(isset($_SESSION["userid"])) {
        header("Location: Logout.php");
        exit();
    }
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="Login.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>

    <body>
        <navbar-component page="Account" style="position: sticky; top: 0; z-index: 1;"> </navbar-component>
    
        <div class="main-container">
            <div class="login-container">

                <div class="login-header">
                    <h1>Login to your Account</h1>
                </div>

                <!-- This div defines the dark area -->
                <div class="login-subcontainer">

                    <!-- The main form content is all in this div -->
                    <div class="form-group">
                        <form action="../Backend/account/login_backend.php" method="post" id="login-field">

                            <table id="login-table">

                                <!-- Email / Username -->
                                <tr>
                                    <th><label for="uid">ID</label></th>
                                </tr>
                                <tr>
                                    <td><input type="text" id="uid" name="uid" placeholder="Email or Username" required></td>
                                </tr> 

                                <!-- Password -->
                                <tr>
                                    <th><label for="password">Password</label></th>
                                </tr>
                                <tr>
                                    <td><input type="password" id="password" name="password" placeholder="Password" required></td>
                                </tr>
                            </table>
                            
                            <!-- Login Button -->
                            <div class="button-submit">
                                <button type="submit" class="button" name="submit">Login</button>
                            </div>

                            <!-- Link to account creation -->
                            <p class="not-member"><a href="Signup.php">Not yet a member ?</a></p>
                        
                        </form>
                    </div>

                </div>
            </div>
       </div>
        <footer-component></footer-component>
   </body>
</html>