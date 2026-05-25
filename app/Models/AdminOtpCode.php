<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class AdminOtpCode extends Model
{
    use HasFactory;

    protected $table = 'admin_otp_codes';

    protected $fillable = [
        'user_id', 'code', 'expires_at', 'used', 'attempts',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    public function isValid(): bool
    {
        return ! $this->used && $this->expires_at->isFuture();
    }
}
