<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>ApplySmart | Admissions</title>
</head>
<body>

    <div class="d-flex">
        {{-- SIDEBAR --}}
        @include('partials.sidebar')

        {{-- Main Content --}}
        <div id="content" class="flex-grow-1 p-2">
          @yield('content')

          {{-- Will delete pag naayos ko na placings
            <a href="{{ route('applicantlist') }}" class="btn btn-primary">
                Applicants
            </a>
            <a href="{{ route('admission.exam.schedule') }}" class="btn btn-primary">
                Exam Schedule
            </a>
            <a href="{{ route('admission.exam.result') }}" class="btn btn-primary">
                Exam Results
            </a> --}}
        </div>
    </div>




</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
</html>
