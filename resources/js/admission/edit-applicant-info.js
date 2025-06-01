import flatpickr from "flatpickr";
import "flatpickr/dist/themes/material_green.css";

// Calendar
document.addEventListener('DOMContentLoaded', function () {
    flatpickr("#applicant_bday", {
        dateFormat: "Y-m-d",
        maxDate: "today",
        allowInput: true,
        altInput: true,                      
        altFormat: "F j, Y",    
    });
});


// Editable Fields & Buttons
document.addEventListener('DOMContentLoaded', function () {
    const editBtn = document.getElementById('editBtn');
    const saveBtn = document.getElementById('saveBtn');
    const cancelBtn = document.getElementById('cancelBtn');
    const inputs = document.querySelectorAll('input');
    const selects = document.querySelectorAll('select');
    const actionButtons = document.getElementById('formActionButtons');

    const originalValues = {};
    inputs.forEach(input => originalValues[input.name] = input.value);
    selects.forEach(select => originalValues[select.name] = select.value);

    if (editBtn) {
        editBtn.addEventListener('click', () => {
            actionButtons.classList.remove('d-none');
            document.querySelectorAll('#step1Content input, #step1Content select, #step4Content input, #step4Content select, #step6Content input, #step6Content select')
                .forEach(el => {
                    el.removeAttribute('readonly');
                    el.removeAttribute('disabled');
                    el.classList.remove('bg-light'); 
                });

            saveBtn.classList.remove('d-none');
            cancelBtn.classList.remove('d-none');
        });
    }

    if (cancelBtn) {
        cancelBtn.addEventListener('click', () => {
            location.reload();
            // actionButtons.classList.add('d-none');
            // inputs.forEach(input => {
            //     input.setAttribute('readonly', true);
            //     input.classList.add('bg-light');
            //     if (originalValues.hasOwnProperty(input.name)) {
            //         input.value = originalValues[input.name];
            //     }
            // });

            // selects.forEach(select => {
            //     select.setAttribute('disabled', true);
            //     select.classList.add('bg-light');
            //     if (originalValues.hasOwnProperty(select.name)) {
            //         select.value = originalValues[select.name];
            //     }
            // });

            saveBtn.classList.add('d-none');
            cancelBtn.classList.add('d-none');
        });
    }
});

