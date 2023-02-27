<?php 
    session_start();

    // This page determines which account/login page to send the user to
    
    // By doing this here, we avoid needing to include any php in the account
    //  button itself and can therefore use a webcomponent to create the
    //  navbar and inlcude it on all our pages, thus reducing duplicate code
    
    if (isset($_SESSION['userid'])) {
        echo '<meta http-equiv="refresh" content="0; URL=LoginExisting.php" />';
    } else {
        echo '<meta http-equiv="refresh" content="0; URL=Login.php" />';
    }
?>