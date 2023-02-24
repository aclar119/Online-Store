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

        <!-- Ensure the database exists. Create it if it doesn't exist -->
        <?php
            require_once(__DIR__.'/../Backend/create_database.php');
            createDatabase();
        ?>

        <navbar-component> </navbar-component>
    
        <div class="main-outer-section">
            <div class="sub-outer-section"> 
              <div class="shopping-cart-section">
          
                <h1 style>Your Shopping Cart</h1>
          
                <div class="items-section">
          
                  <div class="items-picture"></div>
          
                  <div class="left-items-text">
                    <div class="left-text1">Generic White Shirt</div>
                    <div class="left-text2">In Stock</div>
                  </div>
          
                  <div class="quantity-section">
          
                    <div class="quantity-text">Quantity</div>
          
                    <div class="quantity-number-container">
                      <button class="quantity-minus">-</button>
                      <div class="quantity-number">1</div>
                      <button class="quantity-plus">+</button>
                    </div>
          
                  </div>
          
                  <div class="price-section">
                    <div class="single-price">15$</div>
                    <div class="X-Remove">X Remove</div>
                  </div>
          
                </div>
                
                <div class="items-section">
          
                    <div class="items-picture2"></div>
            
                    <div class="left-items-text">
                      <div class="left-text1">Generic Blue Shirt</div>
                      <div class="left-text2">In Stock</div>
                    </div>
            
                    <div class="quantity-section">
            
                      <div class="quantity-text">Quantity</div>
            
                      <div class="quantity-number-container">
                        <button class="quantity-minus">-</button>
                        <div class="quantity-number">3</div>
                        <button class="quantity-plus">+</button>
                      </div>
            
                    </div>
            
                    <div class="price-section">
                      <div class="single-price">45$</div>
                      <div class="X-Remove">X Remove</div>
                    </div>
            
                </div>   

            

              </div>

              <div class="final-price-section"> 
                <div class="inner-price-section">
                    <div class="subtotal-section">
                        <div class="subtotal-label">Subtotal</div>
                        <div class="subtotal-price">$60</div>
                      </div>
                      <hr class="separator"/>
                    
                      <div class="subtotal-section">
                        <div class="subtotal-HST">13%HST</div>
                        <div class="HST-price">$7.80</div>
                      </div>
                      <div class="fees-section">
                        <div class="subtotal-shipping">Shipping</div>
                        <div class="shipping-price">$10</div>
                      </div>
                      <hr class="separator" />

                      <div class="total-section">
                        <div class="total-label">Total</div>
                        <div class="total-price">$77.80</div>
                      </div>

                      <button class="buy-button">Buy</button>

              </div>
              </div>

            </div>
          </div>
          
     
        <footer-component></footer-component>
   </body>
</html>