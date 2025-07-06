@extends('applicant.index')

@section('content')

<div class="container payment-verify">
    <div class="step-form">
        <div class="form-section">
            <div class="form-row">
                <h2>You're almost there — just a few more steps to becoming a <span class="tamaraw-text">Tamaraw!</span></h2>
            </div>
            <div class="form-row">
                <p class="second-line">Please wait for an email or sms confirming your payment verification; this process may take <span class="tamaraw-text">1-4 business days</span>. If you have any issues, kindly please email us on <span class="tamaraw-text">admissions@feudiliman.edu.ph</span></p>
            </div>
        </div>
        <div class="form-section">
           @if ($existingPayment)
            @php $payment = $existingPayment; @endphp
            <div class="form-row">
                <p><span class="fw-semibold">Applicant’s Name:</span> {{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</p>
            </div>
            <div class="form-row">
                <p><span class="fw-semibold">Incoming Grade Level: </span>{{ $payment->incoming_grlvl }}</p>
            </div>   
            <div class="form-row">
                <p><span class="fw-semibold">Email: </span>{{ $payment->applicant_email }}</p>
            </div>  
            <div class="form-row">
                <p><span class="fw-semibold">Contact Number: </span>{{ $payment->applicant_contact_number }}</p>
            </div>  
            <div class="form-row">
                <p><span class="fw-semibold">Payment Method: </span>{{ $payment->payment_method }}</p>
            </div>  
            <div class="form-row">
                <p><span class="fw-semibold">Proof of Payment: </span>
                    <a href="javascript:void(0);" onclick="viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
                        View your proof of payment
                    </a>
                </p>
            </div>
        </div>  
        <div class="form-section pb-4"> {{-- Status Dot --}}
            <div class="d-flex justify-content-center align-items-center gap-2">
                @if ($payment->payment_status === 'denied')
                    <div class="status-dot bg-danger"></div>
                    <span class="fw-semibold text-danger">Denied</span>
                @elseif ($payment->payment_status === 'approved')
                    <div class="status-dot bg-success"></div>
                    <span class="fw-semibold text-success">Approved</span>
                @elseif ($payment->payment_status === 'pending')
                    <div class="status-dot bg-secondary"></div>
                    <span class="fw-semibold text-secondary">Pending</span>
                @endif
            </div>
        </div>
        <div class="form-section"> {{-- Status --}}
            <div class="form-row"> 
                @if ($payment->payment_status === 'denied')
                        <div class="alert alert-info denied">
                            <p><span class="fw-semibold">Remarks: </span>{{ $payment->remarks ?? 'No remarks provided.' }}</p>
                        </div>
                @elseif ($payment->payment_status === 'approved')
                    <div class="alert alert-info approved">
                        <p><span class="fw-semibold">OCR Number:</span> {{ $payment->ocr_number ?? 'N/A' }}</p>

                        <p><span class="fw-semibold">Payment Receipt:</span>
                            <a href="javascript:void(0);" onclick="viewProof('{{ asset('storage/' . $payment->receipt) }}')">
                                View your receipt
                            </a>
                        </p>
                        <p><span class="fw-semibold">Remarks: </span></strong>{{ $payment->remarks ?? 'No remarks provided.' }}</p>
                    </div>
                @endif       
            </div>
        </div>
        <div class="form-section">
            {{-- Button --}}
            @if ($payment->payment_status === 'pending')
                <div class="text-center mt-4">
                    <button class="btn btn-submit" disabled>Proceed</button>
                </div>
            @elseif ($payment->payment_status === 'approved' && $applicant->current_step == 3 ) {{-- Changed href link to button, to handle current_step increment update in database --}}
                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('proceed.to.exam') }}">
                        @csrf
                        <button type="submit" class="btn btn-submit">Proceed</button>
                    </form>
                </div>
            @elseif ($payment->payment_status === 'approved' && $applicant->current_step > 3) {{-- Disable proceed button if current step is greater than 3 to ensure they cant press it again afterwards--}}
                <div class="text-center mt-4">
                    <button class="btn btn-submit" disabled>Proceed</button>
                </div>

            @elseif ($payment->payment_status === 'denied')
                <div class="text-center mt-4">
                    <form method="POST" action="{{ route('payment.delete', ['id' => $payment->id]) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-submit">Back</button>
                    </form>
                </div>
            @endif
        </div>
        
        @else
            <div class="alert alert-info text-center">
                No payment records found.
            </div>
         @endif
    </div>
</div>

@endsection