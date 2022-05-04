const password = document.getElementById("password");
const lowercase = document.getElementById("lowercase");
const uppercase = document.getElementById("uppercase");
const number = document.getElementById("number");
const specialChar = document.getElementById("specialChar");
const length = document.getElementById("length");
const validationCard = document.getElementById("passwordValidation");
let metRequirements = false;

// Display password validation card when the password input field is clicked
password.onfocus = function() {
    // Variable declarations
    const lowerCaseLetters = /[a-z]/g;
    const upperCaseLetters = /[A-Z]/g;
    const numbers = /[0-9]/g;
    const specialChars = /[!@#$%^&*()]/g;

    // Check if all password requirements have been met
    if (!metRequirements) {
        // Show the password validation card
        validationCard.classList.remove("d-none");
    } else {
        // Hide the password validation card
        validationCard.classList.add("d-none");
    }

    // Dynamically check password to see if it meets the requirements
    password.onkeyup = function() {
        // Validate lowercase letters
        if(password.value.match(lowerCaseLetters)) {
            lowercase.classList.add("d-none");
            metRequirements = true;
        } else {
            lowercase.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate capital letters
        if(password.value.match(upperCaseLetters)) {
            uppercase.classList.add("d-none");

            metRequirements = true;
        } else {
            uppercase.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate numbers
        if(password.value.match(numbers)) {
            number.classList.add("d-none");
            metRequirements = true;
        } else {
            number.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate special characters
        if(password.value.match(specialChars)) {
            specialChar.classList.add("d-none");
            metRequirements = true;
        } else {
            specialChar.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate length
        if(password.value.length >= 8) {
            length.classList.add("d-none");
            metRequirements = true;
        } else {
            length.classList.remove("d-none");
            metRequirements = false;
        }

        // Check if all password requirements have been met
        if (!metRequirements) {
            // Show the password validation card
            validationCard.classList.remove("d-none");
        } else {
        // Hide the password validation card
            validationCard.classList.add("d-none");
        }
    } // End of onkeyup()      
} // End of onfocus()