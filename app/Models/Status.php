<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Status extends Model
{
    protected $table = 'statuses';

    protected $fillable = [
        'name',
        'user_id',
        'Nomor',
        'Alamat',
        'Metode_Pembayaran',
        'total_harga',
    ];

    public function statusDetails()
    {
        return $this->hasMany(StatusDetail::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
