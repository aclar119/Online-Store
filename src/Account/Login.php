<?php
    require_once(__DIR__.'/../Backend/login_database.php');
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

        <!-- Ensure the database exists. Create it if it doesn't exist -->
        <?php
            require_once(__DIR__.'/../Backend/create_database.php');
            createDatabase();
        ?>

        <navbar-component page="Account"> </navbar-component>
    
        <div class="main-container">

          <div class="login-container">

             <div class="login-header">
                 <h1>Login to your Account</h1>
             </div>
                
                <div class="login-subcontainer">

                <div class="form-group">

                <form action="../Backend/login_backend.php" method="post" id="login-field">

                    <table id="login-table">
                    
                    <tr>
                    <th><label for="uid">ID</label></th>
                    </tr>
                    <tr>
                    <td><input type="text" id="uid" name="uid" placeholder="Email or Username"></td>
                    </tr>  
                    <tr>
                    <th><label for="password">Password</label></th>
                    </tr>
                    <tr>
                    <td><input type="password" id="password" name="password" placeholder="Password"></td>
                    </tr>

                    </table>
                    
                    <div class="button-submit">
                    <button type="submit" class="button" name="submit">Login</button>
                     </div>
                    <p class="not-member"><a href="Signup.php">Not yet a member ?</a></p>
                   

               </div>
                </form>

               </div>


            </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>