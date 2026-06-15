<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Atsauksmes extends Model
{
    protected $fillable = [
        'vertejums',
        'komentars',
        'lietotajs_id',
        'ire_id',
        'izveidots',
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
