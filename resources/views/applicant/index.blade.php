<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    
    @vite('resources/css/fillupforms/fillupforms.css')
    @vite('resources/js/fillupforms/fillupforms.js')
    @vite('resources/js/address/address.js')
</head>
<body>
    @include('applicant.navbar.navbar')
    @include('applicant.sidebar.sidebar')

    <form action="{{ route('form.step3') }}" method="POST">
        @include('applicant.steps.forms.step-1-forms')
    </form>

</body>
</html>
