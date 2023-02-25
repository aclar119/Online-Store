<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="LoginCreate.css">
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
                 <h1>Create your account</h1>
             </div>

             <div class="login-field">
                <form action="login.php" method="post">
                <div class="form-group">
                 <label for="First Name">First Name</label>
                 <input type="text" id="First Name" name="First Name" placeholder="First Name" required>
                 <label for="Last Name">Last Name</label>
                 <input type="text" id="Last Name" name="Last Name" placeholder="Last Name" required>
                 <label for="Email">Email</label>
                 <input type="Email" id="Password" name="Email" placeholder="Email" required>
                 <label for="Password">Password</label>
                 <input type="password" id="Password" name="Password" placeholder="Password" required>
                 <button type="submit">Create</button>
                  </div>
                 </form>
             </div>

             <div class="login-link-container">
                 <p><a href="login.php">Already a member ?</a></p>
             </div>
            </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>