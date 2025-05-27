@extends('admission.admission-home')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
@vite('resources/js/admission/admission-chart.css')

<div class="dashboard">
    <div class="content">
        <h2 class="text-white mb-4 fw-semibold">Reports</h2>
    </div>
</div>

<div class="report-layout">

    <div class="monthlyreports">
        <div class="card mb-4">
            <div class="card-header bg-light fw-bold">Monthly Applicant Form Reports</div>
            <div class="table-responsive">
                <table class="table table-sm mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Reports</th>
                            <th class="text-end">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($months as $month)
                            <tr>
                                <td>{{ \Carbon\Carbon::create($month['year'], $month['month'])->format('F Y') }}</td>
                                <td class="text-end">
                                    <button
                                        class="btn btn-link p-0 text-decoration-none export-confirm"
                                        data-year="{{ $month['year'] }}"
                                        data-month="{{ $month['month'] }}"
                                    >
                                        Download
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <div class="mb-4 d-flex flex-column align-items-center gap-2">
    <div class="btn-group toggle-group chart-toggle" role="group">
        <button type="button" class="btn btn-toggle active" data-filter="demographic">Demographic</button>
        <button type="button" class="btn btn-toggle" data-filter="academic">Academic</button>
    </div>

    <div class="level-toggle-container">
        <div class="btn-group toggle-group level-toggle" role="group">
            <button type="button" class="btn btn-toggle active" data-level="all">All Levels</button>
            <button type="button" class="btn btn-toggle" data-level="Grade School">Grade School</button>
            <button type="button" class="btn btn-toggle" data-level="Junior High School">Junior High</button>
            <button type="button" class="btn btn-toggle" data-level="Senior High School">Senior High</button>
        </div>
    </div>
</div>


<div class="container-fluid">
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 chart-section demographic">
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Educational Level</div>
                <div class="card-body"><canvas id="applicantChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Gender</div>
                <div class="card-body"><canvas id="GenderChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Age</div>
                <div class="card-body"><canvas id="AgeChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">City</div>
                <div class="card-body"><canvas id="CityChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Region</div>
                <div class="card-body"><canvas id="RegionChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Nationality</div>
                <div class="card-body"><canvas id="NationalityChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">School Type</div>
                <div class="card-body"><canvas id="SchoolTypeChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Source</div>
                <div class="card-body"><canvas id="SourceChart"></canvas></div>
            </div>
        </div>
    </div>

    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 chart-section academic" style="display: none;">
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Senior High School Strands</div>
                <div class="card-body"><canvas id="StrandChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
        <div class="card-header bg-primary text-white">Recommended Strands (Base on Recommender)</div>
        <div class="card-body"><canvas id="RecommendedStrandChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Exam Results</div>
                <div class="card-body"><canvas id="ExamStatusChart"></canvas></div>
            </div>
        </div>
        <div class="col">
            <div class="card chart-card">
                <div class="card-header bg-primary text-white">Incoming Grade Level</div>
                <div class="card-body"><canvas id="IncomingGradeChart"></canvas></div>
            </div>
        </div>
    </div>
</div>

</div>


