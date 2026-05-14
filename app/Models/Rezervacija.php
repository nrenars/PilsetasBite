<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rezervacija extends Model
{
    protected $fillable = [
        'datums',
        'deriguma_beigas',
        'statuss'
    ];
    public function lietotajs()
    {
        return $this->belongsTo(Lietotajs::class, 'lietotajs_id');
    }
    public function masina()
    {
        return $this->belongsTo(Masina::class, 'masina_id');
    }
}
