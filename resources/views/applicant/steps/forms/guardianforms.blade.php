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
    <form id="mainForm" action="{{ route('form.step2') }}" method="POST">
        @csrf
        <!--Guardian Information-->
        <div id="guardian">
            <p>Guardian's Name</p>
            <p>Example: Jeremy E. Joseph</p>

            <p>First Name</p>
            <input type="text" name="guardian_fname" placeholder="First Name" required>

            <p>Middle Initial</p>
            <input type="text" name="guardian_mname" placeholder="Middle Initial">

            <p>Last Name</p>
            <input type="text" name="guardian_lname" placeholder="Last Name" required>

            <p>Guardian's Contact Number</p>
            <input type="tel" name="guardian_contact_number" id="guardian_contact_number" placeholder="000-000-0000 / 000-0000"  required>

            <p>Guardian's Email Address</p>           
            <input type="email" name="guardian_email" id="email" placeholder="Enter email address"  required>

            <h4>How are you related to the applicant?</h4>
            <select name="relation" id="relation" required>
                <option value="">Select Relation</option>
                @foreach (['Parents', 'Brother/Sister', 'Uncle/Aunt', 'Cousin', 'Grandparents'] as $relation)
                    <option value="{{ $relation }}">{{ $relation }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn-primary">Next</button>
        </div>
        <!--<a href="/applicant/payment/payment" class="btn btn-primary">Next</a>-->
    </form>
</body>
</html>