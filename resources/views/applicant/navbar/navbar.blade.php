<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/applicants/navbar.css')
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
        <a class="navbar-brand d-flex align-items-center" href="#">
            <img src="/images/applicants/feudiliman_logo.png" width="30" height="35" class="me-2" alt="">
            <span class="school-name">FEU Diliman</span>
        </a>
    
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarContent">
            <span class="navbar-toggler-icon"></span>
        </button>
    
        <div class="collapse navbar-collapse justify-content-between" id="navbarContent">
            <!-- LEFT SIDE: Session Name -->
            <ul class="navbar-nav">
                <li class="nav-item">
                    <span class="nav-link">Hi, {{ session('name') }}</span>
                </li>
            </ul>
    
            <!-- RIGHT SIDE: Logout -->
            <form method="GET" action="{{ route('logout') }}" class="d-flex">
                @csrf
                <button type="submit" class="btn btn-outline-danger">Logout</button>
            </form>
        </div>
    </nav>
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
