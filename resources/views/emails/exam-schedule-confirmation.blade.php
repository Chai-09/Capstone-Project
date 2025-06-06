<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exam Schedule Notification</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px 30px; text-align: left; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">

                    <!-- Header -->
                    <tr>
                        <td>
                            <h2 style="font-size: 24px; margin-bottom: 20px; color: #000; font-weight: bold; text-align: center;">
                                Your Exam Schedule is Confirmed!
                            </h2>
                        </td>
                    </tr>

                    {{-- Admission Number --}}
                    <tr>
                        <td style="font-size: 16px; line-height: 1; text-align: center;">
                            <p style="color:#16a34a; font-weight: 500;">Admission Number:</p>
                            <p style="font-size: 24px; line-height: 0.1; font-weight: 600; color:#16a34a;">{{ $admissionNumber }}</p>
                        </td>
                    </tr>

                    <!-- Details -->
                    <tr>
                        <td style="font-size: 16px; color: #333333; line-height: 1.8;">
                            <p><strong>Applicant's Name:</strong> {{ strtoupper($applicant->applicant_fname . ' ' . $applicant->applicant_lname) }}</p>
                            <p><strong>Date of Exam:</strong> {{ $date }}</p>
                            <p><strong>Time:</strong> {{ $time }}</p>
                            <p><strong>Campus:</strong> FEU Diliman</p>
                            <p><strong>Venue:</strong> MPR Annex</p>
                        </td>
                    </tr>

                    <!-- Reminder -->
                    <tr>
                        <td style="padding-top: 20px;">
                            <p style="font-size: 15px; color: #555; line-height: 1.6;">
                                Please arrive 15–30 minutes early and bring a valid ID. For any concerns, contact the Admissions Office.
                            </p>
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
