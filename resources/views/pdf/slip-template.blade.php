<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<style>
  * { margin: 0; padding: 0; box-sizing: border-box; }
  body { font-family: Arial, sans-serif; font-size: 11px; padding: 25px; color: #222; }
  .header { text-align: center; margin-bottom: 20px; }
  .header h2 { font-size: 14px; margin-bottom: 3px; }
  .header p { font-size: 11px; }
  hr { border: none; border-top: 2px solid #333; margin: 12px 0; }
  .title { text-align: center; font-size: 14px; font-weight: bold; margin: 16px 0; letter-spacing: 1px; }
  .info { width: 100%; margin-bottom: 14px; }
  .info td { padding: 2px 5px; font-size: 11px; }
  table.gaji { width: 100%; border-collapse: collapse; margin-top: 8px; }
  table.gaji th, table.gaji td { border: 1px solid #555; padding: 5px 8px; font-size: 10.5px; }
  table.gaji th { background-color: #e8e8e8; text-align: center; font-weight: bold; }
  .bold { font-weight: bold; }
  .right { text-align: right; }
  .center { text-align: center; }
  .bg-total { background-color: #f5f5f5; }
  .footer { margin-top: 14px; border: 1px solid #ccc; padding: 8px 10px; font-size: 9px; line-height: 1.6; }
</style>
</head>
<body>
@php
    $logoPath = public_path('images/logo1.png');
    $logoBase64 = base64_encode(file_get_contents($logoPath));
    $logoSrc = 'data:image/png;base64,' . $logoBase64;
@endphp

<div style="position:relative; text-align:center; padding: 10px 0;">
    {{-- Logo watermark di belakang --}}
    <img src="{{ $logoSrc }}"
         style="position:absolute;
                top:50%;
                left:50%;
                transform:translate(-50%, -50%);
                width:500px;
                height:500px;
                object-fit:contain;
                opacity:0.08;
                z-index:0;">

    {{-- Teks header di depan --}}
    <div style="position:relative; z-index:1;">
        <h2 style="font-size:14px; margin-bottom:3px;">PT Walet Abdillah Jabli</h2>
        <p style="font-size:11px; margin:2px 0;">Jl. Kedungpring – Mantup No. 56</p>
        <p style="font-size:11px; margin:2px 0;">Ds. Sukobendu, Kec. Mantup, Kab. Lamongan</p>
    </div>
</div>
<hr>
<div class="title">SLIP GAJI KARYAWAN</div>

<table class="info">
    <tr>
        <td width="70">Nama</td>
        <td width="5">:</td>
        <td width="200"><strong>{{ $slip->karyawan->nama }}</strong></td>
        <td width="60">Periode</td>
        <td width="5">:</td>
        <td><strong>{{ $slip->periode->bulan }} {{ $slip->periode->tahun }}</strong></td>
    </tr>
    <tr>
        <td>NIP</td><td>:</td>
        <td>{{ $slip->karyawan->nip }}</td>
    </tr>
    <tr>
        <td>Jabatan</td><td>:</td>
        <td>{{ $slip->karyawan->jabatan }}</td>
        <td>Departemen</td><td>:</td>
        <td>{{ $slip->karyawan->departemen }}</td>
    </tr>
</table>

<table class="gaji">
    <thead>
        <tr>
            <th colspan="2" width="45%">RINCIAN PENGHASILAN</th>
            <th width="20%">NOMINAL (Rp)</th>
            <th width="25%">RINCIAN POTONGAN</th>
            <th width="20%">NOMINAL (Rp)</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td colspan="2" class="bold">A. Gaji Pokok</td>
            <td class="right">{{ number_format($slip->gaji_pokok,0,',','.') }}</td>
            <td>PPH 21</td>
            <td class="right">{{ number_format($slip->pph21,0,',','.') }}</td>
        </tr>
        <tr>
            <td colspan="2" class="bold">B. Tunjangan</td>
            <td></td>
            <td>BPJS Kesehatan</td>
            <td class="right">{{ number_format($slip->bpjs_kesehatan,0,',','.') }}</td>
        </tr>
        <tr>
            <td width="18">&nbsp;</td>
            <td>1. Tunjangan Jabatan</td>
            <td class="right">{{ number_format($slip->tunj_jabatan,0,',','.') }}</td>
            <td>BPJS Ketenagakerjaan</td>
            <td class="right">{{ number_format($slip->bpjs_ketenagakerjaan,0,',','.') }}</td>
        </tr>
        <tr>
            <td></td><td>2. Tunjangan Masa Kerja</td>
            <td class="right">{{ number_format($slip->tunj_masa_kerja,0,',','.') }}</td>
            <td>Potongan Lain</td>
            <td class="right">{{ number_format($slip->potongan_lain,0,',','.') }}</td>
        </tr>
        <tr>
            <td></td><td>3. Tunjangan Komunikasi</td>
            <td class="right">{{ number_format($slip->tunj_komunikasi,0,',','.') }}</td>
            <td>Pinjaman</td>
            <td class="right">{{ number_format($slip->pinjaman,0,',','.') }}</td>
        </tr>
        <tr>
            <td></td><td>4. Tunjangan Transportasi</td>
            <td class="right">{{ number_format($slip->tunj_transportasi,0,',','.') }}</td>
            <td></td><td></td>
        </tr>
        <tr>
            <td></td><td>5. Tunjangan Performance</td>
            <td class="right">{{ number_format($slip->tunj_performance,0,',','.') }}</td>
            <td></td><td></td>
        </tr>
        <tr>
            <td></td><td>6. Tunjangan Tambahan</td>
            <td class="right">{{ number_format($slip->tunj_tambahan,0,',','.') }}</td>
            <td></td><td></td>
        </tr>
        <tr>
            <td colspan="2" class="bold">C. Lain-lain</td>
            <td></td><td></td><td></td>
        </tr>
        <tr>
            <td></td><td>1. Overtime</td>
            <td class="right">{{ number_format($slip->overtime,0,',','.') }}</td>
            <td></td><td></td>
        </tr>
        <tr class="bg-total">
            <td colspan="2" class="bold">Total Penghasilan (Rp)</td>
            <td class="right bold">{{ number_format($slip->total_penghasilan,0,',','.') }}</td>
            <td class="bold">Total Potongan (Rp)</td>
            <td class="right bold">{{ number_format($slip->total_potongan,0,',','.') }}</td>
        </tr>
        <tr class="bg-total">
            <td colspan="4" class="bold center">Gaji yang Diterima (Rp)</td>
            <td class="right bold">{{ number_format($slip->gaji_diterima,0,',','.') }}</td>
        </tr>
    </tbody>
</table>

<div class="footer">
    <strong>Keterangan:</strong><br>
    1. Slip gaji adalah bukti dan informasi resmi penerimaan gaji dari pemberi kerja kepada karyawan. Mohon gunakan dengan bijaksana.<br>
    2. Sesuaikan jumlah gaji yang Anda terima dengan slip. Segera sampaikan kepada pihak HR jika ada yang tidak sesuai.<br>
    3. Batas klarifikasi gaji maksimal 2 hari setelah slip gaji diterima. HR tidak melayani klarifikasi jika melebihi batas.
</div>

</body>
</html>