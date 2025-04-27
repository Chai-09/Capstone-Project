<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href='https://fonts.googleapis.com/css?family=Poppins' rel='stylesheet'>
    <link rel="website icon" type="png" href="{{ asset('applysmart_logo.png') }}">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <title>Payment verification</title>
    
</head>
<body>
@include('applicant.navbar.navbar')
@include('applicant.sidebar.sidebar')

<div class="container mt-5">

    <h2 class="mb-4 text-center">Payment Verification</h2>

    @if (session('success'))
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                title: 'Success!',
                text: @json(session('success')),
                icon: 'success',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            });
        });
    </script>
    @endif

    @forelse ($payments as $payment)
        <div class="border rounded p-4 mb-5 shadow-sm">

            <p><strong>Applicant’s Name:</strong> {{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</p>

            <p><strong>Incoming Grade Level:</strong> {{ $payment->incoming_grlvl }}</p>

            <p><strong>Email:</strong> {{ $payment->applicant_email }}</p>

            <p><strong>Contact Number:</strong> {{ $payment->applicant_contact_number }}</p>

            <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>

            <p><strong>Proof of Payment:</strong> 
                <a href="javascript:void(0);" onclick="viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
                    {{ basename($payment->proof_of_payment) }}
                </a>
            </p>

            @if ($payment->payment_status === 'pending')
                <div class="text-center mt-4">
                    <button class="btn btn-secondary" disabled>Proceed</button>
                </div>
            @elseif ($payment->payment_status === 'approved')
                <div class="text-center mt-4">
                    <a href="{{ url('/applicant/steps/exam_date/exam-date') }}" class="btn btn-success">Proceed</a>
                </div>
            @elseif ($payment->payment_status === 'denied')
            <div class="text-center mt-4">
                <form method="POST" action="{{ route('payment.delete', ['id' => $payment->id]) }}">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Back</button>
                </form>
            </div>
        @endif
        </div>
        @empty
        <div class="alert alert-info text-center">
            No payment records found.
        </div>
    @endforelse

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