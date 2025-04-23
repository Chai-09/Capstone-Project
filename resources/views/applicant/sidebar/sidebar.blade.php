<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Navbar</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    @vite('resources/css/applicants/sidebar.css')
</head>
<body>

    <!-- layouts/sidebar.blade.php -->
<div class="d-flex flex-column flex-shrink-0 text-white bg-dark" style="width: 450px; height: 93.5vh;">
    <ul class="nav nav-pills flex-column">
        <li class="nav-item">
            <span class="step-number">Step 1</span>
            <a href="{{ route('fillupforms') }}" class="nav-link text-white load-view">
                <i class="fa-brands fa-wpforms"></i> Fill-Up Forms
            </a>
            
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li>
            <span class="step-number">Step 2</span>
            <a href="" class="nav-link text-white">
                <i class="fa-solid fa-money-bill-wave"></i> Send Payment
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li>
            <span class="step-number">Step 3</span>
            <a href="" class="nav-link text-white">
                <i class="fa-solid fa-check-to-slot"></i> Payment Verification
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li>
            <span class="step-number">Step 4</span>
            <a href="" class="nav-link text-white">
                <i class="fa-solid fa-calendar-days"></i> Schedule entrance exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li>
            <span class="step-number">Step 5</span>
            <a href="" class="nav-link text-white">
                <i class="fa-solid fa-file-pen"></i> Take the exam
            </a>
        </li>
        <div class="double-line">
            <div class="line"></div>
            <div class="line"></div>
        </div>
        <li>
            <span class="step-number">Step 6</span>
            <a href="" class="nav-link text-white">
                <i class="fa-solid fa-square-poll-vertical"></i> Results
            </a>
        </li>
        <div class="double-line pb-5">
            <div class="line"></div>
            <div class="line"></div>
        </div>
    </ul>
</div>

    
    

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
