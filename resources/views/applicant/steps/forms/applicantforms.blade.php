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
</head>
<body>
    <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">FEU Diliman</a>
            <form class="d-flex">
            <a href="{{ route('logout') }}">Logout</a> <!--cinacall niya yung sa authcontrller-->
            </form>
        </div>
    </nav>
    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form id="mainForm" action="{{ route('form.step1') }}" method="POST">
        @csrf
        @if ($errors->any())
    <div style="background: #ffe0e0; padding: 10px; border: 1px solid red; margin-top: 10px;">
        <strong>Form submission failed:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li style="color: red;">{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <!--Applicant Information-->
        <div id="applicant">
            <p>Applicant's Name</p>
            <p>Example: Jeremy E. Joseph</p>

            <p>First Name</p>
            <input type="text" name="applicant_fname" placeholder="First Name" required>

            <p>Middle Initial</p>
            <input type="text" name="applicant_mname" placeholder="Middle Initial">

            <p>Last Name</p>
            <input type="text" name="applicant_lname" placeholder="Last Name" required>

            <p>Applicant's Contact Number</p>
            <input type="tel" name="applicant_contact_number" id="applicant_contact_number" placeholder="000-000-0000 / 000-0000" required>

            <p>Applicant's Email Address</p>           
            <input type="email" name="applicant_email" id="email" placeholder="Enter email address" required>

            <p>Home Address</p>
            <p>Building Number, Street Name</p>
            <input type="text" name="numstreet" id="numstreet" placeholder="Enter bldg number, street name" required>

            <p>Barangay</p>
            <input type="text" name="barangay" id="barangay" placeholder="Enter barangay" required>

            <p>City/Municipality</p>
            <input type="text" name="cityormunicipality" id="cityormunicipality" placeholder="Enter city/municipality" required>

            <p>Province</p>
            <input type="text" name="province" id="province" placeholder="Enter province" required>

            <p>Postal Code</p>
            <input type="number" name="postal_code" id="postal_code" placeholder="Enter postal code" required>

            <p>Age</p>
            <input type="number" name="age" id="age" placeholder="Enter age" required>

            <p>Gender</p>
            <select name="gender" id="gender" required>
                <option value="">Select Gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>

            <p>Nationality</p>
            <input type="text" name="nationality" id="nationality" placeholder="Enter nationality" required>
            <!--<a href="/applicant/steps/forms/guardianforms" class="btn btn-primary">Next</a>-->
            <button type="submit" class="btn btn-primary">Next</button>
        </div>
            <!--<a href="/applicant/payment/payment" class="btn btn-primary">Next</a>-->
        </div>
    </form>
</body>
</html>