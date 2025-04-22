document.addEventListener("DOMContentLoaded", function () {

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
