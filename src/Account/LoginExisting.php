<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="LoginExisting.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>

    <body>

        <!-- Ensure the database exists. Create it if it doesn't exist -->
        <?php
            require_once(__DIR__.'/../Backend/create_database.php');
            createDatabase();
        ?>

        <navbar-component> </navbar-component>
    
        <div class="main-container">
          <div class="login-container">
             <div class="login-header">
                 <h1>Logged in as <span class=[username]></span> </h1>
                <div class="not-you"> 
                <p> Not you? </p>
                <form action="logout.php" method="post">
                 <button type="submit">Log Out</button>
                 </form>
                </div>

            </div>
          </div>
       </div>

        <footer-component></footer-component>
   </body>
</html>