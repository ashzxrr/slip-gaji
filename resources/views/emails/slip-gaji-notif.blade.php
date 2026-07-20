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
        .header p { color: #fde68a; margin: 4px 0 0; font-size: 12px; }
        .body { padding: 28px 24px; }
        .greeting { font-size: 15px; color: #374151; margin-bottom: 16px; }
        .info-box { background: #fffbeb; border: 1px solid #fde68a; 
                    border-radius: 8px; padding: 16px; margin: 16px 0; }
        .info-box p { margin: 4px 0; font-size: 13px; color: #92400e; }
        .btn { display: block; width: fit-content; margin: 20px auto;
               background: linear-gradient(135deg, #b45309, #d97706);
               color: white; text-decoration: none; padding: 12px 28px;
               border-radius: 8px; font-size: 14px; font-weight: bold; }
        .credential { background: #f9fafb; border-radius: 8px; 
                      padding: 14px; margin: 16px 0; font-size: 13px; }
        .credential p { margin: 4px 0; color: #374151; }
        .footer { padding: 16px; text-align: center; font-size: 11px; 
                  color: #9ca3af; border-top: 1px solid #f3f4f6; }
        .warning { background: #fef3c7; border-left: 3px solid #f59e0b;
                   padding: 10px 14px; border-radius: 4px; 
                   font-size: 12px; color: #92400e; margin-top: 16px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PT Walet Abdillah Jabli</h1>
            <p>Slip Gaji {{ $periode->bulan }} {{ $periode->tahun }}</p>
        </div>
        <div class="body">
            <p class="greeting">
                Halo, <strong>{{ $slip->karyawan->nama }}</strong>! 👋
            </p>
            <p style="font-size:14px; color:#374151;">
                Slip gaji Anda untuk periode 
                <strong>{{ $periode->bulan }} {{ $periode->tahun }}</strong> 
                telah tersedia.
            </p>

            <div class="info-box">
                <p>📋 <strong>Jabatan:</strong> {{ $slip->karyawan->jabatan }}</p>
                <p>🏢 <strong>Departemen:</strong> {{ $slip->karyawan->departemen }}</p>
                <p>📅 <strong>Periode:</strong> {{ $periode->bulan }} {{ $periode->tahun }}</p>
            </div>

            <p style="font-size:13px; color:#374151;">
                Silakan login ke portal karyawan untuk melihat rincian dan mengunduh slip gaji Anda:
            </p>

            <a href="{{ config('app.url') }}/portal/login" class="btn">
                Lihat Slip Gaji Saya →
            </a>

            <div class="credential">
                <p>👤 <strong>Username:</strong> {{ $slip->karyawan->username }}</p>
                <p>🔑 <strong>Password:</strong> Password yang telah Anda buat</p>
            </div>

            <div class="warning">
                ⚠️ Jangan bagikan informasi login Anda kepada siapapun.
            </div>
        </div>
        <div class="footer">
            PT Walet Abdillah Jabli &mdash; Sistem Informasi Slip Gaji<br>
            Email ini dikirim otomatis, mohon tidak membalas email ini.
        </div>
    </div>
</body>
</html>
