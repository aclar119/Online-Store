<!-- Ensure the database exists. Create it if it doesn't exist -->
<?php 
    require_once(__DIR__.'/../Backend/create_database.php');
    createDatabase();
    session_start();
?>

<!-- Including the AJAX libraries so that we can make POST requests from JavaScript -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>

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

        <navbar-component style="position: sticky; top: 0; z-index: 1;"> </navbar-component>
        
        <div class="outer-main">
            <div class="inner-main">

                <?php
                    $product_id = $_GET["id"];
                    require_once(__DIR__.'/../Backend/database_selector.php');
                    $product = selectProduct($product_id);

                    $product_name = $product["Name"];
                    $product_image = $product["ImageFile"];
                    $product_desc = $product["Description"];
                    $product_price = $product["Price"];
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

                    <p>Available S-XL</p>
                    <div class="price-and-stock" > 
                        <?php
                        echo "<p class='price'>$$product_price</p>";
                        ?>  
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

                            <script>

                                // Make the increment and decrement buttons work for the item quantity

                                let numberContainers = document.getElementsByClassName("quantity-number-container");
                                let numberContainer = numberContainers.item(0);
                                
                                let minusButton = numberContainer.getElementsByClassName("quantity-minus").item(0);
                                let plusButton = numberContainer.getElementsByClassName("quantity-plus").item(0);
                                let numberElement = numberContainer.getElementsByClassName("quantity-number").item(0);

                                minusButton.addEventListener("click", () => {
                                    if (Number(numberElement.innerText) > 0) {
                                        numberElement.innerText = Number(numberElement.innerText) - 1;
                                    }
                                });

                                plusButton.addEventListener("click", () => {
                                    numberElement.innerText = Number(numberElement.innerText) + 1;
                                });

                            </script>

                            <button class="add-to-cart">Add to Cart</button>

                            <script>
                                let btnAddToCart = document.getElementsByClassName("add-to-cart").item(0);
                                let selectSize = document.getElementsByClassName("select-size").item(0);
                                

                                btnAddToCart.addEventListener("click", () => {
                                    const pageParams = new URLSearchParams(window.location.href.split('?')[1]);
                                    let productID = pageParams.get("id");
                                    let quantity = Number(numberElement.innerText);

                                    if (selectSize.value == "Select size") {
                                        // Show prompt to select size
                                        let userMessage = document.getElementsByClassName("added-to-cart").item(0);
                                        userMessage.innerText = "You must select a size!";
                                    } else {
                                        let size = selectSize.value;
                                        
                                        // clear select size prompt if it's there
                                        let userMessage = document.getElementsByClassName("added-to-cart").item(0);
                                        userMessage.innerText = ""; 

                                        // Send an asynchronous post call to the server
                                        $.ajax({
                                            type : "POST",
                                            url  : "add_to_cart_handler.php",
                                            data : { 
                                                product : productID, 
                                                quantity : quantity,
                                                size : size,
                                            },
                                            success: function (response) {
                                                console.log(response);
                                                if (response == "Success!") {
                                                    userMessage.innerText = quantity + " items added to cart"; 
                                                } else {
                                                    userMessage.innerText = response; 
                                                }
                                            }
                                        });
                                    }
                                    
                                    
                                });
                            </script>

                        </div>
                        <div class="added-to-cart">
                            <!-- The content of this div is managed by JS -->
                        </div>
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