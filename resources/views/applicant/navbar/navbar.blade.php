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

    <nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-2">
        <div class="container-fluid d-flex justify-content-between align-items-center">
    
            {{-- Left side: Logo + School name --}}
            <a class="navbar-brand d-flex align-items-center" href="#">
                <img src="/images/applicants/feudiliman_logo.png" width="30" height="35" class="me-2" alt="FEU Logo">
                <span class="school-name fw-semibold">FEU Diliman</span>
            </a>
    
            {{-- Right side: Session name + Logout --}}
            <div class="d-flex align-items-center gap-3">
                <span class="text-uppercase small text-secondary mb-0">
                    Hi, {{ session('name') }}
                </span>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
                </form>
            </div>
    
        </div>
    </nav>
    
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
