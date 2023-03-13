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
        <link rel="stylesheet" href="Logout.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>

    <body>
        <navbar-component page="Account"> </navbar-component>
    
        <div class="main-container">
          <div class="login-container">
            
             <div class="login-header">
                <?php

                session_start();
                if(isset($_SESSION["userid"])) {
                    $username = $_SESSION["username"];
                    echo"<h1>Logged in as <span class='username'>$username</span> </h1>";
                } else {
                    // Send the user back to the login page if they are not logged in
                    header("Location: Login.php");
                    exit();
                }

                ?>
                
                <div class="not-you"> 
                <p> Not you? </p>
                    <button onclick="window.location.href='../Backend/account/logout_backend.php'" type="submit">Log Out</button>
                </div>

            </div>
          </div>
       </div>

        <footer-component></footer-component>
   </body>
</html>