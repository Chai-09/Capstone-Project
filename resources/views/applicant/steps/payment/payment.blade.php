<!-- Payment Form Blade -->
@extends('applicant.index')

@section('content')
<div class="container mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-8 col-lg-6">
            <div class="p-4 bg-none">

                <!-- Image -->
                <div class="image mb-3">
                    <img src="{{ asset('images/applicants/PaymentChannels.jpg') }}" class="img-fluid">
                </div>

                <!-- Payment Form -->
                <form class="step-form" action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class ="form-row">
                        <div class="form-col payment-label">
                            <label for="payment_mode" class="form-label">Mode of Payment: <span class="text-danger">*</span></label>
                            <select class="form-select" id="payment_mode" name="payment_mode" required>
                                <option value="" disabled selected hidden>Select one of these options</option>
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
                            <input class="form-control" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*,.pdf" required>
                        </div>
                    </div>

                    <div class="form-row text-center">
                        <div class="form-col">
                            <button type="submit" class="btn btn-submit">Submit</button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection