import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";

document.addEventListener('DOMContentLoaded', function () {
    const educationalLevelInput = document.querySelector('input[name="educational_level"]'); // readonly input
    const incomingGradeInput = document.querySelector('input[name="incoming_grlvl"]'); // readonly input

    const strandContainer = document.getElementById('strand-container');
    const birthdayContainer = document.getElementById('birthday-container');
    const lrnContainer = document.getElementById('lrn-container');
    const sourceContainer = document.getElementById('source-container');
    const gradeLevelContainer = document.getElementById('grade-level-container');

    function updateVisibility() {

        const bdayInput = document.getElementById('applicant_bday');
        if (bdayInput) {
            flatpickr(bdayInput, {
                dateFormat: "Y-m-d",              
                altInput: true,                   
                altFormat: "F j, Y",              
                maxDate: "today",                 
                allowInput: true,
                disableMobile: true               
            });
        }

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

document.addEventListener('DOMContentLoaded', function () {
    // Strand Recommendation SweetAlert
    if (window.strandRecommendation) {
        Swal.fire({
            icon: 'info',
            title: 'Strand Suggested',
            html: 'Your recommended strand is <b>' + window.strandRecommendation + '</b>. You can still choose another strand if you want.',
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
    }

    // Modal to suggest taking the recommender test
    if (window.showStrandModal && window.strandRecommenderRoute) {
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
                window.location.href = window.strandRecommenderRoute;
            }
        });
    }

    // Chart.js strand breakdown pie chart
    if (window.strandBreakdown && document.getElementById('strandChart')) {
        const ctx = document.getElementById('strandChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: Object.keys(window.strandBreakdown).map(s => s.toUpperCase()),
                datasets: [{
                    data: Object.values(window.strandBreakdown),
                    backgroundColor: ['#007bff', '#28a745', '#ffc107', '#dc3545', '#6f42c1'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom'
                    },
                    tooltip: {
                        callbacks: {
                            label: function (context) {
                                return context.label + ': ' + context.formattedValue + '%';
                            }
                        }
                    }
                }
            }
        });
    }
});

document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('step1Forms');
    const submitBtn = document.getElementById('formSubmission');

    if (submitBtn) {
        submitBtn.addEventListener('click', function (event) {
            event.preventDefault(); 

            if (form.checkValidity()) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "Please review all information before submitting.",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#00753F',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Confirm'
                }).then((result) => {
                    if (result.isConfirmed) {
                        submitBtn.disabled = true;
                        submitBtn.textContent = 'Submitting...';
                        form.submit(); // Only submit here
                    }
                });
            } else {
                form.reportValidity(); // Show native HTML5 validation
            }
        });
    }
});
