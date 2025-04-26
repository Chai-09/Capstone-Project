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
    <form action="{{ route('admin.createaccounts') }}" method="GET" class="ms-auto">
        <button type="submit" class="btn btn-primary">Add User</button>
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
                <th>Contact</th>
                <th>Email</th>
                <th>Payment Method</th>
                <th>Proof</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($payments as $payment)
                <tr>
                    <td>{{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</td>
                    <td>{{ $payment->incoming_grlvl }}</td>
                    <td>{{ $payment->applicant_contact_number }}</td>
                    <td>{{ $payment->applicant_email }}</td>
                    <td>{{ $payment->payment_method }}</td>
                    <td>
                        <button class="btn btn-primary btn-sm" onclick="viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
                            View Proof
                        </button>
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
                    <td>
                        @if ($payment->payment_status == 'pending')
                        <form action="{{ route('accountant.payments.approve', $payment->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-success btn-sm">Approve</button>
                        </form>
                        <form action="{{ route('accountant.payments.deny', $payment->id) }}" method="POST" style="display: inline-block;">
                            @csrf
                            <button type="submit" class="btn btn-danger btn-sm">Deny</button>
                        </form>
                        @else
                        <span class="text-muted">No Action</span>
                        @endif
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
</script>

</body>
</html>
