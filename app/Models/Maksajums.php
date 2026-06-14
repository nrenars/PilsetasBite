<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Maksajums extends Model
{
    protected $fillable = [
        'summa_bez_pvn',
        'summa_ar_pvn',
        'maksajuma_veids',
        'maksajuma_statuss',
        'maksajuma_datums',
        'ire_id'
    ];
    protected $casts = [
        'maksajuma_datums' => 'datetime',
    ];
    public function ire()
    {
        return $this->belongsTo(Ire::class, 'ire_id');
    }
}
