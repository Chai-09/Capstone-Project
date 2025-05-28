@extends('accounting.index')

@section('content')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>

<div class="dashboard">
    <div class="content">
        <h2 class="text-white mb-4 fw-semibold">Reports</h2>
    </div>
</div>

<div class=report-layout>
    <div class="monthlyreports">
        <div class="card mb-4">
            <div class="card-header fw-semibold">Monthly Accounting Reports</div>
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

    {{-- Reports --}}
    <div class="container-fluid">
        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4 chart-section demographic">
            <div class="col">
                <div class="card chart-card">
                    <div class="card-header bg-primary text-white">Educational Level</div>
                    <div class="card-body"><canvas id="GradeLevelChart"></canvas></div>
                </div>
            </div>     
            <div class="col">
                <div class="card chart-card">
                    <div class="card-header bg-primary text-white">Payment Status</div>
                    <div class="card-body"><canvas id="PaymentStatusChart"></canvas></div>
                </div>
            </div>
            <div class="col">
                <div class="card chart-card">
                    <div class="card-header bg-primary text-white">Payment Type</div>
                    <div class="card-body"><canvas id="PaymentForChart"></canvas></div>
                </div>
            </div>
        </div>
    </div>
</div>




<script>
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
                backgroundColor: themePalette,
                borderColor: '#fff',
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
                legend: { display: false },
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
                data: PaymentStatusData,
                backgroundColor: themePalette,
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
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = PaymentStatusTotal > 0 ? (value / PaymentStatusTotal) * 100 : 0;
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
                data: PaymentForData,
                backgroundColor: themePalette,
                borderColor: '#fff',
                borderWidth: 1
            }]
        },
        options: {
            indexAxis: 'y',
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: true, position: 'bottom' },
                datalabels: {
                    color: '#fff',
                    anchor: 'center',
                    align: 'center',
                    font: { weight: 'bold', size: 12 },
                    formatter: (value) => {
                        let percentage = PaymentForTotal > 0 ? (value / PaymentForTotal) * 100 : 0;
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

