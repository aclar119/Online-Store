<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="Login-1.css">
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

        <?php

            if(isset($_REQUEST['login-field'])){
                $email = $_REQUEST['email'];
                $password = password_hash($_REQUEST['password'], PASSWORD_DEFAULT);

                require_once(__DIR__.'/../Backend/login_functions.php');
                echo getUserID($email, $password);
            
            }

        ?>

        <div class="main-container">

          <div class="login-container">

             <div class="login-header">
                 <h1>Login to your Account</h1>
             </div>
                
                <div class="login-subcontainer">

                <div class="form-group">

                <form action="Login.php" method="post" id="login-field">

                    <table id="login-table">
                    
                    <tr>
                    <th><label for="email">Email</label></th>
                    </tr>
                    <tr>
                    <td><input type="email" id="email" name="email" placeholder="Email" required></td>
                    </tr>  
                    <tr>
                    <th><label for="password">Password</label></th>
                    </tr>
                    <tr>
                    <td><input type="password" id="password" name="password" placeholder="Password" required></td>
                    </tr>

                    </table>
            
                    
                </form>

               </div>

                <div class="buttons">
                 <button type="submit" class="button">Login</button>
                 <p><a href="loginCreate.php">Not yet a member ?</a></p>
                </div>
               </div>
            </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>