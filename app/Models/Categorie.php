<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    use HasFactory;
    protected $table = 'categories';
    protected $primaryKey = 'id_categorie';
    protected $fillable = ['libelle', 'id_service', 'masquer'];
    public $timestamps = false;

    public function service()
    {
        return $this->hasOne(Service::class, 'id_service', 'id_service');
    }

    public function fonctions()
    {
        return $this->belongsTo(Fonction::class, 'id_fonction');
    }
}
