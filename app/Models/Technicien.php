<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Technicien extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'niveau_intervontion_id',
        
    ];
    public function niveau()
    {
        return $this->hasMany(NiveauIntervontion::class,"id","niveau_intervontion_id");
    }
    public function user()
    {
        return $this->hasOne(User::class,"id","user_id");
    }
}
