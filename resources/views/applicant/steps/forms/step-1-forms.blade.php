@extends('applicant.index')

@section('content')
<form action="{{ route('applicantdashboard') }}" method="POST">
    @csrf   
    @php
        $readOnly = isset($applicant) && $applicant->current_step > 1;
    @endphp

    <!-- strand recommendation modal display-->
  @if (session('strand_recommendation'))
<script>
Swal.fire({
    icon: 'info',
    title: 'Strand Suggested',
    html: 'Your recommended strand is <b>{{ session('strand_recommendation') }}</b>. You can still choose another strand if you want.',
    showCancelButton: true,
    confirmButtonText: 'View Strand Breakdown',
    cancelButtonText: 'Close',
    confirmButtonColor: '#28a745',
}).then((result) => {
    if (result.isConfirmed) {
        const breakdownModal = new bootstrap.Modal(document.getElementById('scoreBreakdownModal'));
        breakdownModal.show();
    }
});
</script>
@endif


    {{-- Front End Error --}}
    <div id="alert-wrapper">
        <div id="alert-container">
        </div>
    </div>

    {{-- Applicant Information --}}
    <div id="step1">
        <div class="step-form">
            <div class="form-section">
                {{-- Server Side Error --}}
                @include('applicant.error.alert-error')
                <label class="fw-semibold">Applicant's Name<span class="text-danger">*</span></label>
                <p class="text-muted">Example: James E. Joseph</p>

                <div class="form-row">
                    <div class="form-col">
                        <label>First Name</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('applicant_fname', $formSubmission->applicant_fname ?? '') }}" disabled>
                            <input type="hidden" name="applicant_fname" value="{{ old('applicant_fname', $formSubmission->applicant_fname ?? '') }}">
                        @elseif (in_array('applicant_fname', $readOnlyFields ?? []))
                            <input type="text" name="applicant_fname" value="{{ old('applicant_fname', $formSubmission->applicant_fname ?? '') }}" readonly>
                        @endif
                    </div>
                    <div class="form-col">
                        <label>Middle Initial</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('applicant_mname', $formSubmission->applicant_mname ?? '') }}" disabled>
                            <input type="hidden" name="applicant_mname" value="{{ old('applicant_mname', $formSubmission->applicant_mname ?? '') }}">
                        @elseif (in_array('applicant_mname', $readOnlyFields ?? []))
                            <input type="text" name="applicant_mname" value="{{ old('applicant_mname', $formSubmission->applicant_mname ?? '') }}" readonly>
                        @endif
                    </div>
                    <div class="form-col">
                        <label>Last Name</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('applicant_lname', $formSubmission->applicant_lname ?? '') }}" disabled>
                            <input type="hidden" name="applicant_lname" value="{{ old('applicant_lname', $formSubmission->applicant_lname ?? '') }}">
                        @elseif (in_array('applicant_lname', $readOnlyFields ?? []))
                            <input type="text" name="applicant_lname" value="{{ old('applicant_lname', $formSubmission->applicant_lname ?? '') }}" readonly>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label>Applicant's Contact Number<span class="text-danger">*</span></label>
                        <input type="tel" name="applicant_contact_number" value="{{ old('applicant_contact_number', $formSubmission->applicant_contact_number ?? '') }}" placeholder="09XXXXXXXXX" required {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label>Applicant's Email Address<span class="text-danger">*</span></label>
                        <input type="email" name="applicant_email" value="{{ old('applicant_email', $formSubmission->applicant_email ?? '') }}" placeholder="Enter email address" required {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <label class="fw-semibold">Home Address<span class="text-danger">*</span></label>

                <div class="form-row">
                    <div class="form-col">
                        <label class="text-muted">Building Number, Street Name</label>
                        <input type="text" name="numstreet" 
                        value="{{ old('numstreet', $formSubmission->numstreet ?? '') }}"
                        placeholder="Enter bldg number, street name" required {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                    <div class="form-col">
                        <label class="text-muted">Region</label>
                        <select name="region" id="region" required {{ $readOnly ? 'disabled' : '' }} data-selected="{{ old('region', $formSubmission->region ?? '') }}">
                            <option value="">Choose Region</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label class="text-muted">Province</label>
                        <select name="province" id="province" required {{ $readOnly ? 'disabled' : '' }} data-selected="{{ old('province', $formSubmission->province ?? '') }}">
                            <option value="">Choose Province</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label class="text-muted">City</label>
                        <select name="city" id="city" required {{ $readOnly ? 'disabled' : '' }} data-selected="{{ old('city', $formSubmission->city ?? '') }}">
                            <option value="">Choose City</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label class="text-muted">Barangay</label>
                        <select name="barangay" id="barangay" required {{ $readOnly ? 'disabled' : '' }} data-selected="{{ old('barangay', $formSubmission->barangay ?? '') }}"> 
                            <option value="">Choose Barangay</option>
                        </select>
                    </div>
                    <div class="form-col">
                        <label class="text-muted">Postal Code</label>
                        <input type="number" name="postal_code"
                        value="{{ old('postal_code', $formSubmission->postal_code ?? '')}}"
                        placeholder="Enter postal code" required {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Age<span class="text-danger">*</span></label>
                
                    <input type="number" name="age" 
                    value="{{ old('age', $formSubmission->age ?? '')}}"
                    placeholder="Enter age" required {{ $readOnly ? 'disabled' : '' }}>
                </div>
                <div class="form-col">
                    <label>Gender<span class="text-danger">*</span></label>
                    <select name="gender"  id="gender" required {{ $readOnly ? 'disabled' : '' }}>
                        <option value="">Select gender</option>
                        <option value="Male" {{ old('gender', $formSubmission->gender ?? '') == 'Male' ? 'selected' : '' }}>Male</option>
                        <option value="Female" {{ old('gender', $formSubmission->gender ?? '') == 'Female' ? 'selected' : '' }}>Female</option>
                    </select>
                    @if($readOnly)
                <input type="hidden" name="gender" value="{{ old('gender', $formSubmission->gender ?? '') }}">
                @endif
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Nationality<span class="text-danger">*</span></label>
                    <input type="text" name="nationality" 
                    value="{{ old('nationality', $formSubmission->nationality?? '')}}"
                    placeholder="Enter nationality" required {{ $readOnly ? 'disabled' : '' }}>
                </div>
            </div>

            <div class="text-end mt-4">
                <button type="button" class="btn step1-next-btn" onclick="nextStep(2)">Next</button>
            </div>
        </div>
    </div>

    {{-- Guardian Information --}}

    <div id="step2" style="display: none;">
        <div class="step-form">
            <div class="form-section">
                <label class="fw-semibold">Guardian's Name<span class="text-danger">*</span></label>
                <p class="text-muted">Example: James E. Joseph</p>

                <div class="form-row">
                    <div class="form-col">
                        <label>First Name</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('guardian_fname', $formSubmission->guardian_fname ?? '') }}" disabled>
                            <input type="hidden" name="guardian_fname" value="{{ old('guardian_fname', $formSubmission->guardian_fname ?? '') }}">
                        @elseif (in_array('guardian_fname', $readOnlyFields ?? []))
                            <input type="text" name="guardian_fname" value="{{ old('guardian_fname', $formSubmission->guardian_fname ?? '') }}" readonly>
                        @endif
                    </div>
                    <div class="form-col">
                        <label>Middle Initial</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('guardian_mname', $formSubmission->guardian_mname ?? '') }}" disabled>
                            <input type="hidden" name="guardian_mname" value="{{ old('guardian_mname', $formSubmission->guardian_mname ?? '') }}">
                        @elseif (in_array('guardian_mname', $readOnlyFields ?? []))
                            <input type="text" name="guardian_mname" value="{{ old('guardian_mname', $formSubmission->guardian_mname ?? '') }}" readonly>
                        @endif
                    </div>
                    <div class="form-col">
                        <label>Last Name</label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('guardian_lname', $formSubmission->guardian_lname ?? '') }}" disabled>
                            <input type="hidden" name="guardian_lname" value="{{ old('guardian_lname', $formSubmission->guardian_lname ?? '') }}">
                        @elseif (in_array('guardian_lname', $readOnlyFields ?? []))
                            <input type="text" name="guardian_lname" value="{{ old('guardian_lname', $formSubmission->guardian_lname ?? '') }}" readonly>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label>Guardian's Email<span class="text-danger">*</span></label>
                        @if ($readOnly)
                            <input type="email" value="{{ old('guardian_email', $formSubmission->guardian_email ?? '') }}" disabled>
                            <input type="hidden" name="guardian_email" value="{{ old('guardian_email', $formSubmission->guardian_email ?? '') }}">
                        @elseif (in_array('guardian_email', $readOnlyFields ?? []))
                            <input type="email" name="guardian_email" value="{{ old('guardian_email', $formSubmission->guardian_email ?? '') }}" readonly>
                        @endif
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label>Guardian's Contact Number<span class="text-danger">*</span></label>
                        <input type="tel" name="guardian_contact_number" placeholder="09XXXXXXXXX" required value="{{ $formSubmission->guardian_contact_number ?? '' }}" {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-col">
                        <label>How are you related to the applicant?<span class="text-danger">*</span></label>
                        <select name="relation" required {{ $readOnly ? 'disabled' : '' }}>
                            <option value="">Select Option</option>
                            <option value="Parents" {{ (isset($formSubmission->relation) && $formSubmission->relation == 'Parents') ? 'selected' : '' }}>Parents</option>
                            <option value="Brother/Sister" {{ (isset($formSubmission->relation) && $formSubmission->relation == 'Brother/Sister') ? 'selected' : '' }}>Brother/Sister</option>
                            <option value="Uncle/Aunt" {{ (isset($formSubmission->relation) && $formSubmission->relation == 'Uncle/Aunt') ? 'selected' : '' }}>Uncle/Aunt</option>
                            <option value="Cousin" {{ (isset($formSubmission->relation) && $formSubmission->relation == 'Cousin') ? 'selected' : '' }}>Cousin</option>
                            <option value="Grandparents" {{ (isset($formSubmission->relation) && $formSubmission->relation == 'Grandparents') ? 'selected' : '' }}>Grandparents</option>
                        </select>
                    </div>
                </div>

            </div>

            <div class="form-row">
                <div class="form-col">
                    <div class="text-start">
                        <button type="button" class="btn step1-back-btn" onclick="nextStep(1)">Back</button>
                    </div>
                </div>
                <div class="form-col">
                    <div class="text-end">
                        <button type="button" class="btn step1-next-btn" onclick="nextStep(3)">Next</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- School Information --}}

    <div id="step3" style="display: none;">
        <div class="step-form">
            <div class="form-section">
                <div class="form-row">
                    <div class="form-col">
                        <label>Current School<span class="text-danger">*</span></label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('current_school', $formSubmission->current_school ?? '') }}" disabled>
                            <input type="hidden" name="current_school" value="{{ old('current_school', $formSubmission->current_school ?? '') }}">
                        @elseif (in_array('current_school', $readOnlyFields ?? []))
                            <input type="text" name="current_school" value="{{ old('current_school', $formSubmission->current_school ?? '') }}" readonly>
                        @endif
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label class="form-label">Current School City<span class="text-danger">*</span></label>
                        <div class="autocomplete-wrapper">
                            <input type="text" name="current_school_city" id="current_school_city"
                                value="{{ $formSubmission->current_school_city ?? '' }}"
                                class="form-control custom-input"
                                placeholder="Enter current school city" autocomplete="off" required {{ $readOnly ? 'disabled' : '' }}>
                            <ul id="citySuggestions" class="custom-suggestions"></ul>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label>School Type<span class="text-danger">*</span></label>
                        <select name="school_type" required {{ $readOnly ? 'disabled' : '' }}>
                            <option value="">Select</option>
                            <option value="Public" {{ (isset($formSubmission) && $formSubmission->school_type == 'Public') ? 'selected' : '' }}>Public</option>
                            <option value="Private Sectarian" {{ (isset($formSubmission) && $formSubmission->school_type == 'Private Sectarian') ? 'selected' : '' }}>Private Sectarian</option>
                            <option value="Private Non-Sectarian" {{ (isset($formSubmission) && $formSubmission->school_type == 'Private Non-Sectarian') ? 'selected' : '' }}>Private Non-Sectarian</option>
                        </select>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <label>Educational Level<span class="text-danger">*</span></label>            
                        @if ($readOnly)
                        <input type="text" value="{{ old('educational_level', $formSubmission->educational_level ?? '') }}" disabled>
                        <input type="hidden" name="educational_level" value="{{ old('educational_level', $formSubmission->educational_level ?? '') }}">
                        @else
                            <input type="text" name="educational_level" value="{{ old('educational_level', $formSubmission->educational_level ?? '') }}" readonly>
                        @endif 
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col" id="grade-level-container" style="display: none;">
                        <label>Incoming Grade Level<span class="text-danger">*</span></label>
                        @if ($readOnly)
                            <input type="text" value="{{ old('incoming_grlvl', $formSubmission->incoming_grlvl ?? '') }}" disabled>
                            <input type="hidden" name="incoming_grlvl" value="{{ old('incoming_grlvl', $formSubmission->incoming_grlvl ?? '') }}">
                        @else
                            <input type="text" name="incoming_grlvl" value="{{ old('incoming_grlvl', $formSubmission->incoming_grlvl ?? '') }}" readonly>
                        @endif
                    </div>
                </div>
                <div class="form-row" id="strand-container" style="display: none;">
                    <div class="form-col">
                        <label>Strand<span class="text-danger">*</span></label>
                        <select name="strand" id="strand" {{ $readOnly ? 'disabled' : '' }}>
                        <option value="">Select</option>
                        <option value="STEM Health Allied" {{ (session('recommended_strand') === 'STEM Health Allied' || (isset($formSubmission) && $formSubmission->strand == 'STEM Health Allied')) ? 'selected' : '' }}>STEM Health Allied</option>
                        <option value="STEM Engineering" {{ (session('recommended_strand') === 'STEM Engineering' || (isset($formSubmission) && $formSubmission->strand == 'STEM Engineering')) ? 'selected' : '' }}>STEM Engineering</option>
                        <option value="STEM Information Technology" {{ (session('recommended_strand') === 'STEM Information Technology' || (isset($formSubmission) && $formSubmission->strand == 'STEM Information Technology')) ? 'selected' : '' }}>STEM Information Technology</option>
                        <option value="ABM Accountancy" {{ (session('recommended_strand') === 'ABM Accountancy' || (isset($formSubmission) && $formSubmission->strand == 'ABM Accountancy')) ? 'selected' : '' }}>ABM Accountancy</option>
                        <option value="ABM Business Management" {{ (session('recommended_strand') === 'ABM Business Management' || (isset($formSubmission) && $formSubmission->strand == 'ABM Business Management')) ? 'selected' : '' }}>ABM Business Management</option>
                        <option value="HUMSS" {{ (session('recommended_strand') === 'HUMSS' || (isset($formSubmission) && $formSubmission->strand == 'HUMSS')) ? 'selected' : '' }}>HUMSS</option>
                        <option value="GAS" {{ (session('recommended_strand') === 'GAS' || (isset($formSubmission) && $formSubmission->strand == 'GAS')) ? 'selected' : '' }}>GAS</option>
                        <option value="SPORTS" {{ (session('recommended_strand') === 'SPORTS' || (isset($formSubmission) && $formSubmission->strand == 'SPORTS')) ? 'selected' : '' }}>SPORTS</option>
                    </select>

                    </div>
                </div>
                <div class="form-row" id="birthday-container" style="display: none; margin-bottom: 2.1em;">
                    <div class="form-col">
                        <label>Birthday<span class="text-danger">*</span></label>
                        <span class="text-muted">For Kinder to Grade 1 applicants, the student must be 5 years old by October {{ now()->year }}</span>
                        <input type="date" name="applicant_bday" id="applicant_bday"  palceholder ="Select a Date" value="{{ $formSubmission->applicant_bday ?? '' }}" {{ $readOnly ? 'disabled' : '' }}>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col">
                        <div id="lrn-container" style="display: none;">
                            <label>LRN Number</label>
                            <span class="text-muted">LRN is the Learner Reference Number that can be found on your Report Card, or School ID.</span>
                            <input type="text" name="lrn_no" id="lrn_no" value="{{ $formSubmission->lrn_no ?? '' }}" placeholder="Enter LRN number" {{ $readOnly ? 'disabled' : '' }}>
                        </div>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-col" id="source-container" style="display: none;">
                        <label>How did you hear about us?<span class="text-danger">*</span></label>
                        <select name="source" required {{ $readOnly ? 'disabled' : '' }}>
                            <option value="">Select</option>
                            <option value="Career Fair/Career Orientation" {{ (isset($formSubmission) && $formSubmission->source == 'Career Fair/Career Orientation') ? 'selected' : '' }}>Career Fair/Career Orientation</option>
                            <option value="Events" {{ (isset($formSubmission) && $formSubmission->source == 'Events') ? 'selected' : '' }}>Events</option>
                            <option value="Social Media (Facebook, TikTok, Instagram, Youtube, etc)" {{ (isset($formSubmission) && $formSubmission->source == 'Social Media (Facebook, TikTok, Instagram, Youtube, etc)') ? 'selected' : '' }}>Social Media</option>
                            <option value="Friends/Family/Relatives" {{ (isset($formSubmission) && $formSubmission->source == 'Friends/Family/Relatives') ? 'selected' : '' }}>Friends/Family/Relatives</option>
                            <option value="Billboard" {{ (isset($formSubmission) && $formSubmission->source == 'Billboard') ? 'selected' : '' }}>Billboard</option>
                            <option value="Website" {{ (isset($formSubmission) && $formSubmission->source == 'Website') ? 'selected' : '' }}>Website</option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div class="text-start">
                    <button type="button" class="btn step1-back-btn" onclick="nextStep(2)">Back</button>
                </div>
                </div>
                <div class="form-col">
                    <div class="text-end">    
                        @if(!$readOnly)
                        <button type="submit" class="btn btn-submit">Submit</button>
                    @endif
                </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection


