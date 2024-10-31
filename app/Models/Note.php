<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Note extends Model
{
    use HasFactory;

    protected $fillable = [
        'niveau',
        'serie',
        'codeclas',
        'matric',
        'periode',
        'matiere',
        'devoir01',
        'devoir02',
        'devoir03',
        'compos',
    ];
}
