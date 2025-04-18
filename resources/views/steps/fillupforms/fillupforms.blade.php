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
    <nav class="navbar bg-body-tertiary fixed-top">
        <div class="container-fluid">
            <a class="navbar-brand">FEU Diliman</a>
            <form class="d-flex">
            <a href="{{ route('logout') }}">Logout</a> <!--cinacall niya yung sa authcontrller-->
            </form>
        </div>
    </nav>
    <form id="mainForm" action="{{ route('fillupforms.store') }}" method="POST">
        @csrf
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
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <p>Nationality</p>
            <input type="text" name="nationality" id="nationality" placeholder="Enter nationality" required>
            <button type="button">Next</button>
        </div>


        <!--Guardian Information-->
        <div id="guardian" class="hidden">
            <p>Guardian's Name</p>
            <p>Example: Jeremy E. Joseph</p>

            <p>First Name</p>
            <input type="text" name="guardian_fname" placeholder="First Name" required>

            <p>Middle Initial</p>
            <input type="text" name="guardian_mname" placeholder="Middle Initial">

            <p>Last Name</p>
            <input type="text" name="guardian_lname" placeholder="Last Name" required>

            <p>Applicant's Contact Number</p>
            <input type="tel" name="guardian_contact_number" id="guardian_contact_number" placeholder="000-000-0000 / 000-0000"  required>

            <p>Applicant's Email Address</p>           
            <input type="email" name="guardian_email" id="email" placeholder="Enter email address"  required>

            <h4>How are you related to the applicant?</h4>
            <select name="relation" id="relation" required>
                <option value="">Select Relation</option>
                @foreach (['Parents', 'Brother/Sister', 'Uncle/Aunt', 'Cousin', 'Grandparents'] as $relation)
                    <option value="{{ $relation }}">{{ $relation }}</option>
                @endforeach
            </select>

            <button type="button">Next</button>
        </div>
      
        
        <!--School Information-->
        <div id="school_info" class="hidden">
            <p>Current School</p>
            <input type="text" name="current_school" id="current_school" placeholder="Enter current school name" required>

            <p>Current School Location</p>
            <input type="text" name="current_school_city" id="current_school_city" placeholder="Enter current school CITY"  required>

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
                    @foreach (['Grade School','Junior High School','Senior High School'] as $educational_level)
                        <option value="{{ $educational_level }}">{{ $educational_level }}</option>
                    @endforeach
            </select>

            <!--If educational level == grade_school-->
            <!--If educational level == grade_school-->
            <div id="gs">
                <p>Grade School</p>
                <p>Please select what grade level you are applying for the next school year</p>
                <b>Note</b>: <i>For Kinder applicants, the student must be 5 years old by October 2025.</i>
                <select name="incoming_grlvl" id="incoming_grlvl" required>
                    <option value="">Select Grade Level</option>
                    @foreach (['Kinder','Grade 1','Grade 2','Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'] as $incoming_grlvl)
                        <option value="{{ $incoming_grlvl }}">{{ $incoming_grlvl }}</option>
                    @endforeach
                </select>

                <!-- Wrap birthday in its own container -->
                <div id="birthday-container">
                    <p>Applicant's Birthday</p>
                    <input type="date" name="applicant_bday" id="applicant_bday" required>
                </div>

                <p>LRN Number</p>
                <input type="text" name="lrn_no" id="lrn_no" placeholder="Enter LRN Number" required>
            </div>


            <!--If educational level == junior_high-->
            <div id="jhs">
                <p>Junior High School</p>
                <p>Please select what grade level you are applying for the next school year</p>
                <select name="grade_level" id="grade_level" required>
                    <option value="">Select Type of School</option>
                    @foreach (['Grade 7','Grade 8','Grade 9', 'Grade 10'] as $grade_level)
                        <option value="{{ $grade_level }}">{{ $grade_level }}</option>
                    @endforeach
                </select>

                <p>LRN Number</p>
                <input type="text" name="lrn_no" id="lrn_no" placeholder="Enter LRN Number" required>
            </div>

            <!--If educational level == senior_high-->
            <div id="shs">
                <p>Senior High School</p>
                <p>Please select what grade level you are applying for the next school year</p>
                <select name="grade_level" id="grade_level" required>
                    <option value="">Select Type of School</option>
                    @foreach (['Grade 11','Grade 12'] as $grade_level)
                        <option value="{{ $grade_level }}">{{ $grade_level }}</option>
                    @endforeach
                </select>

                <p>Academic Strand</p>
                <select name="strand" id="strand" required>
                    <option value="">Select Type of School</option>
                    @foreach (['STEM Health Allied', 'STEM Engineering', 'STEM Information Technology', 'ABM Accountancy', 'ABM Business Management', 'HUMSS', 'GAS', 'SPORTS'] as $strand)
                        <option value="{{ $strand }}">{{ $strand }}</option>
                    @endforeach
                </select>
            </div>

            <p>How did you learn about us?</p>
            <select name="source" id="source" required>
                <option value="">Select one of these options</option>
                @foreach (['Career Fair/Career Orientation','Events','Social Media (Facebook, TikTok, Instagram, Youtube, etc)',
                    'Friends/Family/Relatives', 'Billboard', 'Website'] as $source)
                    <option value="{{ $source }}">{{ $source }}</option>
                @endforeach
            </select>

            <p>Please review your information carefully before clicking 'Submit' as you won't be able to make changes afterward.</p>

            <button type="submit">Submit</button>
        </div>
    </form>
</body>
</html>