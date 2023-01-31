<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machin extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'description',
    ];
}
