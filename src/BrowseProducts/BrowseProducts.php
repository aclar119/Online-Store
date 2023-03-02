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

                    <!-- Type (Collapsible section) -->
                    <button class="collapsible" id="collapsible-type">
                        <p style="grid-column: 1;">Type</p>
                        <div>
                            <i style="grid-column: 2;" class="chevron"></i>
                        </div>
                    </button>
                    <div class="content">

                        <?php 
                            require_once(__DIR__.'/../Backend/database_selector.php');
                            $categories = selectCategories();

                            foreach ($categories as $category) {
                                $display_name = $category["DisplayName"];
                                $internal_name = $category["InternalName"];

                                echo "<form method='POST'>";
                                echo "  <label class='container-checkbox category'>";
                                echo "      <input name='$internal_name' type='checkbox' id='$internal_name' />";
                                echo "      <p>$display_name</p>";
                                echo "  </label>";
                                echo "</form>";
                            }
                        ?>

                    </div>

                    <!-- Colour (Collapsible section) -->
                    <button class="collapsible" id="collapsible-colour">
                        <p style="grid-column: 1;">Colour</p>
                        <div>
                            <i style="grid-column: 2;" class="chevron"></i>
                        </div>
                    </button>
                    <div class="content">

                        <?php 
                            require_once(__DIR__.'/../Backend/database_selector.php');
                            $colours = selectColours();

                            foreach ($colours as $colour) {
                                $display_name = $colour["DisplayName"];
                                $internal_name = $colour["InternalName"];

                                echo "<form method='POST'>";
                                echo "  <label class='container-checkbox colour'>";
                                echo "      <input name='$internal_name' type='checkbox' id='$internal_name' />";
                                echo "      <p>$display_name</p>";
                                echo "  </label>";
                                echo "</form>";
                            }
                        ?>

                    </div>

                    <!-- JavaScript used for managing the collaspible aspect of the filters bar -->
                    <script>

                        let collapsibleElements = document.getElementsByClassName("collapsible");
                        let i;
                        
                        // Add an anonymous function to each collapsible element. This gets called everytime the element is clicked
                        for (i = 0; i < collapsibleElements.length; i++) {

                            // Re-expand any collapsibles that were previously expanded
                            if (localStorage.getItem(collapsibleElements[i].id) == null || localStorage.getItem(collapsibleElements[i].id) == 'false') {
                                collapsibleElements[i].nextElementSibling.style.maxHeight = collapsibleElements[i].nextElementSibling.scrollHeight + "px";
                                collapsibleElements[i].lastElementChild.lastElementChild.classList.add("up");
                            } else {
                                collapsibleElements[i].nextElementSibling.style.maxHeight = null;
                            }

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
                                    localStorage.setItem(this.id, true)
                                } else {
                                    contentElement.style.maxHeight = contentElement.scrollHeight + "px";
                                    localStorage.setItem(this.id, false)
                                } 

                          });
                        }

                        // For adding actual functionality to the checkboxes
                        document.addEventListener('DOMContentLoaded',()=>{
                            let chks=document.querySelectorAll('input[type="checkbox"]');
                                for(const chk of chks) {

                                    // Re-check any boxes that were previously checked
                                    if (localStorage.getItem(chk.name) == null || localStorage.getItem(chk.name) == 'false') {
                                        chk.checked =  false;
                                    } else {
                                        chk.checked =  true;
                                    }
                                    
                                    // Replace this later with AJAX for project part 3

                                    chk.addEventListener('click', e => {
                                        localStorage.setItem(chk.name, chk.checked);

                                        // Assemble the the parameter to pass to the GET query for categories
                                        let categories = document.getElementsByClassName("category");
                                        let categoriesString = "";

                                        for (const category of categories) {
                                            if (category.getElementsByTagName("input")[0].checked) {
                                                categoriesString = categoriesString + category.getElementsByTagName("input")[0].id + "_";
                                            }
                                        }

                                        if (categoriesString.length > 0) {categoriesString = categoriesString.substring(0,categoriesString.length-1);}

                                        // Assemble the the parameter to pass to the GET query for colours
                                        let colours = document.getElementsByClassName("colour");
                                        let coloursString = "";

                                        for (const colour of colours) {
                                            if (colour.getElementsByTagName("input")[0].checked) {
                                                coloursString = coloursString + colour.getElementsByTagName("input")[0].id + "_";
                                            }
                                        }

                                        if (coloursString.length > 0) {coloursString = coloursString.substring(0,coloursString.length-1);}

                                        let requestURL = "BrowseProducts.php?";
                                        let requestInitialLength = requestURL.length
                                        if (categoriesString.length > 0) {requestURL += "categories=" + categoriesString;}
                                        if (coloursString.length > 0) {
                                            if (requestURL.length > requestInitialLength) {requestURL += "&"}
                                            requestURL += "colours=" + coloursString;
                                        }

                                        console.log(requestURL);

                                        window.location.replace(requestURL);

                                });
                                }
                        });
                        
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

                        <?php 
                            require_once(__DIR__.'/../Backend/database_selector.php');

                            if(isset($_GET["categories"])) {
                                $categories = $_GET["categories"];
                            } else {
                                $categories = "";
                            }

                            if(isset($_GET["colours"])) {
                                $colours = $_GET["colours"];
                            } else {
                                $colours = "";
                            }

                            $products = selectProducts($categories, $colours);

                            foreach ($products as $product) {
                                $name = $product["Name"];
                                $price = $product["Price"];
                                $image_file = $product["ImageFile"];

                                echo "<div class='flex-product-item'>";
                                echo "  <div class='image-holder'>";
                                echo "      <img src='../../resources/ProductImages/480x340/$image_file'>";
                                echo "      <button class='hide-till-hover' onclick=\"window.location.href='../SingleProduct/SingleProduct.php';\">View Details</button>";    
                                echo "  </div>";        
                                echo "  <div class='grid-container'>";  
                                echo "      <p class='product-name'>$name</p>";  
                                echo "      <p class='product-price'>$$price</p>"; 
                                echo "  </div>";
                                echo "</div>"; 
                            }
                        ?>

                    </div>
                </div>
            </div>
        </div>
        <footer-component></footer-component>
    </body>
</html>