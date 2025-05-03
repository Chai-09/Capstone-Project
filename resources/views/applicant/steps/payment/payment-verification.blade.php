@extends('applicant.index')

@section('content')

<div class="container payment-verify">

    <div class="step-form">
        <div class="form-section">
            <div class="form-row">
                <h2>You're almost there — just a few more steps to becoming a <span class="tamaraw-text">Tamaraw!</span></h2>
            </div>
            <div class="form-row">
                <p class="second-line">Please wait for an email or sms confirming your payment verification; this process may take <span class="tamaraw-text">1-4 days</span>. If you have any issues, kindly please email us on <span class="tamaraw-text">admissions@feudiliman.edu.ph</span></p>
            </div>
        </div>
        <div class="form-section">
            @forelse ($payments as $payment)
            <div class="form-row">
                <p><strong>Applicant’s Name:</strong> {{ $payment->applicant_fname }} {{ $payment->applicant_mname }} {{ $payment->applicant_lname }}</p>
            </div>
            <div class="form-row">
                <p><strong>Incoming Grade Level:</strong> {{ $payment->incoming_grlvl }}</p>
            </div>   
            <div class="form-row">
                <p><strong>Email:</strong> {{ $payment->applicant_email }}</p>
            </div>  
            <div class="form-row">
                <p><strong>Contact Number:</strong> {{ $payment->applicant_contact_number }}</p>
            </div>  
            <div class="form-row">
                <p><strong>Payment Method:</strong> {{ $payment->payment_method }}</p>
            </div>  
            <div class="form-row">
                <p><strong>OCR Number:</strong> {{ $payment->ocr_number ?? 'N/A' }}</p>
            </div>
            <div class="form-row">
                <p><strong>Proof of Payment:</strong> 
                    <a href="javascript:void(0);" onclick="viewProof('{{ asset('storage/' . $payment->proof_of_payment) }}')">
                        {{ basename($payment->proof_of_payment) }}
                    </a>
                </p>
            </div>
        </div>  
        <div class="form-section"> {{-- Status Dot --}}
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
                        <div class="payment-status-box denied">
                            <h5>Your payment has been denied.</h5>
                            <p>{{ $payment->remarks ?? 'No remarks provided.' }}</p>
                        </div>
                    @elseif ($payment->payment_status === 'approved')
                        <div class="payment-status-box approved">
                            <h5>Your payment has been approved.</h5>
                            <p>{{ $payment->remarks ?? 'No remarks provided.' }}</p>
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
        @empty
            <div class="alert alert-info text-center">
                No payment records found.
            </div>
        @endforelse
    </div>
</div>

@endsection