document.addEventListener("DOMContentLoaded", function () {
    const applicantSection = document.getElementById("applicant");
    const guardianSection = document.getElementById("guardian");
    const schoolSection = document.getElementById("school_info");

    // Next buttons for step navigation (Applicant -> Guardian -> School Info)
    const nextButtons = document.querySelectorAll("button[type='button']");
    const steps = [applicantSection, guardianSection, schoolSection];

    nextButtons.forEach((btn, idx) => {
        btn.addEventListener("click", function (e) {
            e.preventDefault();

            const requiredInputs = steps[idx].querySelectorAll("input[required], select[required]");
            let allFilled = true;
            requiredInputs.forEach(input => {
                if (!input.value.trim()) {
                    allFilled = false;
                    input.classList.add("missing");
                } else {
                    input.classList.remove("missing");
                }
            });
            
            if (allFilled) {
                steps[idx].classList.add("hidden");
                if (steps[idx + 1]) {
                    steps[idx + 1].classList.remove("hidden");
                }
            } else {
                alert("Please fill out all required fields before proceeding.");
            }
        });
    });


    const eduLevel = document.getElementById("educational_level");
    const gs = document.getElementById("gs");
    const jhs = document.getElementById("jhs");
    const shs = document.getElementById("shs");

    
    gs.style.display = "none";
    jhs.style.display = "none";
    shs.style.display = "none";

    eduLevel.addEventListener("change", function () {
        const level = this.value;

        gs.style.display = "none";
        jhs.style.display = "none";
        shs.style.display = "none";

        if (level === "Grade School") {
            gs.style.display = "block";
        } else if (level === "Junior High School") {
            jhs.style.display = "block";
        } else if (level === "Senior High School") {
            shs.style.display = "block";
        }
    });

    // Grade School birthday logic
    const gradeLevelDropdown = document.getElementById("incoming_grlvl");
    const birthdayContainer = document.getElementById("birthday-container");
    const birthdayField = document.getElementById("applicant_bday");

    
    birthdayContainer.style.display = "none"; 

    gradeLevelDropdown.addEventListener("change", function () {
        const selected = this.value;
        // If Kinder or Grade 1, show birthday container; otherwise, hide it.
        if (selected === "Kinder" || selected === "Grade 1") {
            birthdayContainer.style.display = "block";
            birthdayField.required = true;
        } else {
            birthdayContainer.style.display = "none";
            birthdayField.required = false;
        }
    });
});
