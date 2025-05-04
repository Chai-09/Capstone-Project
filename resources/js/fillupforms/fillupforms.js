document.addEventListener('DOMContentLoaded', function () {
    const educationalLevelInput = document.querySelector('input[name="educational_level"]'); // readonly input
    const incomingGradeInput = document.querySelector('input[name="incoming_grlvl"]'); // readonly input

    const strandContainer = document.getElementById('strand-container');
    const birthdayContainer = document.getElementById('birthday-container');
    const lrnContainer = document.getElementById('lrn-container');
    const sourceContainer = document.getElementById('source-container');
    const gradeLevelContainer = document.getElementById('grade-level-container');

    function updateVisibility() {
        const level = (educationalLevelInput?.value || "").trim();
        const grade = (incomingGradeInput?.value || "").trim();

        
        gradeLevelContainer.style.display = 'none';
        sourceContainer.style.display = 'none';
        strandContainer.style.display = 'none';
        birthdayContainer.style.display = 'none';
        lrnContainer.style.display = 'none';

        if (!level) return;

        gradeLevelContainer.style.display = 'block';
        sourceContainer.style.display = 'block';

        if (level === "Grade School") {
            lrnContainer.style.display = 'block';
            if (grade === "KINDER" || grade === "GRADE 1") {
                birthdayContainer.style.display = 'block';
            }
        } else if (level === "Junior High School") {
            lrnContainer.style.display = 'block';
        } else if (level === "Senior High School") {
            lrnContainer.style.display = 'block';
            strandContainer.style.display = 'block';
        }
    }

    updateVisibility(); 

    educationalLevelSelect.addEventListener('change', function () {
        const level = (educationalLevelSelect?.value || educationalLevelInput?.value || "").trim();
        populateGrades(level);  
        updateVisibility();
    });

    incomingGradeLevelSelect.addEventListener('change', function () {
        updateVisibility();
    });

    const levelInit = (educationalLevelSelect?.value || educationalLevelInput?.value || "").trim();
    if (incomingGradeLevelSelect?.tagName === 'SELECT') {
        populateGrades(levelInit);
    }
    updateVisibility();
    
});


// Step 1 Validation
function showFormError(message) {
    const alertContainer = document.getElementById('alert-container');
    const alertWrapper = document.getElementById('alert-wrapper');

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
    alertWrapper.style.display = "block"
    alertContainer.style.display = "block";
    alertContainer.appendChild(errorBox);
}

// Step switching and validation
window.nextStep = function (step) {
    if (step > 1) {
        const currentStepFields = document.querySelectorAll(`#step${step-1} [required]`);
        let allValid = true;

        currentStepFields.forEach(field => {
            const value = field.value.trim();
            const type = field.getAttribute('type');

            if (!value) {
                allValid = false;
                field.classList.add('border-danger');
                showFormError('Please complete all required fields.');
                return;
            }

            if (type === 'email') {
                const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailPattern.test(value)) {
                    allValid = false;
                    field.classList.add('border-danger');
                    showFormError('Please enter a valid email address (e.g., name@example.com).');
                    return;
                }
            }

            if (type === 'tel') {
                const phonePattern = /^09\d{9}$/;
                if (!phonePattern.test(value)) {
                    allValid = false;
                    field.classList.add('border-danger');
                    showFormError('Please enter a valid phone number starting with 09 followed by 9 digits.');
                    return;
                }
            }

            if (type === 'number') {
                if (isNaN(value) || value < 0) {
                    allValid = false;
                    field.classList.add('border-danger');
                    showFormError('Please enter a valid numeric value.');
                    return;
                }
            }

            // If everything okay for this field
            field.classList.remove('border-danger');
        });

        if (!allValid) {
            return; // Already shown the error inside the loop
        }
    }

    // If all fields valid → continue to next step
    document.querySelectorAll("#step1, #step2, #step3").forEach(div => {
        div.style.display = "none";
    });

    document.getElementById("step" + step).style.display = "block";

    // Remove alert if moving to next step
    const alertBox = document.querySelector('.alert-box');
    if (alertBox) alertBox.remove();

    document.querySelectorAll('input, select').forEach(field => {
        field.classList.remove('border-danger');
    });
};


document.addEventListener('DOMContentLoaded', function () {
    const input = document.getElementById('current_school_city');
    const suggestionBox = document.getElementById('citySuggestions');

    if (!input || !suggestionBox) return;

    let provinces = [];

    // Fetch province list once
    fetch('https://psgc.gitlab.io/api/provinces/')
        .then(res => res.json())
        .then(data => {
            provinces = data;
        })
        .catch(err => console.error('Failed to load provinces:', err));

    input.addEventListener('input', async function () {
        const keyword = input.value.trim().toLowerCase();
        suggestionBox.innerHTML = '';

        if (keyword.length < 2) return;

        try {
            const res = await fetch('https://psgc.gitlab.io/api/cities-municipalities/');
            const cities = await res.json();

            const filtered = [];

            for (const city of cities) {
                if (city.name.toLowerCase().includes(keyword)) {
                    let provinceName = 'Unknown Province';

                    if (!city.provinceCode) {
                        provinceName = 'Metro Manila'; // For NCR cities
                    } else {
                        const provinceMatch = provinces.find(p => p.code === city.provinceCode);
                        if (provinceMatch) {
                            provinceName = provinceMatch.name;
                        }
                    }

                    filtered.push(`${city.name}, ${provinceName}`);
                }
            }

            if (filtered.length === 0) {
                suggestionBox.innerHTML = `<li class="list-group-item disabled">No results found</li>`;
            } else {
                filtered.forEach(fullLocation => {
                    const li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.textContent = fullLocation;
                    li.style.cursor = 'pointer';
                    li.onclick = () => {
                        input.value = fullLocation;
                        suggestionBox.innerHTML = '';
                    };
                    suggestionBox.appendChild(li);
                });
            }
        } catch (err) {
            console.error('City fetch error:', err);
        }
    });

    document.addEventListener('click', (e) => {
        if (!suggestionBox.contains(e.target) && e.target !== input) {
            suggestionBox.innerHTML = '';
        }
    });
});
