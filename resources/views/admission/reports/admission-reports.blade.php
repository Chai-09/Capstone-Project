@extends('admission.admission-home')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<style>
.btn-toggle {
    border-radius: 30px 0 0 30px;
    background-color: white;
    color: #333;
    border: 1px solid #ccc;
    padding: 8px 20px;
    transition: all 0.2s ease-in-out;
}

.btn-toggle:last-child {
    border-radius: 0 30px 30px 0;
    border-left: none;
}

.btn-toggle.active {
    background-color: #6f42c1;
    color: white;
    border-color: #6f42c1;
}
</style>

<div class="d-flex justify-content-end mb-4">
<div class="btn-group toggle-group chart-toggle" role="group">
    <button type="button" class="btn btn-toggle active" data-filter="demographic">Demographic</button>
    <button type="button" class="btn btn-toggle" data-filter="academic">Academic</button>
</div>

</div>
<div class="d-flex justify-content-end mb-4">
<div class="btn-group toggle-group level-toggle" role="group">
    <button type="button" class="btn btn-toggle active" data-level="all">All Levels</button>
    <button type="button" class="btn btn-toggle" data-level="Grade School">Grade School</button>
    <button type="button" class="btn btn-toggle" data-level="Junior High School">Junior High</button>
    <button type="button" class="btn btn-toggle" data-level="Senior High School">Senior High</button>
</div>

</div>





<div class="container mt-5">
    <h3 class="mb-4">Admission Reports Dashboard</h3>

    <div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Educational Level</div>
        <div class="card-body">
            <canvas id="applicantChart" height="80"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Gender</div>
        <div class="card-body">
            <canvas id="GenderChart" style="height: 300px;"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Age</div>
        <div class="card-body">
            <canvas id="AgeChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by City</div>
        <div class="card-body">
            <canvas id="CityChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Region</div>
        <div class="card-body">
            <canvas id="RegionChart" style="height: 300px;"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Nationality</div>
        <div class="card-body">
            <canvas id="NationalityChart" style="height: 300px;"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by School Type</div>
        <div class="card-body">
            <canvas id="SchoolTypeChart" height="300px"></canvas>
        </div>
    </div>
</div>

<div class="chart-card demographic">
    <div class="card">
        <div class="card-header bg-primary text-white">Applicant Count by Source</div>
        <div class="card-body" style="height: 400px;">
            <canvas id="SourceChart"></canvas>
        </div>
    </div>
</div>

    
<div class="chart-card academic" style="display: none;">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Applicant Count by Strands</div>
        <div class="card-body">
            <canvas id="StrandChart" height="300px"></canvas>
        </div>
    </div>
</div>

<div class="chart-card academic" style="display: none;">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Applicant Count by Exam Results</div>
        <div class="card-body">
            <canvas id="ExamStatusChart"></canvas>
        </div>
    </div>
</div>

<div class="chart-card academic" style="display: none;">
    <div class="card mt-4">
        <div class="card-header bg-primary text-white">Applicant Count by Incoming Grade Level</div>
        <div class="card-body">
            <canvas id="IncomingGradeChart"></canvas>
        </div>
    </div>
</div>

</div>

<script>
    //can be used as a sample
    const educationCtx = document.getElementById('applicantChart').getContext('2d');
const applicantChart = new Chart(educationCtx, {
    type: 'bar',
    data: {
        labels: ['Grade School', 'Junior High', 'Senior High'],
        datasets: [{
            label: 'Number of Applicants',
            data: [{{ $gradeSchool ?? 0 }}, {{ $juniorHigh ?? 0 }}, {{ $seniorHigh ?? 0 }}],
            backgroundColor: ['#0d6efd', '#20c997', '#ffc107']
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: { beginAtZero: true, precision: 0 }
        }
    }
});

const genderCtx = document.getElementById('GenderChart').getContext('2d');
const applicantGenderChart = new Chart(genderCtx, {
    type: 'pie',
    data: {
        labels: ['Male', 'Female'],
        datasets: [{
            label: 'Number of Applicants',
            data: [{{ $male ?? 0 }}, {{ $female ?? 0 }}],
            backgroundColor: ['#0d6efd', '#20c997']
        }]
    },
    options: {
        responsive: false, // if gusto niyo iedit, gawin niyo false. if ayaw, true
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const ageCtx = document.getElementById('AgeChart').getContext('2d');
const ageChart = new Chart(ageCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($ageCounts->pluck('age')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($ageCounts->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', '#20c997', '#ffc107', '#fd7e14',
                '#6610f2', '#dc3545', '#198754', '#6f42c1',
                '#17a2b8', '#e83e8c', '#adb5bd', '#ff6b6b',
                '#4dabf7', '#343a40', '#f8f9fa'
            ],
            borderColor: '#fff',
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
            legend: {
                position: 'top'
            }
        }
    }
});


const cityCtx = document.getElementById('CityChart').getContext('2d');
const cityChart = new Chart(cityCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($city->pluck('city')) !!}, // ✅ Use $city not $region
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($city->pluck('total')) !!},
            backgroundColor: ['#0d6efd', '#20c997'],
            borderColor: '#20c997',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y', // ✅ Horizontal bars
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                position: 'top',
                labels: {
                    color: '#333'
                }
            }
        }
    }
});


