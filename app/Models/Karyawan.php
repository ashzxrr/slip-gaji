<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Karyawan extends Model
{
    protected $table = 'karyawan';
    protected $fillable = [
    'nama','nip','jabatan','departemen','no_whatsapp',
    'username','password','aktif','must_change_password'
    ];

    protected $hidden = ['password'];

    public function otpCodes()
    {
        return $this->hasMany(OtpCode::class);
    }

    public function notifikasi()
    {
        return $this->hasMany(Notifikasi::class);
    }

    public function unreadNotifikasi()
    {
        return $this->notifikasi()->where('dibaca', false);
    }
}