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

        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
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
                                    <button class="add-to-cart">Add to Cart</button>
                                </div>
                                <div class="added-to-cart"><!-- The content of this div is managed by JS --></div>
                            </div>

                        </div>

                    </div> 

                    <h4>Description</h4>

                    <?php
                        echo "<p>$product_desc</p>";
                    ?> 

                    <?php 

                    // Get the list of all reviews for this product from the backend
                    require_once(__DIR__.'/../Backend/Reviews/review_functions.php');
                    $reviews = selectReviews($product_id);
                    $review_cumulative_rating = 0;

                    if ($reviews->num_rows > 0) {
                        foreach ($reviews as $review) {
                            $review_cumulative_rating += (int) $review["Rating"];
                        }

                        // Average is calculated on a 0-10 scale to account for displaying half-stars
                        $review_average_rating = round(($review_cumulative_rating / $reviews->num_rows) * 2);
                    } else {
                        $review_average_rating = 0;
                    }
                    

                    ?>

                    <div class="reviews-headerline">
                        <div>
                            <h4>Reviews</h4>
                            <div style="font-size: 16px;">
                                <?php
                                for ($i = 0; $i < $review_average_rating - 1; $i = $i + 2) {
                                    echo "<span class='fa fa-sharp fa-star'></span> ";
                                }
                                if ($review_average_rating % 2 == 1) {
                                    echo "<span class='fa fa-star-half-full'></span> ";
                                }
                                for ($i = $review_average_rating; $i < 9; $i = $i + 2) {
                                    echo "<span class='fa fa-star-o'></span> ";
                                }
                                
                                echo "(" . $reviews->num_rows . ")";
                                ?>
                            </div>
                        </div>
                        
                        <button class="add-review">Add Review</button>
                    </div>
                    
                    <div class="my-review"> <!-- The content of this div is managed by JS --></div>

                    <?php 

                    if ($reviews->num_rows > 0) {
                        foreach ($reviews as $review) {

                            $reviewer_username = $review["Username"];
                            $review_rating = (int) $review["Rating"];
                            $review_time = strtotime($review["CreatedAt"]);
                            $review_date = date("F j, Y", $review_time);
                            $review_message = $review["ReviewMessage"];
                            $your_review = false;

                            if (isset($_SESSION["userid"])) {
                                if ($review["UserID"] == $_SESSION["userid"]) {
                                    $your_review = true;
                                }
                            }
                            

                            // Review
                            echo "<div class='review'>";
                            echo "    <div class='review-title-line'>";
                            if ($your_review) {
                                echo "        <div style='display: flex;flex-direction: row; flex-wrap: nowrap; gap: 6px;'>";
                                echo "            <h5>$reviewer_username</h5>   <h5 style='color: darkgrey'>(you)</h5>";
                                echo "        </div>";
                            } else {
                                echo "        <h5>$reviewer_username</h5>";
                            }
                            echo "        <div class='display-rating'>";

                            // Display the rating correctly
                            for ($i = 0; $i < $review_rating; $i++) {
                                echo "<span class='fa fa-sharp fa-star checked'></span> ";
                            }
                            for ($i = $review_rating; $i < 5; $i++) {
                                echo "<span class='fa fa-star-o'></span> ";
                            }


                            echo "        </div>";
                            echo "    </div>";
                            echo "    <div class='review-title-line'>";
                            echo "        <h6>Verified Purchase</h6>";
                            echo "        <h6 class='review-date'>$review_date</h6>";
                            echo "    </div>";
                            echo "    <p2>$review_message</p2>";
                            echo "</div>";

                        }

                    } else {
                        echo "This product has no reviews!";
                    } 
                                        
                    ?>

                </div> 
            </div>
        </div>
    </div>
    <footer-component></footer-component>
    <script src="SingleProduct.js" type="text/javascript"></script>
    </body>
</html>