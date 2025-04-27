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

    <!-- Logo Top -->
    <div id="logo-wrapper">
      <img src="{{ asset('images/partials/applysmart_logo.png') }}" alt="Logo" id="sidebar-logo">
    </div>

    <!-- Sidebar Content -->
    <div id="sidebar-content" class="d-flex flex-column flex-grow-1 p-3 sidebar-links gap-2">

      <!-- Navigation links -->
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-solid fa-table-columns"></i></div>
        <span>Dashboard</span>
      </a>
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-regular fa-rectangle-list"></i></div>
        <span>Applications</span>
      </a>
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-solid fa-calendar-days"></i></div>
        <span>Exam Scheduling</span>
      </a>
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-solid fa-certificate"></i></div>
        <span>Exam Results</span>
      </a>
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-solid fa-square-poll-vertical"></i></div>
        <span>Reports</span>
      </a>
      <a href="#" class="nav-link">
        <div class="icon-wrapper"><i class="fa-solid fa-gear"></i></div>
        <span>Settings</span>
      </a>

      <!-- Spacer to push Logout to bottom -->
      <div class="mt-auto d-flex flex-column gap-2">
        <button id="toggleSidebar" class="btn btn-light w-100">☰</button>
        <a href="#" class="nav-link logout-link">
          <div class="icon-wrapper"><i class="fa-solid fa-right-from-bracket"></i></div>
          <span>Logout</span>
        </a>
      </div>

    </div>

  </nav>

  <!-- Main Content -->
  <div id="content" class="flex-grow-1 p-4">
    <h1>ETO CONTENT</h1>
  </div>

</div>

<!-- Sidebar Toggle Script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script>
  $('#toggleSidebar').on('click', function () {
    $('#sidebar').toggleClass('collapsed expanded');
  });
</script>

</body>
</html>
