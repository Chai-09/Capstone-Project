<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <title>Fill-up Forms</title>
    @vite('resources/css/fillupforms/fillupforms.css')
    <!--@vite('resources/js/fillupforms/fillupforms.js')-->
    @vite('resources/js/address/address.js')
</head>
<body>

    
<form action="{{ route('applicant.payment.payment') }}" method="GET">
    <button type="submit" class="btn btn-success">Proceed</button>
</form>
</body>
</html>
</body>
</html>