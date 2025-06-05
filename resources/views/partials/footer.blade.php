<style>
    footer {
        font-family: 'Poppins', sans-serif;
        font-size: 14px;
        height: 250px;
        display: flex;
        justify-content: center;
        align-items: center;
        text-align: center;
    }

    .footer-links a {
        color: #fff;
        text-decoration: underline;
        margin: 0 10px;
    }

    .footer-links a:hover {
        text-decoration: none;
        color: #ffc107;
    }
</style>

<footer class="bg-success text-white">
    <div class="container">
        <h4 class="fw-semibold mb-3">CONTACT US</h4>

        <div class="mb-2">
            <p class="mb-1 fw-light">
                Mobile:
                <span class="fw-semibold">(0906) 407 6850</span> &amp;
                <span class="fw-semibold">(0917) 112 2694</span>
            </p>
            <p class="fw-light mb-0">
                Email address:
                <a href="mailto:admissions@feudiliman.edu.ph" class="text-warning fw-semibold text-decoration-none">
                    admissions@feudiliman.edu.ph
                </a>
            </p>
        </div>
        <br>

        <div class="footer-links mb-2">
            <a href="{{ route('terms-and-condition') }}">Terms & Conditions</a> |
            <a href="{{ route('privacy-policy') }}">Privacy Policy</a> |
            <a href="{{ route('cookies-use') }}">Cookie Use</a>
        </div>

        <p class="small text-light mb-0">&copy; {{ date('Y') }} ApplySmart – FEU Diliman. All rights reserved.</p>
    </div>
</footer>
