<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Lokacija extends Model
{
    protected $fillable = [
        'platuma_gradi',
        'garuma_gradi',
        'adrese',
        'pilseta',
    ];
    public function masina()
    {
        return $this->hasMany(Masina::class, 'lokacija_id');
    }
    public function ire()
    {
        return $this->hasMany(Ire::class, 'lokacija_id');
    }
}
