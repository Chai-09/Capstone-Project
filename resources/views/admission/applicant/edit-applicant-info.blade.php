@extends('admission.admission-home')

@section('content')
<a href="{{ route('applicantlist') }}" class="btn btn-primary">Back</a>

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

   {{-- Progress Tracker, paiba design if gusto niyo (walang controller toh, since display lang) --}}
    @php
    $steps = [
        1 => 'Fill-Up Forms',
        2 => 'Send Payment',
        3 => 'Payment Verification',
        4 => 'Schedule Entrance Exam',
        5 => 'Take the Exam',
        6 => 'Results',
        7 => 'Complete',
    ];
@endphp

<div class="mb-4">
    <h6 class="fw-bold">Progress Tracker</h6>
    <p>Current Stage: <span class="fw-semibold">{{ $steps[$applicant->current_step] ?? 'Unknown' }}</span></p>
    <div class="d-flex gap-2 align-items-center flex-wrap">

        @foreach ($steps as $stepNum => $label)
            <div class="d-flex align-items-center">
                <div class="border rounded d-flex justify-content-center align-items-center
                    @if ($stepNum < $applicant->current_step || $stepNum == 7 && $applicant->current_step == 7) bg-success text-white border-success
                    @elseif ($stepNum == $applicant->current_step) border-success text-success fw-bold
                    @else border-secondary text-secondary
                    @endif"
                    style="width: 40px; height: 40px;">
                    @if ($stepNum == 7)
                        &#10003; <!-- ginawa ko nalang checkmark, dito ko kinuha https://www.w3schools.com/charsets/ref_utf_dingbats.asp -->
                    @else
                        {{ $stepNum }}
                    @endif
                </div>
                @if ($stepNum < count($steps))
                    <div class="mx-1"
                         style="width: 25px; height: 3px;
                         background-color: {{ $stepNum < $applicant->current_step ? '#198754' : '#ccc' }};">
                    </div>
                @endif
            </div>
        @endforeach
    </div>
    
        <div class="d-flex gap-4 align-items-center flex-wrap mt-1">
        @foreach ($steps as $stepNum => $label)
            <div class="text-center" style="width: 55px;">
                <small style="font-size: 0.75rem;" class="{{ $stepNum == $applicant->current_step ? 'fw-bold text-success' : 'text-muted' }}">
                    {{ $label }}
                </small>
            </div>
        @endforeach
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
            <div class="col-md-4">
                <label>Region</label>
                <select id="region" name="region" class="form-control" data-selected="{{ $formData->region }}" disabled></select>
            </div>
            <div class="col-md-4">
                <label>Province</label>
                <select id="province" name="province" class="form-control" data-selected="{{ $formData->province }}" disabled></select>
            </div>

            <div class="col-md-4">
                <label>City</label>
                <select id="city" name="city" class="form-control" data-selected="{{ $formData->city }}" disabled></select>
            </div>
                        </div>
                        <div class="row mt-3">
                        <div class="col-md-6">
                <label>Barangay</label>
                <select id="barangay" name="barangay" class="form-control" data-selected="{{ $formData->barangay }}" disabled></select>
            </div>
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
    <div class="card mb-4">
    <div class="card-header bg-primary text-white">
        <strong>Time stamp per Stage</strong>
    </div>
    <div class="card-body">
    <ul class="list-group list-group-flush">
    <li class="list-group-item">
        <strong>Account Created:</strong>
        {{ $timestamps['account_created'] !== '—' ? \Carbon\Carbon::parse($timestamps['account_created'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
    <li class="list-group-item">
        <strong>Fill-up Forms:</strong>
        {{ $timestamps['form_submitted'] !== '—' ? \Carbon\Carbon::parse($timestamps['form_submitted'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
    <li class="list-group-item">
        <strong>Send Payment:</strong>
        {{ $timestamps['payment_sent'] !== '—' ? \Carbon\Carbon::parse($timestamps['payment_sent'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
    <li class="list-group-item">
        <strong>Payment Verified:</strong>
        {{ $timestamps['payment_verified'] !== '—' ? \Carbon\Carbon::parse($timestamps['payment_verified'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
    <li class="list-group-item">
        <strong>Exam Booking:</strong>
        {{ $timestamps['exam_booked'] !== '—' ? \Carbon\Carbon::parse($timestamps['exam_booked'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
    <li class="list-group-item">
        <strong>Exam Results:</strong>
        {{ $timestamps['exam_result'] !== '—' ? \Carbon\Carbon::parse($timestamps['exam_result'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
    </li>
</ul>

    </div>
</div>

    @if(isset($historyLogs) && count($historyLogs))
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0">Change History Log</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                
                    @if($historyLogs->count())
<div class="card mt-4">
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-striped align-middle" id="historyTable">
                <thead>
                    <tr>
                        <th>Date</th>
                        <th>Time</th>
                        <th>Changed By</th>
                        <th>Field</th>
                        <th>Old Value</th>
                        <th>New Value</th>
                    </tr>
                </thead>

                {{-- Only latest 5 logs --}}
                <tbody id="limitedLogs">
                    @foreach ($limitedLogs as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('h:i A') }}</td>
                        <td>{{ $log->changed_by }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $log->field_name)) }}</td>
                        <td class="text-danger">{{ $log->old_value ?? 'N/A' }}</td>
                        <td class="text-success">{{ $log->new_value ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>

                {{-- All logs --}}
                <tbody id="allLogs" class="d-none">
                    @foreach ($historyLogs as $log)
                    <tr>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('M d, Y') }}</td>
                        <td>{{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('h:i A') }}</td>
                        <td>{{ $log->changed_by }}</td>
                        <td>{{ ucwords(str_replace('_', ' ', $log->field_name)) }}</td>
                        <td class="text-danger">{{ $log->old_value ?? 'N/A' }}</td>
                        <td class="text-success">{{ $log->new_value ?? 'N/A' }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($historyLogs->count() > 5)
        <div class="text-end mt-2">
            <button class="btn btn-sm btn-outline-primary" id="toggleHistoryBtn">Show All</button>
        </div>
        @endif
    </div>
</div>
@endif


            </div>
        </div>
    </div>
@endif

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

    
    document.addEventListener('DOMContentLoaded', function () {
        const regionSelect = document.getElementById('region');
        const provinceSelect = document.getElementById('province');
        const citySelect = document.getElementById('city');
        const barangaySelect = document.getElementById('barangay');

        const selectedRegion = regionSelect.getAttribute('data-selected');
        const selectedProvince = provinceSelect.getAttribute('data-selected');
        const selectedCity = citySelect.getAttribute('data-selected');
        const selectedBarangay = barangaySelect.getAttribute('data-selected');

        function resetSelect(select, label = null) {
            const placeholder = label || "Choose " + capitalize(select.name);
            select.innerHTML = `<option value="" disabled selected hidden>${placeholder}</option>`;
        }

        function capitalize(str) {
            return str.charAt(0).toUpperCase() + str.slice(1);
        }

        function fetchData(url, select, valueKey = 'name', selectedValue = null) {
            return fetch(url)
                .then(res => res.json())
                .then(data => {
                    resetSelect(select);
                    data.forEach(item => {
                        const value = item[valueKey];
                        const isSelected = selectedValue && value === selectedValue ? 'selected' : '';
                        select.innerHTML += `<option value="${value}" ${isSelected}>${value}</option>`;
                    });
                });
        }

        // Load initial regions
        fetchData('https://psgc.gitlab.io/api/regions/', regionSelect, 'name', selectedRegion)
        .then(() => {
            if (selectedRegion) {
                regionSelect.value = selectedRegion;
                regionSelect.dispatchEvent(new Event('change'));
            }
        });

        regionSelect.addEventListener('change', function () {
            const regionName = this.value;
            resetSelect(provinceSelect);
            resetSelect(citySelect);
            resetSelect(barangaySelect);

            fetch('https://psgc.gitlab.io/api/regions/')
            .then(res => res.json())
            .then(regions => {
                const selected = regions.find(r => r.name === regionName);
                if (!selected) return;

                const regionCode = selected.code;

                if (regionCode === '130000000') {
                    provinceSelect.innerHTML = `<option value="Metro Manila (NCR)" selected>Metro Manila (NCR)</option>`;
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/cities-municipalities/`, citySelect, 'name', selectedCity)
                    .then(() => {
                        if (selectedCity) {
                            citySelect.value = selectedCity;
                            citySelect.dispatchEvent(new Event('change'));
                        }
                    });
                } else {
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`, provinceSelect, 'name', selectedProvince)
                    .then(() => {
                        if (selectedProvince) {
                            provinceSelect.value = selectedProvince;
                            provinceSelect.dispatchEvent(new Event('change'));
                        }
                    });
                }
            });
        });

        provinceSelect.addEventListener('change', function () {
            const provinceName = this.value;
            resetSelect(citySelect);
            resetSelect(barangaySelect);

            if (provinceName === 'Metro Manila (NCR)') return;

            fetch('https://psgc.gitlab.io/api/provinces/')
            .then(res => res.json())
            .then(provinces => {
                const selected = provinces.find(p => p.name === provinceName);
                if (!selected) return;

                fetchData(`https://psgc.gitlab.io/api/provinces/${selected.code}/cities-municipalities/`, citySelect, 'name', selectedCity)
                .then(() => {
                    if (selectedCity) {
                        citySelect.value = selectedCity;
                        citySelect.dispatchEvent(new Event('change'));
                    }
                });
            });
        });

        citySelect.addEventListener('change', function () {
            const cityName = this.value;
            resetSelect(barangaySelect);

            fetch('https://psgc.gitlab.io/api/cities-municipalities/')
            .then(res => res.json())
            .then(cities => {
                const selected = cities.find(c => c.name === cityName);
                if (!selected) return;

                fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${selected.code}/barangays/`, barangaySelect, 'name', selectedBarangay)
                .then(() => {
                    if (selectedBarangay) {
                        barangaySelect.value = selectedBarangay;
                    }
                });
            });
        });
    });
</script>

<!--Displaying changes-->
@php
    $changeHtml = collect(session('changes'))->map(function($change) {
        $field = ucwords(str_replace('_', ' ', $change['field_name']));
        $old = e($change['old_value']);
        $new = e($change['new_value']);
        return "<p><strong>{$field}</strong><br><span style='color:red;'>Old:</span> {$old}<br><span style='color:green;'>New:</span> {$new}</p>";
    })->implode('');
@endphp

@if(session('changes'))
<script>
Swal.fire({
    position: 'top-end',
    icon: 'success',
    html: '<span class="custom-toast-click">Edit saved. <u>See changes</u></span>',
    showConfirmButton: false,
    toast: true,
    timer: 5000,
    timerProgressBar: true,
    didOpen: (toast) => {
        toast.addEventListener('click', () => {
            Swal.fire({
                title: 'Changes Made',
                html: @json($changeHtml),
                confirmButtonText: 'Close',
                customClass: {
                    popup: 'text-start'
                }
            });
        });
    }
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleHistoryBtn');
    const limitedLogs = document.getElementById('limitedLogs');
    const allLogs = document.getElementById('allLogs');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isExpanded = !allLogs.classList.contains('d-none');

            if (isExpanded) {
                allLogs.classList.add('d-none');
                limitedLogs.classList.remove('d-none');
                toggleBtn.textContent = 'Show All';
            } else {
                limitedLogs.classList.add('d-none');
                allLogs.classList.remove('d-none');
                toggleBtn.textContent = 'Show Less';
            }
        });
    }
});
</script>


@endsection
