<?php 
    session_start();
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="BrowseProducts.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>
    <body>

        <!-- Ensure the database exists. Create it if it doesn't exist -->
        <?php
            require_once(__DIR__.'/../Backend/create_database.php');
            createDatabase();
        ?>

        <navbar-component id="navbar" style="position: sticky; top: 0; z-index: 1;"> </navbar-component>
        
        <div id="main-container">
            <div class="grid-main">
                
                <div class="filters">

                    <!-- Collapsible functionality inspired by (but NOT directly copied from) https://www.w3schools.com/howto/howto_js_collapsible.asp -->
                    
                    <!-- Sort (Collapsible section) -->
                    <!-- <button class="collapsible">
                        <p style="grid-column: 1;">Sort</p>
                        <div>
                            <i style="grid-column: 2;" class="chevron"></i>
                        </div>
                    </button>
                    <div class="content">
                        <p class="sort-type">Price: Ascending</p>
                        <p class="sort-type">Price: Descending</p>
                    </div> -->

                    <!-- Type (Collapsible section) -->
                    <button class="collapsible">
                        <p style="grid-column: 1;">Type</p>
                        <div>
                            <i style="grid-column: 2;" class="chevron"></i>
                        </div>
                    </button>
                    <div class="content">
                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>Shirts</p>
                        </label>

                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>Pants</p>
                        </label>

                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>Shoes</p>
                        </label>
                    </div>

                    <!-- Colour (Collapsible section) -->
                    <button class="collapsible">
                        <p style="grid-column: 1;">Colour</p>
                        <div>
                            <i style="grid-column: 2;" class="chevron"></i>
                        </div>
                    </button>
                    <div class="content">
                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>Blue</p>
                        </label>

                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>White</p>
                        </label>

                        <label class="container-checkbox">
                            <input type="checkbox">
                            <p>Black</p>
                        </label>
                    </div>

                    <!-- JavaScript used for managing the collaspible aspect of the filters bar -->
                    <script>

                        let collapsibleElements = document.getElementsByClassName("collapsible");
                        let i;
                        
                        // Add an anonymous function to each collapsible element. This gets called everytime the element is clicked
                        for (i = 0; i < collapsibleElements.length; i++) {
                            collapsibleElements[i].addEventListener("click", function() {

                                let chevronElement = this.lastElementChild.lastElementChild;

                                // Flip the chevron in the button when pressed, by adding/removing the .up class
                                if (chevronElement.classList.contains("up")) {
                                    chevronElement.classList.remove("up");
                                } else {
                                    chevronElement.classList.add("up");
                                }

                                // Find the content (we know it's always right after the collapsible element)
                                let contentElement = this.nextElementSibling;

                                // Toggle the max height of the content pane between null and scrollHeight
                                if (contentElement.style.maxHeight) {
                                    contentElement.style.maxHeight = null;
                                } else {
                                    contentElement.style.maxHeight = contentElement.scrollHeight + "px";
                                } 

                          });
                        }
                        
                    </script>

                </div>
                

                <div class="products">
                    <div class="products-header">
                        <h1>Products</h1>
                        <div class="select-wrapper">
                            <select name="sort" id="sort">
                                <option value="featured">Featured</option>
                                <option value="price-ascending">Price: Ascending</option>
                                <option value="price-descending">Price: Descending</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex-products">

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic White T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic White T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic White T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic White T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic White T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic White T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic White T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic White T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                        <div class="flex-product-item">
                            <div class="image-holder">
                                <img src="../../resources/ProductImages/480x340/Generic Blue T.png">
                                <button class="hide-till-hover" onclick="window.location.href='../SingleProduct/SingleProduct.php';">View Details</button>
                            </div>
                            <div class="grid-container">
                                <p class="product-name">Generic Blue T</p>
                                <p class="product-price">$15</p>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <footer-component></footer-component>
    </body>
</html>