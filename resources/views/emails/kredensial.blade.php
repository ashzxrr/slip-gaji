<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: Arial, sans-serif; background: #fdfbf5; margin: 0; padding: 20px; }
        .container { max-width: 480px; margin: 0 auto; background: white;
                     border-radius: 12px; overflow: hidden; border: 1px solid #fde68a; }
        .header { background: linear-gradient(135deg, #b45309, #d97706);
                  padding: 24px; text-align: center; }
        .header h1 { color: white; margin: 0; font-size: 18px; }
        .body { padding: 28px 24px; }
        .credential-box { background: #fffbeb; border: 2px solid #fbbf24;
                          border-radius: 10px; padding: 20px; margin: 20px 0; }
        .credential-box p { margin: 8px 0; font-size: 15px; color: #92400e; }
        .btn { display: block; width: fit-content; margin: 20px auto;
               background: linear-gradient(135deg, #b45309, #d97706);
               color: white; text-decoration: none; padding: 12px 28px;
               border-radius: 8px; font-size: 14px; font-weight: bold; }
        .warning { background: #fef3c7; border-left: 3px solid #f59e0b;
                   padding: 10px 14px; border-radius: 4px;
                   font-size: 12px; color: #92400e; margin-top: 16px; }
        .footer { padding: 16px; text-align: center; font-size: 11px;
                  color: #9ca3af; border-top: 1px solid #f3f4f6; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PT Walet Abdillah Jabli</h1>
        </div>
        <div class="body">
            <p style="font-size:15px; color:#374151;">
                Halo, <strong>{{ $karyawan->nama }}</strong>! 👋
            </p>
            <p style="font-size:13px; color:#374151;">
                Akun portal slip gaji Anda telah siap. 🎉 Berikut informasi login Anda:
            </p>

            <div class="credential-box">
                <p>👤 <strong>Username:</strong> {{ $karyawan->username }}</p>
                <p>🔑 <strong>Password:</strong> karyawan123</p>
            </div>

            <a href="{{ config('app.url') }}/portal/login" class="btn">
                Login ke Portal →
            </a>

            <div class="warning">
                ⚠️ Segera ganti password Anda setelah login pertama demi keamanan akun.
            </div>
        </div>
        <div class="footer">
            PT Walet Abdillah Jabli &mdash; Sistem Informasi Slip Gaji<br>
            Email ini dikirim otomatis, mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
