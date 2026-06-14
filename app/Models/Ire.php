<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ire extends Model
{
    protected $fillable = [
        'sakuma_laiks',
        'beigu_laiks',
        'nobrauktais_attalums',
        'statuss',
        'cena',
        'lietotajs_id',
        'masina_id',
        'lokacija_id'
    ];
    protected $casts = [
        'sakuma_laiks' => 'datetime',
        'beigu_laiks' => 'datetime',
    ];
    public function lietotajs()
    {
        return $this->belongsTo(Lietotajs::class, 'lietotajs_id');
    }
    public function masina()
    {
        return $this->belongsTo(Masina::class, 'masina_id');
    }
    public function lokacija()
    {
        return $this->belongsTo(Lokacija::class, 'lokacija_id');
    }
    public function maksajums()
    {
        return $this->hasOne(Maksajums::class, 'ire_id');
    }
    public function atsauksmes()
    {
        return $this->hasMany(Atsauksmes::class, 'ire_id');
    }
    public function parkapums()
    {
        return $this->hasMany(Parkapums::class, 'ire_id');
    }
}
