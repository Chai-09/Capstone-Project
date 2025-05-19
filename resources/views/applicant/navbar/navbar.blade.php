<nav class="navbar navbar-expand-lg fixed-top px-4 py-2">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/images/applicants/feudiliman_logo.png" width="30" height="35" class="me-2" alt="FEU Logo">
            <span class="school-name">FEU Diliman</span>
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarCollapse">
            <div class="d-lg-none w-100">
                @include('applicant.sidebar.sidebar', ['currentStep' => $currentStep ?? 1])
            </div>

            <div class="ms-auto d-flex align-items-center gap-3">
                <span class="text-uppercase small text-white mb-0">
                    {{ session('name') }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="logout btn btn-sm fw-light">Logout</button>
                </form>
            </div>
        </div>
    </div>
</nav>