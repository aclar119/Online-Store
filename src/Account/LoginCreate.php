
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

        <navbar-component> page="Account" </navbar-component>
    
      <div class="main-container">

          <div class="login-container">

             <div class="login-header">
                 <h1>Create your account</h1>
             </div>

             <div class="login-subcontainer">

                <div class="form-group">

                    <form action="Registration.php" method="get" id="Create-form">

                    <label for="First Name">First Name</label>
                    <input class ="Form-input" type="text" id="First-Name" name="First Name" placeholder="First Name" required>
                    <label for="Last Name">Last Name</label>
                    <input class ="Form-input" type="text" id="Last-Name" name="Last Name" placeholder="Last Name" required>
                    <label for="Email">Email</label>
                    <input class ="Form-input" type="Email" id="Email" name="Email" placeholder="Email" required>
                    <label for="Password">Password</label>
                    <input class="Form-input" type="password" id="Password" name="Password" placeholder="Password" required>
                    

                        <div class="buttons-div">
                        <button class= "button" type="submit">Create Account</button>
                        </div>
                        <p class="already-member"><a href="login.php">Already a member ?</a></p>
                    

                    </form>

                </div>

                 
            

             </div>

            
            </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>