<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; background-color: #e6f4ea; font-family: Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
        <!-- Para ito sa isesend na email papunta sa user, so ito yung magpapakita feel free na ibahin if pangit design Ginaya ko lang yung sa Semaphore API HAHAHHA -->
        <!-- Also if gusto niyo maglagay ng logo ni FEU sa email, erm sinubukan ko na ayaw niya gumana di ko alam bakit -->

        <tr>
            <td align="center">
                {{-- Ito yung sinasabi ko if gusto niyo subukan ayusin go lang 
                <img src="{{ asset('feudiliman_logo.png') }}" alt="FEU Diliman Logo"> 
                 --}}
                <table cellpadding="20" cellspacing="0" width="500" style="background-color: #ffffff; border-radius: 8px; box-shadow: 0 0 8px rgba(0,0,0,0.05);">
                    <tr>
                        <td align="center">
                            <h2 style="margin: 0 0 10px;">Reset Your Password</h2>

                            <p style="margin: 10px 0; font-size: 14px; color: #333;">
                                Hello,<br>
                                You requested a password reset for your FEU Diliman-ApplySmart account.
                            </p>

                            <p style="margin: 15px 0; font-size: 16px;">
                                <a href="{{ $link }}" style="background-color: #16a34a; color: white; text-decoration: none; padding: 12px 24px; border-radius: 5px; display: inline-block;">
                                    Reset Password
                                </a>
                            </p>

                            <p style="font-size: 13px; color: #666; margin-top: 10px;">
                                This link is valid for 10 minutes.<br>
                                If you did not request this, please ignore this email.
                            </p>
                        </td>
                    </tr>
                </table>

                <p style="margin-top: 20px; font-size: 12px; color: #666;">
                    Copyright {{ now()->year }} | FEU DILIMAN-APPLYSMART
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
