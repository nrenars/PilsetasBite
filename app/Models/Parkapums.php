<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Parkapums extends Model
{
    protected $fillable = [
        'apraksts',
        'summa',
        'tips',
        'statuss'
    ];
    public function lietotajs()
    {
        return $this->belongsTo(Lietotajs::class, 'lietotajs_id');
    }
    public function ire()
    {
        return $this->belongsTo(Ire::class, 'ire_id');
    }
}
