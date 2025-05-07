@extends('accounting.index')

@section('content')
<div class="container mt-5">
  <h2 class="mb-4 text-center">Payment Management</h2>

  @if (session('success'))
  <div class="alert alert-success text-center">
      {{ session('success') }}
  </div>
  @endif
  <form method="GET" action="{{ route('accountingdashboard') }}" class="row g-2 mb-4">
  <div class="col-md-3">
    <select name="educational_level" class="form-select">
      <option value="">All Grade Levels</option>
      <option value="Kinder">Kinder</option>
      <option value="Grade 1">Grade 1</option>
      <option value="Grade 2">Grade 2</option>
      <option value="Grade 3">Grade 3</option>
      <option value="Grade 4">Grade 4</option>
      <option value="Grade 5">Grade 5</option>
      <option value="Grade 6">Grade 6</option>
      <option value="Grade 7">Grade 7</option>
      <option value="Grade 8">Grade 8</option>
      <option value="Grade 9">Grade 9</option>
      <option value="Grade 10">Grade 10</option>
      <option value="Grade 11">Grade 11</option>
      <option value="Grade 12">Grade 12</option>
    </select>
  </div>

  <div class="col-md-3">
    <select name="payment_status" class="form-select">
      <option value="">All Statuses</option>
      <option value="pending">Pending</option>
      <option value="approved">Approved</option>
      <option value="denied">Denied</option>
    </select>
  </div>

  <div class="col-md-4">
    <input type="text" name="search" class="form-control" placeholder="Search Applicant Name">
  </div>

  <div class="col-md-2">
    <button type="submit" class="btn btn-primary w-100">Filter</button>
  </div>
</form>

  <table class="table table-bordered text-center align-middle">
    <thead class="table-dark">
      <tr>
        <th>Applicant Name</th>
        <th>Grade Level</th>
        <th>Payment Method</th>
        <th>Proof</th>
        <th>Status</th>
        <th>Remarks</th><!--dinagdag ko to para rin makita ni accounting yung remarks per figma-->
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      @forelse ($payments as $payment)
        <tr onclick="viewInfo({{ json_encode($payment) }})" style="cursor: pointer;">
          <td>{{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</td>
          <td>{{ $payment->incoming_grlvl }}</td>
          <td>{{ $payment->payment_method }}</td>
          <td>
            <a href="javascript:void(0)" class="text-primary text-decoration-underline" onclick="event.stopPropagation(); viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
              Proof of Payment
            </a>
          </td>
          <td>
            @if ($payment->payment_status == 'pending')
              <span class="badge bg-secondary">Pending</span>
            @elseif ($payment->payment_status == 'approved')
              <span class="badge bg-success">Approved</span>
            @elseif ($payment->payment_status == 'denied')
              <span class="badge bg-danger">Denied</span>
            @endif
          </td>
          <td>{{ $payment->remarks ?? '-' }}</td>
          <td>
            {{-- Optional action space --}}
          </td>
        </tr>
        @empty
        <tr>
          <td colspan="8">No payments found.</td>
        </tr>
      @endforelse
    </tbody>
  </table>
</div>

<!-- Applicant's Payment Info Modal (ito na yung bagong way of showing yung payment info ng mga applicants-->
<div class="modal fade" id="infoModal" tabindex="-1" aria-labelledby="infoModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg modal-dialog-scrollable">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="infoModalLabel">Applicant's Information</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <form id="updateForm" method="POST" action="">
        @csrf
        @method('PUT')
        <div class="modal-body overflow-auto" style="max-height: 80vh; padding-bottom: 50px;">
          <div class="row">
            <!-- nasa left mga info per figma -->
            <div class="col-md-7">
              <input type="hidden" id="paymentId" name="payment_id">

              <p><strong>ID Number:</strong> <span id="idNumber"></span></p>
              <p><strong>Applicant's Name:</strong> <span id="applicantName"></span></p>
              <p><strong>Grade Level:</strong> <span id="gradeLevel"></span></p>
              <p><strong>Contact Number:</strong> <span id="contactNumber"></span></p>
              <p><strong>Guardian's Name:</strong> <span id="guardianName"></span></p>

              <hr>

              <h6>Payment Information</h6>
              <p><strong>Time of Payment:</strong> <span id="paymentTime"></span></p>
              <p><strong>Mode of Payment:</strong> <span id="paymentMethod"></span></p>

              <div class="mb-3">
                <label class="form-label"><strong>Status:</strong></label><br>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_status" id="acceptStatus" value="approved">
                  <label class="form-check-label" for="acceptStatus">Accept</label>
                </div>
                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="payment_status" id="denyStatus" value="denied">
                  <label class="form-check-label" for="denyStatus">Deny</label>
                </div>
              </div>
              <div class="mb-3">
                <label for="remarks" class="form-label"><strong>Remarks:</strong></label>
                <textarea class="form-control" id="remarks" name="remarks" rows="3"></textarea>
              </div>
              <div id="approvedFields">
              <div class="mb-3">
                <p><strong>NOTE: Add OCR and Receipt only if payment is approved</p></strong>
                <label for="ocr_number" class="form-label"><strong>OCR Number:</strong></label>
                <input type="text" class="form-control" id="ocr_number" name="ocr_number" placeholder="Enter OCR Number">
            </div>
            <div class="mb-3">
              <label class="form-label"><strong>Upload Receipt:</strong></label>
              <p>Upload limit is 2MB. Accepted file types: png, jpg, jpeg, pdf.</p>
              <div id="receiptDropzone" class="dropzone border border-secondary rounded" style="padding: 20px;"></div>
              <input type="hidden" name="receipt" id="receipt">
            </div>  
         </div>
        </div> 
        
        
            <!-- nilagay ko sa right yung image per figma -->
            <div class="col-md-5 text-center">
              <div id="proofContainer" class="text-center"></div>
            </div>
          </div>
        </div>
        <div class="modal-footer bg-white sticky-bottom">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>
@endsection

<script>
  window.uploadReceiptUrl = "{{ route('upload.receipt') }}";
  window.deleteReceiptUrl = "{{ route('delete.receipt') }}";
  window.csrfToken = "{{ csrf_token() }}";
</script>
