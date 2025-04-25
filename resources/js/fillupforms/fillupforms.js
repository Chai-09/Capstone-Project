document.addEventListener("DOMContentLoaded", function () {
    const levelSelect = document.getElementById("educational_level");
    const gradeSelect = document.getElementById("incoming_grlvl");
    const birthday = document.getElementById("birthday-container");
    const birthdayField = document.getElementById("applicant_bday");
    const lrn = document.getElementById("lrn-container");
    const lrnField = document.getElementById("lrn_no");
    const strand = document.getElementById("strand-container");
    const strandField = document.getElementById("strand");

    const gradeLevelContainer = document.getElementById("grade-level-container");
    gradeLevelContainer.style.display = "none";

    const sourceContainer = document.getElementById("source-container");
    sourceContainer.style.display = "none";



    const gradeOptions = {
        "Grade School": ['Kinder','Grade 1','Grade 2','Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'],
        "Junior High School": ['Grade 7','Grade 8','Grade 9', 'Grade 10'],
        "Senior High School": ['Grade 11','Grade 12']
    };

    function populateGrades(level) {
        gradeSelect.innerHTML = '<option value="">Select Grade Level</option>';
        
        if (gradeOptions[level]) {
            gradeOptions[level].forEach(grade => {
                const option = document.createElement("option");
                option.value = grade;
                option.textContent = grade;
                gradeSelect.appendChild(option);
            });         
        } 
    }
    
    levelSelect.addEventListener("change", function () {
        const level = this.value;

        populateGrades(level);

        if (gradeOptions[level]) {
            gradeLevelContainer.style.display = "block";
            sourceContainer.style.display = "block";
        } else {
            gradeLevelContainer.style.display = "none";
            sourceContainer.style.display = "none";
        }
        
        // Hide + clear all conditional fields
        birthday.style.display = "none";
        birthdayField.required = false;
        birthdayField.disabled = true;
        birthdayField.value = "";

        lrn.style.display = "none";
        lrnField.required = false;
        lrnField.disabled = true;
        lrnField.value = "";

        strand.style.display = "none";
        strandField.required = false;
        strandField.disabled = true;
        strandField.value = "";

        // Show relevant fields
        if (level === "Grade School" || level === "Junior High School") {
            lrn.style.display = "block";
            lrnField.disabled = false;
            lrnField.required = true;
        }

        if (level === "Senior High School") {
            lrn.style.display = "block";
            lrnField.disabled = false;
            lrnField.required = true;
            strand.style.display = "block";
            strandField.disabled = false;
            strandField.required = true;
        }
    });

    gradeSelect.addEventListener("change", function () {
        const selected = this.value;
        const level = levelSelect.value;

        if (level === "Grade School" && (selected === "Kinder" || selected === "Grade 1")) {
            birthday.style.display = "block";
            birthdayField.disabled = false;
            birthdayField.required = true;
        } else {
            birthday.style.display = "none";
            birthdayField.disabled = true;
            birthdayField.required = false;
            birthdayField.value = "";
        }
    });
});

function showFormError(message) {
    const alertContainer = document.getElementById('alert-container');

    // Clear existing alerts
    const existing = document.querySelector('.alert-box');
    if (existing) existing.remove();

    const errorBox = document.createElement('div');
    errorBox.classList.add('alert-box');
    errorBox.innerHTML = `
        <div class="alert-content">
            <div class="alert-message">
                <span><i class="fa-solid fa-circle-exclamation"></i> ${message}</span>
            </div>
            <span class="alert-close" onclick="this.parentElement.parentElement.remove()">&times;</span>
        </div>
    `;

    alertContainer.appendChild(errorBox);
}

// Step switching and validation
window.nextStep = function (step) {
    // Validate only when going forward
    if (step > 1) {
        const currentStepFields = document.querySelectorAll(`#step${step-1} [required]`);
        let allValid = true;

        currentStepFields.forEach(field => {
            const value = field.value.trim();
            if (!value) {
                allValid = false;
                field.classList.add('border-danger');
            } else {
                field.classList.remove('border-danger');
            }
        });

        if (!allValid) {
            showFormError('Please complete all required fields before proceeding.');
            return;
        }
    }

    // Hide all steps
    document.querySelectorAll("#step1, #step2, #step3").forEach(div => {
        div.style.display = "none";
    });

    // Show current step
    document.getElementById("step" + step).style.display = "block";

    // ✨ Remove alert if visible
    const alertBox = document.querySelector('.alert-box');
    if (alertBox) alertBox.remove();

    // ✨ Remove red borders
    document.querySelectorAll('input, select').forEach(field => {
        field.classList.remove('border-danger');
    });
};

