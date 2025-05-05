<h2>Hello {{ $payment->applicant_fname }}!</h2>

<p>Your payment has been <strong>{{ ucfirst($payment->payment_status) }}</strong>.</p>

@if ($payment->ocr_number)
  <p><strong>OCR Number:</strong> {{ $payment->ocr_number }}</p>
@endif

@if ($payment->remarks)
  <p><strong>Remarks:</strong> {{ $payment->remarks }}</p>
@endif