<script>
    document.querySelectorAll('.chart-toggle .btn-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            // Toggle active class
            document.querySelectorAll('.chart-toggle .btn-toggle').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const selected = this.getAttribute('data-filter');

            // Show the correct chart section
            document.querySelectorAll('.chart-section').forEach(section => {
                section.style.display = section.classList.contains(selected) ? 'flex' : 'none';
            });

            const levelToggleContainer = document.querySelector('.level-toggle-container');

              if (selected === 'academic') {
                // Hide level filter
                levelToggleContainer.style.display = 'none';

                // Automatically trigger click on "Senior High School"
                // When switching to academic, do NOT trigger any level button.
                // Instead, ensure the "All Levels" button stays selected.
                document.querySelectorAll('.level-toggle .btn-toggle').forEach(b => b.classList.remove('active'));
                const allBtn = document.querySelector('.level-toggle .btn-toggle[data-level="all"]');
                if (allBtn) allBtn.classList.add('active');

                // Manually trigger fetch for All Levels data
                fetch('/chart-data?level=all')
                    .then(res => res.json())
                    .then(data => {
                        applicantGenderChart.data.datasets[0].data = [
                            data.gender.find(g => g.gender === 'Male')?.total || 0,
                            data.gender.find(g => g.gender === 'Female')?.total || 0
                        ];
                        applicantGenderChart.update();

                        ageChart.data.labels = data.age.map(a => a.age);
                        ageChart.data.datasets[0].data = data.age.map(a => a.total);
                        ageChart.update();

                        cityChart.data.labels = data.city.map(c => c.city);
                        cityChart.data.datasets[0].data = data.city.map(c => c.total);
                        cityChart.update();

                        regionChart.data.labels = data.region.map(r => r.region);
                        regionChart.data.datasets[0].data = data.region.map(r => r.total);
                        regionChart.update();

                        nationalityChart.data.labels = data.nationality.map(n => n.nationality);
                        nationalityChart.data.datasets[0].data = data.nationality.map(n => n.total);
                        nationalityChart.update();

                        schoolTypeChart.data.labels = data.schoolType.map(s => s.school_type);
                        schoolTypeChart.data.datasets[0].data = data.schoolType.map(s => s.total);
                        schoolTypeChart.update();

                        sourceChart.data.labels = data.source.map(s => s.source);
                        sourceChart.data.datasets[0].data = data.source.map(s => s.total);
                        sourceChart.update();

                        strandChart.data.labels = data.strand.map(s => s.strand);
                        strandChart.data.datasets[0].data = data.strand.map(s => s.total);
                        strandChart.update();

                        incomingGradeChart.data.labels = data.incomingGrades.map(g => g.incoming_grlvl);
                        incomingGradeChart.data.datasets[0].data = data.incomingGrades.map(g => g.total);
                        incomingGradeChart.update();
                    });

            } else {
                levelToggleContainer.style.display = 'block';
            }
        });
    });

    const educationCtx = document.getElementById('applicantChart').getContext('2d');
    const applicantLabels = ['Grade School', 'Junior High', 'Senior High'];
    const applicantValues = [{{ $gradeSchool ?? 0 }}, {{ $juniorHigh ?? 0 }}, {{ $seniorHigh ?? 0 }}];
    const applicantTotal = applicantValues.reduce((a, b) => a + b, 0);

    const themePalette = [
        '#129439', // main green
        '#f39c12', // amber
        '#1abc9c', // turquoise
        '#9b59b6', // violet
        '#31c75a', // bright leaf green

        '#e67e22', // orange
        '#117a65', // deep jade
        '#8e44ad', // deep purple
        '#6ccf5d', // lime green
        '#2980b9', // denim blue

        '#0b722f', // dark forest green
        '#d35400', // burnt orange
        '#2e8b57', // sea green
        '#4db849', // mid green
        '#1f618d', // steel blue

        '#27ae60', // emerald
        '#20c997', // teal
        '#2471a3'  // navy blue
        ];

        const applicantChart = new Chart(educationCtx, {
            type: 'bar',
            data: {
                labels: applicantLabels,
                datasets: [{
                data: applicantValues,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const value = context.parsed.y;
                                const percentage = applicantTotal > 0 ? ((value / applicantTotal) * 100).toFixed(2) : 0;
                                return `${context.label}: ${value} (${percentage}%)`;
                            }
                        }
                    },
                    datalabels: {
                        anchor: 'center',
                        align: 'center',
                        color: '#fff',
                        font: {
                            weight: 'bold'
                        },
                        formatter: function(value) {
                            const percentage = applicantTotal > 0 ? ((value / applicantTotal) * 100).toFixed(1) : 0;
                            return `${percentage}%`;
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        precision: 0
                    }
                }
            },
            plugins: [ChartDataLabels]
        });

    const genderCtx = document.getElementById('GenderChart').getContext('2d');
    const applicantGenderChart = new Chart(genderCtx, {
        type: 'pie',
        data: {
            labels: ['Male', 'Female'],
            datasets: [{
                label: 'Number of Applicants',
                data: [{{ $male ?? 0 }}, {{ $female ?? 0 }}],
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    formatter: (value, context) => {
                        const data = context.chart.data.datasets[0].data;
                        const total = data.reduce((a, b) => a + b, 0);
                        const percentage = (value / total) * 100;
                        return percentage.toFixed(2) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });


    const ageCtx = document.getElementById('AgeChart').getContext('2d');
    const ageData = {!! json_encode($ageCounts->pluck('total')) !!};
    const total = ageData.reduce((a, b) => a + b, 0);

    const ageChart = new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($ageCounts->pluck('age')) !!},
            datasets: [{
            data: ageData,
            backgroundColor: themePalette,
            borderColor: '#ffffff',
            borderWidth: 1
        }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: { precision: 0 }
                }
            },
            plugins: {
                legend: { display: false},
                datalabels: {
                    color: '#fff',  
                    anchor: 'center',  
                    align: 'center',   
                    font: {
                    weight: 'bold',
                    size: 12
                    },
                    formatter: (value) => {
                        let percentage = (value / total) * 100;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const CityData = {!! json_encode($city->pluck('total')) !!};
    const CityDataTotal = CityData.reduce((a, b) => a + b, 0);
    const cityCtx = document.getElementById('CityChart').getContext('2d');
    const cityChart = new Chart(cityCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($city->pluck('city')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: CityData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false},
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = CityDataTotal > 0 ? (value / CityDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });


    const RegionData = {!! json_encode($region->pluck('total')) !!};
    const RegionDataTotal = RegionData.reduce((a, b) => a + b, 0);
    const regionCtx = document.getElementById('RegionChart').getContext('2d');
    const regionChart = new Chart(regionCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($region->pluck('region')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: RegionData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    formatter: (value) => {
                        let percentage = RegionDataTotal > 0 ? (value / RegionDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const NationalityData = {!! json_encode($nationality->pluck('total')) !!};
    const NationalityDataTotal = NationalityData.reduce((a, b) => a + b, 0);
    const nationalityCtx = document.getElementById('NationalityChart').getContext('2d');
    const nationalityChart = new Chart(nationalityCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($nationality->pluck('nationality')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: NationalityData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    formatter: (value) => {
                        let percentage = NationalityDataTotal > 0 ? (value / NationalityDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const SchoolTypeData = {!! json_encode($schoolType->pluck('total')) !!};
    const SchoolTypeDataTotal = SchoolTypeData.reduce((a, b) => a + b, 0);
    const schoolTypeCtx = document.getElementById('SchoolTypeChart').getContext('2d');
    const schoolTypeChart = new Chart(schoolTypeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($schoolType->pluck('school_type')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: SchoolTypeData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = SchoolTypeDataTotal > 0 ? (value / SchoolTypeDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const SourceData = {!! json_encode($source->pluck('total')) !!};
    const SourceDataTotal = SourceData.reduce((a, b) => a + b, 0);
    const sourceCtx = document.getElementById('SourceChart').getContext('2d');
    const sourceChart = new Chart(sourceCtx, {
        type: 'doughnut',
        data: {
            labels: {!! json_encode($source->pluck('source')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: SourceData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    formatter: (value) => {
                        let percentage = SourceDataTotal > 0 ? (value / SourceDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const strandCtx = document.getElementById('StrandChart').getContext('2d');
const strandLabels = {!! json_encode($strand->pluck('strand')) !!};
const strandData = {!! json_encode($strand->pluck('total')) !!};
const strandTotal = strandData.reduce((a, b) => a + b, 0);

const strandChart = new Chart(strandCtx, {
    type: 'pie',
    data: {
        labels: strandLabels,
        datasets: [{
            data: strandData,
            backgroundColor: themePalette.slice(0, strandLabels.length),
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true,
                position: 'bottom', // show color-keyed labels under the pie
                labels: {
                    boxWidth: 20,
                    padding: 15
                }
            },
            datalabels: {
                color: '#fff',
                font: {
                    weight: 'bold'
                },
                formatter: (value) => {
                    const percentage = strandTotal > 0 ? (value / strandTotal) * 100 : 0;
                    return `${percentage.toFixed(1)}%`;
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});

    const recommendedStrandLabels = {!! json_encode($recommendedStrand->pluck('recommended_strand')) !!};
const recommendedStrandData = {!! json_encode($recommendedStrand->pluck('total')) !!};
const recommendedStrandTotal = recommendedStrandData.reduce((a, b) => a + b, 0);

const recommendedStrandCtx = document.getElementById('RecommendedStrandChart').getContext('2d');
const recommendedStrandChart = new Chart(recommendedStrandCtx, {
    type: 'pie',
    data: {
        labels: recommendedStrandLabels,
        datasets: [{
            data: recommendedStrandData,
            backgroundColor: themePalette.slice(0, recommendedStrandLabels.length),
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: { display: true, position: 'bottom' },
            datalabels: {
                color: '#fff',
                font: { weight: 'bold' },
                formatter: (value) => {
                    const percentage = recommendedStrandTotal > 0 ? (value / recommendedStrandTotal) * 100 : 0;
                    return percentage.toFixed(1) + '%';
                }
            }
        }
    },
    plugins: [ChartDataLabels]
});


    const ExamStatusData = {!! json_encode($examStatus->pluck('total')) !!};
    const ExamStatusDataTotal = ExamStatusData.reduce((a, b) => a + b, 0);
    const examCtx = document.getElementById('ExamStatusChart').getContext('2d');
    const examStatusChart = new Chart(examCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($examStatus->pluck('exam_status')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: ExamStatusData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false},
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = ExamStatusDataTotal > 0 ? (value / ExamStatusDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const IncomingGradeData = {!! json_encode($incomingGrades->pluck('total')) !!};
    const IncomingGradeDataTotal = IncomingGradeData.reduce((a, b) => a + b, 0);
    const incomingGradeCtx = document.getElementById('IncomingGradeChart').getContext('2d');
    const incomingGradeChart = new Chart(incomingGradeCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($incomingGrades->pluck('incoming_grlvl')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: IncomingGradeData,
                backgroundColor: themePalette,
                borderColor: '#ffffff',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: { beginAtZero: true, ticks: { precision: 0 } }
            },
            plugins: {
                legend: { display: false},
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = IncomingGradeDataTotal > 0 ? (value / IncomingGradeDataTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    document.querySelectorAll('.chart-toggle .btn-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.chart-toggle .btn-toggle').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const selected = this.getAttribute('data-filter');
            document.querySelectorAll('.chart-section').forEach(section => {
                if (section.classList.contains(selected)) {
                    section.style.display = 'flex'; 
                } else {
                    section.style.display = 'none';
                }
            });

        });
    });

    document.querySelectorAll('.level-toggle .btn-toggle').forEach(btn => {
        btn.addEventListener('click', function () {
            document.querySelectorAll('.level-toggle .btn-toggle').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const level = this.getAttribute('data-level');

            fetch(`/chart-data?level=${encodeURIComponent(level)}`)
            .then(res => res.json())
            .then(data => {
                // Update charts using `data` just like before
                applicantGenderChart.data.datasets[0].data = [
                    data.gender.find(g => g.gender === 'Male')?.total || 0,
                    data.gender.find(g => g.gender === 'Female')?.total || 0
                ];
                applicantGenderChart.update();

                ageChart.data.labels = data.age.map(a => a.age);
                ageChart.data.datasets[0].data = data.age.map(a => a.total);
                ageChart.update();

                cityChart.data.labels = data.city.map(c => c.city);
                cityChart.data.datasets[0].data = data.city.map(c => c.total);
                cityChart.update();

                regionChart.data.labels = data.region.map(r => r.region);
                regionChart.data.datasets[0].data = data.region.map(r => r.total);
                regionChart.update();

                nationalityChart.data.labels = data.nationality.map(n => n.nationality);
                nationalityChart.data.datasets[0].data = data.nationality.map(n => n.total);
                nationalityChart.update();

                schoolTypeChart.data.labels = data.schoolType.map(s => s.school_type);
                schoolTypeChart.data.datasets[0].data = data.schoolType.map(s => s.total);
                schoolTypeChart.update();

                sourceChart.data.labels = data.source.map(s => s.source);
                sourceChart.data.datasets[0].data = data.source.map(s => s.total);
                sourceChart.update();

                strandChart.data.labels = data.strand.map(s => s.strand);
                strandChart.data.datasets[0].data = data.strand.map(s => s.total);
                strandChart.update();

                incomingGradeChart.data.labels = data.incomingGrades.map(g => g.incoming_grlvl);
                incomingGradeChart.data.datasets[0].data = data.incomingGrades.map(g => g.total);
                incomingGradeChart.update();
            });
        });
    });
</script>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
document.querySelectorAll('.export-confirm').forEach(button => {
    button.addEventListener('click', function () {
        const year = this.getAttribute('data-year');
        const month = this.getAttribute('data-month');

        const today = new Date();
        const isCurrentMonth = parseInt(month) === (today.getMonth() + 1) && parseInt(year) === today.getFullYear();
        const lastDay = new Date(today.getFullYear(), today.getMonth() + 1, 0).getDate();
        const isEndOfMonth = today.getDate() === lastDay;

        if (isCurrentMonth && !isEndOfMonth) {
            Swal.fire({
                title: 'Incomplete Month',
                text: "This month's report isn't finished yet. Do you still want to export data up to today?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, export anyway',
                cancelButtonText: 'Cancel'
            }).then(result => {
                if (result.isConfirmed) {
                    window.location.href = `/export/forms/${year}/${month}`;
                }
            });
        } else {
            window.location.href = `/export/forms/${year}/${month}`;
        }
    });
});
</script>


@endsection

