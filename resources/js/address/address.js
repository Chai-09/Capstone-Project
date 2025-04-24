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

    function fetchData(url, select, valueKey = 'name') {
        fetch(url)
            .then(res => res.json())
            .then(data => {
                resetSelect(select);
                data.forEach(item => {
                    select.innerHTML += `<option value="${item[valueKey]}">${item[valueKey]}</option>`;
                });
            });
    }

    // 1. Load regions
    fetchData('https://psgc.gitlab.io/api/regions/', regionSelect);

    // 2. When region is selected
    regionSelect.addEventListener('change', function () {
        const regionName = this.value;

        resetSelect(provinceSelect);
        resetSelect(citySelect);
        resetSelect(barangaySelect);

        // Find the matching region's code (because PSGC API uses code in URL)
        fetch('https://psgc.gitlab.io/api/regions/')
            .then(res => res.json())
            .then(regions => {
                const selectedRegion = regions.find(r => r.name === regionName);
                if (!selectedRegion) return;

                const regionCode = selectedRegion.code;

                if (regionCode === '130000000') {
                    provinceSelect.innerHTML = `<option value="Metro Manila (NCR)" selected>Metro Manila (NCR)</option>`;
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/cities-municipalities/`, citySelect);
                } else {
                    fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`, provinceSelect);
                }
            });
    });

    // 3. When province is selected
    provinceSelect.addEventListener('change', function () {
        const provinceName = this.value;

        resetSelect(citySelect);
        resetSelect(barangaySelect);

        // Skip if NCR
        if (provinceName === 'Metro Manila (NCR)') return;

        fetch('https://psgc.gitlab.io/api/provinces/')
            .then(res => res.json())
            .then(provinces => {
                const selectedProvince = provinces.find(p => p.name === provinceName);
                if (!selectedProvince) return;

                fetchData(`https://psgc.gitlab.io/api/provinces/${selectedProvince.code}/cities-municipalities/`, citySelect);
            });
    });

    // 4. When city is selected
    citySelect.addEventListener('change', function () {
        const cityName = this.value;
        resetSelect(barangaySelect);

        fetch('https://psgc.gitlab.io/api/cities-municipalities/')
            .then(res => res.json())
            .then(cities => {
                const selectedCity = cities.find(c => c.name === cityName);
                if (!selectedCity) return;

                fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${selectedCity.code}/barangays/`, barangaySelect);
            });
    });
});
