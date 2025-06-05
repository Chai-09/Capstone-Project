// Validation Function
window.showFormError = function (message) {
    const alertContainer = document.getElementById('alert-container');
    const alertWrapper = document.getElementById('alert-wrap');

    const existing = document.querySelector('.alert-box');
    if (existing) existing.remove();

    const errorBox = document.createElement('div');
    errorBox.classList.add('alert-box');
    errorBox.innerHTML = `
        <div class="alert-content">
            <div class="alert-message">
                <span><i class="fa-solid fa-circle-exclamation"></i> ${message}</span>
            </div>
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    `;
    alertWrapper.style.display = "block";
    alertContainer.style.display = "block";
    alertContainer.appendChild(errorBox);
};

// Validation
window.validateInputFormats = function () {
    const emailInputs = document.querySelectorAll('input[type="email"]')
    const middleInitialInputs = document.querySelectorAll('input[name*="middle_name"]');

    for (let mi of middleInitialInputs) {
        if (mi.value && mi.value.length > 3) {
            showFormError("Middle initial must be 1 or 2 characters only. (eg., A. or AP.)")
            mi.classList.add("border-danger");
            return false;
        } else {
            mi.classList.remove("border-danger");
        }
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    for (let email of emailInputs) {
        if (!email.value || !emailPattern.test(email.value)) { 
            showFormError('Please enter a valid email address (e.g., name@example.com).');
            email.classList.add("border-danger");
            return false;
        } else {
            email.classList.remove("border-danger");
        }
    }
    return true;
};


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("accountProfile");

    if (form) {
        form.addEventListener("submit", function (e) {
            if (!validateInputFormats()) {
                e.preventDefault(); // Prevent form submission if invalid
            }
        });
    }
});