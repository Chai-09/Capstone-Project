<p>Hi {{ $applicant->applicant_fname }},</p>

<p>Your exam result has been released:</p>

<p><strong>Result:</strong> {{ $result }}</p>

@if (strtolower($result) === 'passed')
    <p>Congratulations! You have passed your entrance exam.</p>
@elseif (strtolower($result) === 'failed')
    <p>Unfortunately, you did not pass the exam. You may contact Admissions for further options.</p>
@elseif (strtolower($result) === 'interview')
    <p>Your next step is an interview. Please wait for a follow-up schedule.</p>
@elseif (strtolower($result) === 'scholarship')
    <p>Good news! You are qualified for a scholarship. Please contact Admissions to proceed.</p>
@endif

<p>– ApplySmart Admissions</p>
