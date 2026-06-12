<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Lietotajs extends Authenticatable
{
    protected $fillable = [
        'vards',
        'uzvards',
        'pilns_vards',
        'epasts',
        'telefons',
        'paroles_hash',
        'vaditaja_apliecibas_nr',
        'vaditaja_apliecibas_statuss',
        'vaditaja_apliecibas_termins',
        'statuss',
        'izveidots',
        'loma',
    ];
    protected $primaryKey = 'id';
    protected $authPasswordName = 'paroles_hash';
    protected $rememberTokenName = 'remember_token';

    public function ire()
    {
        return $this->hasMany(Ire::class, 'lietotajs_id');
    }
    public function rezervacija()
    {
        return $this->hasMany(Rezervacija::class, 'lietotajs_id');
    }
    public function atsauksme()
    {
        return $this->hasMany(Atsauksmes::class, 'lietotajs_id');
    }
    public function parkapums()
    {
        return $this->hasMany(Parkapums::class, 'lietotajs_id');
    }
    public function getAuthIdentifierName()
    {
        return 'epasts';
    }
    public function getAuthPassword()
    {
        return $this->paroles_hash;
    }
}
