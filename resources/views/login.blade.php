<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <title>ApplySmart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/2c99ab7d67.js" crossorigin="anonymous"></script>
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>

    @vite('resources/css/login/login.css')
    @vite('resources/js/app.js')
</head>
<body>

<div class="main">
    <div class="wrapper1">
        <img src="/images/login/logo_name.png">

        <div class="container">
            <div class="contents">
                <h2>FEU Diliman</h2>
                <h1>BE A <span>TAMARAW</span> NOW!</h1>
                <p><i class="fa-solid fa-check"></i> Kinder to Grade 6</p>
                <p><i class="fa-solid fa-check"></i> Junior High School</p>
                <p><i class="fa-solid fa-check"></i> Senior High School</p>
            </div>
        </div>
    </div>

    <div class="wrapper2">
        <div id="loginforms">
            <form action="{{ route('login.store') }}" method="POST">
                @csrf
                <h2>Welcome!</h2>
                <div class="form-group">
                    <label>Email address</label>
                    <input type="email" name="email" required>
                </div>

                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span> 
                    @endif
                </div>

                <button type="submit">LOGIN</button>

                @if ($errors->any())
                    <div class="text-danger mt-2">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <p class="signup-link">Not yet registered? <a href="#" id="openForms">Sign Up</a></p>
            </form>                
        </div>

        <div id="formsModal">
            <span id="close">&times;</span>
            <h3>Create your account</h3>

            <form action="{{ route('loginForms.store') }}" method="POST">
                @csrf

                <!-- Guardian Section -->
                <fieldset>
                    <div class="form-group">
                        <label>Guardian's Full Name <span class="required">*</span></label>
                        <p>Example: Jeremy E. Joseph</p>
                        <div class="name-fields">
                            <div class="name-field">
                                <input type="text" name="guardian_fname" placeholder="First Name" required>
                            </div>
                            <div class="name-field">
                                <input type="text" name="guardian_mname" placeholder="Middle Name" value="{{ old('guardian_mname') }}">
                            </div>
                            <div class="name-field">
                                <input type="text" name="guardian_lname" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="guardian_email">Email Address <span class="required">*</span></label>
                        <input type="email" name="guardian_email" id="guardian_email" required>
                    </div>

                    <div class="form-group">
                        <label for="password">Password <span class="required">*</span></label>
                        <input type="password" name="password" id="password" required>
                    </div>

                    <div class="form-group">
                        <label for="repassword">Confirm Password <span class="required">*</span></label>
                        <input type="password" name="repassword" id="repassword" required>
                    </div>
                </fieldset>

                <!-- Applicant Section -->
                <fieldset>
                    <div class="form-group">
                        <label>Applicant's Full Name <span class="required">*</span></label>
                        <p>Example: Jeremy E. Joseph</p>
                        <div class="name-fields">
                            <div class="name-field">
                                <input type="text" name="applicant_fname" placeholder="First Name" required>
                            </div>
                            <div class="name-field">
                                <input type="text" name="applicant_mname" placeholder="Middle Name">
                            </div>
                            <div class="name-field">
                                <input type="text" name="applicant_lname" placeholder="Last Name" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="current_school">Current School <span class="required">*</span></label>
                        <input type="text" name="current_school" id="current_school" required>
                    </div>

                    <div class="form-group">
                        <label for="incoming_grlvl">Incoming Grade Level <span class="required">*</span></label>
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
                    </div>
                </fieldset>

                <div class="terms">
                    <p>By signing up, you agree to the <a href="#">Terms of Service</a>, <a href="#">Privacy Policy</a>, including <a href="#">Cookie Use</a></p>
                </div>

                <div class="form-group">
                    <div class="g-recaptcha" data-sitekey="{{ config('services.recaptcha.site_key') }}"></div>
                    @if ($errors->has('g-recaptcha-response'))
                        <span class="text-danger">{{ $errors->first('g-recaptcha-response') }}</span> 
                    @endif
                </div>

                <button type="submit" class="submit-btn">Sign Up</button>
            </form>
        </div>
    </div>
</div>

</body>
</html>
