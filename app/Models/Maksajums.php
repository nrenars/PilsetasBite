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
        'maksajuma_datums'
    ];
    public function ire()
    {
        return $this->hasMany(Ire::class, 'maksajums_id');
    }
}
