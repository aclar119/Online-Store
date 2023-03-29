'use strict';

const pageParams = new URLSearchParams(window.location.href.split('?')[1]);
let productID = pageParams.get("id");

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


// Adding items to the cart

let btnAddToCart = document.getElementsByClassName("add-to-cart").item(0);
let selectSize = document.getElementsByClassName("select-size").item(0);


btnAddToCart.addEventListener("click", () => {
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


// Managing adding a review 
let btnAddReview = document.getElementsByClassName("add-review").item(0);
let divMyReview = document.getElementsByClassName("my-review").item(0);
let username = false;
let orderedProduct = false;
let alreadyReviewed = false;
let reviewError = null;

// Get the username so that it can be displayed at the top of the review box
let xhttpGetUsername = new XMLHttpRequest();
xhttpGetUsername.onload = function () {
    if (xhttpGetUsername.response != "Not logged in!") {
        username = xhttpGetUsername.response;
    }
};
xhttpGetUsername.open("GET", "get_username.php");
xhttpGetUsername.send();

console.log(`Product ID: ${productID}`);

// Get whether the current user has ever ordered the current product
let xhttpGetHasOrdered = new XMLHttpRequest();
xhttpGetHasOrdered.onload = function () {
    console.log("Ordered response: " + xhttpGetHasOrdered.response);
    if (xhttpGetHasOrdered.response == "true") {
        orderedProduct = true;

        // Get whether the current user has already reviewed the current product
        let xhttpGetHasReviewed = new XMLHttpRequest();
        xhttpGetHasReviewed.onload = function () {
            console.log("Reviewed response: " + xhttpGetHasReviewed.response);
            if (xhttpGetHasReviewed.response == "true") {
                alreadyReviewed = true;
            } else if (xhttpGetHasReviewed.response == "false") {
                alreadyReviewed = false;
            } else {
                reviewError = xhttpGetHasReviewed.response;
            }
        };
        xhttpGetHasReviewed.open("GET", `get_has_reviewed.php?productid=${productID}`);
        xhttpGetHasReviewed.send();

    } else if (xhttpGetHasOrdered.response == "false") {
        orderedProduct = false;
    } else {
        reviewError = xhttpGetHasOrdered.response;
    }
};
xhttpGetHasOrdered.open("GET", `get_has_ordered.php?productid=${productID}`);
xhttpGetHasOrdered.send();


// Add a review button behaviour
btnAddReview.addEventListener("click", () => {

    if (!username) {
        divMyReview.innerHTML = `
            <div class='no-review-message'>
                You must be logged in to leave a review!
            </div>
        `;

    } else if (reviewError) {
        divMyReview.innerHTML = `
            <div class='no-review-message'>
                ${reviewError}
            </div>
        `;

    } else if (!orderedProduct) {
        divMyReview.innerHTML = `
            <div class='no-review-message'>
                You can't review an item that you have never ordered!
            </div>
        `;

    } else if (alreadyReviewed) {
        divMyReview.innerHTML = `
            <div class='no-review-message'>
                You have already reviewed this item!
            </div>
        `;

    } else {
        btnAddReview.style.visibility="hidden";

        divMyReview.innerHTML = `
            <div class='review-topline'>
                <h5>${username}</h5> 
                <div class='select-rating'>
                    <div class='star'><span class='fa fa-star-o'></span></div>
                    <div class='star'><span class='fa fa-star-o'></span></div>
                    <div class='star'><span class='fa fa-star-o'></span></div>
                    <div class='star'><span class='fa fa-star-o'></span></div>
                    <div class='star'><span class='fa fa-star-o'></span></div>
                </div>
            </div>
            <textarea id='my-review-text' name='my-review-text'></textarea>
            <div class='review-bottomline'>
                <div class='review-message'></div>
                <div class='review-buttons'>
                    <button class='cancel-review'>Cancel</button>
                    <button class='submit-review'>Submit</button>
                </div>
            </div>
        `;

        let ratingStars = document.getElementsByClassName("star");
        let txtMyReview = document.getElementById("my-review-text");
        let divReviewMessage = document.getElementsByClassName("review-message").item(0);
        let btnCancelReview = document.getElementsByClassName("cancel-review").item(0);
        let btnSubmitReview = document.getElementsByClassName("submit-review").item(0);
        let selectedRating = 0;

        for (let i = 0; i < ratingStars.length; i++) {
            let ratingStar = ratingStars.item(i);
            ratingStar.addEventListener("click", () => {
                selectedRating = i+1;
                for (let j = 0; j < selectedRating; j++) {
                    ratingStars.item(j).innerHTML = "<span class='fa fa-sharp fa-star'></span>";
                }
                for (let j = selectedRating; j < ratingStars.length; j++) {
                    ratingStars.item(j).innerHTML = "<span class='fa fa-star-o'></span>";
                }
                console.log("Rating updated to: " + selectedRating);
            });
        }

        btnCancelReview.addEventListener("click", () => {
            btnAddReview.style.visibility="visible";
            divMyReview.innerHTML = "";
            divMyReview.classList.remove("my-review-expanded");
        });

        btnSubmitReview.addEventListener("click", () => {
            if (selectedRating == 0) {
                divReviewMessage.innerText = "Please select a rating!";
            } else if (txtMyReview.value.length == 0) {
                divReviewMessage.innerText = "Please write a review!";
            } else {
                console.log("Review submit reached");

                // Post request to actually create/add the review
                let xhttpAddReview = new XMLHttpRequest();
                xhttpAddReview.onload = function () {
                    console.log("Add Review response: " + xhttpAddReview.response);
                    if (xhttpAddReview.response == "Success!") {
                        // Review successfully added. Reload page
                        location.reload();
                    } else {
                        divReviewMessage.innerText = xhttpAddReview.response;
                    }
                };
                xhttpAddReview.open("POST", `add_review_handler.php`);
                xhttpAddReview.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhttpAddReview.send(`productid=${productID}&rating=${selectedRating}&message=${txtMyReview.value}`);

            }
        });
    }

    divMyReview.classList.add("my-review-expanded");

});