<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>
    <title>ApplySmart</title>
    @vite('resources/js/fillupforms/fillupforms.js')

    </style>
</head>
<body>

    @csrf
    @include('applicant.navbar.navbar')

    @include('applicant.sidebar.sidebar')

    
    {{-- Call the Forms --}}
    
    <a href="/applicant/steps/forms/applicantforms" class="btn btn-primary">Go to forms</a>

</body>
</html>