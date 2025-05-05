<!-- Payment Form Blade -->
@extends('applicant.index')

@section('content')
<div class="container mt-4 payment">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-lg-6">
            <div class="p-4 bg-none">

                <!-- Image -->
                <div class="image mb-3">
                    <img src="{{ asset('images/applicants/PaymentChannels.jpg') }}" class="img-fluid">
                </div>
                    <!-- Extra message if payment exists paiba nalang paul ng design salamuch -->
                     @if ($existingPayment)
                        <div class="alert alert-info">
                            You have already submitted a payment (Status: <strong>{{ ucfirst($existingPayment->payment_status) }}</strong>). You cannot resubmit unless your payment is denied.
                        </div>
                    @endif

                <!-- Payment Form --> 
                <!-- Added disable condition if payment exists -->
                <form class="step-form" action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class ="form-row">
                        <div class="form-col payment-label">
                            <label for="payment_mode" class="form-label">Mode of Payment: <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_mode" name="payment_mode" required {{ $existingPayment ? 'disabled' : '' }}>
                                <option value="" disabled {{ !$existingPayment ? 'selected' : '' }}>Select one of these options</option>
                                <option value="BDO" {{ $existingPayment && $existingPayment->payment_method == 'BDO' ? 'selected' : '' }}>BDO</option>
                                <option value="Robinsons_Bank" {{ $existingPayment && $existingPayment->payment_method == 'Robinsons_Bank' ? 'selected' : '' }}>Robinsons Bank</option>
                                <option value="LandBank" {{ $existingPayment && $existingPayment->payment_method == 'LandBank' ? 'selected' : '' }}>LandBank</option>
                                <option value="Metrobank" {{ $existingPayment && $existingPayment->payment_method == 'Metrobank' ? 'selected' : '' }}>MetroBank</option>
                                <option value="BPI" {{ $existingPayment && $existingPayment->payment_method == 'BPI' ? 'selected' : '' }}>BPI</option>
                            </select>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-col payment-label">
                            <label for="proof_of_payment" class="form-label">Attach Proof of Payment: <span class="text-danger">*</span></label>
                            <p>Upload limit is 2MB. Accepted file types: png, jpg, jpeg, pdf.</p>
                            <input class="form-control" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*,.pdf" required {{ $existingPayment ? 'disabled' : '' }}>

                        </div>
                    </div>

                    @if (!$existingPayment)
                    <div class="form-row text-center">
                        <div class="form-col">
                            <button type="submit" class="btn btn-submit">Submit</button>
                        </div>
                    </div>
                @endif
                </form>

            </div>
        </div>
    </div>
</div>
@endsection