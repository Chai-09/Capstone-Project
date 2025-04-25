document.addEventListener("DOMContentLoaded", function () {
    const levelSelect = document.getElementById("educational_level");
    const gradeSelect = document.getElementById("incoming_grlvl");
    const birthday = document.getElementById("birthday-container");
    const birthdayField = document.getElementById("applicant_bday");
    const lrn = document.getElementById("lrn-container");
    const lrnField = document.getElementById("lrn_no");
    const strand = document.getElementById("strand-container");
    const strandField = document.getElementById("strand");

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

// Step switching
window.nextStep = function (step) {
    document.querySelectorAll("#step1, #step2, #step3").forEach(div => {
        div.style.display = "none";
    });
    document.getElementById("step" + step).style.display = "block";
};

