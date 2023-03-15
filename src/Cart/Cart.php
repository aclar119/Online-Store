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
        <link rel="stylesheet" href="Cart.css">
        <script src="../Components/navbar.js" type="text/javascript" defer></script>
        <script src="../Components/footer.js" type="text/javascript" defer></script>
    </head>

    <body>
        <navbar-component page="Cart" style="position: sticky; top: 0; z-index: 1;"> </navbar-component>

        <div class="main-outer-section">
            <div class="sub-outer-section">

                <!-- The left side of the page -->
                <div class="shopping-cart-section">

                    <h1 style>Your Shopping Cart</h1>
                    
                    <div class="items-section">

                        <?php 
                            
                            if(!isset($_SESSION["userid"])) {
                                echo "You must be logged in to view your cart";
                            } else {
                                require_once(__DIR__.'/../Backend/Cart/cart_functions.php');
                                $cart_items = selectCartItems($_SESSION["userid"]);

                                if ($cart_items->num_rows > 0) {
                                    foreach ($cart_items as $cart_item) {

                                        $item_quantity = $cart_item["Quantity"];
                                        $item_size = $cart_item["Size"];
                                        $item_price = $cart_item["Price"] * $item_quantity;

                                        $product_id = $cart_item["ID"];
                                        $product_name = $cart_item["Name"];
                                        $product_image = $cart_item["ImageFile"];

                                        // Cart Item
                                        echo "<!-- Cart Item -->";
                                        echo "<div class='cart-item' id='cart-product-$product_id-$item_size'>";
                                        echo "";
                                        echo "    <div class='items-picture'>";
                                        echo "        <img src='../../resources/ProductImages/360x360/$product_image'>";
                                        echo "    </div>";
                                        echo "";
                                        echo "    <div class='left-items-text'>";
                                        echo "        <div class='left-text1' onclick=\"window.location.href='../SingleProduct/SingleProduct.php?id=$product_id';\">$product_name ($item_size)</div>";
                                        echo "        <div class='left-text2'>In Stock</div>";
                                        echo "    </div>";
                                        echo "";
                                        echo "    <div class='quantity-section'>";
                                        echo "";
                                        echo "        <div class='quantity-text'>Quantity</div>";
                                        echo "";        
                                        echo "        <!-- Quantity Adjustment Button -->";
                                        echo "        <div class='quantity-number-container' id='cart-product-1'>";
                                        echo "            <button class='quantity-minus'>-</button>";
                                        echo "            <div class='quantity-number'>$item_quantity</div>";
                                        echo "            <button class='quantity-plus'>+</button>";
                                        echo "        </div>";
                                        echo "";
                                        echo "    </div>";
                                        echo "";
                                        echo "    <div class='price-section'>";
                                        echo "        <div class='item-price'>$$item_price</div>";
                                        echo "        <div class='x-remove'>x Remove</div>";
                                        echo "    </div>";
                                        echo "";
                                        echo "</div>";
                                    }

                                } else {
                                    echo "Your cart is empty!";
                                }
                            }
                        ?>

                        <!-- Cart Item -->
                        <!-- <div class="cart-item">
                
                            <div class="items-picture">
                                <img src='../../resources/ProductImages/360x360/Generic White T.png'>
                            </div>
                
                            <div class="left-items-text">
                                <div class="left-text1">Generic White Shirt</div>
                                <div class="left-text2">In Stock</div>
                            </div>
                
                            <div class="quantity-section">
                
                                <div class="quantity-text">Quantity</div> -->
                                
                                <!-- Quantity Adjustment Button -->
                                <!-- <div class="quantity-number-container" id="cart-product-1">
                                    <button class="quantity-minus">-</button>
                                    <div class="quantity-number">1</div>
                                    <button class="quantity-plus">+</button>
                                </div>

                            </div>
                
                            <div class="price-section">
                                <div class="single-price">15$</div>
                                <div class="x-remove">X Remove</div>
                            </div>
                    
                        </div> -->
                        
                    
                    </div>

                    <script>

                        // Event handling associated with the cart items

                        let cartItems = document.getElementsByClassName("cart-item");
                        let priceElements= [];

                        for (let i = 0; i < cartItems.length; i++) {
                            let cartItem = cartItems.item(i);
                            let numberContainer = cartItem.getElementsByClassName("quantity-number-container").item(0);
                            
                            // Gathering references to all the elements that we will be manipulating
                            let minusButton = numberContainer.getElementsByClassName("quantity-minus").item(0);
                            let plusButton = numberContainer.getElementsByClassName("quantity-plus").item(0);
                            let numberElement = numberContainer.getElementsByClassName("quantity-number").item(0);
                            let priceElement = cartItem.getElementsByClassName("item-price").item(0);
                            priceElements.push(priceElement);
                            let removeButton = cartItem.getElementsByClassName("x-remove").item(0);

                            // Gathering the information associated with the particular cart item
                            let cartItemID = cartItem.id;
                            let productID = Number(cartItemID.split('-')[cartItemID.split('-').length - 2]);
                            let size = cartItemID.split('-')[cartItemID.split('-').length - 1];
                            let singlePrice = Number(priceElement.innerText.substr(1)) / Number(numberElement.innerText);

                            minusButton.addEventListener("click", () => {
                                if (Number(numberElement.innerText) > 0) {
                                    // Send an asynchronous post call to decrease the quantity in the cart
                                    $.ajax({
                                        type : "POST",
                                        url  : "update_item_quantity.php",
                                        data : { 
                                            product : productID,
                                            quantityDifference : -1,
                                            size : size,
                                        },
                                        success: function (response) {
                                            console.log(response);
                                            if (response == "Success!") {
                                                // If the quantity change worked, we update the number and price in the UI
                                                numberElement.innerText = Number(numberElement.innerText) - 1;
                                                priceElement.innerText = "$" + (singlePrice * Number(numberElement.innerText));
                                                updateTotals();
                                            }
                                        }
                                    });
                                }
                            });

                            plusButton.addEventListener("click", () => {
                                // Send an asynchronous post call to increase the quantity in the cart
                                $.ajax({
                                    type : "POST",
                                    url  : "update_item_quantity.php",
                                    data : { 
                                        product : productID,
                                        quantityDifference : 1,
                                        size : size,
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        if (response == "Success!") {
                                            // If the quantity change worked, we update the number and price in the UI
                                            numberElement.innerText = Number(numberElement.innerText) + 1;
                                            priceElement.innerText = "$" + (singlePrice * Number(numberElement.innerText));
                                            updateTotals();
                                        }
                                    }
                                });
                            });

                            removeButton.addEventListener("click", () => {
                                // Send an asynchronous post call to delete the cart item
                                $.ajax({
                                    type : "POST",
                                    url  : "remove_from_cart.php",
                                    data : { 
                                        product : productID,
                                        size : size,
                                    },
                                    success: function (response) {
                                        console.log(response);
                                        if (response == "Success!") {
                                            // If the quantity change worked, we reload the page
                                            location.reload();
                                        }
                                    }
                                });
                            });

                        }

                    </script>
                    
                </div>
            
                <!-- The right side of the page -->
                <div class="final-price-section"> 
                    <div class="inner-price-section">
                        <div class="upper-price-section">

                            <div class="subtotal-section">
                                <div class="subtotal-label">Subtotal</div>
                                <div class="subtotal-price">$0</div>
                            </div>
                            <hr class="separator"/>
                            
                            <div class="fees-section">
                                <div class="subtotal-HST">13%HST</div>
                                <div class="HST-price">$0</div>
                            </div>
                            <div class="fees-section">
                                <div class="subtotal-shipping">Shipping</div>
                                <div class="shipping-price">$0</div>
                            </div>
                            <hr class="separator" />

                            <div class="total-section">
                                <div class="total-label">Total</div>
                                <div class="total-price">$0</div>
                            </div>

                        </div>
                        
                        <script>
                            const SHIPPING_PER_ITEM = 10;
                            const TAX_RATE = 0.13;

                            function updateTotals() {
                                let subtotal = 0;
                                let shipping = 0;
                                
                                for (let i = 0; i < priceElements.length; i++) {
                                    let priceElement = priceElements[i];
                                    subtotal += Number(priceElement.innerText.substr(1));
                                    shipping += SHIPPING_PER_ITEM;
                                }
                                let taxes = Number(subtotal * TAX_RATE);

                                document.getElementsByClassName("subtotal-price").item(0).innerText = "$" + subtotal.toFixed(2);
                                document.getElementsByClassName("HST-price").item(0).innerText = "$" + taxes.toFixed(2);
                                document.getElementsByClassName("shipping-price").item(0).innerText = "$" + shipping.toFixed(2);
                                document.getElementsByClassName("total-price").item(0).innerText = "$" + (subtotal + taxes + shipping).toFixed(2);

                            }

                            updateTotals();
                        </script>

                        <div class="lower-price-section">
                            <button class="buy-button">Checkout</button>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </body>
</html>