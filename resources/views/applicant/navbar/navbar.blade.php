<nav class="navbar navbar-expand-lg navbar-light bg-light px-4 py-2">
    <div class="container-fluid">
      {{-- Logo --}}
      <a class="navbar-brand d-flex align-items-center" href="#">
          <img src="/images/applicants/feudiliman_logo.png" width="30" height="35" class="me-2" alt="FEU Logo">
          <span class="school-name fw-semibold">FEU Diliman</span>
      </a>
  
      {{-- Hamburger Button --}}
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarCollapse">
          <span class="navbar-toggler-icon"></span>
      </button>
  
      <div class="collapse navbar-collapse" id="navbarCollapse">
  
          {{-- 🔥 Sidebar links for mobile only --}}
          <div class="d-lg-none w-100">
              <ul class="nav flex-column">
                  <li class="nav-item">
                      <span class="step-number">Step 1</span>
                      <a href="{{ route('fillupforms') }}" class="nav-link text-dark">
                          <i class="fa-brands fa-wpforms"></i> Fill-Up Forms
                      </a>
                  </li>
                  <li class="nav-item">
                      <span class="step-number">Step 2</span>
                      <a href="#" class="nav-link text-dark">
                          <i class="fa-solid fa-money-bill-wave"></i> Send Payment
                      </a>
                  </li>
                  <li class="nav-item">
                      <span class="step-number">Step 3</span>
                      <a href="#" class="nav-link text-dark">
                          <i class="fa-solid fa-check-to-slot"></i> Payment Verification
                      </a>
                  </li>
                  <li class="nav-item">
                      <span class="step-number">Step 4</span>
                      <a href="#" class="nav-link text-dark">
                          <i class="fa-solid fa-calendar-days"></i> Schedule entrance exam
                      </a>
                  </li>
                  <li class="nav-item">
                      <span class="step-number">Step 5</span>
                      <a href="#" class="nav-link text-dark">
                          <i class="fa-solid fa-file-pen"></i> Take the exam
                      </a>
                  </li>
                  <li class="nav-item">
                      <span class="step-number">Step 6</span>
                      <a href="#" class="nav-link text-dark">
                          <i class="fa-solid fa-square-poll-vertical"></i> Results
                      </a>
                  </li>
              </ul>
          </div>
  
          {{-- Right side: user + logout --}}
          <div class="ms-auto d-flex align-items-center gap-3">
              <span class="text-uppercase small text-secondary mb-0">
                  Hi, {{ session('name') }}
              </span>
              <form method="POST" action="{{ route('logout') }}">
                  @csrf
                  <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
              </form>
          </div>
  
      </div>
    </div>
  </nav>
  