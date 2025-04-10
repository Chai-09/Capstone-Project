<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

    @vite('resources/css/app.css')
    @vite('resources/js/app.js')
</head>
<body>
    <h2>Welcome</h2>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div id="loginforms">
        <form action="{{ route('login.store') }}" method="POST">
            @csrf
            <label>Email address</label>
            <input type="email" name="email" required>
            <br />
            <label>Password</label>
            <input type="password" name="password" required>
            <br />
            <button type="submit">LOGIN</button>

            
        </form>

        <p>Not yet registered?
                <a href="" id="openForms">
                    Sign Up
                </a>
            </p>
    </div>
    
    
    <div id="formsModal">
        <h3><span id="close">&times</span>
            Create your account
        </h3>
        <p id="req">* Indicates a Required Question</p>
        <form action="{{ route('loginForms.store') }}" method="POST">
            @csrf
            <p>Guardian Name<br />Example: James E. Joseph</p>

            <p>
                First Name
                <input type="text" name="guardian_fname" id="guardian_fname" required>
            </p>

            <p>
                Middle Name
                <input type="text" name="guardian_mname" value="{{ old('guardian_mname') }}">
            </p>

            <p>
                Last Name
                <input type="text" name="guardian_lname" id="guardian_lname" required>
            </p>

            <p>
                Email Address
                <input type="email" name="guardian_email" id="guardian_email" required>
            </p>

            <p>
                Email Password
                <input type="password" name="password" id="password" required>
            </p>

            <p>
                Re-enter Password
                <input type="password" name="repassword" id="repassword" required>
            </p>

            <p>Applicant's Name<br />Example: James E. Joseph</p>

            <p>
                First Name
                <input type="text" name="applicant_fname" id="applicant_fname" required>
            </p>

            <p>
                Middle Name
                <input type="text" name="applicant_mname" id="applicant_mname">
            </p>

            <p>
                Last Name
                <input type="text" name="applicant_lname" id="applicant_lname" required>
            </p>

            <p>
                Applicant's Current School
                <input type="text" name="current_school" id="current_school" required>
            </p>

            <p>
                Incoming Grade Level
                <select name="incoming_grlvl" id="incoming_grlvl" required>
                    <option value="">Select Grade Level</option>
                    <option value="Kinder">Kinder</option>
                    <option value="Grade 1">Grade 1</option>
                    <option value="Grade 2">Grade 2</option>
                    <option value="Grade 3">Grade 3</option>
                    <option value="Grade 4">Grade 4</option>
                    <option value="Grade 5">Grade 5</option>
                    <option value="Grade 6">Grade 6</option>
                    <option value="Grade 7">Grade 7</option>
                    <option value="Grade 8">Grade 8</option>
                    <option value="Grade 9">Grade 9</option>
                    <option value="Grade 10">Grade 10</option>
                    <option value="Grade 11">Grade 11</option>
                    <option value="Grade 12">Grade 12</option>
                </select>
            </p>
            <p>By signing up, you agree to the<u>Terms of Service</u>and<u>Privacy Policy,</u>including<u>Cookie Use</u></p>
            <button type="submit">Sign Up</button>
        </form>
    </div>  
        
</body>
</html>