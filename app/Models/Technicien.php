<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Technicien extends Model
{
    //use \Staudenmeir\EloquentJsonRelations\HasJsonRelationships;

    use HasFactory;
    protected $fillable = [
        'user_id',
        'niveau_intervontion_id',
        
    ];
    protected $casts = [
        'niveau_intervontion_id' => 'array',
    ];
 /*   public function niveau()
    {
        return $this->belongsToJson(NiveauIntervontion::class,"niveau_intervontion_id");
    }*/
    public function niveau()
    {
        return $this->belongsToMany(NiveauIntervontion::class,"niveau_techniciens","technicien_id","niveau_intervontion_id");
    }
    public function user()
    {
        return $this->hasOne(User::class,"id","user_id");
    }
}
