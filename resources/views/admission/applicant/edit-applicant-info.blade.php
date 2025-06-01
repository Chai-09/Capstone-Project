@extends('admission.admission-home')
@vite('resources/js/admission/edit-applicant-info.js')

<script>
    window.applicantLevel = @json($formData->educational_level);
</script>

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

@section('content')

{{-- Breadcrumbs --}}
<nav aria-label="breadcrumb">
    <ol class="breadcrumb">
        <li class="breadcrumb-item">
            <a href="{{ route('applicantlist') }}" class="text-decoration-none">Application List</a>
        </li>
        <li class="breadcrumb-item active text-dark" aria-current="page">
            {{ $formData->applicant_fname }} {{ $formData->applicant_mname }} {{ $formData->applicant_lname }}
        </li>
    </ol>
</nav>

<hr>


<div class="applicant-list row">
    <div class="col-md-9">

        {{-- Applicant Header Card --}}
        <div class="card shadow-sm border-0 mb-4 p-4 d-flex flex-md-row flex-column justify-content-between align-items-start align-items-md-center rounded-4 bg-white">
            <div class="flex-grow-1">
                <h4 class="fw-bold text-dark mb-3">
                    {{ $formData->applicant_fname }} {{ $formData->applicant_mname }} {{ $formData->applicant_lname }}
                </h4>
                <div class="row small text-secondary">
                    <div class="col-md-6 mb-2">
                        <strong>Guardian Name:</strong><br>
                        <span class="fw-semibold text-dark">
                            {{ $formData->guardian_fname }} {{ $formData->guardian_mname }} {{ $formData->guardian_lname }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Upcoming Grade Level:</strong><br>
                        <span class="fw-semibold text-dark">
                            {{ $formData->educational_level }} - {{ $formData->incoming_grlvl }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Email Address:</strong><br>
                        <span class="fw-semibold text-dark">
                            {{ $formData->applicant_email }}
                        </span>
                    </div>
                    <div class="col-md-6 mb-2">
                        <strong>Contact Number:</strong><br>
                        <span class="fw-semibold text-dark">
                            {{ $formData->applicant_contact_number }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="mt-4 mt-md-0 ms-md-3 text-md-end">
                <button class="btn btn-outline-secondary btn-sm me-2" id="editBtn">
                    <i class="bi bi-pencil-square"></i> Edit
                </button>
                <form id="deleteApplicantForm" method="POST" action="{{ route('applicant.delete', $formData->id) }}" class="d-inline">
                    @csrf
                    @method('DELETE')
                    <button type="button" class="btn btn-outline-danger btn-sm" id="deleteBtn">
                        <i class="bi bi-trash"></i> Delete
                    </button>
                </form>
            </div>
        </div>

        {{-- Progress Tracker --}}
        <div class="card shadow-sm border-0 mb-4 p-4 rounded-4 bg-white">
            <h6 class="fw-bold text-dark mb-3">Progress Tracker</h6>
            <p class="mb-4">Current Stage:
                <span class="fw-semibold text-success">
                    {{ $steps[$applicant->current_step] ?? 'Unknown' }}
                </span>
            </p>

            <div class="d-flex flex-wrap">
                @foreach ($steps as $stepNum => $label)
                    {{-- Step Item --}}
                    <div class="d-flex align-items-center">
                        {{-- Step Circle --}}
                        <div class="step-circle 
                            @if ($stepNum < $applicant->current_step || ($stepNum == 7 && $applicant->current_step == 7))
                                bg-success text-white border-success
                            @elseif ($stepNum == $applicant->current_step)
                                text-success border-success
                            @else
                                text-secondary border-secondary
                            @endif"
                            title="{{ $label }}"
                            onclick="showStepContent({{ $stepNum }})"
                        >
                            @if ($stepNum == 7)
                                <i class="bi bi-check-lg"></i>
                            @else
                                {{ $stepNum }}
                            @endif
                        </div>

                        {{-- Progress Line (Only show if not the last step) --}}
                        @if ($stepNum < count($steps))
                            <div class="progress-line"></div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Front End Error --}}
        <div id="alert-wrap">
            <div id="alert-container"></div>
        </div>

        {{-- Main Content --}}
        @if ($formData)
        <form method="POST" id="editApplicantForm" action="{{ route('applicant.update', $formData->id) }}">
            @csrf
            @method('PUT')

            {{-- Step 1: Applicant Information --}}
            <div id="step1Content">
                <div class="card p-4 shadow-sm rounder-4 border-0">
                    <h5 class="text-dark fw-bold mb-4"><i class="bi bi-person-lines-fill me-2"></i>Applicant Information</h5>

                    {{-- Name Row --}}
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">First Name</label>
                            <input type="text" class="form-control bg-light" name="applicant_fname" value="{{ $formData->applicant_fname }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Middle Initial</label>
                            <input type="text" class="form-control bg-light" name="applicant_mname" value="{{ $formData->applicant_mname }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Last Name</label>
                            <input type="text" class="form-control bg-light" name="applicant_lname" value="{{ $formData->applicant_lname }}" readonly>
                        </div>
                    </div>

                    {{-- Contact Details --}}
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Contact Number</label>
                            <input type="text" class="form-control bg-light" name="applicant_contact_number" value="{{ $formData->applicant_contact_number }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" class="form-control bg-light" name="applicant_email" value="{{ $formData->applicant_email }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Birthday</label>
                            <input type="date" class="form-control bg-light" name="applicant_bday" id="applicant_bday" value="{{ $formData->applicant_bday }}" disabled>
                        </div>
                    </div>

                    {{-- Other Applicant Info --}}
                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Age</label>
                            <input type="text" class="form-control bg-light" name="age" data-validate="numeric" value="{{ $formData->age }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Gender</label>
                            <select class="form-control bg-light" name="gender" readonly disabled>
                                <option value="">Select Gender</option>
                                <option value="Male" {{ $formData->gender == 'Male' ? 'selected' : '' }}>Male</option>
                                <option value="Female" {{ $formData->gender == 'Female' ? 'selected' : '' }}>Female</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Nationality</label>
                            <input type="text" class="form-control bg-light" name="nationality" value="{{ $formData->nationality }}" readonly>
                        </div>
                    </div>

                    <hr class="my-4">

                    {{-- Address --}}
                    <h5 class="text-dark fw-bold mb-4"><i class="bi bi-geo-alt-fill me-2"></i>Address</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Region</label>
                            <select id="region" name="region" class="form-control bg-light" data-selected="{{ $formData->region }}" disabled></select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Province</label>
                            <select id="province" name="province" class="form-control bg-light" data-selected="{{ $formData->province }}" disabled></select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">City</label>
                            <select id="city" name="city" class="form-control bg-light" data-selected="{{ $formData->city }}" disabled></select>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Barangay</label>
                            <select id="barangay" name="barangay" class="form-control bg-light" data-selected="{{ $formData->barangay }}" disabled></select>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Street/No.</label>
                            <input type="text" class="form-control bg-light" name="numstreet" value="{{ $formData->numstreet }}" readonly>
                        </div>
                        <div class="col-md-3">
                            <label class="form-label text-muted small">Postal Code</label>
                            <input type="text" data-validate="numeric" class="form-control bg-light" name="postal_code" value="{{ $formData->postal_code }}" readonly>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="text-dark fw-bold mb-4"><i class="bi bi-people-fill me-2"></i>Guardian Information</h5>
                    <div class="row g-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">First Name</label>
                            <input type="text" class="form-control bg-light" name="guardian_fname" value="{{ $formData->guardian_fname }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Middle Initial</label>
                            <input type="text" class="form-control bg-light" name="guardian_mname"  value="{{ $formData->guardian_mname }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Last Name</label>
                            <input type="text" class="form-control bg-light" name="guardian_lname" value="{{ $formData->guardian_lname }}" readonly>
                        </div>
                    </div>

                    <div class="row g-3 mt-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Contact Number</label>
                            <input type="text" class="form-control bg-light" name="guardian_contact_number" value="{{ $formData->guardian_contact_number }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email</label>
                            <input type="email" class="form-control bg-light" name="guardian_email" value="{{ $formData->guardian_email }}" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Relation</label>
                            <select class="form-control bg-light" name="relation" readonly disabled>
                                <option value="">Select Relation</option>
                                <option value="Parents" {{ $formData->relation == 'Parents' ? 'selected' : '' }}>Parents</option>
                                <option value="Brother/Sister" {{ $formData->relation == 'Brother/Sister' ? 'selected' : '' }}>Brother/Sister</option>
                                <option value="Uncle/Aunt" {{ $formData->relation == 'Uncle/Aunt' ? 'selected' : '' }}>Uncle/Aunt</option>
                                <option value="Cousin" {{ $formData->relation == 'Cousin' ? 'selected' : '' }}>Cousin</option>
                                <option value="Grandparents" {{ $formData->relation == 'Grandparents' ? 'selected' : '' }}>Grandparents</option>
                            </select>
                        </div>
                    </div>

                    <hr class="my-4">

                    <h5 class="text-dark fw-bold mb-4"><i class="bi bi-building me-2"></i>School Information</h5>
                    <div class="row">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Current School</label>
                            <input type="text" class="form-control bg-light" name="current_school" value="{{ $formData->current_school }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">School City</label>
                            <input type="text" class="form-control bg-light" name="current_school_city" value="{{ $formData->current_school_city }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">School Type</label>
                            <select class="form-control bg-light" name="school_type" readonly disabled>
                                <option value="">Select School Type</option>
                                <option value="Public" {{ $formData->school_type == 'Public' ? 'selected' : '' }}>Public</option>
                                <option value="Private Sectarian" {{ $formData->school_type == 'Private Sectarian' ? 'selected' : '' }}>Private Sectarian</option>
                                <option value="Private Non-Sectarian" {{ $formData->school_type == 'Private Non-Sectarian' ? 'selected' : '' }}>Private Non-Sectarian</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Educational Level</label>
                            <select class="form-control bg-light" name="educational_level" readonly disabled>
                                <option value="">Select Level</option>
                                <option value="Grade School" {{ $formData->educational_level == 'Grade School' ? 'selected' : '' }}>Grade School</option>
                                <option value="Junior High School" {{ $formData->educational_level == 'Junior High School' ? 'selected' : '' }}>Junior High School</option>
                                <option value="Senior High School" {{ $formData->educational_level == 'Senior High School' ? 'selected' : '' }}>Senior High School</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">Grade Level</label>
                            <input type="text" class="form-control bg-light" name="incoming_grlvl" value="{{ $formData->incoming_grlvl }}" readonly>
                        </div>
                        <div class="col-md-4">
                            <label class="form-label text-muted small">LRN</label>
                            <input type="text" class="form-control bg-light" name="lrn_no" data-validate="numeric" value="{{ $formData->lrn_no }}" readonly>
                        </div>
                    </div>

                    <div class="row mt-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Source</label>
                            <select class="form-control bg-light" name="source" readonly disabled>
                                <option value="">Select Source</option>
                                <option value="Career Fair/Career Orientation" {{ $formData->source == 'Career Fair/Career Orientation' ? 'selected' : '' }}>Career Fair/Career Orientation</option>
                                <option value="Events" {{ $formData->source == 'Events' ? 'selected' : '' }}>Events</option>
                                <option value="Social Media (Facebook, TikTok, Instagram, Youtube, etc)" {{ $formData->source == 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)' ? 'selected' : '' }}>Social Media</option>
                                <option value="Friends/Family/Relatives" {{ $formData->source == 'Friends/Family/Relatives' ? 'selected' : '' }}>Friends/Family</option>
                                <option value="Billboard" {{ $formData->source == 'Billboard' ? 'selected' : '' }}>Billboard</option>
                                <option value="Website" {{ $formData->source == 'Website' ? 'selected' : '' }}>Website</option>
                            </select>
                        </div>

                        @if($formData->educational_level === 'Senior High School')
                            <div class="col-md-6">
                                <label class="form-label text-muted small">Strand</label>
                                <select class="form-control bg-light name="strand" readonly disabled>
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
                        @endif
                    </div>
                </div>
            </div>
            
            {{-- Step 2: Payment Information --}}
            <div id="step2Content" class="d-none">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-cash-coin me-2"></i> Payment Information
                    </h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                             <label class="form-label text-muted small">Full Name</label><br>
                            <span>
                                {{ $formData->applicant_fname }} {{ $formData->applicant_mname }} {{ $formData->applicant_lname }}
                            </span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Email</label><br>
                            <span>{{ $formData->applicant_email }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Contact Number</label><br>
                            <span>{{ $formData->applicant_contact_number }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Guardian Name</label><br>
                            <span>
                                {{ $formData->guardian_fname }} {{ $formData->guardian_mname }} {{ $formData->guardian_lname }}
                            </span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Incoming Grade Level</label><br>
                            <span>{{ $formData->incoming_grlvl }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Payment Method</label><br>
                            <span>{{ $existingPayment->payment_method ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="row mb-3 align-items-center">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Proof of Payment</label><br>
                            @if($existingPayment && $existingPayment->proof_of_payment)
                                <a href="javascript:void(0)"  class="view-proof-link" onclick="showProofModal('{{ asset('storage/' . $existingPayment->proof_of_payment) }}')">
                                    View Proof
                                </a>
                            @else
                                <span class="text-secondary">No file uploaded</span>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Payment Date</label><br>
                            <span>{{ $existingPayment->payment_date ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Payment Time</label><br>
                           <span>
                                @if ($existingPayment && $existingPayment->payment_time)
                                    {{ \Carbon\Carbon::createFromFormat('H:i:s', $existingPayment->payment_time)->format('h:i A') }}
                                @else
                                    N/A
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 3: Payment Result --}}
            <div id="step3Content" class="d-none">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-receipt-cutoff me-2"></i> Payment Result
                    </h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Payment Status</label><br>
                            <span>{{ $existingPayment->payment_status ?? 'N/A' }}</span>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">OCR Number</label><br>
                            <span>{{ $existingPayment->ocr_number ?? 'N/A' }}</span>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Remarks</label>
                        <div class="border rounded p-2 bg-light">
                            {{ $existingPayment->remarks ?? 'N/A' }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Step 4: Exam Schedule --}}
            <div id="step4Content" class="d-none">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-calendar-event me-2"></i> Applicant Schedule
                    </h5>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Admission Number</label>
                            <input type="text" name="admission_number" class="form-control bg-light" 
                                value="{{ $schedule->admission_number ?? '' }}" readonly>
                        </div>
                        <div class="col-md-6">
                            <label class="form-label text-muted small">Exam Date</label>
                            <select name="exam_date" class="form-select bg-light" {{ $isEditable ? '' : 'disabled' }}>
                                @foreach($availableSchedules->groupBy('exam_date') as $date => $schedules)
                                    <option value="{{ $date }}" {{ ($schedule && $schedule->exam_date == $date) ? 'selected' : '' }}>
                                        {{ \Carbon\Carbon::parse($date)->format('F d, Y') }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label class="form-label text-muted small">Available Time Slots</label>
                        <select id="time_slot" name="time_slot" class="form-select bg-light" {{ $isEditable ? '' : 'disabled' }}>
                            <option value="">Select time</option>
                            @if(isset($schedule->start_time, $schedule->end_time))
                                <option selected value="{{ $schedule->start_time }}|{{ $schedule->end_time }}">
                                    {{ \Carbon\Carbon::parse($schedule->start_time)->format('g:i A') }}
                                    to
                                    {{ \Carbon\Carbon::parse($schedule->end_time)->format('g:i A') }}
                                </option>
                            @endif
                        </select>
                    </div>
                </div>
            </div>

            {{-- Step 5: Placeholder --}}
            <div id="step5Content" class="d-none">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-pencil-square me-2"></i> Take the Exam
                    </h5>
                    <div class="mb-3">
                        <label class="form-label text-muted small">Exam Status</label>
                        <select name="exam_status" class="form-control bg-light" readonly disabled>
                            <option value="">Select Status</option>
                            <option value="done" {{ ($examResult->exam_status ?? '') == 'done' ? 'selected' : '' }}>Done</option>
                            <option value="no show" {{ ($examResult->exam_status ?? '') == 'no show' ? 'selected' : '' }}>No Show</option>
                        </select>
                    </div>
                </div>
            </div>

            {{-- Step 6: Exam Result --}}
            <div id="step6Content" class="d-none">
                <div class="card shadow-sm p-4">
                    <h5 class="fw-bold text-dark mb-4">
                        <i class="bi bi-bar-chart-fill me-2"></i> Exam Result
                    </h5>

                    <div class="row mb-3">
                        <div class="col-md-12">
                            <label class="form-label text-muted small">Exam Result</label>
                            <select name="exam_result" class="form-control bg-light" readonly disabled>
                            <option value="">Select Result</option>
                            <option value="passed" {{ ($examResult->exam_result ?? '') == 'passed' ? 'selected' : '' }}>Passed</option>
                            <option value="failed" {{ ($examResult->exam_result ?? '') == 'failed' ? 'selected' : '' }}>Failed</option>
                            <option value="pending" {{ ($examResult->exam_result ?? '') == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="interview" {{ ($examResult->exam_result ?? '') == 'interview' ? 'selected' : '' }}>Interview</option>
                            <option value="scholarship" {{ ($examResult->exam_result ?? '') == 'scholarship' ? 'selected' : '' }}>Scholarship</option>
                            <option value="no show"
                                {{ ($examResult->exam_result ?? '') == 'no show' ? 'selected' : '' }}
                                style="{{ ($examResult->exam_status ?? '') != 'no show' ? 'display: none;' : '' }}">
                                No Show
                            </option>
                        </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Save & Cancel Buttons --}}
            <div id="formActionButtons" class="fixed-action-buttons d-none">
                <button type="button" class="btn btn-secondary" id="cancelBtn">Cancel</button>
                <button type="submit" class="btn btn-success" id="saveBtn">Save Changes</button>
            </div>

        </form>
    </div>

    <div class="col-md-3">

        {{-- Timestamp --}}
        <div class="card shadow-sm mb-4 rounded-4">
            <div class="card-header bg-success text-white rounded-top-4">
                <i class="bi bi-clock-history me-2"></i>
                <strong>Timestamp per Stage</strong>
            </div>
            <div class="card-body px-3 py-2">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item small">
                        <i class="bi bi-person-plus me-2 text-secondary"></i>
                        <strong>Account Created:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['account_created'] !== '—' ? \Carbon\Carbon::parse($timestamps['account_created'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item small">
                        <i class="bi bi-journal-text me-2 text-secondary"></i>
                        <strong>Fill-up Forms:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['form_submitted'] !== '—' ? \Carbon\Carbon::parse($timestamps['form_submitted'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item small">
                        <i class="bi bi-wallet2 me-2 text-secondary"></i>
                        <strong>Send Payment:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['payment_sent'] !== '—' ? \Carbon\Carbon::parse($timestamps['payment_sent'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item small">
                        <i class="bi bi-shield-check me-2 text-secondary"></i>
                        <strong>Payment Verified:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['payment_verified'] !== '—' ? \Carbon\Carbon::parse($timestamps['payment_verified'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item small">
                        <i class="bi bi-calendar-event me-2 text-secondary"></i>
                        <strong>Exam Booking:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['exam_booked'] !== '—' ? \Carbon\Carbon::parse($timestamps['exam_booked'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                    <li class="list-group-item small">
                        <i class="bi bi-bar-chart-line me-2 text-secondary"></i>
                        <strong>Exam Results:</strong><br>
                        <span class="text-dark">
                            {{ $timestamps['exam_result'] !== '—' ? \Carbon\Carbon::parse($timestamps['exam_result'])->timezone('Asia/Manila')->format('M d, Y - h:i A') : '—' }}
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        {{-- Change History Log --}}
        @if(isset($historyLogs) && count($historyLogs))
            <div class="card mt-4">
                <div class="card-header bg-success text-white rounded-top-4 d-flex align-items-center">
                    <i class="bi bi-clock-history me-2"></i>
                    <strong>Change History Log</strong>
                </div>

                <div class="card-body">
                    {{-- Latest 5 Logs --}}
                    <div id="limitedLogs">
                        @foreach ($limitedLogs as $log)
                            <div class="border rounded-3 p-3 mb-3 bg-light small">
                                <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('M d, Y') }}</p>
                                <p class="mb-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('h:i A') }}</p>
                                <p class="mb-1"><strong>Field:</strong> {{ ucwords(str_replace('_', ' ', $log->field_name)) }}</p>
                                <p class="mb-1"><strong>User:</strong> {{ $log->changed_by }}</p>
                                <p class="mb-1 text-danger"><strong>Original Value:</strong> {{ $log->old_value ?? 'N/A' }}</p>
                                <p class="mb-0 text-success"><strong>New Value:</strong> {{ $log->new_value ?? 'N/A' }}</p>
                            </div>
                        @endforeach
                    </div>

                    {{-- All Logs --}}
                    <div id="allLogs" class="d-none">
                        @foreach ($historyLogs as $log)
                            <div class="border rounded-3 p-3 mb-3 bg-light small">
                                <p class="mb-1"><strong>Date:</strong> {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('M d, Y') }}</p>
                                <p class="mb-1"><strong>Time:</strong> {{ \Carbon\Carbon::parse($log->created_at)->timezone('Asia/Manila')->format('h:i A') }}</p>
                                <p class="mb-1"><strong>Field:</strong> {{ ucwords(str_replace('_', ' ', $log->field_name)) }}</p>
                                <p class="mb-1"><strong>User:</strong> {{ $log->changed_by }}</p>
                                <p class="mb-1 text-danger"><strong>Original Value:</strong> {{ $log->old_value ?? 'N/A' }}</p>
                                <p class="mb-0 text-success"><strong>New Value:</strong> {{ $log->new_value ?? 'N/A' }}</p>
                            </div>
                        @endforeach
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

    {{-- SweetAlert for Change Confirmation --}}
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
    
@endif
@endsection
