@csrf


<div id="step1">
    <h4>Step 1 of 3: Applicant Information</h4>

    <p>First Name</p>
    <input type="text" name="applicant_fname" required>

    <p>Middle Initial</p>
    <input type="text" name="applicant_mname">

    <p>Last Name</p>
    <input type="text" name="applicant_lname" required>

    <p>Contact Number</p>
    <input type="tel" name="applicant_contact_number" required>

    <p>Email</p>
    <input type="email" name="applicant_email" required>

    <p>Region</p>
    <select name="region" id="region" required></select>

    <p>Province</p>
    <select name="province" id="province" required></select>

    <p>City</p>
    <select name="city" id="city" required></select>

    <p>Barangay</p>
    <select name="barangay" id="barangay" required></select>

    <p>Street & Number</p>
    <input type="text" name="numstreet" required>

    <p>Postal Code</p>
    <input type="number" name="postal_code" required>

    <p>Age</p>
    <input type="number" name="age" required>

    <p>Gender</p>
    <select name="gender" required>
        <option value="">Select</option>
        <option value="Male">Male</option>
        <option value="Female">Female</option>
    </select>

    <p>Nationality</p>
    <input type="text" name="nationality" required>

    <button type="button" class="btn btn-primary mt-3" onclick="nextStep(2)">Next</button>
</div>

<div id="step2" style="display: none;">
    <h4>Step 2 of 3: Guardian Information</h4>

    <p>First Name</p>
    <input type="text" name="guardian_fname" required>

    <p>Middle Initial</p>
    <input type="text" name="guardian_mname">

    <p>Last Name</p>
    <input type="text" name="guardian_lname" required>

    <p>Contact Number</p>
    <input type="tel" name="guardian_contact_number" required>

    <p>Email</p>
    <input type="email" name="guardian_email" required>

    <p>Relation</p>
    <select name="relation" required>
        <option value="">Select</option>
        <option value="Parents">Parents</option>
        <option value="Brother/Sister">Brother/Sister</option>
        <option value="Uncle/Aunt">Uncle/Aunt</option>
        <option value="Cousin">Cousin</option>
        <option value="Grandparents">Grandparents</option>
    </select>

    <button type="button" class="btn btn-secondary" onclick="nextStep(1)">Back</button>
    <button type="button" class="btn btn-primary" onclick="nextStep(3)">Next</button>
</div>

<div id="step3" style="display: none;">
    <h4>Step 3 of 3: School Information</h4>

    <p>Current School</p>
    <input type="text" name="current_school" required>

    <p>Current School City</p>
    <input type="text" name="current_school_city" required>

    <p>School Type</p>
    <select name="school_type" required>
        <option value="">Select</option>
        <option value="Private">Private</option>
        <option value="Public">Public</option>
        <option value="Private Sectarian">Private Sectarian</option>
        <option value="Private Non-Sectarian">Private Non-Sectarian</option>
    </select>

    <p>Educational Level</p>
    <select name="educational_level" id="educational_level" required>
        <option value="">Select</option>
        <option value="Grade School">Grade School</option>
        <option value="Junior High School">Junior High School</option>
        <option value="Senior High School">Senior High School</option>
    </select>

    <p>Incoming Grade Level</p>
    <select name="incoming_grlvl" id="incoming_grlvl" required></select>

    <div id="birthday-container" style="display: none;">
        <p>Birthday</p>
        <input type="date" name="applicant_bday" id="applicant_bday">
    </div>

    <div id="lrn-container" style="display: none;">
        <p>LRN Number</p>
        <input type="text" name="lrn_no" id="lrn_no">
    </div>

    <div id="strand-container" style="display: none;">
        <p>Strand</p>
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

    <p>How did you hear about us?</p>
    <select name="source" required>
        <option value="">Select</option>
        <option value="Career Fair/Career Orientation">Career Fair/Career Orientation</option>
        <option value="Events">Events</option>
        <option value="Social Media (Facebook, TikTok, Instagram, Youtube, etc)">Social Media</option>
        <option value="Friends/Family/Relatives">Friends/Family/Relatives</option>
        <option value="Billboard">Billboard</option>
        <option value="Website">Website</option>
    </select>

    <button type="button" class="btn btn-secondary" onclick="nextStep(2)">Back</button>
    <button type="submit" class="btn btn-success">Submit</button>
</div>
