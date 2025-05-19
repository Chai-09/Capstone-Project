@extends('admission.admission-home')

@section('content')

    
    <div class="container mt-4">
    <h2 class="text-white mb-4">Dashboard Metrics</h2>
    <div class="row g-4">

        <!-- New Applicants -->
        <div class="col-md-3">
            <div class="dashboard-card bg-white rounded p-4">
                <span class="fw-semibold text-muted">New Applicants ({{ now()->year }})</span>
                <h3 class="mb-0">{{ $newApplicants }}</h3>
            </div>
        </div>

        <!-- Examinees -->
        <div class="col-md-3">
            <div class="dashboard-card bg-white rounded p-4">
                <span class="fw-semibold text-muted">Examinees</span>
                <h3 class="mb-0">{{ $examinees }}</h3>
            </div>
        </div>

        <!-- Verified Payments -->
        <div class="col-md-3">
            <div class="dashboard-card bg-white rounded p-4">
                <span class="fw-semibold text-muted">Verified Payments</span>
                <h3 class="mb-0">{{ $verifiedPayments }}</h3>
            </div>
        </div>

        <!-- Completed Applicants -->
        <div class="col-md-3">
            <div class="dashboard-card bg-white rounded p-4">
                <span class="fw-semibold text-muted">Completed Applicants</span>
                <h3 class="mb-0">{{ $doneApplicants }}</h3>
            </div>
        </div>
    </div>
</div>

<div class="card mt-5">
    <div class="card-header bg-white">
        <h5 class="mb-0 fw-bold">Applicants per Stage Level</h5>
    </div>
    <div class="card-body p-0">
        <table class="table table-hover mb-0">
            <thead class="table-light">
                <tr>
                    <th scope="col">
                        <i class="bi bi-diagram-3"></i> Stage Level
                    </th>
                    <th scope="col" class="text-end">
                        Number of Applicants
                    </th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><i class="bi bi-person-lines-fill me-2"></i> Fill-up Forms</td>
                    <td class="text-end">{{ $stepCounts['Fill-up Forms'] }}</td>
                </tr>
                <tr>
                    <td><i class="bi bi-cash-coin me-2"></i> Send Payment</td>
                    <td class="text-end">{{ $stepCounts['Send Payment'] }}</td>
                </tr>
                <tr>
                    <td><i class="bi bi-receipt-cutoff me-2"></i> Payment Verification</td>
                    <td class="text-end">{{ $stepCounts['Payment Verification'] }}</td>
                </tr>
                <tr>
                    <td><i class="bi bi-calendar-check me-2"></i> Schedule Entrance Exam</td>
                    <td class="text-end">{{ $stepCounts['Schedule Entrance Exam'] }}</td>
                </tr>
                <tr>
                    <td><i class="bi bi-pencil-square me-2"></i> Examination</td>
                    <td class="text-end">{{ $stepCounts['Examination'] }}</td>
                </tr>
                <tr>
                    <td><i class="bi bi-bar-chart-line me-2"></i> Results</td>
                    <td class="text-end">{{ $stepCounts['Results'] }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</div>

@endsection