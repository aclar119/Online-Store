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

        <script>
            if ((!window.location.href.includes('?')) || window.location.href.includes('search')) {
                localStorage.clear();

                // Redirect to no search if search term is blank
                if (window.location.href.substr(-7) == "search=") {
                    window.location.replace("BrowseProducts.php");
                }
            }
        </script>

        <navbar-component page="Store" id="navbar" style="position: sticky; top: 0; z-index: 1;"> </navbar-component>
        
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
                                collapsibleElements[i].nextElementSibling.style.maxHeight = null;
                            } else {
                                collapsibleElements[i].nextElementSibling.style.maxHeight = collapsibleElements[i].nextElementSibling.scrollHeight + "px";
                                collapsibleElements[i].lastElementChild.lastElementChild.classList.add("up");
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
                                    localStorage.setItem(this.id, false)
                                } else {
                                    contentElement.style.maxHeight = contentElement.scrollHeight + "px";
                                    localStorage.setItem(this.id, true)
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

                                        // Assemble the categories parameter to pass to the GET query
                                        let categories = document.getElementsByClassName("category");
                                        let categoriesString = "";

                                        for (const category of categories) {
                                            if (category.getElementsByTagName("input")[0].checked) {
                                                categoriesString = categoriesString + category.getElementsByTagName("input")[0].id + "_";
                                            }
                                        }

                                        if (categoriesString.length > 0) {categoriesString = categoriesString.substring(0,categoriesString.length-1);}

                                        // Assemble the colours parameter to pass to the GET query
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

                                        if (window.location.href.includes('sort')) {
                                            url = window.location.href;
                                            if (url.includes('sort=featured')) {
                                                requestURL += '&sort=featured';
                                            } else if (url.includes('sort=priceascending')) {
                                                requestURL += '&sort=priceascending';
                                            } else if (url.includes('sort=pricedescending')) {
                                                requestURL += '&sort=pricedescending';
                                            }
                                        }

                                        console.log(requestURL);

                                        window.location.replace(requestURL);

                                    });
                                }
                        });

                        // Combining search with sort/filter isn't worth the effort so if there is a search
                        //  query, unselect all the 
                        const requestParameters = new URLSearchParams(window.location.search);
                        if(requestParameters.has("search")) {
                            
                        }
                        
                    </script>

                </div>
                
                <div class="products">
                    <div class="products-header">
                        <h1>Products</h1>

                        <div class="select-wrapper">
                            <select name="sort" id="sort">
                                <?php 
                                    if (isset($_GET["sort"])) {
                                        if ($_GET["sort"] == "featured") {
                                            echo "<option selected  value='featured'>Featured</option>";
                                            echo "<option value='priceascending'>Price: Ascending</option>";
                                            echo "<option value='pricedescending'>Price: Descending</option>";

                                        } elseif ($_GET["sort"] == "priceascending") {
                                            echo "<option value='featured'>Featured</option>";
                                            echo "<option selected  value='priceascending'>Price: Ascending</option>";
                                            echo "<option value='pricedescending'>Price: Descending</option>";

                                        } else {
                                            echo "<option value='featured'>Featured</option>";
                                            echo "<option value='priceascending'>Price: Ascending</option>";
                                            echo "<option selected value='pricedescending'>Price: Descending</option>";
                                        }
                                    } else {
                                        echo "<option value='featured'>Featured</option>";
                                        echo "<option value='priceascending'>Price: Ascending</option>";
                                        echo "<option value='pricedescending'>Price: Descending</option>";
                                    }
                                ?>
                            </select>
                        </div>

                        <script>
                            let selectSort = document.getElementById("sort");
                            selectSort.addEventListener("change", () => {
                                let url = window.location.href;

                                // Add special chars to URL iff needed
                                if (url.at(-1) != "?") {
                                    if (url.substr(-4) == ".php") {
                                        url = url + "?";
                                    } else if (url.includes('sort')) {
                                        if (url.includes('sort=featured')) {
                                            url = url.replace('sort=featured', "");
                                        } else if (url.includes('sort=priceascending')) {
                                            url = url.replace('sort=priceascending', "");
                                        } else if (url.includes('sort=pricedescending')) {
                                            url = url.replace('sort=pricedescending', "");
                                        }
                                        //console.log(url);
                                    }   
                                    else {
                                        url = url + "&";
                                    }
                                } 

                                // Add sort variable to end of the URL
                                url = url + "sort=" + selectSort.value;

                                window.location.replace(url);
                            });
                        </script>

                    </div>

                    <?php 
                        if (isset($_GET["search"])) {
                            $search = $_GET["search"];
                            echo "<div class='search-criteria'>";
                            echo "  <p>Displaying search results for <b>$search</b></p>";
                            echo "</div>";
                        }
                    ?>

                    <div class="flex-products">

                        <?php 
                            require_once(__DIR__.'/../Backend/database_selector.php');

                            $search = "";
                            $categories = "";
                            $colours = "";
                            $sort = "featured";
                            
                            // We decided to make search incompatible with sort/filter for simplicity
                            if (isset($_GET["search"])) {
                                $search = $_GET["search"];
                            } else {

                                if(isset($_GET["categories"])) {
                                    $categories = $_GET["categories"];
                                }
    
                                if(isset($_GET["colours"])) {
                                    $colours = $_GET["colours"];
                                }
                                
                            }

                            if(isset($_GET["sort"])) {
                                $sort = $_GET["sort"];
                            }

                            $products = selectProducts($search, $categories, $colours, $sort);

                            foreach ($products as $product) {
                                $name = $product["Name"];
                                $price = $product["Price"];
                                $image_file = $product["ImageFile"];
                                $product_id = $product["ID"];

                                echo "<div class='flex-product-item'>";
                                echo "  <div class='image-holder'>";
                                echo "      <img src='../../resources/ProductImages/480x340/$image_file'>";
                                echo "      <button class='hide-till-hover' onclick=\"window.location.href='../SingleProduct/SingleProduct.php?id=$product_id';\">View Details</button>";    
                                echo "  </div>";        
                                echo "  <div class='grid-container'>";  
                                echo "      <p class='product-name'>$name</p>";  
                                echo "      <p class='product-price'>$$price</p>"; 
                                echo "  </div>";
                                echo "</div>"; 

                            }

                            // If there are 2 products in the last row, add a blank one so that everything aligns properly
                            if ($products->num_rows % 3 == 2) {
                                echo "<div class='flex-product-item'>";
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