const regionCtx = document.getElementById('RegionChart').getContext('2d');
const regionChart = new Chart(regionCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($region->pluck('region')) !!}, // ✅ Use 'region'
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($region->pluck('total')) !!},
            backgroundColor: ['#6f42c1', '#20c997']
        }]
    },
    options: {
        responsive: false,
        scales: {
            y: { beginAtZero: true, precision: 0 }
        }
    }
});

const nationalityCtx = document.getElementById('NationalityChart').getContext('2d');
const nationalityChart = new Chart(nationalityCtx, {
    type: 'pie',
    data: {
        labels: {!! json_encode($nationality->pluck('nationality')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($nationality->pluck('total')) !!},
            backgroundColor: [
                '#6f42c1', '#20c997', '#0d6efd', '#ffc107',
                '#fd7e14', '#198754', '#dc3545', '#6610f2',
                '#e83e8c', '#17a2b8', '#f8f9fa', '#adb5bd'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const schoolTypeCtx = document.getElementById('SchoolTypeChart').getContext('2d');
const schoolTypeChart = new Chart(schoolTypeCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($schoolType->pluck('school_type')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($schoolType->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', // Blue
                '#20c997', // Teal
                '#ffc107', // Yellow
                '#fd7e14', // Orange
                '#dc3545'  // Red
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

const sourceCtx = document.getElementById('SourceChart').getContext('2d');
const sourceChart = new Chart(sourceCtx, {
    type: 'doughnut', // 👈 Change here
    data: {
        labels: {!! json_encode($source->pluck('source')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($source->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', '#20c997', '#ffc107', '#dc3545',
                '#6f42c1', '#fd7e14', '#17a2b8', '#6610f2'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});

const strandCtx = document.getElementById('StrandChart').getContext('2d');
const strandChart = new Chart(strandCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($strand->pluck('strand')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($strand->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', '#20c997', '#ffc107', '#fd7e14',
                '#6610f2', '#dc3545', '#198754', '#6f42c1'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

const examCtx = document.getElementById('ExamStatusChart').getContext('2d');
const examStatusChart = new Chart(examCtx, {
    type: 'bar',
    data: {
        labels: {!! json_encode($examStatus->pluck('exam_status')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($examStatus->pluck('total')) !!},
            backgroundColor: [
                '#198754', // Passed (green)
                '#dc3545', // Failed (red)
                '#ffc107', // Pending (yellow)
                '#6c757d'  // No show or others (gray)
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        indexAxis: 'y', // ✅ Makes the bars horizontal
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            x: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});

const incomingGradeCtx = document.getElementById('IncomingGradeChart').getContext('2d');
const incomingGradeChart = new Chart(incomingGradeCtx, {
    type: 'bar', // vertical by default
    data: {
        labels: {!! json_encode($incomingGrades->pluck('incoming_grlvl')) !!},
        datasets: [{
            label: 'Number of Applicants',
            data: {!! json_encode($incomingGrades->pluck('total')) !!},
            backgroundColor: [
                '#0d6efd', '#20c997', '#ffc107', '#fd7e14',
                '#6610f2', '#dc3545', '#198754', '#6f42c1',
                '#17a2b8', '#e83e8c', '#adb5bd', '#ff6b6b',
                '#4dabf7'
            ],
            borderColor: '#fff',
            borderWidth: 1
        }]
    },
    options: {
        responsive: false,
        maintainAspectRatio: false,
        scales: {
            y: {
                beginAtZero: true,
                ticks: {
                    precision: 0
                }
            }
        },
        plugins: {
            legend: {
                display: true,
                position: 'top'
            }
        }
    }
});


document.querySelectorAll('.chart-toggle .btn-toggle').forEach(btn => {
    btn.addEventListener('click', function () {
        document.querySelectorAll('.chart-toggle .btn-toggle').forEach(b => b.classList.remove('active'));
        this.classList.add('active');

        const selected = this.getAttribute('data-filter');
        const cards = document.querySelectorAll('.chart-card');

        cards.forEach(card => {
            if (selected === 'all' || card.classList.contains(selected)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
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
@endsection

