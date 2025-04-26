@csrf

<div id="alert-wrapper">
    <div id="alert-container"></div>
</div>

{{-- Appicant Information --}}

<div id="step1">
    <div class="step-form">
        <div class="form-section">
            <label class="fw-semibold">Applicant's Name<span class="text-danger">*</span></label>
            <p class="text-muted">Example: James E. Joseph</p>

            <div class="form-row">
                <div class="form-col">
                    <label>First Name</label>
                    <input type="text" name="applicant_fname" placeholder="Enter first name" required>
                </div>
                <div class="form-col">
                    <label>Middle Initial</label>
                    <input type="text" name="applicant_mname" placeholder="Enter middle initial">
                </div>
                <div class="form-col">
                    <label>Last Name</label>
                    <input type="text" name="applicant_lname" placeholder="Enter last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Applicant's Contact Number<span class="text-danger">*</span></label>
                    <input type="tel" name="applicant_contact_number" placeholder="09XXXXXXXXX" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Applicant's Email Address<span class="text-danger">*</span></label>
                    <input type="email" name="applicant_email" placeholder="Enter email address" required>
                </div>
            </div>
        </div>

        <div class="form-section">
            <label class="fw-semibold">Home Address<span class="text-danger">*</span></label>

            <div class="form-row">
                <div class="form-col">
                    <label class="text-muted">Building Number, Street Name</label>
                    <input type="text" name="numstreet" placeholder="Enter bldg number, street name" required>
                </div>
                <div class="form-col">
                    <label class="text-muted">Region</label>
                    <select name="region" id="region" required>
                        <option value="">Choose Region</option>
                    </select>
                </div>
                <div class="form-col">
                    <label class="text-muted">Province</label>
                    <select name="province" id="province" required>
                        <option value="">Choose Province</option>
                    </select>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label class="text-muted">City</label>
                    <select name="city" id="city" required>
                        <option value="">Choose City</option>
                    </select>
                </div>
                <div class="form-col">
                    <label class="text-muted">Barangay</label>
                    <select name="barangay" id="barangay" required>
                        <option value="">Choose Barangay</option>
                    </select>
                </div>
                <div class="form-col">
                    <label class="text-muted">Postal Code</label>
                    <input type="number" name="postal_code" placeholder="Enter postal code" required>
                </div>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label>Age<span class="text-danger">*</span></label>
                <input type="number" name="age" placeholder="Enter age" required>
            </div>
            <div class="form-col">
                <label>Gender<span class="text-danger">*</span></label>
                <select name="gender" required>
                    <option value="">Select gender</option>
                    <option value="Male">Male</option>
                    <option value="Female">Female</option>
                </select>
            </div>
        </div>

        <div class="form-row">
            <div class="form-col">
                <label>Nationality<span class="text-danger">*</span></label>
                <input type="text" name="nationality" placeholder="Enter nationality" required>
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
                    <input type="text" name="guardian_fname" placeholder="Enter first name" required>
                </div>
                <div class="form-col">
                    <label>Middle Initial</label>
                    <input type="text" name="guardian_mname" placeholder="Enter middle name">
                </div>
                <div class="form-col">
                    <label>Last Name</label>
                    <input type="text" name="guardian_lname" placeholder="Enter last name" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Email<span class="text-danger">*</span></label>
                    <input type="email" name="guardian_email" placeholder="Enter email address" required>
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>Contact Number<span class="text-danger">*</span></label>
                    <input type="tel" name="guardian_contact_number" placeholder="09XXXXXXXXX" required>  
                </div>
            </div>

            <div class="form-row">
                <div class="form-col">
                    <label>How are you related to the applicant?<span class="text-danger">*</span></label>
                    <select name="relation" required>
                        <option value="">Select Option</option>
                        <option value="Parents">Parents</option>
                        <option value="Brother/Sister">Brother/Sister</option>
                        <option value="Uncle/Aunt">Uncle/Aunt</option>
                        <option value="Cousin">Cousin</option>
                        <option value="Grandparents">Grandparents</option>
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
                    <input type="text" name="current_school" placeholder="Enter current school" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label class="form-label">Current School City</label>
                    <div class="autocomplete-wrapper">
                        <input type="text" name="current_school_city" id="current_school_city"
                               class="form-control custom-input"
                               placeholder="Enter current school city" autocomplete="off" required>
                        <ul id="citySuggestions" class="custom-suggestions"></ul>
                    </div>
                </div>
                
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label>School Type<span class="text-danger">*</span></label>
                    <select name="school_type" required>
                        <option value="">Select</option>
                        <option value="Private">Private</option>
                        <option value="Public">Public</option>
                        <option value="Private Sectarian">Private Sectarian</option>
                        <option value="Private Non-Sectarian">Private Non-Sectarian</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <label>Educational Level<span class="text-danger">*</span></label>
                    <select name="educational_level" id="educational_level" required>
                        <option value="">Select</option>
                        <option value="Grade School">Grade School</option>
                        <option value="Junior High School">Junior High School</option>
                        <option value="Senior High School">Senior High School</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col" id="grade-level-container" style="display: none;">
                    <label>Incoming Grade Level<span class="text-danger">*</span></label>
                    <select name="incoming_grlvl" id="incoming_grlvl" required></select>
                    <div class="form-col">
                        <div id="strand-container" style="display: none;">
                            <label>Strand</label>
                            <select name="strand" id="strand">
                                <option value="">Select</option>
                                <option value="STEM Health Allied">STEM Health Allied</option>
                                <option value="STEM Engineering">STEM Engineering</option>
                                <option value="STEM Information Technology">STEM Information Technology</option>
                                <option value="ABM Accountancy">ABM Accountancy</option>
                                <option value="ABM Business Management">ABM Business Management</option>
                                <option value="HUMSS">HUMSS</option>
                                <option value="GAS">GAS</option>
                                <option value="SPORTS">SPORTS</option>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="form-col">
                    <div id="birthday-container" style="display: none;">
                        <label>Birthday<span class="text-danger">*</span></label>
                        <input type="date" name="applicant_bday" id="applicant_bday">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-col">
                    <div id="lrn-container" style="display: none;">
                        <label>LRN Number</label>
                        <span class="text-muted">LRN is the Learner Reference Number that can be found on your Report Card, or School ID.</span>
                        <input type="text" name="lrn_no" id="lrn_no" placeholder="Enter LRN number">
                    </div>
                </div>
            </div>
            <div class="form-row">
                <div class="form-row" id="source-container" style="display: none;">
                    <label>How did you hear about us?<span class="text-danger">*</span></label>
                    <select name="source" required>
                        <option value="">Select</option>
                        <option value="Career Fair/Career Orientation">Career Fair/Career Orientation</option>
                        <option value="Events">Events</option>
                        <option value="Social Media (Facebook, TikTok, Instagram, Youtube, etc)">Social Media</option>
                        <option value="Friends/Family/Relatives">Friends/Family/Relatives</option>
                        <option value="Billboard">Billboard</option>
                        <option value="Website">Website</option>
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
                <button type="submit" class="btn btn-submit">Submit</button>
            </div>
            </div>
        </div>
    </div>
</div>

