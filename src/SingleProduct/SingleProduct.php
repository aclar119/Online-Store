<?php 
    session_start();
?>

<!DOCTYPE html> 
<html>
    <head>
        <title>Online Store</title>
        <link rel="icon" type="image/x-icon" href="../../resources/Icons/Logo Square.png">
        <link rel="stylesheet" href="SingleProduct.css">
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
        
        <div class="outer-main">
            <div class="inner-main">

                <?php
                    $product_id = $_GET["id"];
                    require_once(__DIR__.'/../Backend/database_selector.php');
                    $product = selectProduct($product_id);

                    $product_name = $product["Name"];
                    $product_image = $product["ImageFile"];
                    $product_desc = $product["Description"];
                ?>

                <div class="left-main">
                    <h1>Product Details</h1>
                    <div class="image-holder">
                        <?php
                        echo "<img src='../../resources/ProductImages/Full Size/$product_image'>";
                        ?> 
                    </div>
                </div>

                <div class="right-main">
                    <div class="user-selection" >
                    
                    <?php
                        echo "<h2>$product_name</h2>";
                    ?> 

                    <p>Available XS-XL</p>
                    <div class="price-and-stock" > 
                        <p class="price">$15</p> 
                        <p class="stock">In Stock</p> 
                    </div>           
                    
                    <select name="selectSize" class="select-size">
                        <option disabled selected>Select size</option>
                        <option value="S">S</option>
                        <option value="M">M</option>
                        <option value="L">L</option>
                        <option value="XL">XL</option>
                    </select>

                <div class="quantity-container" >

                    <h3 class="h3-quantity">Quantity</h3>

                    <div class="quantity-bottom-section">
                        <div>
                            <div class="quantity-number-container">
                                <button class="quantity-minus">-</button>
                                <div class="quantity-number">1</div>
                                <button class="quantity-plus">+</button>
                            </div>
                        
                            <button class="add-to-cart">Add to Cart</button>
                        </div>
                        <div class="added-to-cart"> 1 item added to cart </div>
                    </div>
                </div>

                    </div>  
                    <h4>Description</h4>

                    <?php
                        echo "<p2>$product_desc</p2>";
                    ?> 

                    <h4>Reviews</h4>
                    
                    <div class="review"> 
                        <div>
                            <h5>John Cena</h5> 
                            <div class="rating">
                                &#9733; &#9733; &#9733; &#9733; &#9734;
                            </div>
                        </div>
                        <p2>Such an excellent product! Highly recommended to anyone wanting to get this t-shirt!</p2>
                    </div>

                </div> 
            </div>
        </div>
    </div>



    
        <footer-component></footer-component>
    </body>
</html>