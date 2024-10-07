<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Eleve extends Model
{
    use HasFactory;

    protected $fillable = [
        'matric', 'nom', 'prenom', 'sexe', 'datenais', 'phoneeleve', 'nompar', 'prenpar', 'sexepar', 'profespar', 'phonepar',
    ];

    protected $primary_key = 'id';
}
