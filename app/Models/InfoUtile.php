<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InfoUtile extends Model
{
    use HasFactory;

    protected $table = 'infos_utiles';
    
    protected $fillable = [
        'libelle',
        'description',
        'icon',
        'active',
        'ordre'
    ];

    protected $casts = [
        'active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];
}