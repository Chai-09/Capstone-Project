@if($payment->payment_status === 'approved')
  <h2 style="font-size: 20px; margin-bottom: 16px; color: #000;">
    Dear Ma'am/Sir, {{ strtoupper($payment->applicant_lname) }}!
  </h2>

  <p style="font-size: 15px; color: #333; line-height: 1.6; margin-bottom: 12px;">
    Payment Status: <strong style="color: #16a34a;">{{ ucfirst($payment->payment_status) }}</strong>.
  </p>

  @if ($payment->ocr_number)
    <p style="font-size: 15px; color: #333; line-height: 1.6; margin-bottom: 12px;">
      Your official receipt number is: <strong style="text-decoration: underline;">{{ $payment->ocr_number }}</strong>
    </p>
  @endif

  <p style="font-size: 15px; color: #333; line-height: 1.6; margin-bottom: 12px;">
    The transaction has been verified and officially recorded.
  </p>

  @if ($payment->remarks)
    <p style="font-size: 15px; color: #333; line-height: 1.6; margin-top: 20px;">
      <strong>Remarks:</strong> {{ $payment->remarks }}
    </p>
  @endif

  <p style="font-size: 15px; color: #333; line-height: 1.6; margin-top: px;">
    Thank You
  </p>

@elseif($payment->payment_status === 'denied')
  <h2 style="font-size: 20px; margin-bottom: 16px; color: #000;">
    Dear Ma'am/Sir, {{ strtoupper($payment->applicant_lname) }}!
  </h2>

  <p style="font-size: 15px; color: #333; line-height: 1.6; margin-bottom: 12px;">
    Payment Status: <strong style="color: rgb(172, 23, 23);">{{ ucfirst($payment->payment_status) }}</strong>.
  </p>

  @if ($payment->remarks)
    <p style="font-size: 15px; color: #333; line-height: 1.6; margin-top: 20px;">
      <strong>Remarks:</strong> {{ $payment->remarks }}
    </p>
  @endif

  <p style="font-size: 15px; color: #333; line-height: 1.6; margin-top: 40px;">
    Thank You.
  </p>
@endif

<!-- Gmail trimming -->
<span style="display: none; color: #fff;">{{ uniqid() }} | {{ now() }}</span>
