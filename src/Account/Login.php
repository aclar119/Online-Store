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

        <!-- Ensure the database exists. Create it if it doesn't exist -->
        <?php
            require_once(__DIR__.'/../Backend/create_database.php');
            createDatabase();
        ?>

        <navbar-component> </navbar-component>
    
        <div class="main-container">

          <div class="login-container">

             <div class="login-header">
                 <h1>Login to your account</h1>
             </div>

             <div class="login-field">
                <form action="login.php" method="post">
                <div class="form-group">
                 <label for="email">Email</label>
                 <input type="email" id="email" name="email" placeholder="Enter your email" required>
                 <label for="password">Password</label>
                 <input type="password" id="password" name="password" placeholder="Enter your password" required>
                 <button type="submit">Login</button>
                  </div>
                 </form>
               </div>

          </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>