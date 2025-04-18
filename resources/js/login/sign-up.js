let signupWidgetId;

function initSignupRecaptcha() {
    const container = document.createElement('div');
    container.style.display = 'none';
    document.body.appendChild(container);

    signupWidgetId = grecaptcha.render(container, {
        sitekey: document.querySelector('meta[name="recaptcha-site-key"]').content,
        size: 'invisible',
        callback: onSignupCaptchaSuccess
    });
}

document.getElementById('signup-btn').addEventListener('click', function () {
    const form = document.getElementById('signup-form');
    const requiredFields = form.querySelectorAll('[required]');
    let allValid = true;

    requiredFields.forEach(field => {
        if (!field.value.trim()) {
            allValid = false;
            field.classList.add('border-danger');
        } else {
            field.classList.remove('border-danger');
        }
    });

    // Password match check
    const password = document.getElementById('password').value.trim();
    const repassword = document.getElementById('repassword').value.trim();
    if (password && repassword && password !== repassword) {
        allValid = false;
        alert('Passwords do not match.');
    }

    if (allValid) {
        grecaptcha.execute(signupWidgetId);
    }
});

function onSignupCaptchaSuccess(token) {
    const form = document.getElementById('signup-form');

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'g-recaptcha-response';
    input.value = token;
    form.appendChild(input);

    form.submit();
}