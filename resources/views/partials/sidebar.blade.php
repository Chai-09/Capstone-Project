<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    {{-- CSS --}}
    @vite('resources/css/partials/sidebar.css')
</head>
<body>

  <div class="d-flex">

    <!-- Sidebar -->
    <nav id="sidebar" class="expanded d-flex flex-column">
        
        <!-- Logo Top (White Background Separate) -->
        <div id="logo-wrapper">
            <img src="{{ asset('images/partials/applysmart_logo.png') }}" alt="Logo" id="sidebar-logo">
        </div>

        <!-- Sidebar Content (Green background) -->
        <div id="sidebar-content" class="d-flex flex-column flex-grow-1 p-3">

            <!-- Navigation links -->
            <ul class="nav flex-column flex-grow-1 gap-2">
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-table-columns"></i> <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-regular fa-rectangle-list"></i> <span>Applications</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-calendar-days"></i> <span>Exam Scheduling</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-certificate"></i> <span>Exam Results</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-square-poll-vertical"></i> <span>Reports</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="fa-solid fa-gear"></i> <span>Settings</span>
                    </a>
                </li>
            </ul>

            <!-- Burger and Logout at Bottom -->
            <div class="d-flex flex-column gap-2">
                <button id="toggleSidebar" class="btn btn-light w-100">☰</button>
                <a href="#" class="nav-link text-danger">
                    <i class="fa-solid fa-right-from-bracket"></i> <span>Logout</span>
                </a>
            </div>
        </div>
    </nav>

    <!-- Main Page Content -->
    <div id="content" class="flex-grow-1 p-4">
        <h1>ETO CONTENT</h1>
    </div>

</div>


<!-- Sidebar Toggle Script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
    $('#toggleSidebar').on('click', function () {
        $('#sidebar').toggleClass('collapsed');
    });
</script>

</body>
</html>
