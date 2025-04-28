document.addEventListener('DOMContentLoaded', function () {
    const regionSelect = document.getElementById('region');
    const provinceSelect = document.getElementById('province');
    const citySelect = document.getElementById('city');
    const barangaySelect = document.getElementById('barangay');

    const selectedRegion = regionSelect.getAttribute('data-selected');
    const selectedProvince = provinceSelect.getAttribute('data-selected');
    const selectedCity = citySelect.getAttribute('data-selected');
    const selectedBarangay = barangaySelect.getAttribute('data-selected');

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

    // 1. Load regions
    fetchData('https://psgc.gitlab.io/api/regions/', regionSelect, 'name', selectedRegion)
    .then(() => {
        if (selectedRegion) {
            regionSelect.value = selectedRegion;
            regionSelect.dispatchEvent(new Event('change'));
        }
    });

    // 2. When region is selected
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
                .then(() => {
                    if (selectedCity) {
                        citySelect.value = selectedCity;
                        citySelect.dispatchEvent(new Event('change'));
                    }
                });
            } else {
                fetchData(`https://psgc.gitlab.io/api/regions/${regionCode}/provinces/`, provinceSelect, 'name', selectedProvince)
                .then(() => {
                    if (selectedProvince) {
                        provinceSelect.value = selectedProvince;
                        provinceSelect.dispatchEvent(new Event('change'));
                    }
                });
            }
        });
    });

    // 3. When province is selected
    provinceSelect.addEventListener('change', function () {
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
            .then(() => {
                if (selectedCity) {
                    citySelect.value = selectedCity;
                    citySelect.dispatchEvent(new Event('change'));
                }
            });
        });
    });

    // 4. When city is selected
    citySelect.addEventListener('change', function () {
        const cityName = this.value;
        resetSelect(barangaySelect);

        fetch('https://psgc.gitlab.io/api/cities-municipalities/')
        .then(res => res.json())
        .then(cities => {
            const selected = cities.find(c => c.name === cityName);
            if (!selected) return;

            fetchData(`https://psgc.gitlab.io/api/cities-municipalities/${selected.code}/barangays/`, barangaySelect, 'name', selectedBarangay)
            .then(() => {
                if (selectedBarangay) {
                    barangaySelect.value = selectedBarangay;
                }
            });
        });
    });
});
