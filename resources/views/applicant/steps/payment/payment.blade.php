<!-- Payment Form Blade -->
@extends('applicant.index')

@section('content')
<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="p-4 border rounded shadow-sm bg-white text-center">

                <!-- Image -->
                <div class="mb-4">
                    <img src="{{ asset('images/applicants/PaymentChannels.jpg') }}" class="img-fluid">
                </div>

                <!-- Payment Form -->
                <form action="{{ route('payment.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-4 text-start">
                        <label for="payment_mode" class="form-label fw-semibold">Mode of Payment: <span class="text-danger">*</span></label>
                        <select class="form-select" id="payment_mode" name="payment_mode" required>
                            <option value="" disabled selected hidden>Select one of these options</option>
                            <option value="BDO">BDO</option>
                            <option value="Robinsons_Bank">Robinsons Bank</option>
                            <option value="LandBank">LandBank</option>
                            <option value="Metrobank">MetroBank</option>
                            <option value="BPI">BPI</option>
                        </select>
                    </div>

                    <div class="mb-4 text-start">
                        <label for="proof_of_payment" class="form-label fw-semibold">Attach Proof of Payment: <span class="text-danger">*</span></label>
                        <input class="form-control" type="file" id="proof_of_payment" name="proof_of_payment" accept="image/*,.pdf" required>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>

            </div>
        </div>
    </div>
</div>
@endsection