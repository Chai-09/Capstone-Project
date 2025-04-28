@csrf

<div id="alert-wrapper">
    <div id="alert-container"></div>
</div>

{{-- Applicant Information --}}

<div id="step1">
    <div class="step-form">
        <div class="form-section">
            <label class="fw-semibold">Applicant's Name<span class="text-danger">*</span></label>
            <p class="text-muted">Example: James E. Joseph</p>

            <div class="form-row">
                <div class="form-col">
                    <label>First Name</label>
                    <input type="text" name="applicant_fname" value="{{ old ('applicant_fname', $formSubmission->applicant_fname ?? '') }}" placeholder="Enter first name" required {{ $readOnly ? 'readonly' : '' }}>
                </div>
                <div class="form-col">
                    <label>Middle Initial</label>
                    <input type="text" name="applicant_mname" value="{{ old('applicant_mname', $formSubmission->applicant_mname ?? '') }}" placeholder="Enter middle initial" {{ $readOnly ? 'readonly' : '' }}>
                </div>
                <div class="form-col">
                    <label>Last Name</label>
                    <input type="text" name="applicant_lname" value="{{ old('applicant_lname', $formSubmission->applicant_lname ?? '') }}" placeholder="Enter last name" required {{ $readOnly ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Applicant's Contact Number<span class="text-danger">*</span></label>
                    <input type="tel" name="applicant_contact_number" value="{{ old('applicant_contact_number', $formSubmission->applicant_contact_number ?? '') }}" placeholder="09XXXXXXXXX" required {{ $readOnly ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Applicant's Email Address<span class="text-danger">*</span></label>
                    <input type="email" name="applicant_email" value="{{ old('applicant_email', $formSubmission->applicant_email ?? '') }}" placeholder="Enter email address" required {{ $readOnly ? 'readonly' : '' }}>
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
                    placeholder="Enter bldg number, street name" required {{ $readOnly ? 'readonly' : '' }}>
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
                placeholder="Enter nationality" required {{ $readOnly ? 'readonly' : '' }}>
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
                    <input type="text" name="guardian_fname" placeholder="Enter first name" required value="{{ $formSubmission->guardian_fname ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
                </div>
                <div class="form-col">
                    <label>Middle Initial</label>
                    <input type="text" name="guardian_mname" placeholder="Enter middle name" value="{{ $formSubmission->guardian_mname ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
                </div>
                <div class="form-col">
                    <label>Last Name</label>
                    <input type="text" name="guardian_lname" placeholder="Enter last name" required value="{{ $formSubmission->guardian_lname ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Email<span class="text-danger">*</span></label>
                    <input type="email" name="guardian_email" placeholder="Enter email address" required value="{{ $formSubmission->guardian_email ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Contact Number<span class="text-danger">*</span></label>
                    <input type="tel" name="guardian_contact_number" placeholder="09XXXXXXXXX" required value="{{ $formSubmission->guardian_contact_number ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
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
                    <input type="text" name="current_school" value="{{ $formSubmission->current_school ?? '' }}" placeholder="Enter current school" required {{ $readOnly ? 'readonly' : '' }}>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label">Current School City</label>
                    <div class="autocomplete-wrapper">
                        <input type="text" name="current_school_city" id="current_school_city"
                               value="{{ $formSubmission->current_school_city ?? '' }}"
                               class="form-control custom-input"
                               placeholder="Enter current school city" autocomplete="off" required {{ $readOnly ? 'readonly' : '' }}>
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
                    <select name="educational_level" id="educational_level" required {{ $readOnly ? 'disabled' : '' }}>
                        <option value="">Select</option>
                        <option value="Grade School" {{ (isset($formSubmission) && $formSubmission->educational_level == 'Grade School') ? 'selected' : '' }}>Grade School</option>
                        <option value="Junior High School" {{ (isset($formSubmission) && $formSubmission->educational_level == 'Junior High School') ? 'selected' : '' }}>Junior High School</option>
                        <option value="Senior High School" {{ (isset($formSubmission) && $formSubmission->educational_level == 'Senior High School') ? 'selected' : '' }}>Senior High School</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col" id="grade-level-container" style="display: none;">
                    <label>Incoming Grade Level<span class="text-danger">*</span></label>
                    <span class="text-muted">For Kinder applicants, the student must be 5 years old by October {{ now()->year }}</span>
                    <select name="incoming_grlvl" id="incoming_grlvl" required {{ $readOnly ? 'disabled' : '' }}>
                        @if(isset($formSubmission))
                            <option value="{{ $formSubmission->incoming_grlvl }}" selected>{{ $formSubmission->incoming_grlvl }}</option>
                        @else
                            <option value="">Select Grade Level</option>
                        @endif
                    </select>
                    <div class="form-col">
                        <div id="strand-container" style="display: none;">
                            <label>Strand</label>
                            <select name="strand" id="strand" {{ $readOnly ? 'disabled' : '' }}>
                                <option value="">Select</option>
                                <option value="STEM Health Allied" {{ (isset($formSubmission) && $formSubmission->strand == 'STEM Health Allied') ? 'selected' : '' }}>STEM Health Allied</option>
                                <option value="STEM Engineering" {{ (isset($formSubmission) && $formSubmission->strand == 'STEM Engineering') ? 'selected' : '' }}>STEM Engineering</option>
                                <option value="STEM Information Technology" {{ (isset($formSubmission) && $formSubmission->strand == 'STEM Information Technology') ? 'selected' : '' }}>STEM Information Technology</option>
                                <option value="ABM Accountancy" {{ (isset($formSubmission) && $formSubmission->strand == 'ABM Accountancy') ? 'selected' : '' }}>ABM Accountancy</option>
                                <option value="ABM Business Management" {{ (isset($formSubmission) && $formSubmission->strand == 'ABM Business Management') ? 'selected' : '' }}>ABM Business Management</option>
                                <option value="HUMSS" {{ (isset($formSubmission) && $formSubmission->strand == 'HUMSS') ? 'selected' : '' }}>HUMSS</option>
                                <option value="GAS" {{ (isset($formSubmission) && $formSubmission->strand == 'GAS') ? 'selected' : '' }}>GAS</option>
                                <option value="SPORTS" {{ (isset($formSubmission) && $formSubmission->strand == 'SPORTS') ? 'selected' : '' }}>SPORTS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <div id="birthday-container" style="display: none;">
                        <label>Birthday<span class="text-danger">*</span></label>
                        <input type="date" name="applicant_bday" id="applicant_bday" value="{{ $formSubmission->applicant_bday ?? '' }}" {{ $readOnly ? 'readonly' : '' }}>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div id="lrn-container" style="display: none;">
                        <label>LRN Number</label>
                        <span class="text-muted">LRN is the Learner Reference Number that can be found on your Report Card, or School ID.</span>
                        <input type="text" name="lrn_no" id="lrn_no" value="{{ $formSubmission->lrn_no ?? '' }}" placeholder="Enter LRN number" {{ $readOnly ? 'readonly' : '' }}>
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-row" id="source-container" style="display: none;">
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

