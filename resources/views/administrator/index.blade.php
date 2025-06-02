<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <title> ApplySmart | Administrator </title>

    {{-- CSS --}}
    @vite('resources/css/partials/reports.css')
    @vite('resources/css/partials/sidebar.css')
    @vite('resources/css/partials/tables.css')
    @vite('resources/css/partials/layout.css')
    @vite('resources/css/partials/dashboard.css')
    @vite('resources/css/administrator/edit-account.css')

    {{-- JS --}}
    @vite('resources/js/partials/sidebar.js')

</head>
<body>

<div class="d-flex">
    {{-- SIDEBAR --}}
    @include('partials.sidebar')

    {{-- Main Content --}}
    <div class="container table-design" id="content" class="flex-grow-1 p-2">
        @yield('content')
    </div>

</body>
</html>

