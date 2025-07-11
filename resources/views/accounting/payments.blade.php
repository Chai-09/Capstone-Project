@extends('accounting.index')

@section('content')

  <div class="dashboard" style="display: block;">
    <div class="content">
      <h2 class="text-white mb-4 fw-semibold">Dashboard</h2>
      <div class="row g-4">

          <!-- New Applicants -->
          <div class="col-md-3 col-sm-6">
            <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
              <div>
                <div class="text-muted small fw-semibold mb-1">Pending</div>
                <h3 class="mb-0 fw-bold">{{ $pendingPayments }}</h3>
              </div>
              <div class="icon-box bg-primary bg-opacity-10 text-primary rounded p-2">
                <i class="bi bi-briefcase-fill fs-4"></i>
              </div>
            </div>
          </div>


          <!-- Examinees -->
          <!-- Approved -->
          <div class="col-md-3 col-sm-6">
            <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
              <div>
                <div class="text-muted small fw-semibold mb-1">Approved</div>
                <h3 class="mb-0 fw-bold">{{ $approvedPayments }}</h3>
              </div>
              <div class="icon-box bg-info bg-opacity-10 text-info rounded p-2">
                <i class="bi bi-list-check fs-4"></i>
              </div>
            </div>
          </div>

          <!-- Denied -->
          <div class="col-md-3 col-sm-6">
            <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
              <div>
                <div class="text-muted small fw-semibold mb-1">Denied</div>
                <h3 class="mb-0 fw-bold">{{ $deniedPayments }}</h3>
              </div>
              <div class="icon-box bg-danger bg-opacity-10 text-danger rounded p-2">
                <i class="bi bi-person-x-fill fs-4"></i>
              </div>
            </div>
          </div>

          <!-- Total -->
          <div class="col-md-3 col-sm-6">
            <div class="dashboard-card bg-white rounded p-4 d-flex justify-content-between align-items-center shadow-sm">
              <div>
                <div class="text-muted small fw-semibold mb-1">Total</div>
                <h3 class="mb-0 fw-bold">{{ $totalPayments }}</h3>
              </div>
              <div class="icon-box bg-success bg-opacity-10 text-success rounded p-2">
                <i class="bi bi-bullseye fs-4"></i>
              </div>
            </div>
          </div>

      </div>
  </div>

  </div>


  <div class="table-design">
    {{-- Alert --}}
    @if (session('success'))
    <div class="alert alert-success alert-dismissible fade show text-center" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif


    {{-- Filter Methods --}}
    <form method="GET" id="filterForm" action="{{ route('accountingdashboard') }}">
      <div class="filter-bar" style="gap: 10px;">
        
        {{-- Filter Button --}}
        <div class="dropdown">
          <button class="btn btn-filter dropdown-toggle" type="button" data-bs-toggle="dropdown">
            Add filter
          </button>
          <div class="dropdown-menu p-3" style="min-width: 300px;">
            {{-- Educational Level --}}
            <div class="mb-3">
              <label for="educational_level" class="form-label">Educational Level</label>
              <select name="educational_level" id="educational_level" class="form-select form-select-sm">
                <option value="">All Grade Levels</option>
                @foreach (['Kinder','Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6','Grade 7','Grade 8','Grade 9','Grade 10','Grade 11','Grade 12'] as $level)
                  <option value="{{ $level }}" {{ request('educational_level') == $level ? 'selected' : '' }}>{{ $level }}</option>
                @endforeach
              </select>
            </div>

            {{-- Payment Status --}}
            <div class="mb-3">
              <label for="payment_status" class="form-label">Payment Status</label>
              <select name="payment_status" id="payment_status" class="form-select form-select-sm">
                <option value="">All Statuses</option>
                <option value="pending" {{ request('payment_status') == 'pending' ? 'selected' : '' }}>Pending</option>
                <option value="approved" {{ request('payment_status') == 'approved' ? 'selected' : '' }}>Approved</option>
                <option value="denied" {{ request('payment_status') == 'denied' ? 'selected' : '' }}>Denied</option>
              </select>
            </div>

            {{-- Mode of Payment --}}
            <div class="mb-3">
              <label for="payment_method" class="form-label">Mode of Payment</label>
              <select name="payment_method" id="payment_method" class="form-select form-select-sm">
                <option value="">All Methods</option>
                <option value="BDO" {{ request('payment_method') == 'BDO' ? 'selected' : '' }}>BDO</option>
                <option value="LandBank" {{ request('payment_method') == 'LandBank' ? 'selected' : '' }}>LandBank</option>
                <option value="Robinsons_Bank" {{ request('payment_method') == 'Robinsons_Bank' ? 'selected' : '' }}>Robinsons Bank</option>
                <option value="MetroBank" {{ request('payment_method') == 'MetroBank' ? 'selected' : '' }}>MetroBank</option>
                <option value="BPI" {{ request('payment_method') == 'BPI' ? 'selected' : '' }}>BPI</option>
              </select>
            </div>

            {{-- Payment Type --}}
            <div class="mb-3">
              <label for="payment_for" class="form-label">Payment Type</label>
              <select name="payment_for" class="form-select">
              <option value="">All Types</option>
              <option value="first-time" {{ request('payment_for') == 'first-time' ? 'selected' : '' }}>First Time</option>
              <option value="resched" {{ request('payment_for') == 'resched' ? 'selected' : '' }}>Reschedule</option>
             </select>
            </div>
          </div>
        </div>

        {{-- Search Input --}}
        <div class="search-wrapper">
          <input type="text" name="search" class="search-input" placeholder="Search for an applicant by name or email" value="{{ request('search') }}">
          <i class="bi bi-search position-absolute" style="left: 12px; top: 50%; transform: translateY(-50%); color: #888;"></i>
        </div>

        {{-- Submit Button --}}
        <button type="submit" class="btn btn-search">Search</button>
      </div>
    </form>

    
    {{-- Table --}}
    <div class="table-wrapper">
      <table class="custom-table">

        {{-- Category Names --}}
        <thead>
          <tr>
            <th style="width: 5%">#</th>
            <th style="width: 30%; position: relative;">
              <div class="d-flex justify-content-between align-items-center w-100">
                <span>Applicant Name</span>
                <div class="dropdown">
                  <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                          type="button"
                          id="sortNameDropdown"
                          data-bs-toggle="dropdown"
                          aria-expanded="false"
                          style="line-height: 1;">
                    <i class="bi bi-funnel"></i>
                  </button>
                  <ul class="dropdown-menu dropdown-menu-end"
                      aria-labelledby="sortNameDropdown"
                      style="min-width: 200px;">
                    <li><strong class="dropdown-header">Sort by Name</strong></li>
                    <li>
                      <a class="dropdown-item {{ request('sort_name') === 'asc' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['sort_name' => 'asc', 'sort_date' => null]) }}">
                        A to Z
                      </a>
                    </li>
                    <li>
                      <a class="dropdown-item {{ request('sort_name') === 'desc' ? 'active' : '' }}"
                        href="{{ request()->fullUrlWithQuery(['sort_name' => 'desc', 'sort_date' => null]) }}">
                        Z to A
                      </a>
                    </li>
                    <li><hr class="dropdown-divider"></li>
                    <li>
                      <a class="dropdown-item {{ !request('sort_name') && !request('sort_date') ? 'active' : '' }}"
                        href="{{ request()->url() }}">
                        Default (Latest)
                      </a>
                    </li>
                  </ul>
                </div>
              </div>
            </th>

           <th style="width: 15%; position: relative;">
            <div class="d-flex justify-content-between align-items-center w-100">
              <span>Grade Level</span>
              <div class="dropdown">
                <button class="btn btn-light btn-sm p-1 px-2 border rounded"
                        type="button"
                        id="sortNameDropdown"
                        data-bs-toggle="dropdown"
                        aria-expanded="false"
                        style="line-height: 1;">
                  <i class="bi bi-funnel"></i>
                </button>
                <ul class="dropdown-menu dropdown-menu-end"
                    aria-labelledby="sortGradeDropdown"
                    style="min-width: 200px;">
                  <li><strong class="dropdown-header">Sort by Grade</strong></li>
                  <li>
                    <a class="dropdown-item {{ request('sort_grade') === 'asc' ? 'active' : '' }}"
                      href="{{ request()->fullUrlWithQuery(['sort_grade' => 'asc', 'sort_name' => null, 'sort_date' => null]) }}">
                      Kinder to Grade 12
                    </a>
                  </li>
                  <li>
                    <a class="dropdown-item {{ request('sort_grade') === 'desc' ? 'active' : '' }}"
                      href="{{ request()->fullUrlWithQuery(['sort_grade' => 'desc', 'sort_name' => null, 'sort_date' => null]) }}">
                      Grade 12 to Kinder
                    </a>
                  </li>
                  <li><hr class="dropdown-divider"></li>
                  <li>
                    <a class="dropdown-item {{ !request('sort_grade') ? 'active' : '' }}"
                      href="{{ request()->url() }}">
                      Default
                    </a>
                  </li>
                </ul>
              </div>
            </div>
          </th>
            <th style="width: 16%">Payment Method</th>
            <th style="width: 16%">Proof of Payment</th>
            <th>Status</th>
            <th>Type</th>
          </tr>
        </thead>
        
        {{-- Shows Data --}}
        <tbody>
          @forelse ($payments as $index => $payment)
            <tr onclick="viewInfo({{ json_encode($payment) }})" style="cursor: pointer;">
              <td>{{ ($payments->currentPage() - 1) * $payments->perPage() + $loop->iteration }}</td>
              <td>{{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</td>
              <td>{{ $payment->incoming_grlvl }}</td>
              <td>{{ $payment->payment_method }}</td>
              <td>
                <a href="javascript:void(0)" class="proof-text" onclick="event.stopPropagation(); viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
                  Proof of Payment
                </a>
              </td>
              <td>
                @if ($payment->payment_status == 'pending')
                  <span class="payment-status pending">Pending</span>
                @elseif ($payment->payment_status == 'approved')
                  <span class="payment-status approved">Approved</span>
                @elseif ($payment->payment_status == 'denied')
                  <span class="payment-status denied">Denied</span>
                @endif
              </td>
              <td>
              @if ($payment->payment_for === 'resched')
                  <span class="badge bg-warning text-dark">Reschedule</span>  
              @else
                  <span class="badge bg-success">First Time</span>
              @endif
             </td>
            </tr>
            @empty
            <tr>
              <td colspan="7">No payments found.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>
  </div>

  <!-- Pagination -->
  <div class="d-flex justify-content-center mt-4">
    {{ $payments->withQueryString()->links('pagination::bootstrap-5') }}
  </div>

<!-- Applicant's Payment Info Modal -->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl modal-dialog-centered">
    <div class="modal-content shadow rounded-4">
      <div class="modal-header bg-light border-0">
        <h5 class="modal-title fw-semibold" id="infoModalLabel">Applicant's Payment Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <form id="updateForm" method="POST" action="">
        @csrf
        @method('PUT')

        <div class="modal-body py-4">
          <input type="hidden" id="paymentId" name="payment_id">

          <div class="container-fluid">
            <!-- Applicant Info -->
            <h6 class="fw-semibold mb-3">Applicant’s Information</h6>
            <div class="row mb-4">
              <div class="col-md-3"><label>ID Number:</label><br><span id="idNumber"></span></div>
              <div class="col-md-3"><label>Applicant's Name:</label><br><span id="applicantName"></span></div>
              <div class="col-md-3"><label>Grade Level:</label><br><span id="gradeLevel"></span></div>
              <div class="col-md-3"><label>Contact Number:</label><br><span id="contactNumber"></span></div>
            </div>
            <div class="row mb-4">
              <div class="col-md-6"><label>Guardian's Name:</label><br><span id="guardianName"></span></div>
            </div>

            <hr>

            <!-- Payment Info -->
            <h6 class="fw-semibold mb-3">Payment Information</h6>
            <div class="row mb-4">
              <div class="col-md-4"><label>Time of Payment:</label><br><span id="paymentTime"></span></div>
              <div class="col-md-4"><label>Mode of Payment:</label><br><span id="paymentMethod"></span></div>
              <div class="col-md-4">
                <label>Status:</label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_status" id="acceptStatus" value="approved">
                  <label class="form-check-label" for="acceptStatus">Accept</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_status" id="denyStatus" value="denied">
                  <label class="form-check-label" for="denyStatus">Deny</label>
                </div>
              </div>
            </div>
            <div class="row mb-4">
              <div class="col-md-4">
                <label>Payment Type:</label><br>
                <span id="paymentType"></span>
              </div>
              <div class="col-md-4">
                <label>Proof of Payment:</label><br>
                <a href="#" onclick="event.preventDefault(); viewProofFromModal();" class="proof-text">
                  Click here to view uploaded receipt
                </a>
              </div>
              <div class="col-md-4">
                {{-- @if ($payment->receipt)
                  <label>Payment Receipt:</label><br> 
                    <a href="javascript:void(0);" onclick="viewProof('{{ asset('storage/' . $payment->receipt) }}')" class="proof-text">
                      Click here to view
                    </a>
                  </p>
                @endif --}}
              </div>
            </div>

            <hr>

            <!-- Remarks -->
            <div class="mb-3">
              <label for="remarks" class="form-label fw-semibold">Remarks:</label>
              <textarea class="form-control" id="remarks" name="remarks" rows="3" placeholder="Enter remarks here..." required></textarea>
            </div>

          <!-- OCR and Receipt Upload (only if approved) -->
          <div id="approvedFields" style="display: none;">
            <p class="fw-bold text-danger">NOTE: Add OCR and Receipt only if payment is approved.</p>
            <div class="row align-items-start">

              <!-- Upload Receipt Dropzone -->
              <div class="col-md-6">
                <label class="form-label fw-semibold">Upload Receipt</label>
                <div class="small text-muted mb-2">Max 2MB. Accepted: PNG, JPG, JPEG, PDF.</div>
                <div id="receiptDropzone" class="dropzone border border-secondary rounded p-3" style="min-height: 120px;"></div>
                <input type="hidden" name="receipt" id="receipt">
              </div>
              <!-- OCR Number Input -->
              <div class="col-md-6">
                <label for="ocr_number" class="form-label fw-semibold">OCR Number</label>
                <input type="number" class="form-control" id="ocr_number" name="ocr_number" placeholder="Enter OCR Number">
              </div>
            </div>
          </div>

        <div class="modal-footer bg-white border-0">
          <button type="submit" class="btn btn-success w-100">Submit Decision</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('filterForm');
    const selects = form.querySelectorAll('select');

    selects.forEach(select => {
      select.addEventListener('change', () => {
        form.submit();
      });
    });
  });
</script>


@endsection

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
