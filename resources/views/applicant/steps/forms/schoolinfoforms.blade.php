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
    @vite('resources/js/fillupforms/fillupforms.js')
</head>
<body>

    @if ($errors->any())
    <div class="alert alert-danger">
        <strong>Form submission failed:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<nav class="navbar bg-body-tertiary fixed-top">
    <div class="container-fluid">
        <a class="navbar-brand">FEU Diliman</a>
        <form class="d-flex">
            <a href="{{ route('logout') }}">Logout</a> <!--cinacall niya yung sa authcontrller-->
        </form>
    </div>
</nav>

<form id="mainForm" action="{{ route('form.step3') }}" method="POST">
    @csrf
    <div id="school_info" class="container mt-5 pt-5">
        <h3>School Information</h3>

        <p>Current School</p>
        <input type="text" name="current_school" id="current_school" placeholder="Enter current school name" required>

        <p>Current School Location</p>
        <input type="text" name="current_school_city" id="current_school_city" placeholder="Enter current school CITY" required>

        <p>Type of School</p>
        <select name="school_type" id="school_type" required>
            <option value="">Select Type of School</option>
            @foreach (['Private','Public','Private Sectarian','Private Non-Sectarian'] as $school_type)
                <option value="{{ $school_type }}">{{ $school_type }}</option>
            @endforeach
        </select>

        <p>What is your incoming educational level?</p>
        <select name="educational_level" id="educational_level" required>
            <option value="">Select Type of School</option>
            @foreach ([
                'Grade School',
                'Junior High School',
                'Senior High School'
            ] as $level)
                <option value="{{ $level }}">{{ $level }}</option>
            @endforeach
        </select>
        

        <!-- Shared Grade Level -->
        <p>Select Grade Level</p>
        <select name="incoming_grlvl" id="incoming_grlvl" required>
            <option value="">Select Grade Level</option>
        </select>

        <!-- Birthday (only for Kinder / Grade 1) -->
        <div id="birthday-container" style="display: none;">
            <p>Applicant's Birthday</p>
            <input type="date" name="applicant_bday" id="applicant_bday">
        </div>

        <!-- LRN (not for SHS) -->
        <div id="lrn-container" style="display: none;">
            <p>LRN Number</p>
            <input type="text" name="lrn_no" id="lrn_no" placeholder="Enter LRN Number">
        </div>

        <!-- Strand (only for SHS) -->
        <div id="strand-container" style="display: none;">
            <p>Academic Strand</p>
            <select name="strand" id="strand">
                <option value="">Select Academic Strand</option>
                @foreach (['STEM Health Allied', 'STEM Engineering', 'STEM Information Technology', 'ABM Accountancy', 'ABM Business Management', 'HUMSS', 'GAS', 'SPORTS'] as $strand)
                    <option value="{{ $strand }}">{{ $strand }}</option>
                @endforeach
            </select>
        </div>

        <p>How did you learn about us?</p>
        <select name="source" id="source" required>
            <option value="">Select one of these options</option>
            @foreach (['Career Fair/Career Orientation','Events','Social Media (Facebook, TikTok, Instagram, Youtube, etc)', 'Friends/Family/Relatives', 'Billboard', 'Website'] as $source)
                <option value="{{ $source }}">{{ $source }}</option>
            @endforeach
        </select>

        <p class="mt-3">Please review your information carefully before clicking 'Submit' as you won't be able to make changes afterward.</p>
        <button type="submit" class="btn btn-primary">Submit</button>
        <!--<a href="/applicant/payment/payment" class="btn btn-primary">Next</a>-->
    </div>
</form>
</body>
</html>
