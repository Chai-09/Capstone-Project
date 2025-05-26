<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">

  {{-- Bootstrap --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  
  {{-- FontAwesome --}}
  <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>

  {{-- Bootstrap Bundle --}}
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  {{-- CSS and JS --}}
  @vite('resources/css/partials/sidebar.css')
  @vite('resources/js/partials/sidebar.js')
</head>
<body>

<div class="d-flex">
  <nav id="sidebar" class="expanded collapsed d-flex flex-column">
 
   <!-- Logo and User Info -->
<div id="logo-wrapper" class="text-center p-3 flex-column">
  <img src="{{ asset('images/partials/applysmart_logo.png') }}" alt="Logo" id="sidebar-logo" class="img-fluid mb-2">
</div>
<div class="user-labels">
  <span class="user-name text-label">{{ strtoupper(session('name')) }}</span><br>
  <span class="user-role text-label">{{ strtoupper(session('role')) }}</span>
</div>




    <!-- Sidebar Content -->
    <div id="sidebar-content" class="d-flex flex-column flex-grow-1 p-3 sidebar-links gap-2">

      <!-- Dynamic Navigation links based on Role -->
      @if(auth()->check() && auth()->user()->role == 'admission')
        <a href="{{ route('admissiondashboard') }}" class="nav-link" title="Dashboard">
          <div class="icon-wrapper"><i class="fa-solid fa-table-columns"></i></div>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('applicantlist') }}" class="nav-link" title="Applications">
          <div class="icon-wrapper"><i class="fa-regular fa-rectangle-list"></i></div>
          <span>Applications</span>
        </a>
        <a href="{{ route('admission.exam.schedule') }}" class="nav-link" title="Exam Scheduling">
          <div class="icon-wrapper"><i class="fa-solid fa-calendar-days"></i></div>
          <span>Exam Scheduling</span>
        </a>
        <a href="{{ route('admission.exam.result') }}" class="nav-link" title="Exam Results">
          <div class="icon-wrapper"><i class="fa-solid fa-certificate"></i></div>
          <span>Exam Results</span>
        </a>
        <a href="{{ route('admission.reports') }}" class="nav-link" title="Reports">
          <div class="icon-wrapper"><i class="fa-solid fa-square-poll-vertical"></i></div>
          <span>Reports</span>
        </a>

      @elseif(auth()->check() && auth()->user()->role == 'accounting')
        <a href="{{ route('accountingdashboard') }}" class="nav-link" title="Dashboard">
          <div class="icon-wrapper"><i class="fa-solid fa-table-columns"></i></div>
          <span>Dashboard</span>
        </a>
        <a href="{{ route('accounting.reports') }}" class="nav-link" title="Reports">
          <div class="icon-wrapper"><i class="fa-solid fa-square-poll-vertical"></i></div>
          <span>Reports</span>
        </a>

      @elseif(auth()->check() && auth()->user()->role == 'administrator')
        <a href="#" class="nav-link" title="Dashboard">
          <div class="icon-wrapper"><i class="fa-solid fa-table-columns"></i></div>
          <span>Dashboard</span>
        </a>
        <a href="#" class="nav-link" title="Applications">
          <div class="icon-wrapper"><i class="fa-regular fa-rectangle-list"></i></div>
          <span>Applications</span>
        </a>
        <a href="#" class="nav-link" title="Exam Scheduling"> 
          <div class="icon-wrapper"><i class="fa-solid fa-calendar-days"></i></div>
          <span>Exam Scheduling</span>
        </a>
        <a href="#" class="nav-link" title="Exam Results">
          <div class="icon-wrapper"><i class="fa-solid fa-certificate"></i></div>
          <span>Exam Results</span>
        </a>
        <a href="#" class="nav-link" title="Payment">
          <div class="icon-wrapper"><i class="fa-solid fa-money-bill"></i></div>
          <span>Payment</span>
        </a>
        <a href="#" class="nav-link" title="Reports">
          <div class="icon-wrapper"><i class="fa-solid fa-square-poll-vertical"></i></div>
          <span>Reports</span>
        </a>
      @endif

      <!-- Spacer to push Logout to bottom -->
      <div class="mt-auto d-flex flex-column gap-2">

      {{-- Sidebar Toggle Button --}}
      <button id="toggleSidebar" class="btn btn-light w-100">☰</button>

      {{-- Settings Link for Everyone --}}
      <a href="#" class="nav-link" title="Profile">
        <div class="icon-wrapper"><i class="fa-solid fa-user"></i></div>
          <span>Profile</span>
      </a>

        {{-- Logout Form Styled Like Nav Link --}}
        <form method="POST" action="{{ route('logout') }}" class="w-100" title="Logout">
          @csrf
          <button type="submit" class="nav-link logout-link d-flex align-items-center gap-2 w-100">
              <div class="icon-wrapper">
                  <i class="fa-solid fa-right-from-bracket"></i>
              </div>
              <span>​​​​​​  Logout</span>
          </button>
        </form>
      </div>

    </div>
  </nav>
</div>

<!-- Sidebar Toggle Script -->
<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>

</body>
</html>
