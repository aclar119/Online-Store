<!DOCTYPE html>
<html>
    <head>
        <title>Online Store</title>
        <link rel="stylesheet" href="Home.css">
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>
    <body>

        <?php
            // $DB_NAME = "onlinestore";

            // $db_host = '127.0.0.1';
            // $db_user = 'root';
            // $db_password = ''; // (if not working, try 'root')
            // // $db_db = 'information_schema'; // (database already exists)
            // // $db_port = 3306; // (3306 for WAMP; 8889 for MAMP)

            // $mysqli = new mysqli(
            //     $db_host,
            //     $db_user,
            //     $db_password,
            //     // $db_db,
            //     // $db_port
            // );

            // if ($mysqli->connect_error) {
            //     echo 'Errno: '.$mysqli->connect_errno;
            //     echo '<br>';
            //     echo 'Error: '.$mysqli->connect_error;
            //     exit();
            // }

            // // Create the database if it doesn't already exist
            // $create_query = "CREATE DATABASE " . $DB_NAME;
            // $mysqli->query($create_query);


            
            // $mysqli->close(); 
        ?>

        <!-- Top section above (before) the navbar -->
        <div id="top-main">
            <div id="top-flex-container">
                <div id="title-outer">
                    <h1>Generic Clothing Co.</h1>
                    <button onclick="window.location.href='../BrowseProducts/BrowseProducts.php';">Shop Now</button>
                </div>
                <div></div>
            </div>
        </div>

        <!-- Navbar (Custom navbar behaviour prevents us from using the custom component) -->
        <div id="navbar" class="not-sticky">
            <div id="navbar-left">
                <div id="logo" onclick="window.location.href='../Home/Home.php';"><img src="../../resources/Icons/Logo.png" height="32" ></div>
                <div><a href="../BrowseProducts/BrowseProducts.php">Store</a></div>
                <div><a href="../AboutUs/AboutUs.php">About Us</a></div>
            </div>

            <div id="navbar-right">
                <form id="search-bar" action="../BrowseProducts/BrowseProducts.php">
                    <div>
                        <button><img src="../../resources/Icons/Search.png"></button>
                        <input id="search-input" type="text" placeholder="Search" name="search" autocomplete="off">
                    </div>
                </form>
                <div id="cart" onclick="window.location.href='../Cart/Cart.php';"><img src="../../resources/Icons/Cart.png" height="32" ></div>
            </div>
        </div>


        <!-- JavaScript code to enact the stciky effect on the navbar -->
        <!-- Scroll/Sticky functionality inspired by (but NOT directly copied from) https://www.w3schools.com/howto/howto_js_navbar_sticky.asp -->

        <script>

            // Run the toggleSticky() function when the user is scrolling
            window.onscroll = () => {toggleSticky()};
            
            // Calculate the Y position at which the navbar should become sticky
            let navbar = document.getElementById("navbar");
            let stickyThreshold = navbar.offsetTop - navbar.offsetHeight;
            
            // Change the classes that are applied to the navbar when it passes the threshold defined above
            function toggleSticky() {
              if (window.pageYOffset >= stickyThreshold) {
                navbar.classList.add("sticky")
                navbar.classList.remove("not-sticky")
              } else {
                navbar.classList.remove("sticky");
                navbar.classList.add("not-sticky")
              }
            }
            
        </script>
        

        <!-- Everything after the navbar starts here -->
        <div id="featured">
            <div>

                <!-- Top Featured Products Bar -->
                <div id="featured-top">
                    <div class="product">
                        <div class="image-holder">
                            <img src="../../resources/ProductImages/Your Logo T.png">
                            <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                        </div>
                        <div class="grid-container">
                            <p class="product-name">Your Logo T</p>
                            <p class="product-price">$20</p>
                        </div>
                    </div>
    
                    <div class="product">
                        <div class="image-holder">
                            <img src="../../resources/ProductImages/White Pants.png">
                            <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                        </div>
                        <div class="grid-container">
                            <p class="product-name">White Pants</p>
                            <p class="product-price">$50</p>
                        </div>
                    </div>
    
                    <div class="product">
                        <div class="image-holder">
                            <img src="../../resources/ProductImages/Beige Jacket.png">
                            <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                        </div>
                        <div class="grid-container">
                            <p class="product-name">Beige Jacket</p>
                            <p class="product-price">$50</p>
                        </div>
                    </div>
    
                    <div class="product">
                        <div class="image-holder">
                            <img src="../../resources/ProductImages/Leather Jacket.png">
                            <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                        </div>
                        <div class="grid-container">
                            <p class="product-name">Leather Jacket</p>
                            <p class="product-price">$100</p>
                        </div>
                    </div>
                </div>

                <div id="divider-container">
                    <div></div>
                    <button onclick="window.location.href='../BrowseProducts/BrowseProducts.php';">Shop All Products</button>
                </div>
    
                <h2 class="featured-shirts">Featured Shirts</h2>


                <!-- Table needed to ensure columns are equal-height -->
                <table>

                    <!-- Generic Black T -->
                    <tr>
                        <td rowspan="4" style="padding-left: 0;">
                            <div class="product" id="generic-black-t">
                                <div class="image-holder">
                                    <img src="../../resources/ProductImages/Generic Black T.png">
                                    <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                                </div>
                                <div class="grid-container">
                                    <p class="product-name">Generic Black T</p>
                                    <p class="product-price">$15</p>
                                </div>
                            </div>
                        </td>
                    </tr>
                    
                    <!-- Free Mockup T -->
                    <tr>
                        <td id="free-mockup-t">
                            <div class="product">
                                <div class="image-holder">
                                    <img src="../../resources/ProductImages/Free Mockup T.png">
                                    <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                                </div>
                                <div class="grid-container">
                                    <p class="product-name">Free Mockup T</p>
                                    <p class="product-price">$15</p>
                                </div>
                            </div>
                            
                        </td>
                    </tr>

                    <!-- Generic Colours Line Divider -->
                    <tr>
                        <td style="padding-right: 0;">
                            <div id="generic-colours-divider">
                                <h2>Generic Colours Line</h2>
                                <div></div>
                                <button onclick="window.location.href='../BrowseProducts/BrowseProducts.php';">View More</button>
                            </div>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding-right: 0;">
                            <div id="generic-colours-container">
                                
                                <!-- Generic White T -->
                                <div class="product">
                                    <div class="image-holder">
                                        <img src="../../resources/ProductImages/360x295/Generic White T.png">
                                        <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                                    </div>
                                    <div class="grid-container">
                                        <p class="product-name">Generic White T</p>
                                        <p class="product-price">$15</p>
                                    </div>
                                </div>
                                
                                <!-- Generic Blue T -->
                                <div class="product">
                                    <div class="image-holder">
                                        <img src="../../resources/ProductImages/360x295/Generic Blue T.png">
                                        <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                                    </div>
                                    <div class="grid-container">
                                        <p class="product-name">Generic Blue T</p>
                                        <p class="product-price">$15</p>
                                    </div>
                                </div>

                            </div>
                        </div>
                        </td>
                    </tr>

                </table>

            </div>
        </div>
        <footer-component></footer-component>
    </body>
</html>