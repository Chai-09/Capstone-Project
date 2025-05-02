<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Payments</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<nav class="navbar bg-dark p-3">
    <p style="color: white" class="m-0"> {{ auth()->user()->name }}</p>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-danger btn-sm">Logout</button>
    </form>
</nav>

<div class="container mt-5">
  <h2 class="mb-4 text-center">Payment Management</h2>

  @if (session('success'))
  <div class="alert alert-success text-center">
      {{ session('success') }}
  </div>
  @endif

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
          <td>{{ $payment->remarks ?? '-' }}</td?>
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
        <div class="modal-body">
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
            </div>

            <!-- nilagay ko sa right yung image per figma -->
            <div class="col-md-5 text-center">
              <img id="proofImage" src="" alt="Proof of Payment" class="img-fluid rounded shadow" style="max-height: 400px;">
            </div>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Submit</button>
        </div>
      </form>
    </div>
  </div>

<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
<script>
function viewProof(fileUrl) {
    Swal.fire({
        title: 'Proof of Payment',
        imageUrl: fileUrl,
        imageAlt: 'Proof of Payment',
        width: 600,
        confirmButtonText: 'Close'
    });
}

function viewInfo(data) {
    document.getElementById('idNumber').innerText = data.id || 'N/A';
    document.getElementById('applicantName').innerText = `${data.applicant_fname} ${data.applicant_mname} ${data.applicant_lname}`;
    document.getElementById('gradeLevel').innerText = `${data.incoming_grlvl} ${data.incoming_strand || ''}`.trim();
    document.getElementById('contactNumber').innerText = data.applicant_contact_number;
    document.getElementById('guardianName').innerText = data.guardian_name || 'N/A';

    document.getElementById('paymentTime').innerText = new Date(data.created_at).toLocaleString();
    document.getElementById('paymentMethod').innerText = data.payment_method;

    document.getElementById('proofImage').src = `/storage/${data.proof_of_payment}`;

    document.getElementById('acceptStatus').checked = data.payment_status === 'approved';
    document.getElementById('denyStatus').checked = data.payment_status === 'denied';
    document.getElementById('remarks').value = data.remarks || '';

    document.getElementById('paymentId').value = data.id;
    document.getElementById('updateForm').action = `/accountant/payments/${data.id}`;
    
    new bootstrap.Modal(document.getElementById('infoModal')).show();
}
</script>
</body>
</html>
