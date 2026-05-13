<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Apkope extends Model
{
    protected $fillable = [
        'apraksts',
        'datums',
        'izmaksas',
        'statuss',
    ];
    public function masina()
    {
        return $this->hasMany(Masina::class, 'masina_id');
    }
}
