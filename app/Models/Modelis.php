<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Modelis extends Model
{
    protected $fillable = [
        'marka',
        'modelis',
        'degvielas_tips',
        'vietu_skaits',
        'transmisija',
    ];
    public function masina()
    {
        return $this->hasMany(Masina::class, 'modelis_id');
    }
}