<!---------------------------------------- STRAND RECOMMENDER MODALS AND SWEETALERTS ----------------------------------------------------------------------------->


@if ($showStrandModal && !session('strand_modal_shown') && empty($applicant->recommended_strand))
    @php
        session(['strand_modal_shown' => true]); // ipakita lang once per session
    @endphp
    <script>
        //script for modal auto load
        document.addEventListener('DOMContentLoaded', function () {
            Swal.fire({
                title: 'Need help choosing your strand?',
                text: 'If you are undecided on your strand, why not try a set of questions to see our recommendations?',
                icon: 'question',
                showCancelButton: true,
                confirmButtonText: 'Yes, answer now',
                cancelButtonText: 'No, maybe later',
                confirmButtonColor: '#28a745'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('strand.recommender') }}";
                }
            });
        });
    </script>
@endif


<!-- Strand breakdown modal display -->
@if (isset($applicant->strand_breakdown))
    @php
        $breakdown = json_decode($applicant->strand_breakdown, true);
    @endphp
    <div class="modal fade" id="scoreBreakdownModal" tabindex="-1" aria-labelledby="scoreBreakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content rounded">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold" id="scoreBreakdownModalLabel">Strand Breakdown</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-unstyled">
                        @foreach ($breakdown as $strand => $percent)
                            <li><strong>{{ strtoupper($strand) }}</strong> – {{ $percent }}%</li>
                        @endforeach
                    </ul>
                    <p class="text-muted small mt-3">*Only main strands are included in this breakdown. Sub-strands are considered separately.</p>
                </div>
            </div>
        </div>
    </div>
@endif








