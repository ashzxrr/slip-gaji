<!doctype html>
<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body style="margin:0;padding:0;background:#f0fdf9;font-family:Arial, Helvetica, sans-serif;">
  <table width="100%" cellpadding="0" cellspacing="0">
    <tr>
      <td align="center" style="padding:20px 10px;">
        <table width="480" cellpadding="0" cellspacing="0" style="background:#ffffff;border-radius:12px;overflow:hidden;">
          <tr>
            <td style="background:linear-gradient(90deg,#064e3b,#059669);color:#fff;padding:18px 20px;">
              <h2 style="margin:0;font-size:18px;">PT Walet Abdillah Jabli — Admin Panel</h2>
            </td>
          </tr>
          <tr>
            <td style="padding:20px;">
              <p>Halo {{ $nama }},</p>
              <p>Berikut kode OTP untuk login ke Admin Panel:</p>
              <div style="margin:18px 0;padding:18px;background:#f0fdf9;border:2px dashed #6ee7b7;border-radius:8px;text-align:center;">
                <div style="font-size:42px;letter-spacing:10px;color:#059669;font-weight:700;">{{ $otp }}</div>
              </div>
              <p style="font-size:13px;color:#555;">Kode berlaku 5 menit. Jangan berikan kode ini kepada siapapun.</p>
            </td>
          </tr>
          <tr>
            <td style="background:#f9faf9;padding:12px 20px;text-align:center;font-size:12px;color:#888;">PT Walet Abdillah Jabli</td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>