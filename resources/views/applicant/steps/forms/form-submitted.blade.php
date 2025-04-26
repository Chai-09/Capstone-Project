<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <title>Form Submission</title>
    @vite('resources/css/fillupforms/fillupforms.css')
    <!--@vite('resources/js/fillupforms/fillupforms.js')-->
    @vite('resources/js/address/address.js')
</head>
<body>
@include('applicant.navbar.navbar')

@include('applicant.sidebar.sidebar')

<div class="container submission-container d-flex align-items-center justify-content-center">
    <div class="submission-box text-center col-12 col-sm-10 col-md-8 col-lg-6">
        <h2>Your form has been submitted!</h2>
        <p>Please proceed to the next step</p>
        
            <button type="submit" class="btn btn-success">Proceed</button>
        
    </div>
</div>
    

</body>
</html>
</body>
</html>