<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;
    protected $table = 'role';
    protected $primaryKey = 'id_role';
    protected $fillable = ['libelle'];
    public $timestamps = false;

    public function techniciens()
    {
        return $this->belongsTo(Technicien::class, 'id_technicien');
    }
}
