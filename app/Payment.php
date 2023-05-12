<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'place_id',
        'total_price',
        'received_price',
        'change',
    ];

    public function place()
    {
        return $this->belongsTo(Place::class);
    }

}
