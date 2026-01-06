<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StatusDetail extends Model
{
    protected $table = 'status_details';

    protected $fillable = [
        'status_id',
        'food_id',
        'quantity',
        'subtotal',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }
    public function food()
    {
        return $this->belongsTo(Food::class);
    }
}
