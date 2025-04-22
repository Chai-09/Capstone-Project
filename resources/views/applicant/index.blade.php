<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <title>ApplySmart</title>
    
    </style>
</head>
<body>

    @csrf
    @include('applicant.navbar.navbar')

    <p>This is the applicant dashboard. Gabe ikaw na lang magtuloy neto :></p>
    <a href="/applicant/steps/forms/applicantforms" class="btn btn-primary">Next</a>

</body>
</html>