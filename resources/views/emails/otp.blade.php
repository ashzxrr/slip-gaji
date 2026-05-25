<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #f5f5f5; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: white; border-radius: 12px; overflow: hidden; }
        .header { background: #15803d; padding: 24px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 18px; }
        .body { padding: 32px; text-align: center; }
        .otp { font-size: 42px; font-weight: bold; letter-spacing: 10px; color: #15803d;
               background: #f0fdf4; border: 2px dashed #86efac; border-radius: 10px;
               padding: 16px 24px; margin: 24px 0; display: inline-block; }
        .footer { padding: 16px; text-align: center; font-size: 11px; color: #999; border-top: 1px solid #eee; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PT Walet Abdillah Jabli</h1>
        </div>
        <div class="body">
            <p>Halo <strong>{{ $nama }}</strong>,</p>
            <p>Berikut kode OTP untuk login ke Portal Slip Gaji:</p>
            <div class="otp">{{ $otp }}</div>
            <p style="color:#666; font-size:13px;">Kode berlaku selama <strong>5 menit</strong>.<br>Jangan berikan kode ini kepada siapapun.</p>
        </div>
        <div class="footer">
            PT Walet Abdillah Jabli &mdash; Sistem Informasi Slip Gaji
        </div>
    </div>
</body>
</html>