<?php
    require_once(__DIR__.'/../Backend/login_database.php');
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

                    <form action="../Backend/signup_backend.php" method="post" id="Create-form">

                    <label for="username">Username</label>
                    <input class ="Form-input" type="text" id="username" name="username" placeholder="Username" >
                    <label for="email">Email</label>
                    <input class ="Form-input" type="email" id="email" name="email" placeholder="Email" >
                    <label for="password">Password</label>
                    <input class="Form-input" type="password" id="password" name="password" placeholder="Password" >
                    

                        <div class="buttons-div">
                        <button class= "button" type="submit" name="submit">Create Account</button>
                        </div>
                        <p class="already-member"><a href="login.php">Already a member ?</a></p>

                    <?php 

                    if(isset($_GET["error"]))
                        {
                            if($_GET["error"] == "alreadytaken"){
                                echo "<p style='text-align: center; color: red;'>Username or Email already exist<p>"; }
                        
                            else if($_GET["error"] == "none"){
                                echo "<p style='text-align: center; color: green;'>You have succesfully sign up ! <p>"; }            
                        }
                    ?>                    

                    </form>

                </div>

                 
            

             </div>

            
            </div>

       </div>

        <footer-component></footer-component>
   </body>
</html>