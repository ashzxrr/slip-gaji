<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlipGaji extends Model
{
    protected $table = 'slip_gaji';
    protected $fillable = [
        'karyawan_id','periode_id',
        'gaji_pokok','tunj_jabatan','tunj_masa_kerja','tunj_komunikasi',
        'tunj_transportasi','tunj_performance','tunj_tambahan','overtime',
        'pph21','bpjs_kesehatan','bpjs_ketenagakerjaan','potongan_lain','pinjaman',
        'status_kirim','waktu_kirim',
    ];

    public function karyawan()
    {
        return $this->belongsTo(Karyawan::class);
    }

    public function periode()
    {
        return $this->belongsTo(GajiPeriode::class, 'periode_id');
    }

    public function getTotalPenghasilanAttribute(): int
    {
        return $this->gaji_pokok + $this->tunj_jabatan + $this->tunj_masa_kerja
            + $this->tunj_komunikasi + $this->tunj_transportasi
            + $this->tunj_performance + $this->tunj_tambahan + $this->overtime;
    }

    public function getTotalPotonganAttribute(): int
    {
        return $this->pph21 + $this->bpjs_kesehatan + $this->bpjs_ketenagakerjaan
            + $this->potongan_lain + $this->pinjaman;
    }

    public function getGajiDiterimaAttribute(): int
    {
        return $this->total_penghasilan - $this->total_potongan;
    }
}