function validateRegistration() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.length < 3) {
        alert("Username must be at least 3 characters long.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }
    return true;
}

function validateLogin() {
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    if (username.length < 3) {
        alert("Username must be at least 3 characters long.");
        return false;
    }
    if (password.length < 6) {
        alert("Password must be at least 6 characters long.");
        return false;
    }
    return true;
}

// function validatePatientForm() {
//     let contactNumber = document.getElementById('contact_number').value;
//     let email = document.getElementById('email').value;
//     let regexPhone = /^\d{10,15}$/;
//     let regexEmail = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

//     if (!regexPhone.test(contactNumber)) {
//         alert('Please enter a valid contact number.');
//         return false;
//     }

//     if (!regexEmail.test(email)) {
//         alert('Please enter a valid email.');
//         return false;
//     }

//     return true;
// }
