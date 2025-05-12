<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="icon" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Admissions | Edit Applicant Info</title>
</head>
<body>
<nav class="navbar bg-dark p-3 d-flex justify-content-between">
    <p style="color: white" class="m-0">{{ auth()->user()->name }}</p>
    <div class="d-flex gap-2">
        <a href="{{ route('applicantlist') }}" class="btn btn-primary">Back</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
        </form>
    </div>
</nav>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h2>Applicant Profile</h2>
        <div>
            <button class="btn btn-warning btn-sm" id="editBtn"><i class="bi bi-pencil-square"></i> Edit</button>
            <form method="POST" action="{{ route('applicant.delete', $formData->id) }}" class="d-inline" onsubmit="return confirm('Are you sure you want to delete this applicant?')">
                @csrf
                @method('DELETE')
                <button class="btn btn-danger btn-sm"><i class="bi bi-trash"></i> Delete</button>
            </form>
        </div>
    </div>

    @if ($formData)
    <form method="POST" action="{{ route('applicant.update', $formData->id) }}">
        @csrf
        @method('PUT')
        <div class="card p-4">
            <h5 class="text-primary">Applicant Information</h5>
            <div class="row">
                <div class="col-md-4">
                    <label>First Name</label>
                    <input type="text" class="form-control" name="applicant_fname" value="{{ $formData->applicant_fname }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Middle Initial</label>
                    <input type="text" class="form-control" name="applicant_mname" value="{{ $formData->applicant_mname }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Last Name</label>
                    <input type="text" class="form-control" name="applicant_lname" value="{{ $formData->applicant_lname }}" readonly>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Contact Number</label>
                    <input type="text" class="form-control" name="applicant_contact_number" value="{{ $formData->applicant_contact_number }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Email</label>
                    <input type="email" class="form-control" name="applicant_email" value="{{ $formData->applicant_email }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Birthday</label>
                    <input type="date" class="form-control" name="applicant_bday" value="{{ $formData->applicant_bday }}" readonly>
                </div>
            </div>

            <div class="row mt-3">
                <div class="col-md-4">
                    <label>Age</label>
                    <input type="number" class="form-control" name="age" value="{{ $formData->age }}" readonly>
                </div>
                <div class="col-md-4">
                    <label>Gender</label>
                    <select class="form-control" name="gender" readonly disabled>
                        <option value="">Select Gender</option>
                        <option value="Male" {{ $formData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ $formData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                </div>

                <div class="col-md-4">
                    <label>Nationality</label>
                    <input type="text" class="form-control" name="nationality" value="{{ $formData->nationality }}" readonly>
                </div>
            </div>

            <hr>
            <h5 class="text-primary mt-4">Address</h5>
            <div class="row">
                <div class="col-md-4"><label>Region</label><input type="text" class="form-control" name="region" value="{{ $formData->region }}" readonly></div>
                <div class="col-md-4"><label>Province</label><input type="text" class="form-control" name="province" value="{{ $formData->province }}" readonly></div>
                <div class="col-md-4"><label>City</label><input type="text" class="form-control" name="city" value="{{ $formData->city }}" readonly></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6"><label>Barangay</label><input type="text" class="form-control" name="barangay" value="{{ $formData->barangay }}" readonly></div>
                <div class="col-md-3"><label>Street/No.</label><input type="text" class="form-control" name="numstreet" value="{{ $formData->numstreet }}" readonly></div>
                <div class="col-md-3"><label>Postal Code</label><input type="text" class="form-control" name="postal_code" value="{{ $formData->postal_code }}" readonly></div>
            </div>

            <hr>
            <h5 class="text-primary mt-4">Guardian Information</h5>
            <div class="row">
                <div class="col-md-4"><label>First Name</label><input type="text" class="form-control" name="guardian_fname" value="{{ $formData->guardian_fname }}" readonly></div>
                <div class="col-md-4"><label>Middle Initial</label><input type="text" class="form-control" name="guardian_mname" value="{{ $formData->guardian_mname }}" readonly></div>
                <div class="col-md-4"><label>Last Name</label><input type="text" class="form-control" name="guardian_lname" value="{{ $formData->guardian_lname }}" readonly></div>
            </div>
            <div class="row mt-3">
                <div class="col-md-6"><label>Contact Number</label><input type="text" class="form-control" name="guardian_contact_number" value="{{ $formData->guardian_contact_number }}" readonly></div>
                <div class="col-md-6"><label>Email</label><input type="email" class="form-control" name="guardian_email" value="{{ $formData->guardian_email }}" readonly></div>
            </div>
            <div class="mt-3">
                <label>Relation</label>
                <select class="form-control" name="relation" readonly disabled>
                    <option value="">Select Relation</option>
                    <option value="Parents" {{ $formData->relation == 'Parents' ? 'selected' : '' }}>Parents</option>
                    <option value="Brother/Sister" {{ $formData->relation == 'Brother/Sister' ? 'selected' : '' }}>Brother/Sister</option>
                    <option value="Uncle/Aunt" {{ $formData->relation == 'Uncle/Aunt' ? 'selected' : '' }}>Uncle/Aunt</option>
                    <option value="Cousin" {{ $formData->relation == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                    <option value="Grandparents" {{ $formData->relation == 'Grandparents' ? 'selected' : '' }}>Grandparents</option>
                </select>
            </div>


            <hr>
            <h5 class="text-primary mt-4">School Information</h5>
            <div class="row">
                <div class="col-md-4"><label>Current School</label><input type="text" class="form-control" name="current_school" value="{{ $formData->current_school }}" readonly></div>
                <div class="col-md-4"><label>School City</label><input type="text" class="form-control" name="current_school_city" value="{{ $formData->current_school_city }}" readonly></div>
                <div class="col-md-4">
                    <label>School Type</label>
                    <select class="form-control" name="school_type" readonly disabled>
                        <option value="">Select School Type</option>
                        <option value="Public" {{ $formData->school_type == 'Public' ? 'selected' : '' }}>Public</option>
                        <option value="Private Sectarian" {{ $formData->school_type == 'Private Sectarian' ? 'selected' : '' }}>Private Sectarian</option>
                        <option value="Private Non-Sectarian" {{ $formData->school_type == 'Private Non-Sectarian' ? 'selected' : '' }}>Private Non-Sectarian</option>
                    </select>
                </div>

            </div>
            <div class="row mt-3">
            <div class="col-md-4">
                <label>Educational Level</label>
                <select class="form-control" name="educational_level" readonly disabled>
                    <option value="">Select Level</option>
                    <option value="Grade School" {{ $formData->educational_level == 'Grade School' ? 'selected' : '' }}>Grade School</option>
                    <option value="Junior High School" {{ $formData->educational_level == 'Junior High School' ? 'selected' : '' }}>Junior High School</option>
                    <option value="Senior High School" {{ $formData->educational_level == 'Senior High School' ? 'selected' : '' }}>Senior High School</option>
                </select>
            </div>

                <div class="col-md-4"><label>Grade Level</label><input type="text" class="form-control" name="incoming_grlvl" value="{{ $formData->incoming_grlvl }}" readonly></div>
                <div class="col-md-4"><label>LRN</label><input type="text" class="form-control" name="lrn_no" value="{{ $formData->lrn_no }}" readonly></div>
            </div>
            @if($formData->educational_level === 'Senior High School')
                <div class="row mt-3">
                    <div class="col-md-6">
                        <label>Strand</label>
                        <select class="form-control" name="strand" readonly disabled>
                            <option value="">Select Strand</option>
                            <option value="STEM Health Allied" {{ $formData->strand == 'STEM Health Allied' ? 'selected' : '' }}>STEM Health Allied</option>
                            <option value="STEM Engineering" {{ $formData->strand == 'STEM Engineering' ? 'selected' : '' }}>STEM Engineering</option>
                            <option value="STEM Information Technology" {{ $formData->strand == 'STEM Information Technology' ? 'selected' : '' }}>STEM IT</option>
                            <option value="ABM Accountancy" {{ $formData->strand == 'ABM Accountancy' ? 'selected' : '' }}>ABM Accountancy</option>
                            <option value="ABM Business Management" {{ $formData->strand == 'ABM Business Management' ? 'selected' : '' }}>ABM Business Management</option>
                            <option value="HUMSS" {{ $formData->strand == 'HUMSS' ? 'selected' : '' }}>HUMSS</option>
                            <option value="GAS" {{ $formData->strand == 'GAS' ? 'selected' : '' }}>GAS</option>
                            <option value="SPORTS" {{ $formData->strand == 'SPORTS' ? 'selected' : '' }}>SPORTS</option>
                        </select>
                    </div>
                </div>
            @endif


                <div class="col-md-6">
                    <label>Source</label>
                    <select class="form-control" name="source" readonly disabled>
                        <option value="">Select Source</option>
                        <option value="Career Fair/Career Orientation" {{ $formData->source == 'Career Fair/Career Orientation' ? 'selected' : '' }}>Career Fair/Career Orientation</option>
                        <option value="Events" {{ $formData->source == 'Events' ? 'selected' : '' }}>Events</option>
                        <option value="Social Media (Facebook, TikTok, Instagram, Youtube, etc)" {{ $formData->source == 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)' ? 'selected' : '' }}>Social Media</option>
                        <option value="Friends/Family/Relatives" {{ $formData->source == 'Friends/Family/Relatives' ? 'selected' : '' }}>Friends/Family</option>
                        <option value="Billboard" {{ $formData->source == 'Billboard' ? 'selected' : '' }}>Billboard</option>
                        <option value="Website" {{ $formData->source == 'Website' ? 'selected' : '' }}>Website</option>
                    </select>
                </div>
            </div>

            <div class="mt-4 text-end d-flex justify-content-end gap-2">
                <button type="button" class="btn btn-secondary d-none" id="cancelBtn">Cancel</button>
                <button type="submit" class="btn btn-success d-none" id="saveBtn">Save Changes</button>
            </div>
        </div>
    </form>
    @else
        <p>No form data found for this applicant.</p>
    @endif
</div>

<script>
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const inputs = document.querySelectorAll('input');
    const selects = document.querySelectorAll('select');


    const originalValues = {};
    inputs.forEach(input => originalValues[input.name] = input.value);
    selects.forEach(select => originalValues[select.name] = select.value);

    editBtn.addEventListener('click', () => {
        inputs.forEach(input => input.removeAttribute('readonly'));
        selects.forEach(select => {
            select.removeAttribute('disabled');
            select.removeAttribute('readonly');
        });
        saveBtn.classList.remove('d-none');
        cancelBtn.classList.remove('d-none');
    });

    cancelBtn.addEventListener('click', () => {
        inputs.forEach(input => {
            input.setAttribute('readonly', true);
            if (originalValues.hasOwnProperty(input.name)) {
                input.value = originalValues[input.name];
            }
        });

        selects.forEach(select => {
            select.setAttribute('disabled', true);
            if (originalValues.hasOwnProperty(select.name)) {
                select.value = originalValues[select.name];
            }
        });

        saveBtn.classList.add('d-none');
        cancelBtn.classList.add('d-none');
    });
</script>

</body>
</html>
