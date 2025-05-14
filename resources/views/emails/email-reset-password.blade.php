<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Reset Password</title>
</head>
<body style="margin: 0; padding: 0; background-color: #f4f4f4; font-family: Arial, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0" style="padding: 40px 0;">
    <tr>
      <td align="center">
        <table width="480" cellpadding="0" cellspacing="0" style="background-color: #ffffff; border-radius: 12px; padding: 40px 30px; text-align: center; box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);">
          <tr>
            <td style="padding-bottom: 20px;">
              <img src="https://i.imgur.com/ZaP8Yck.png" alt="FEU Logo" style="width: 100px; height: auto;">
            </td>
          </tr>

          <!-- Title -->
          <tr>
            <td>
              <h2 style="font-size: 26px; margin: 0 0 16px; color: #000; font-weight: bold;">
                Forgot Your Password?
              </h2>
              <p style="font-size: 15px; color: #555; line-height: 1.6; margin: 0 0 30px;">
                To reset your password, click the button below. The link will expire in 10 minutes.
              </p>
            </td>
          </tr>

          <!-- Reset Button -->
          <tr>
            <td>
              <a href="{{ $link }}" style="display: inline-block; background-color: #16a34a; color: #ffffff; text-decoration: none; padding: 16px 36px; border-radius: 8px; font-size: 16px; font-weight: 600;">
                Reset your password
              </a>
            </td>
          </tr>

          <!-- Footer Text -->
          <tr>
            <td style="padding-top: 30px;">
              <p style="font-size: 13px; color: #999999; line-height: 1.5;">
                If you do not want to change your password or didn’t request a reset, you can safely ignore this email.
              </p>
            </td>
          </tr>

        </table>

        <!-- Copyright -->
        <p style="margin-top: 20px; font-size: 12px; color: #999;">
          &copy; {{ now()->year }} | FEU DILIMAN-APPLYSMART
        </p>

        <span style="display:none;">{{ uniqid() }}{{ now() }}</span>
      </td>
    </tr>
  </table>
</body>
</html>
