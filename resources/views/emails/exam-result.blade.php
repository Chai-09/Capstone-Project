<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exam Result Released</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">

                    <!-- Greeting and Result -->
                    <tr>
                        <td>
                            <p style="font-size: 16px; color: #333; line-height: 1.6;">
                                <strong> Dear Ma'am/Sir, {{ $applicant->applicant_lname }}!</strong>
                            </p>
                            <p style="font-size: 16px; color: #333; line-height: 1.6;">
                                We are pleased to inform you that your entrance exam result is now available:
                            </p>
                            <p style="font-size: 18px; font-weight: bold; color: #16a34a; margin: 12px 0;">
                                {{ $result }}
                            </p>
                        </td>
                    </tr>

                    <!-- Conditional Message -->
                    <tr>
                        <td>
                            @if (strtolower($result) === 'passed')
                                <p style="font-size: 15px; color: #555; line-height: 1.6;">
                                    Congratulations on passing the entrance exam! We look forward to welcoming you to FEU Diliman. Please await further instructions from our Admissions team regarding the next steps in your enrollment process.
                                </p>
                            @elseif (strtolower($result) === 'failed')
                                <p style="font-size: 15px; color: #555; line-height: 1.6;">
                                    Thank you for taking the entrance exam. Unfortunately, you did not meet the passing criteria at this time. We encourage you to reach out to our Admissions office for guidance on possible options or future opportunities.
                                </p>
                            @elseif (strtolower($result) === 'interview')
                                <p style="font-size: 15px; color: #555; line-height: 1.6;">
                                    Your application is progressing to the next stage. Please wait for an official schedule from our Admissions team regarding your interview.
                                </p>
                            @elseif (strtolower($result) === 'scholarship')
                                <p style="font-size: 15px; color: #555; line-height: 1.6;">
                                    Congratulations! You are eligible for a scholarship. Our Admissions team will contact you soon with details on how to proceed with your application.
                                </p>
                            @endif
                        </td>
                    </tr>
                </table>

                <!-- Copyright -->
                <p style="margin-top: 20px; font-size: 12px; color: #999;">
                    &copy; {{ now()->year }} | FEU DILIMAN-APPLYSMART
                </p>

                <!-- Gmail trimming prevention -->
                <span style="display: none;">{{ uniqid() }}{{ now() }}</span>
            </td>
        </tr>
    </table>
</body>
</html>
