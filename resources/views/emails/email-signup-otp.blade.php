<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Email Verification - ApplySmart</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="480" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
          
          <!-- Logo -->
          <tr>
            <td style="padding-bottom: 20px;">
              <img src="https://i.imgur.com/ZaP8Yck.png" alt="FEU Logo" style="width: 100px; height: auto;">
            </td>
          </tr>

          <!-- Title & Instructions -->
          <tr>
            <td>
              <h2 style="font-size: 26px; margin: 0 0 16px; color: #000; font-weight: bold;">
                Verify Your Email
              </h2>
              <p style="font-size: 15px; color: #555; line-height: 1.6; margin: 0 0 30px;">
                Thank you for signing up with <strong>ApplySmart</strong>!<br>
                Use the 6-digit OTP code below to verify your email and complete your registration.
              </p>
            </td>
          </tr>

          <!-- OTP Box -->
          <tr>
            <td>
              <div style="display: inline-block; background-color: #e6ffe6; color: #111; padding: 16px 36px; border-radius: 8px; font-size: 24px; font-weight: bold; letter-spacing: 3px; margin-bottom: 20px;">
                {{ $otp }}
              </div>
            </td>
          </tr>

          <!-- Expiry Text -->
          <tr>
            <td style="padding-top: 10px;">
              <p style="font-size: 13px; color: #999999; line-height: 1.5;">
                This code will expire in 5 minutes. If you didn’t request this, you can safely ignore this email.
              </p>
            </td>
          </tr>
        </table>

        <!-- Copyright -->
        <p style="margin-top: 20px; font-size: 12px; color: #999;">
          &copy; {{ now()->year }} | FEU DILIMAN-APPLYSMART
        </p>

        {{-- Gmail Trimming --}}
        <span style="display:none;">{{ uniqid() }}{{ now() }}</span>
      </td>
    </tr>
  </table>
</body>
</html>
