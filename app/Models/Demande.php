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

}
