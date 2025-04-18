let widgetId;

function initRecaptcha() {
    const container = document.createElement('div');
    container.style.display = 'none';
    document.body.appendChild(container);

    widgetId = grecaptcha.render(container, {
        sitekey: "{{ config('services.recaptcha.site_key') }}",
        size: "invisible",
        callback: onSubmitRecaptcha
    });
}

document.getElementById('login-btn').addEventListener('click', function () {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    // Trigger blade-based error if fields are empty
    if (!email || !password) {
        const errorBox = document.createElement('div');
        errorBox.classList.add('alert-box');
        errorBox.innerHTML = `<p><i class="fa-solid fa-circle-exclamation"></i> Please fill in all required fields.</p>`;

        // Remove existing errors before appending new
        const existing = document.querySelector('.alert-box');
        if (existing) existing.remove();

        const form = document.getElementById('login-form');
        form.insertBefore(errorBox, form.children[2]); // insert after img + csrf + errors
        return;
    }

    grecaptcha.execute(widgetId);
});

function onSubmitRecaptcha(token) {
    const form = document.getElementById('login-form');

    const input = document.createElement('input');
    input.type = 'hidden';
    input.name = 'g-recaptcha-response';
    input.value = token;
    form.appendChild(input);

    form.submit();
}