<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GajiPeriode extends Model
{
    protected $table = 'gaji_periode';
    protected $fillable = ['bulan', 'tahun', 'status'];

    public function slipGaji()
    {
        return $this->hasMany(SlipGaji::class, 'periode_id');
    }

    public function getLabelAttribute(): string
    {
        return $this->bulan . ' ' . $this->tahun;
    }
}