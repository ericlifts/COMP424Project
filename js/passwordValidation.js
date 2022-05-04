const myInput = document.getElementById("password");
const letter = document.getElementById("letter");
const capital = document.getElementById("capital");
const number = document.getElementById("number");
const specialChar = document.getElementById("specialChar");
const length = document.getElementById("length");
const validationCard = document.getElementById("passwordValidation");
let metRequirements = false;

// When the user clicks on the password field, show the message box
myInput.onfocus = function() {
    // Variable declarations
    const upperCaseLetters = /[A-Z]/g;
    const lowerCaseLetters = /[a-z]/g;
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

    // When the user starts to type something inside the password field
    myInput.onkeyup = function() {
        // Validate lowercase letters
        if(myInput.value.match(lowerCaseLetters)) {
            letter.classList.add("d-none");
            metRequirements = true;
        } else {
            letter.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate capital letters
        if(myInput.value.match(upperCaseLetters)) {
            capital.classList.add("d-none");

            metRequirements = true;
        } else {
            capital.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate numbers
        if(myInput.value.match(numbers)) {
            number.classList.add("d-none");
            metRequirements = true;
        } else {
            number.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate special characters
        if(myInput.value.match(specialChars)) {
            specialChar.classList.add("d-none");
            metRequirements = true;
        } else {
            specialChar.classList.remove("d-none");
            metRequirements = false;
        }

        // Validate length
        if(myInput.value.length >= 8) {
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