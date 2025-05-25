@extends('admission.admission-home')

@section('content')
<div class="dashboard">
  <div class="content">
    <h2 class="text-white mb-4 fw-semibold">Dashboard</h2>
    <div class="row g-4">

      <!-- New Applicants -->
      <div class="col-md-3 col-sm-6">
        <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
          <div>
            <div class="text-muted small fw-semibold mb-1">New Applicants ({{ now()->year }})</div>
            <h3 class="mb-0 fw-bold">{{ $newApplicants }}</h3>
          </div>
          <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-2">
            <i class="bi bi-person-plus-fill fs-4"></i>
          </div>
        </div>
      </div>

      <!-- Examinees -->
      <div class="col-md-3 col-sm-6">
        <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
          <div>
            <div class="text-muted small fw-semibold mb-1">Examinees</div>
            <h3 class="mb-0 fw-bold">{{ $examinees }}</h3>
          </div>
          <div class="icon-box bg-warning bg-opacity-10 text-warning rounded p-2">
            <i class="bi bi-pencil-fill fs-4"></i>
          </div>
        </div>
      </div>

      <!-- Verified Payments -->
      <div class="col-md-3 col-sm-6">
        <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
          <div>
            <div class="text-muted small fw-semibold mb-1">Verified Payments</div>
            <h3 class="mb-0 fw-bold">{{ $verifiedPayments }}</h3>
          </div>
          <div class="icon-box bg-success bg-opacity-10 text-success rounded p-2">
            <i class="bi bi-cash-stack fs-4"></i>
          </div>
        </div>
      </div>

      <!-- Completed Applicants -->
      <div class="col-md-3 col-sm-6">
        <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
          <div>
            <div class="text-muted small fw-semibold mb-1">Completed Applicants</div>
            <h3 class="mb-0 fw-bold">{{ $doneApplicants }}</h3>
          </div>
          <div class="icon-box bg-info bg-opacity-10 text-info rounded p-2">
            <i class="bi bi-check-circle fs-4"></i>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>


<div class="card shadow-sm border-0 admission-dashboard">
  <div class="card-header bg-success text-white d-flex align-items-center">
    <i class="bi bi-bar-chart me-2 fs-5"></i>
    <h5 class="mb-0 fw-semibold">Applicants per Stage Level</h5>
  </div>
  <div class="card-body p-0">
    <div class="table-responsive">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-success text-dark">
          <tr>
            <th scope="col">
              <i class="bi bi-diagram-3-fill me-1"></i> Stage Level
            </th>
            <th scope="col" class="text-end">
              <i class="bi bi-people-fill me-1"></i> Number of Applicants
            </th>
          </tr>
        </thead>
        <tbody>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 1]) }}'">
            <td><i class="bi bi-person-lines-fill me-2 text-secondary"></i> Fill-up Forms</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Fill-up Forms'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 2]) }}'">
            <td><i class="bi bi-cash-coin me-2 text-warning"></i> Send Payment</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Send Payment'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 3]) }}'">
            <td><i class="bi bi-receipt-cutoff me-2 text-danger"></i> Payment Verification</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Payment Verification'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 4]) }}'">
            <td><i class="bi bi-calendar-check me-2 text-primary"></i> Schedule Entrance Exam</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Schedule Entrance Exam'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 5]) }}'">
            <td><i class="bi bi-pencil-square me-2 text-info"></i> Examination</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Examination'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 6]) }}'">
            <td><i class="bi bi-bar-chart-line me-2 text-success"></i> Results</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Results'] }}</td>
          </tr>
          <tr onclick="window.location='{{ route('applicantlist', ['stage' => 7]) }}'">
            <td><i class="bi bi-check-circle-fill me-2 text-success"></i> Completed</td>
            <td class="text-end fw-semibold">{{ $stepCounts['Completed'] ?? 0 }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>
</div>

@endsection
