document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');

    function resetSelect(select, label = null) {
        select.innerHTML = `<option value="">${label || "Choose " + capitalize(select.name)}</option>`;
    }

    function capitalize(str) {
        return str.charAt(0).toUpperCase() + str.slice(1);
    }

    function fetchData(url, select, valueKey = 'name', codeKey = 'code') {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                resetSelect(select);
                data.forEach(item => {
                    select.innerHTML += `<option value="${item[codeKey]}" data-name="${item[valueKey]}">${item[valueKey]}</option>`;
                });
            });
    }

    // 1. Load regions
    fetchData('https://psgc.gitlab.io/api/regions/', regionSelect);

    // 2. When region is selected
    regionSelect.addEventListener('change', function () {
        const regionCode = this.value;

        resetSelect(provinceSelect);
        resetSelect(citySelect);
        resetSelect(barangaySelect);

        if (regionCode === '130000000') {
            // Special case for NCR
            provinceSelect.innerHTML = `<option value="130000000" selected>Metro Manila (NCR)</option>`;
            fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/cities-municipalities/`, citySelect);
        } else {
            // Normal case
            fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`, provinceSelect);
        }
    });

    // 3. When province is selected (not for NCR)
    provinceSelect.addEventListener('change', function () {
        const provinceCode = this.value;

        resetSelect(citySelect);
        resetSelect(barangaySelect);

        // Skip if NCR (already loaded)
        if (provinceCode !== '130000000') {
            fetchData(`https://psgc.gitlab.io/api/provinces/${provinceCode}/cities-municipalities/`, citySelect);
        }
    });

    // 4. When city is selected
    citySelect.addEventListener('change', function () {
        const cityCode = this.value;
        resetSelect(barangaySelect);
        fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${cityCode}/barangays/`, barangaySelect);
    });
});
