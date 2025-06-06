<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Exam Status Update</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <tr>
            <td align="center">
                <table width="480" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
                    
                    <!-- Greeting and Status -->
                    <tr>
                        <td>
                            <p style="font-size: 16px; color: #333333; line-height: 1.6; margin-bottom: 20px;">
                                <strong>Dear Ma'am/Sir, {{ $applicant->applicant_lname }}!</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Conditional Message -->
                    <tr>
                        <td>
                            @if ($status === 'Done')
                                <p style="font-size: 15px; color: #555555; line-height: 1.6; margin-top: 20px;">
                                    You have completed the exam. Please wait for your exam result — we will notify you soon.
                                </p>
                            @elseif ($status === 'No show')
                                <p style="font-size: 15px; color: #555555; line-height: 1.6; margin-top: 20px;">
                                    It looks like you missed your exam schedule. Please contact Admissions to reschedule.
                                </p>
                            @endif
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="padding-top: 30px;">
                            <p style="font-size: 14px; color: #777777; line-height: 1.5;">
                                Thank you and have a nice day!
                            </p>
                        </td>
                    </tr>
                </table>

                <!-- Copyright -->
                <p style="margin-top: 20px; font-size: 12px; color: #999;">
                    &copy; {{ now()->year }} | FEU DILIMAN-APPLYSMART
                </p>

                <!-- Prevent Gmail Trimming -->
                <span style="display:none;">{{ uniqid() }}{{ now() }}</span>
            </td>
        </tr>
    </table>
</body>
</html>
