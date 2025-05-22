<!-- Payment Form Blade -->
@extends('applicant.index')

@section('content')
<div class="container mt-4 payment">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-lg-6">

            {{-- Back End Error --}}
            @include('applicant.error.alert-error')
            
            <!-- Image -->
            <div class="image mb-3">
                <img src="{{ asset('images/applicants/payment.png') }}" class="img-fluid">
            </div>
                @if ($isPaymentSubmitted)
                    <div class="alert alert-info">
                        You have already submitted a payment (Status: <strong>{{ ucfirst($existingPayment->payment_status) }}</strong>). You cannot resubmit unless your payment is denied.
                    </div>
                @endif

                <!-- Payment Form --> 
                <!-- Added disable condition if payment exists -->
                <form class="step-form" id="step2Payment" action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-row">
                        <div class="form-col payment-label">
                            <input type="hidden" name="payment_for" value="{{ $isReschedPayment ? 'resched' : 'first-time' }}">
                            <label for="payment_mode" class="form-label">Mode of Payment: <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_mode" name="payment_mode" {{ $isPaymentSubmitted ? 'disabled' : '' }}>
                                <option value="">Select one of these options</option>
                                <option value="BDO">BDO</option>
                                <option value="Robinsons_Bank">Robinsons Bank</option>
                                <option value="LandBank">LandBank</option>
                                <option value="Metrobank">MetroBank</option>
                                <option value="BPI">BPI</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col payment-label">
                            <label for="proof_of_payment" class="form-label">Attach Proof of Payment: <span class="text-danger">*</span></label>
                            <label class="text-secondary">Upload limit is 2MB. Accepted file types: png, jpg, jpeg, pdf.</label>
                            <input class="form-control" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*,.pdf" required {{ $isPaymentSubmitted ? 'disabled' : '' }}>
                        </div>
                    </div>

                   @if (!$isPaymentSubmitted)
                    <div class="form-row text-center">
                        <div class="form-col">
                            <button type="button" class="btn btn-submit" id="paymentSubmission">Submit</button>
                        </div>
                    </div>
                    @endif

                </form>
        </div>
    </div>
</div>
@endsection