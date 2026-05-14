<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Masina extends Model
{
    protected $fillable = [
        'registracijas_nr',
        'gads',
        'degvielas_limenis',
        'baterijas_limenis',
        'statuss',
        'tehniskas_apskates_termins',
    ];
    public function modelis()
    {
        return $this->belongsTo(Modelis::class, 'modelis_id');
    }
    public function lokacija()
    {
        return $this->belongsTo(Lokacija::class, 'lokacija_id');
    }
    public function ire()
    {
        return $this->hasMany(Ire::class, 'masina_id');
    }
    public function rezervacija()
    {
        return $this->hasMany(Rezervacija::class, 'masina_id');
    }
    public function apkope()
    {
        return $this->hasMany(Apkope::class, 'masina_id');
    }
}