// Address Drop Down
document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');

    const selectedRegion = regionSelect?.getAttribute('data-selected');
    const selectedProvince = provinceSelect?.getAttribute('data-selected');
    const selectedCity = citySelect?.getAttribute('data-selected');
    const selectedBarangay = barangaySelect?.getAttribute('data-selected');

    function resetSelect(select, label = null) {
        const placeholder = label || "Choose " + capitalize(select.name);
        select.innerHTML = `<option value="" disabled selected hidden>${placeholder}</option>`;
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function fetchData(url, select, valueKey = 'name', selectedValue = null) {
        return fetch(url)
            .then(res => res.json())
            .then(data => {
                resetSelect(select);
                data.forEach(item => {
                    const value = item[valueKey];
                    const isSelected = selectedValue && value === selectedValue ? 'selected' : '';
                    select.innerHTML += `<option value="${value}" ${isSelected}>${value}</option>`;
                });
            });
    }

    if (regionSelect) {
        fetchData('https://psgc.gitlab.io/api/regions/', regionSelect, 'name', selectedRegion)
        .then(() => {
            if (selectedRegion) {
                regionSelect.value = selectedRegion;
                regionSelect.dispatchEvent(new Event('change'));
            }
        });

        regionSelect.addEventListener('change', function () {
            const regionName = this.value;
            resetSelect(provinceSelect);
            resetSelect(citySelect);
            resetSelect(barangaySelect);

            fetch('https://psgc.gitlab.io/api/regions/')
            .then(res => res.json())
            .then(regions => {
                const selected = regions.find(r => r.name === regionName);
                if (!selected) return;

                const regionCode = selected.code;

                if (regionCode === '130000000') {
                    provinceSelect.innerHTML = `<option value="Metro Manila (NCR)" selected>Metro Manila (NCR)</option>`;
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/cities-municipalities/`, citySelect, 'name', selectedCity)
                    .then(() => citySelect.dispatchEvent(new Event('change')));
                } else {
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`, provinceSelect, 'name', selectedProvince)
                    .then(() => provinceSelect.dispatchEvent(new Event('change')));
                }
            });
        });

        provinceSelect?.addEventListener('change', function () {
            const provinceName = this.value;
            resetSelect(citySelect);
            resetSelect(barangaySelect);

            if (provinceName === 'Metro Manila (NCR)') return;

            fetch('https://psgc.gitlab.io/api/provinces/')
            .then(res => res.json())
            .then(provinces => {
                const selected = provinces.find(p => p.name === provinceName);
                if (!selected) return;

                fetchData(`https://psgc.gitlab.io/api/provinces/${selected.code}/cities-municipalities/`, citySelect, 'name', selectedCity)
                    .then(() => citySelect.dispatchEvent(new Event('change')));
            });
        });

        citySelect?.addEventListener('change', function () {
            const cityName = this.value;
            resetSelect(barangaySelect);

            fetch('https://psgc.gitlab.io/api/cities-municipalities/')
            .then(res => res.json())
            .then(cities => {
                const selected = cities.find(c => c.name === cityName);
                if (!selected) return;

                fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${selected.code}/barangays/`, barangaySelect, 'name', selectedBarangay);
            });
        });
    }
});


// Time Slot
document.addEventListener('DOMContentLoaded', function () {
    const examDateSelect = document.querySelector('[name="exam_date"]');
    const timeSlotSelect = document.getElementById('time_slot');
    const applicantLevel = window.applicantLevel; // This must be declared in Blade

    if (examDateSelect) {
        examDateSelect.addEventListener('change', function () {
            const selectedDate = this.value;
            if (!selectedDate) return;

            fetch(`/get-time-slots?exam_date=${selectedDate}&educational_level=${encodeURIComponent(applicantLevel)}`)
                .then(response => response.json())
                .then(slots => {
                    timeSlotSelect.innerHTML = '<option value="">Select time</option>';

                    slots.forEach(slot => {
                        const label = formatTime(slot.start_time) + ' to ' + formatTime(slot.end_time);
                        const value = `${slot.start_time}|${slot.end_time}`;
                        timeSlotSelect.innerHTML += `<option value="${value}">${label}</option>`;
                    });
                });
        });
    }

    function formatTime(timeStr) {
        const [hour, minute] = timeStr.split(':');
        const h = parseInt(hour);
        const suffix = h >= 12 ? 'PM' : 'AM';
        const formattedHour = h % 12 || 12;
        return `${formattedHour}:${minute} ${suffix}`;
    }
});

// Exam Status & Exam Result Logic
document.addEventListener('DOMContentLoaded', function () {
    const statusSelect = document.querySelector('select[name="exam_status"]');
    const resultSelect = document.querySelector('select[name="exam_result"]');
    const noShowOption = resultSelect?.querySelector('option[value="no show"]');

    if (statusSelect && resultSelect) {
        statusSelect.addEventListener('change', function () {
            if (this.value === 'no show') {
                resultSelect.value = 'no show';
                if (noShowOption) noShowOption.style.display = 'block';
            } else {
                if (noShowOption) noShowOption.style.display = 'none';
                if (resultSelect.value === 'no show') {
                    resultSelect.value = '';
                }
            }
        });

        // Initial setup (on page load)
        const initialStatus = statusSelect.querySelector('option:checked')?.value;
        if (initialStatus === 'no show') {
            if (noShowOption) noShowOption.style.display = 'block';
            resultSelect.value = 'no show';
        } else {
            if (noShowOption) noShowOption.style.display = 'none';
            if (resultSelect.value === 'no show') {
                resultSelect.value = '';
            }
        }
    }
});

// Step Navigation
window.showStepContent = function(step) {
    const allSteps = [
        'step1Content', 'step2Content', 'step3Content',
        'step4Content', 'step5Content', 'step6Content'
    ];

    allSteps.forEach(id => document.getElementById(id)?.classList.add('d-none'));

    const target = document.getElementById('step' + step + 'Content');
    if (target) target.classList.remove('d-none');

    
};

// Change History Logs
document.addEventListener('DOMContentLoaded', function () {
    const toggleBtn = document.getElementById('toggleHistoryBtn');
    const limitedLogs = document.getElementById('limitedLogs');
    const allLogs = document.getElementById('allLogs');

    if (toggleBtn) {
        toggleBtn.addEventListener('click', function () {
            const isExpanded = !allLogs.classList.contains('d-none');

            allLogs.classList.toggle('d-none', isExpanded);
            limitedLogs.classList.toggle('d-none', !isExpanded);
            toggleBtn.textContent = isExpanded ? 'Show All' : 'Show Less';
        });
    }
});

// SweetAlert Modal: Proof of Payment of Viewer
window.showProofModal = function(fileUrl) {
    const isImage = fileUrl.match(/\.(jpeg|jpg|png|gif)$/i);

    Swal.fire({
        title: 'Proof of Payment',
        html: isImage
            ? `<img src="${fileUrl}" alt="Proof" style="max-width:100%; max-height:400px;" />`
            : `<a href="${fileUrl}" target="_blank">Open File</a>`,
        showCloseButton: true,
        showConfirmButton: false,
        width: 600,
        customClass: { popup: 'text-start' }
    });
};

document.addEventListener('DOMContentLoaded', function () {
    const deleteBtn = document.getElementById('deleteBtn');
    const deleteForm = document.getElementById('deleteApplicantForm');

    if (deleteBtn && deleteForm) {
        deleteBtn.addEventListener('click', function (e) {
            Swal.fire({
                title: 'Are you sure?',
                text: "This action will permanently delete the applicant's record.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#198754',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Confirm',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });
    }
});


// Validation Function
window.showFormError = function (message) {
    const alertContainer = document.getElementById('alert-container');
    const alertWrapper = document.getElementById('alert-wrap');

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
    alertWrapper.style.display = "block";
    alertContainer.style.display = "block";
    alertContainer.appendChild(errorBox);
};


// Validation
window.validateInputFormats = function () {
    const emailInputs = document.querySelectorAll('input[type="email"]');
    const phoneInputs = document.querySelectorAll('input[name*="contact"]');
    const numericInputs = document.querySelectorAll('input[data-validate="numeric"]');
    const middleInitialInputs = document.querySelectorAll('input[name*="mname"]');

    for (let mi of middleInitialInputs) {
        if (mi.value && mi.value.length > 3) {
            showFormError("Middle initial must be 1 or 2 characters only.");
            mi.classList.add("border-danger");
            return false;
        } else {
            mi.classList.remove("border-danger");
        }
    }


    

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    const phonePattern = /^09\d{9}$/;

    for (let email of emailInputs) {
        if (!email.value || !emailPattern.test(email.value)) { 
            showFormError('Please enter a valid email address (e.g., name@example.com).');
            email.classList.add("border-danger");
            return false;
        } else {
            email.classList.remove("border-danger");
        }
    }

    for (let phone of phoneInputs) {
        if (!phone.value || !phonePattern.test(phone.value)) {
            showFormError("Contact number must start with 09 and have 11 digits.");
            phone.classList.add("border-danger");
            return false;
        } else {
            phone.classList.remove("border-danger");
        }
    }

    for (let numeric of numericInputs) {
        if (numeric.value && isNaN(numeric.value)) {
            showFormError("Only numbers are allowed in numeric fields.");
            numeric.classList.add("border-danger");
            return false;
        } else {
            numeric.classList.remove("border-danger");
        }
    }

    return true;
};


document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById("editApplicantForm");

    if (form) {
        form.addEventListener("submit", function (e) {
            if (!validateInputFormats()) {
                e.preventDefault(); // Prevent form submission if invalid
            }
        });
    }
});
