@extends('admission.admission-home')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="monthlyreports">
    <div class="card mb-4">
        <div class="card-header bg-light fw-bold">Monthly Accounting Reports</div>
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



<div class="container mt-5">
    <h3 class="mb-4">Admission Reports Dashboard</h3>

    <div class="chart-card demographic">
        <div class="card">
            <div class="card-header bg-primary text-white">Applicant Count by Educational Level</div>
            <div class="card-body">
                <canvas id="GradeLevelChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-card demographic">
        <div class="card">
            <div class="card-header bg-primary text-white">Applicant Count by Educational Level</div>
            <div class="card-body">
                <canvas id="PaymentStatusChart" height="300"></canvas>
            </div>
        </div>
    </div>

    <div class="chart-card demographic">
        <div class="card">
            <div class="card-header bg-primary text-white">Applicant Count by Educational Level</div>
            <div class="card-body">
                <canvas id="PaymentForChart" height="300"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    const GradeLevelData = {!! json_encode($gradeLevel->pluck('total')) !!};
    const GradeLevelTotal = GradeLevelData.reduce((a, b) => a + b, 0);

    const gradeLevelCtx = document.getElementById('GradeLevelChart').getContext('2d');
    const gradeLevelChart = new Chart(gradeLevelCtx, {
        type: 'bar',
        data: {
            labels: {!! json_encode($gradeLevel->pluck('incoming_grlvl')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: GradeLevelData,
                backgroundColor: ['#0d6efd', '#20c997'],
                borderColor: '#20c997',
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
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = GradeLevelTotal > 0 ? (value / GradeLevelTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });


    const PaymentStatusData = {!! json_encode($paymentStatus->pluck('total')) !!};
    const PaymentStatusTotal = PaymentStatusData.reduce((a, b) => a + b, 0);

    const paymentStatusCtx = document.getElementById('PaymentStatusChart').getContext('2d');
    const paymentStatusChart = new Chart(paymentStatusCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($paymentStatus->pluck('payment_status')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: GradeLevelData,
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107'],
                borderColor: '#20c997',
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
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = GradeLevelTotal > 0 ? (value / GradeLevelTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
    });

    const PaymentForData = {!! json_encode($paymentFor->pluck('total')) !!};
    const PaymentForTotal = PaymentForData.reduce((a, b) => a + b, 0);

    const paymentForCtx = document.getElementById('PaymentForChart').getContext('2d');
    const paymentForChart = new Chart(paymentForCtx, {
        type: 'pie',
        data: {
            labels: {!! json_encode($paymentFor->pluck('payment_for')) !!},
            datasets: [{
                label: 'Number of Applicants',
                data: GradeLevelData,
                backgroundColor: ['#0d6efd', '#20c997', '#ffc107'],
                borderColor: '#20c997',
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
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = GradeLevelTotal > 0 ? (value / GradeLevelTotal) * 100 : 0;
                        return percentage.toFixed(1) + '%';
                    }
                }
            }
        },
        plugins: [ChartDataLabels]
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
                    window.location.href = `/export/accounting/${year}/${month}`;
                }
            });
        } else {
            window.location.href = `/export/accounting/${year}/${month}`;
        }
    });
});
</script>

@endsection

