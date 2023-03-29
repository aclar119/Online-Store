'use strict';

let usernameInput = document.getElementById("username");
let emailInput = document.getElementById("email");
let passwordInput = document.getElementById("password");
let userFeedback = document.getElementById("user-feedback");

function validateForm() {

    if (usernameInput.value.length > 80) {
        userFeedback.innerHTML=`<p style='text-align: center; color: red;'>Error: the provided username exceeds 80 characters<p>`;
        return false;
    }

    if (emailInput.value.length > 80) {
        userFeedback.innerHTML=`<p style='text-align: center; color: red;'>Error: the provided email exceeds 80 characters<p>`;
        return false;
    }

    let passwordCheck = /^(?=.*\d)(?=.*[!@#$%^&*()])(?=.*[a-z])(?=.*[A-Z]).{8,}$/;
    if (!passwordCheck.test(passwordInput.value)){
        alert("Error: The password needs to contain at least 8 characters, have one number, one lowercase, one uppercase and one special character");
        console.log("Error: The password needs to contain at least 8 characters, one uppercase and one special character")
        return false;
    }

    return true;
}


// Live Password Validation

function validatePassword() {
    let numberCheck = /[0-9]+/;
    let lowercaseCheck = /[a-z]+/;
    let uppercaseCheck = /[A-Z]+/;
    let specialCheck = /[!@#$%^&*()]+/;

    let feedback = "";

    if (passwordInput.value.length >= 8) {
        feedback = feedback + `
        <li style='color: green;'>
            <p>Minimum 8 characters &#10004;</p>
        </li>`;

    } else {
        feedback = feedback + `
        <li style='color: red;'>
            <p>Minimum 8 characters &#10008;</p>
        </li>`;
    }

    if (numberCheck.test(passwordInput.value)) {
        feedback = feedback + `
        <li style='color: green;'>
            <p>Contains a number &#10004;</p>
        </li>`;

    } else {
        feedback = feedback + `
        <li style='color: red;'>
            <p>Contains a number &#10008;</p>
        </li>`;
    }

    if (lowercaseCheck.test(passwordInput.value)) {
        feedback = feedback + `
        <li style='color: green;'>
            <p>Contains a lowercase letter &#10004;</p>
        </li>`;

    } else {
        feedback = feedback + `
        <li style='color: red;'>
            <p>Contains a lowercase letter &#10008;</p>
        </li>`;
    }

    if (uppercaseCheck.test(passwordInput.value)) {
        feedback = feedback + `
        <li style='color: green;'>
            <p>Contains a uppercase letter &#10004;</p>
        </li>`;

    } else {
        feedback = feedback + `
        <li style='color: red;'>
            <p>Contains a uppercase letter &#10008;</p>
        </li>`;
    }

    if (specialCheck.test(passwordInput.value)) {
        feedback = feedback + `
        <li style='color: green;'>
            <p>Contains a special character &#10004;</p>
        </li>`;

    } else {
        feedback = feedback + `
        <li style='color: red;'>
            <p>Contains a special character &#10008;</p>
        </li>`;
    }
    
    userFeedback.innerHTML=`<ul style="">${feedback}</ul>`;
}

passwordInput.addEventListener("input", () => {
    validatePassword();
});

passwordInput.addEventListener("focus", () => {
    validatePassword();
});

passwordInput.addEventListener("blur", () => {
    userFeedback.innerHTML=``;
});