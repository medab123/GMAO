<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Demande extends Model
{
    use HasFactory;
    protected $fillable = [
        'demandeur_id',
        'niveau_intervontion_id',
        'type_intervontion_id',
        'machine_id',
        'description',
    ];
    public function techniciens()
    {
        return $this->belongsToMany(User::class,"demande_techniciens","demande_id","user_id");
    }
    public function demandeur()
    {
        return $this->hasOne(User::class,"id","demandeur_id");
    }
    public function machine()
    {
        return $this->hasOne(Machin::class,"id","machine_id");
    }
    public function niveau()
    {
        return $this->hasOne(NiveauIntervontion::class,"id","niveau_intervontion_id");
    }

}
